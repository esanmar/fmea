<?php
/**
 * @package dompdf
 * @link    http://www.dompdf.com/
 * @author  Benj Carson <benjcarson@digitaljunkies.ca>
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @version $Id: tcpdf_adapter.cls.php 448 2011-11-13 13:00:03Z fabien.menager $
 */

namespace Dompdf\Adapter; //***

use Dompdf\Canvas;
use Dompdf\Dompdf;
use Dompdf\Helpers;
use Dompdf\Exception;
use Dompdf\Image\Cache;
use Dompdf\PhpEvaluator;

/**
 * TCPDF PDF Rendering interface
 *
 * TCPDF_Adapter provides a simple, stateless interface to TCPDF.
 *
 * Unless otherwise mentioned, all dimensions are in points (1/72 in).
 * The coordinate origin is in the top left corner and y values
 * increase downwards.
 *
 * See {@link http://tcpdf.sourceforge.net} for more information on
 * the underlying TCPDF class.
 *
 * @package dompdf
 */
class TCPDF implements Canvas { //***

	/**
	 * Dimensions of paper sizes in points
	 *
	 * @var array;
	 */
	static public $PAPER_SIZES = array (); // Set to Dompdf\Adapter\CPDF::$PAPER_SIZES below.

	/**
	 * Fudge factor to adjust reported font heights
	 *
	 * CPDF reports larger font heights than TCPDF.  This factor
	 * adjusts the height reported by get_font_height().
	 *
	 * CORRECTION: at a certain point, with given DOMPDF and TCPDF versions, this was true
	 * and the number was 1.116. Now it does not seem necessary anymore.
	 * Just in case it will be useful again in the future, I leave it in the code setting it to 1
	 *
	 * @var float
	 */
	const FONT_HEIGHT_SCALE_NORMAL = 1.116;
	const FONT_HEIGHT_SCALE_BOLD = 1.153;

	/**
	 * Instance of the TCPDF class
	 *
	 * @var TCPDF
	 */
	private $_pdf;

	/**
	 * PDF width in points
	 *
	 * @var float
	 */
	private $_width;

	/**
	 * PDF height in points
	 *
	 * @var float
	 */
	private $_height;

	/**
	 * Last fill colour used
	 *
	 * @var array
	 */
	private $_last_fill_color;

	/**
	 * Last stroke colour used
	 *
	 * @var array
	 */
	private $_last_stroke_color;

	/**
	 * Cache of image handles
	 *
	 * @var array
	 */
	private $_imgs;

	/**
	 * Cache of font handles
	 *
	 * @var array
	 */
	private $_fonts;

	/**
	 * List of objects (templates) to add to multiple pages
	 *
	 * @var array
	 */
	private $_objs;

	/**
	 * Text to display on every page
	 *
	 * @var array
	 */
	private $_page_text;

	/**
   * Array of pages for accesing after rendering is initially complete
	 *
	 * @var array
	 */
	private $_pages;

	/**
	 * Array of temporary cached images to be deleted when processing is complete
	 *
	 * @var array
	 */
	private $_image_cache;

	////
	///  TCPDF only ///
	///

	/**
	 * Map named links (internal) to links ID
	 * @var unknown_type
	 */
	private $_nameddest;

	/**
	 * Saves internal links info for later insertion
	 * @var unknown_type
	 */
	private $_internal_links;

	private $_currentLineTransparency;	// not used because line transparency is set by fill transparency

	private $_currentFillTransparency;

  /**
   * Class constructor
   *
   * @param mixed  $paper       The size of paper to use either a string (see {@link CPDF_Adapter::$PAPER_SIZES}) or
   *                            an array(xmin,ymin,xmax,ymax)
   * @param string $orientation The orientation of the document (either 'landscape' or 'portrait')
   * @param DOMPDF $dompdf
   */
  function __construct($paper = "letter", $orientation = "portrait", DOMPDF $dompdf) { //***

		if ( is_array($paper) )
		  $size = $paper;
		else if ( isset(self::$PAPER_SIZES[mb_strtolower($paper)]) )
		  $size = self::$PAPER_SIZES[mb_strtolower($paper)];
		else
		  $size = self::$PAPER_SIZES["letter"];

		$ori = 'P'; // ***
		if ( mb_strtolower($orientation) === "landscape" ) {
		  list($size[2], $size[3]) = array($size[3], $size[2]);
		  $ori = 'L'; // ***
		}

		$this->_width = $size[2] - $size[0];
		$this->_height = $size[3] - $size[1];

		$this->_dompdf = $dompdf;

		//***$this->_pdf = new My_TCPDF('P', 'pt', $paper, true, 'UTF-8', false);
		$this->_pdf = new My_TCPDF($ori, 'pt', $paper, true, 'UTF-8', false); // ***
		$this->_pdf->SetCreator("DOMPDF Converter");

		// CreationDate and ModDate info are added by TCPDF itself

		// don't use TCPDF page defaults
		$this->_pdf->SetAutoPageBreak(false);
		$this->_pdf->SetMargins(0, 0, 0, true);
		$this->_pdf->setPrintHeader(false);	// remove default header/footer
		$this->_pdf->setPrintFooter(false);
		$this->_pdf->setHeaderMargin(0);
		$this->_pdf->setFooterMargin(0);
		$this->_pdf->SetCellPadding(0);

		$this->_pdf->AddPage();
		$this->_pdf->SetDisplayMode('fullpage', 'continuous');

		$this->_page_number = $this->_page_count = 1;
		$this->_page_text = array ();

		$this->_pages = array($this->_pdf->PageNo());

		$this->_image_cache = array();

		// other TCPDF stuff...
		$this->_objs = array();				// for templating support
		$this->_nameddest = array();		// for internal link support
		$this->_internal_links = array();	//		"	"	"

		$this->_pdf->setAlpha(1.0);
		$this->_currentLineTransparency = array("mode" => "Normal", "opacity" => 1.0);
		$this->_currentFillTransparency = array("mode" => "Normal", "opacity" => 1.0);

		$this->_last_fill_color = $this->_last_stroke_color = null;

		//Helpers::dompdf_debug("trace", "Exit");
	}

	function get_dompdf(){ //***
		return $this->_dompdf;
	}

	/**
	 * Class destructor
	 *
	 * Deletes all temporary image files
	 */
	function __destruct() {
		foreach ($this->_image_cache as $img) {
	  //debugpng
	  if (DEBUGPNG) print '[__destruct unlink '.$img.']';
	  if (!DEBUGKEEPTEMP)
			unlink($img);
		}
	}

	/**
	 * Returns the Tcpdf instance
	 *
	 * @return Tcpdf
	 */
	function get_lib_obj() {
		return $this->_pdf;
	}

	/**
	 * Add meta information to the PDF
	 *
	 * TCPDF does not have a generic method to do this, but limits the possible info to add
	 * to well specific cases
	 *
	 * @param string $label  label of the value (Creator, Producter, etc.)
	 * @param string $value  the text to set
	 */
	function add_info($label, $value) {
		global $_dompdf_warnings;

		switch($label) {
			case 'Creator':
				$this->_pdf->SetCreator($value);
				break;
			case 'Author':
				$this->_pdf->SetAuthor($value);
				break;
			case 'Title':
				$this->_pdf->SetTitle($value);
				break;
			case 'Subject':
				$this->_pdf->SetSubject($value);
				break;
			case 'Keywords':
				$this->_pdf->SetKeywords($value);
				break;
			default:
				$_dompdf_warnings[] = "add_info: label '$label' is not supported by the TCPDF library.";
				break;
		}
	}

	/**
	 * Opens a new 'object' (template in PDFLib-speak)
	 *
	 * While an object is open, all drawing actions are recored in the object,
	 * as opposed to being drawn on the current page.  Objects can be added
	 * later to a specific page or to several pages.
	 *
	 * The return value is an integer ID for the new object.
	 *
	 * @see TCPDF_Adapter::close_object()
	 * @see TCPDF_Adapter::add_object()
	 *
	 * @return int
	 */
	function open_object() {
		/* TCPDF does not appear to have template support. Options:
		 * 1) add template support to TCPDF
		 * 2) throw an error
		 * 3) implement the template support in this adapter
		 *
		 * I have chosen a mix of 1st and 3rd options, using code from the PDFLIB and CPDF adapters, and the CPDF library,
		 * to make a TCPDF subclass
		 * The only tests performed are those in the dompdf/www/test directory.
		 *
		 * What it does essentially is saving the TCPDF output buffer in a local stack, and resetting it to its initial value (empty string).
		 * When the template is closed, the output collected from its opening, is moved to an internal template dictionary,
		 * and the TCPDF output buffer is restored to the saved values (from the stack).
		 *
		 * The TCPDF output buffer cannot be accessed because it is private, and its accessor methods are protected.
		 * Therefore, I used a derived class (My_TCPDF - see bottom of this file)
		 *
		 * To prevent any side effects to the TCPDF object state, while a template is open, I issue a rollbackTransaction() when the template is closed,
		 * to restore everything to the original state. I don't know yet if this is necessary, correct, useful, etc. It needs further learning and testing.
		 * It also makes the use of the stack pretty redundant. For the moment I keep both of them.
		 */

		//throw new DOMPDF_Exception("TCPDF Adapter does not support opening objects.");

		$this->_pdf->startTransaction();	// ???
		$ret = $this->_pdf->openObject();
		$this->_objs[$ret] = array("start_page" => $this->_pdf->PageNo());
		return $ret;
	}

	/**
	 * Reopen an existing object
	 *
	 * @param int $object the ID of a previously opened object
	 */
	function reopen_object($object) {
		$this->_pdf->startTransaction();	// ???
		$this->_pdf->reopenObject($object);
	}

	/**
	 * Close the current object
	 *
	 * @see TCPDF_Adapter::open_object()
	 */
	function close_object() {
		$this->_pdf->closeObject();
		$this->_pdf->rollbackTransaction(true);	// ???
	}

	/**
	 * Adds the specified object to the document
	 *
	 * $where can be one of:
	 * - 'add' add to current page only
	 * - 'all' add to every page from the current one onwards
	 * - 'odd' add to all odd numbered pages from now on
	 * - 'even' add to all even numbered pages from now on
	 * - 'next' add the object to the next page only
	 * - 'nextodd' add to all odd numbered pages from the next one
	 * - 'nexteven' add to all even numbered pages from the next one
	 *
	 * @param int $object the object handle returned by open_object()
	 * @param string $where
	 */
	function add_object($object, $where = 'all') {
		if (mb_strpos($where, "next") !== false) {
			$this->_objs[$object]["start_page"]++;
			$where = str_replace("next", "", $where);
			if ($where == "") {
				$where = "add";
			}
		}

		$this->_objs[$object]["where"] = $where;
	}

	/**
	 * Stops the specified object from appearing in the document.
	 *
	 * The object will stop being displayed on the page following the
	 * current one.
	 *
	 * @param int $object
	 */
	function stop_object($object) {
		if (! isset ($this->_objs[$object])) {
			return;
		}

		$start = $this->_objs[$object]["start_page"];
		$where = $this->_objs[$object]["where"];

		// Place the object on this page if required
		$page_number = $this->_pdf->PageNo();
		if ($page_number >= $start &&
		(($page_number % 2 == 0 && $where == "even") ||
		($page_number % 2 == 1 && $where == "odd") ||
		($where == "all"))) {
			$data = $this->_pdf->getObject($object);
			$this->_pdf->setPageBuffer($page_number, $data['c'], true);
		}

		unset ($this->_objs[$object]);
	}

	/**
	 * Add all active objects to the current page
	 */
	protected function _place_objects() {
		//Helpers::dompdf_debug("trace", "()");

		foreach ($this->_objs as $obj=>$props) {
			//var_dump($props);

			$start = $props["start_page"];
			$where = $props["where"];

			// Place the object on this page if required
			$page_number = $this->_pdf->PageNo();
			if ($page_number >= $start &&
			(($page_number % 2 == 0 && $where == "even") ||
			($page_number % 2 == 1 && $where == "odd") ||
			($where == "all"))) {
				$data = $this->_pdf->getObject($obj);
				//Helpers::dompdf_debug("trace", "object data = " . $data['c']);
				$this->_pdf->setPageBuffer($page_number, $data['c'], true);
			}
		}

	}


	/******************************************************************************
	 ***                            Protected methods                           ***
	 ******************************************************************************/
	/**
	 * Sets the stroke color
	 *
	 * @param array $color
	 */
	/*
	protected function _set_stroke_color($color) {
		//Helpers::dompdf_debug("trace", "([$color[0], $color[1], $color[2]])");

		//if ($this->_last_stroke_color == $color) {
		//	return;
		//}

		$this->_last_stroke_color = $color;

		list ($r, $g, $b) = $this->_get_rgb($color);
		$this->_pdf->SetDrawColor($r, $g, $b);
	}
	*/

	/**
	 * Sets the fill color
	 *
	 * @param array $color
	 */
	/*
	protected function _set_fill_color($color) {
		//Helpers::dompdf_debug("trace", "([$color[0], $color[1], $color[2]])");

		if ($this->_last_fill_color == $color) {
			return;
		}

		$this->_last_fill_color = $color;

		list ($r, $g, $b) = $this->_get_rgb($color);
		$this->_pdf->SetFillColor($r, $g, $b);
	}
	*/

	/**
	 * Sets line transparency
	 * @see Tcpdf::setAlpha()
	 *
	 * In TCFTP the setAlpha() method, sets both line transparency and fill transparency
	 *
	 * Valid blend modes are (case-sensitive):
	 *
	 * Normal, Multiply, Screen, Overlay, Darken, Lighten,
	 * ColorDodge, ColorBurn, HardLight, SoftLight, Difference,
	 * Exclusion
	 *
	 * @param string $mode the blending mode to use
	 * @param float $opacity 0.0 fully transparent, 1.0 fully opaque
	 */
	protected function _set_line_transparency($mode, $opacity) {
		//Helpers::dompdf_debug("trace", "($mode, $opacity)");

		// Only create a new graphics state if required
		//if ( $mode != $this->_currentFillTransparency["mode"]  ||
		//$opacity != $this->_currentFillTransparency["opacity"] ) {
			$this->_pdf->setAlpha($opacity, $mode);
			$this->_currentFillTransparency["opacity"] = $opacity;
			$this->_currentFillTransparency["mode"] = $mode;
		//}
	}

	/**
	 * Sets fill transparency
	 * @see Tcpdf::setAlpha()
	 *
	 * In TCFTP the setAlpha() method, sets both line transparency and fill transparency
	 *
	 * Valid blend modes are (case-sensitive):
	 *
	 * Normal, Multiply, Screen, Overlay, Darken, Lighten,
	 * ColorDogde, ColorBurn, HardLight, SoftLight, Difference,
	 * Exclusion
	 *
	 * @param string $mode the blending mode to use
	 * @param float $opacity 0.0 fully transparent, 1.0 fully opaque
	 */
	protected function _set_fill_transparency($mode, $opacity) {
		//Helpers::dompdf_debug("trace", "($mode, $opacity)");

		// Only create a new graphics state if required
		//if ( $mode != $this->_currentFillTransparency["mode"]  ||
		//$opacity != $this->_currentFillTransparency["opacity"] ) {
			$this->_pdf->setAlpha($opacity, $mode);
			$this->_currentFillTransparency["opacity"] = $opacity;
			$this->_currentFillTransparency["mode"] = $mode;
		//}
	}

	/**
	 * Sets the line style
	 *
	 * @see TCpdf::setLineStyle()
	 *
	 * @param float width
	 * @param string cap
	 * @param string join
	 * @param array dash
	 */
	/*
	protected function _set_line_style($width, $cap, $join, $dash) {
		//Helpers::dompdf_debug("trace", "($width, $cap, $join, $dash)");
		//var_dump($dash);
		if ($dash) {
			$dash = implode(',', $dash);
		}
		else {
			$dash = 0;
		}

		$style = array ('width'=>$width, 'cap'=>$cap, 'join'=>$join, 'dash'=>$dash);
		$this->_pdf->SetLineStyle($style);
	}
	*/

	/**
	 *
	 * @param unknown_type $color
	 * @return unknown_type
	 */
	protected function _get_rgb($color) {
		return array (round(255*$color[0]), round(255*$color[1]), round(255*$color[2]));
	}

	/**
	 *
	 * @param unknown_type $color
	 * @param unknown_type $width
	 * @param unknown_type $cap
	 * @param unknown_type $join
	 * @param unknown_type $dash
	 * @return unknown_type
	 */
	protected function _make_line_style($color = '', $width='', $cap='', $join='', $dash='') {
		//Helpers::dompdf_debug("trace", "($color, $width, $cap, $join, $dash)");
		$style = array();
		if ($color) {
			$style['color'] = $this->_get_rgb($color);
		}
		if ($width) {
			$style['width'] = $width;
		}
		if ($cap) {
			$style['cap'] = $cap;
		}
		if ($join) {
			$style['join'] = $join;
		}
		$style['dash'] = $dash ? implode(',', $dash) : 0;
		return $style;
	}

	/**
	 * Convert a GIF image to a PNG image
	 *
	 * @return string The url of the newly converted image
	 */
	protected function _convert_gif_to_png($image_url) {
		if ( !function_exists("imagecreatefromgif") ) {
			throw new DOMPDF_Exception("Function imagecreatefromgif() not found.  Cannot convert gif image: $image_url.  Please install the image PHP extension.");
		}

		$old_err = set_error_handler("record_warnings");

		$tmp_img = getImageSize($img_url);
		if ($tmp_img[2] == '1') {
			$img = imagecreatefromgif($img_url);
			if ($img) {
				imageinterlace($img, 0);
				$tmp_filename = tempnam(DOMPDF_TEMP_DIR, "dompdf_img_");
				imagepng($img, $tmp_filename);
				rename($tmp_filename, $tmp_filename.'.png');
				$img_url = $tmp_filename.'.png';
			}
			else {
				$img_url = "../../lib/res/broken_image.png";
			}
		}

		restore_error_handler();

		$this->_image_cache[] = $img_url;

		return $img_url;
	}

	/**
	 * Add text to each page after rendering is complete
	 */
	protected function _add_page_text() {
		//Helpers::dompdf_debug("trace", "()");

		if (!count($this->_page_text)) {
			return;
		}

		$page_number = 1;
		$eval = null;

		foreach ($this->_pages as $pid) {
			//$this->reopen_object($pid);

			$this->_pdf->setPage($pid);
			foreach ($this->_page_text as $pt) {
				extract($pt);

				switch($_t) {

					case "text":
						$text = str_replace( array ("{PAGE_NUM}", "{PAGE_COUNT}"),
						array ($page_number, $this->_pdf->getNumPages()), $text);
						$this->text($x, $y, $text, $font, $size, $color, $adjust, 0, $angle); //***
						break;

					case "script":
						if (!$eval) {
							$eval = new PHP_Evaluator($this);
						}
						$eval->evaluate($code, array ('PAGE_NUM'=>$page_number, 'PAGE_COUNT'=>$this->_pdf->getNumPages()));
						break;
				}
			}

			//$this->close_object();
			$page_number++;
		}
	}

	/**
	 *
	 * @return unknown_type
	 */
	protected function _add_internal_links() {
		//Helpers::dompdf_debug("trace", "()");

		if (!count($this->_internal_links)) {
			return;
		}

		foreach ($this->_internal_links as $link) {
			extract($link); // compact('page', 'name', 'x', 'y', 'width', 'height')
			$this->_pdf->setPage($page);
			$this->_pdf->Link($x, $y, $width, $height, $this->_nameddest[$name]);
		}
	}

	/**
	 *
	 * @param unknown_type $font
	 * @return unknown_type
	 */
	protected function _get_font($font) {
		$name = basename($font);
		$a = explode('-', $name);
		$f = strtolower($a[0]);
		$s = '';
//***		if (strpos($a[1], 'Bold') !== false) {
//			$s .= 'B';
//		}
//		if (strpos($a[1], 'Italic') !== false) {
//			$s .= 'I';
//		}
		//Helpers::dompdf_debug("trace2", "($font): returns $f, $s");
		return array('family' => $f, 'style' => $s);
	}

	/******************************************************************************
	 ***                 Interface Canvas implementation                        ***
	 ******************************************************************************/
	/**
	 * @return Number
	 */
	function get_width() {
		//Helpers::dompdf_debug("trace", ": returns $this->_width");
		return $this->_width;
	}

	/**
	 *
	 * @return Number
	 */
	function get_height() {
		//Helpers::dompdf_debug("trace", ": returns $this->_height");
		return $this->_height;
	}

	/**
	 * Returns the current page number
	 *
	 * @return int
	 */
	function get_page_number() {
		return $this->_pdf->PageNo();
	}

	/**
	 * Sets the current page number
	 *
	 * @param int $num
	 */
	function set_page_number($num) {
		$this->_pdf->setPage($num);
	}

	/**
	 * Returns the total number of pages
	 *
	 * @return int
	 */
	function get_page_count() {
		return $this->_pdf->getNumPages();
	}

	/**
	 * Sets the total number of pages
	 *
	 * Who uses it ???
	 *
	 * @param int $count
	 */
	function set_page_count($count) {
		//$this->_page_count = (int)$count;
		//throw new DOMPDF_Exception("TCPDF does not support setting the page count.");
		$_dompdf_warnings[] = "TCPDF does not support setting the page count.";
	}

	/**
	 * Draws a line from x1,y1 to x2,y2
	 *
	 * See {@link Style::munge_color()} for the format of the color array.
	 * See {@link Cpdf::setLineStyle()} for a description of the format of the
	 * $style parameter (aka dash).
	 *
	 * @param float $x1
	 * @param float $y1
	 * @param float $x2
	 * @param float $y2
	 * @param array $color
	 * @param float $width
	 * @param array $style
	 */
	function line($x1, $y1, $x2, $y2, $color, $width, $style = array(), $blend = "Normal", $opacity = 1.0) {
		//Helpers::dompdf_debug("trace", "($x1, $y1, $x2, $y2, [$color[0], $color[1], $color[2]], $width, $style, $blend, $opacity)");

		//$this->_set_stroke_color($color);
		//$this->_set_line_style($width, "butt", "", $style);
		$this->_set_line_transparency($blend, $opacity);

		$this->_pdf->Line($x1, $y1, $x2, $y2, $this->_make_line_style($color, $width, "butt", "", $style));
	}

	function arc($x, $y, $r1, $r2, $astart, $aend, $color, $width, $style = array()) { //***
		$this->_set_stroke_color($color);
		$this->_set_line_style($width, "butt", "", $style);

		$this->_pdf->ellipse($x, $this->y($y), $r1, $r2, 0, 8, $astart, $aend, false, false, true, false);
	}

	/**
	 * Draws a rectangle at x1,y1 with width w and height h
	 *
	 * See {@link Style::munge_color()} for the format of the color array.
	 * See {@link Cpdf::setLineStyle()} for a description of the $style
	 * parameter (aka dash)
	 *
	 * @param float $x1
	 * @param float $y1
	 * @param float $w
	 * @param float $h
	 * @param array $color
	 * @param float $width
	 * @param array $style
	 */
	function rectangle($x1, $y1, $w, $h, $color, $width, $style = null, $blend = "Normal", $opacity = 1.0) {
		//Helpers::dompdf_debug("trace", "($x1, $y1, $w, $h, [$color[0], $color[1], $color[2]], $width, $style, $blend, $opacity)");

		//$this->_set_stroke_color($color);
		//$this->_set_line_style($width, "square", "miter", $style);
		$this->_set_line_transparency($blend, $opacity);

		$this->_pdf->Rect($x1, $y1, $w, $h, 'D', $this->_make_line_style($color, $width, "square", "miter", $style));
	}

	/**
	 * Draws a filled rectangle at x1,y1 with width w and height h
	 *
	 * See {@link Style::munge_color()} for the format of the color array.
	 *
	 * @param float $x1
	 * @param float $y1
	 * @param float $w
	 * @param float $h
	 * @param array $color
	 */
	function filled_rectangle($x1, $y1, $w, $h, $color, $blend = "Normal", $opacity = 1.0) {
		//var_dump($color);
		//Helpers::dompdf_debug("trace", "($x1, $y1, $w, $h, [$color[0], $color[1], $color[2]], $blend, $opacity)");

		//$this->_set_stroke_color($color);
		//$this->_set_fill_color($color);
		//$this->_set_line_style(1, "square", "miter", array());
		$this->_set_line_transparency($blend, $opacity);
		$this->_set_fill_transparency($blend, $opacity);

		$this->_pdf->Rect($x1, $y1, $w, $h, 'F', $this->_make_line_style($color, 1, "square", "miter", array()), $this->_get_rgb($color)); //***

	}

	/**
	 * Starts a clipping rectangle at x1,y1 with width w and height h
	 *
	 * @param float $x1
	 * @param float $y1
	 * @param float $w
	 * @param float $h
	 */
  function clipping_rectangle($x1, $y1, $w, $h) {}

  function clipping_roundrectangle($x1, $y1, $w, $h, $rTL, $rTR, $rBR, $rBL) { //***
	$this->_pdf->clippingRectangleRounded($x1, $this->y($y1) - $h, $w, $h, $rTL, $rTR, $rBR, $rBL);
  }

	/**
	 * Ends the last clipping shape
	 */
	function clipping_end() {}

	/**
	 * Save current state
	 */
	function save() {}

	/**
	 * Restore last state
	 */
	function restore() {}

	/**
	 * Rotate
	 */
	function rotate($angle, $x, $y) {}

	/**
	 * Skew
	 */
	function skew($angle_x, $angle_y, $x, $y) {}

	/**
	 * Scale
	 */
	function scale($s_x, $s_y, $x, $y) {}

	/**
	 * Translate
	 */
	function translate($t_x, $t_y) {}

	/**
	 * Transform
	 */
	function transform($a, $b, $c, $d, $e, $f) {}

	/**
	 * Draws a polygon
	 *
	 * The polygon is formed by joining all the points stored in the $points
	 * array.  $points has the following structure:
	 * <code>
	 * array(0 => x1,
	 *       1 => y1,
	 *       2 => x2,
	 *       3 => y2,
	 *       ...
	 *       );
	 * </code>
	 *
	 * See {@link Style::munge_color()} for the format of the color array.
	 * See {@link Cpdf::setLineStyle()} for a description of the $style
	 * parameter (aka dash)
	 *
	 * @param array $points
	 * @param array $color
	 * @param float $width
	 * @param array $style
	 * @param bool  $fill  Fills the polygon if true
	 */
	function polygon($points, $color, $width = null, $style = null, $fill = false, $blend = "Normal", $opacity = 1.0) {
		//Helpers::dompdf_debug("trace", "($points, [$color[0], $color[1], $color[2]], $width, $style, $fill, $blend, $opacity)");

		//$this->_set_fill_color($color);
		//$this->_set_stroke_color($color);

		$this->_set_line_transparency($blend, $opacity);
		if ($fill) {
			$this->_set_fill_transparency($blend, $opacity);
		}

		//if (!$fill && isset ($width)) {
		//	$this->_set_line_style($width, "square", "miter", $style);
		//}

		$this->_pdf->Polygon($points, $fill ? 'F' : '', $this->_make_line_style($color, $width, "square", "miter", $style), $this->_get_rgb($color));
	}

	/**
	 * Draws a circle at $x,$y with radius $r
	 *
	 * See {@link Style::munge_color()} for the format of the color array.
	 * See {@link Cpdf::setLineStyle()} for a description of the $style
	 * parameter (aka dash)
	 *
	 * @param float $x
	 * @param float $y
	 * @param float $r
	 * @param array $color
	 * @param float $width
	 * @param array $style
	 * @param bool $fill Fills the circle if true
	 */
	function circle($x, $y, $r, $color, $width = null, $style = null, $fill = false, $blend = "Normal", $opacity = 1.0) {
		//Helpers::dompdf_debug("trace", "($x, $y, $r, [$color[0], $color[1], $color[2]], $width, $style, $fill, $blend, $opacity)");

		//$this->_set_fill_color($color);
		//$this->_set_stroke_color($color);

		$this->_set_line_transparency($blend, $opacity);
		if ($fill) {
			$this->_set_fill_transparency($blend, $opacity);
		}

		//if (!$fill && isset ($width)) {
		//	$this->_set_line_style($width, "round", "round", $style);
		//}

		$this->_pdf->Circle($x, $y, $r, 0, 360, $fill ? 'F' : '', $this->_make_line_style($color, $width, "round", "round", $style), $this->_get_rgb($color));
	}

	/**
	 * Add an image to the pdf.
	 *
	 * The image is placed at the specified x and y coordinates with the
	 * given width and height.
	 *
	 * @param string $img_url the path to the image
	 * @param string $img_type the type (e.g. extension) of the image
	 * @param float $x x position
	 * @param float $y y position
	 * @param int $w width (in pixels)
	 * @param int $h height (in pixels)
	 */
	function image($img, $x, $y, $w, $h, $resolution = "normal") {

//***		if ($img_type == 'gif') {
//			$img_url = $this->_convert_gif_to_png($img_url);
//			$img_type = 'png';
//		}
		$path_parts = pathinfo($img);
		$img_url = $img;
		$img_type = strtolower($path_parts['extension']);
		if ($img_type == 'gif') {
			$img_url = $this->_convert_gif_to_png($img_url);
			$img_type = 'png';
		}
		$this->_pdf->Image($img_url, $x, $y, $w, $h, $img_type);
	}

	/**
	 * Writes text at the specified x and y coordinates
	 *
	 * See {@link Style::munge_color()} for the format of the color array.
	 *
	 * @param float $x
	 * @param float $y
	 * @param string $text the text to write
	 * @param string $font the font file to use
	 * @param float $size the font size, in points
	 * @param array $color
	 * @param float $adjust word spacing adjustment
	 */
	//***function text($x, $y, $text, $font, $size, $color = array (0, 0, 0), $adjust = 0, $angle = 0, $blend = "Normal", $opacity = 1.0) {
	function text($x, $y, $text, $font, $size, $color = array(0, 0, 0), $adjust = 0.0, $char_space = 0.0, $angle = 0.0) { //***
		//Helpers::dompdf_debug("trace", "($x, $y, $text, ". basename($font) .", $size, [$color[0], $color[1], $color[2]], $adjust, $angle, $blend, $opacity)");

		list ($r, $g, $b) = $this->_get_rgb($color);
		$this->_pdf->SetTextColor($r, $g, $b);
		//***$this->_set_line_transparency($blend, $opacity);
		//***$this->_set_fill_transparency($blend, $opacity);

		$fontdata = $this->_get_font($font);
		$this->_pdf->SetFont($fontdata['family'], $fontdata['style'] /*strpos($font, '-Bold') === false ? '' : 'B'*/, $size, $font);

		//$this->_pdf->SetFontSize($size); // ???

		if ($adjust > 0) {
			$a = explode(' ', $text);
			//$this->_pdf->SetXY($x - 3, $y + (self::FONT_HEIGHT_SCALE - 1) * $size);
			$this->_pdf->SetXY($x, $y);

			//$y += self::FONT_HEIGHT_SCALE * $size + 1;
			for ($i = 0; $i < count($a)-1; $i++) {
				$this->_pdf->Write($size, $a[$i].' ', '');
				//$this->_pdf->Text($x, $y, $a[$i].' ');
				$this->_pdf->SetX($this->_pdf->GetX()+$adjust);
				//$x += $this->_pdf->GetX() + $adjust;
			}
			$this->_pdf->Write($size, $a[$i], '');
			//$this->_pdf->Text($x, $y, $a[$i].' ');
		}
		else {
			if ($angle != 0) {
				$this->_pdf->StartTransform();
				//$y += self::FONT_HEIGHT_SCALE * $size;
				//$y += $size;
				$this->_pdf->Rotate(-$angle, $x, $y);
				$this->_pdf->Text($x, $y, $text, false, false, true, 0, 0, '', 0, '', 0, false, 'T', 'T');
				$this->_pdf->StopTransform();
			}
			else {
				//$pippo = $this->_pdf->getFontAscent($fontdata['family'], $fontdata['style'], $size);
				//$y += $pippo / 8;
				//$y = $y - 0.85 * $size;	// + 0.8 * $size;
				$this->_pdf->Text($x, $y, $text, false, false, true, 0, 0, '', 0, '', 0, false, 'T', 'T');
			}
		}
	}

	/**
	 * Add a named destination (similar to <a name="foo">...</a> in html)
	 *
	 * @param string $anchorname The name of the named destination
	 */
	function add_named_dest($anchorname) {
		//Helpers::dompdf_debug("trace", "($anchorname)");
		$link = $this->_pdf->AddLink();
		$this->_pdf->SetLink($link, -1, -1);
		$this->_nameddest[$anchorname] = $link;
	}

	/**
	 * Add a link to the pdf
	 *
	 * @param string $url The url to link to
	 * @param float  $x   The x position of the link
	 * @param float  $y   The y position of the link
	 * @param float  $width   The width of the link
	 * @param float  $height   The height of the link
	 */
	function add_link($url, $x, $y, $width, $height) {
		//Helpers::dompdf_debug("trace", "($url, $x, $y, $width, $height)");

		if (strpos($url, '#') === 0) {
			// Local link
			$name = substr($url, 1);
			if ($name) {
				$page = $this->_pdf->PageNo();
				//$this->_pdf->Link($x, $y, $width, $height, $this->_nameddest[$name]);
				$this->_internal_links[] = compact('page', 'name', 'x', 'y', 'width', 'height');	//array($this->_pdf->PageNo(), $name, $x, $y, $width, $height);
			}
		}
		else {
			$this->_pdf->Link($x, $y, $width, $height, rawurldecode($url));
		}
	}

	/**
	 * Calculates text size, in points
	 *
	 * @param string $text the text to be sized
	 * @param string $font the desired font
	 * @param float  $size the desired font size
	 * @param float  $spacing word spacing, if any
	 * @return float
	 */
	function get_text_width($text, $font, $size, $word_spacing = 0, $char_spacing = 0) {
		// Determine the additional width due to extra spacing
		$num_spaces = mb_substr_count($text, " ");
		$delta = $word_spacing*$num_spaces;
		$fontdata = $this->_get_font($font);
		$result = $this->_pdf->GetStringWidth($text, $fontdata['family'], $fontdata['style'], $size)+$delta; //$font);
		//Helpers::dompdf_debug("trace", "($text, ". basename($font) .", $size, $word_spacing, $char_spacing): returns $result");
		return $result;
	}

	/**
	 * Calculates font height, in points
	 *
	 * TCPDF lacks a method to get the font height
	 *
	 * @param string $font
	 * @param float $size
	 * @return float
	 */
	function get_font_height($font, $size) {
		if (!$font) {
			$fontFamily = $this->_pdf->getFontFamily();
			$fontStyle = $this->_pdf->getFontStyle();
		}
		else {
			$fontdata = $this->_get_font($font);
			$fontFamily = $fontdata['family'];
			$fontStyle = $fontdata['style'];
			$this->_pdf->SetFont($fontFamily, $fontStyle, $size, $font);
		}
		if (strpos($fontStyle, 'B') !== false) {
			$scale = self::FONT_HEIGHT_SCALE_BOLD;
		}
		else {
			$scale = self::FONT_HEIGHT_SCALE_NORMAL;
		}
		$result = $scale * $size;
		//Helpers::dompdf_debug("trace", "(". basename($font) .", $size): returns $result");
		return $result;
	}

	function get_font_baseline($font, $size) { // b3
		//***return $this->get_font_height($font, $size) / DOMPDF_FONT_HEIGHT_RATIO;
		$ratio = $this->_dompdf->get_option("font_height_ratio"); //***
		return $this->get_font_height($font, $size) / $ratio; //***
	}

	/**
	 * Sets the opacity
	 *
	 * @param $opacity
	 * @param $mode
	 */
	function set_opacity($opacity, $mode = "Normal") {
		//Helpers::dompdf_debug("trace", "($opacity, $mode)");
		$this->_set_line_transparency($mode, $opacity);
		$this->_set_fill_transparency($mode, $opacity);
	}

	function set_default_view($view, $options = array()) { // b3
		array_unshift($options, $view);
		$currentPage = $this->_pdf->currentPage;
		call_user_func_array(array($this->_pdf, "openHere"), $options);
	}

	/**
	 * Starts a new page
	 *
	 * Subsequent drawing operations will appear on the new page.
	 */
	function new_page() {
		//Helpers::dompdf_debug("trace", "()");

		// Add objects to the current page
		$this->_place_objects();

		//$this->_pdf->endPage();
		$this->_pdf->lastPage();

		$this->_pdf->AddPage();
		//$this->_page_count++;
		$this->_pages[] = $this->_pdf->PageNo();
		return $this->_pdf->getNumPages();
	}

	/**
	 * Streams the PDF directly to the browser
	 *
	 * @param string $filename the name of the PDF file
	 * @param array  $options associative array, 'Attachment' => 0 or 1, 'compress' => 1 or 0
	 */
	function stream($filename, $options = null) {
		//Helpers::dompdf_debug("trace", "($filename, $options)");

		// Add page text
		$this->_add_page_text();
		$this->_add_internal_links();

		// TCPDF expects file name with extension (cf. Cpdf expects file name without extension) //***
		if (!preg_match('/\.pdf$/', $filename))
			$filename .= ".pdf";

		$options["Content-Disposition"] = $filename;

		if ( isset($options["compress"]) && $options["compress"] == 0 )
		$compress = false;
		else
		$compress = true;

		$this->_pdf->SetCompression($compress);

		$this->_pdf->Output($filename, $options["Attachment"] ? "D" : "I"); // ***
	}

	/**
	 * Returns the PDF as a string
	 *
	 * @param array  $options associative array: 'compress' => 1 or 0
	 * @return string
	 */
	function output($options = null) {
		//Helpers::dompdf_debug("trace", "($options[compress])");

		// Add page text
		$this->_add_page_text();
		$this->_add_internal_links();

		$this->_place_objects();

		if ( isset($options["compress"]) && $options["compress"] == 0 ) {
			$compress = false;
		}
		else {
			$compress = true;
		}

		$this->_pdf->SetCompression($compress);

		return $this->_pdf->Output('', 'S');
	}

	/**
	 *
	 * @param $code
	 * @return unknown_type
	 */
	function javascript($code) {
		// STUB
	}

	/**
	 * Other public methods callable from user pages
	 */
	/**
	 * Writes text at the specified x and y coordinates on every page
	 *
	 * The strings '{PAGE_NUM}' and '{PAGE_COUNT}' are automatically replaced
	 * with their current values.
	 *
	 * See {@link Style::munge_colour()} for the format of the colour array.
	 *
	 * @param float $x
	 * @param float $y
	 * @param string $text the text to write
	 * @param string $font the font file to use
	 * @param float $size the font size, in points
	 * @param array $color
	 * @param float $adjust word spacing adjustment
	 * @param float $angle angle to write the text at, measured CW starting from the x-axis
	 */
	function page_text($x, $y, $text, $font, $size, $color = array(0,0,0), $adjust = 0, $angle = 0) {
		//Helpers::dompdf_debug("trace", "($x, $y, $text, ". basename($font) .", $size, $color, $adjust, $angle, $blend, $opacity)");

		$_t = "text";
		$this->_page_text[] = compact("_t", "x", "y", "text", "font", "size", "color", "adjust", "angle");
	}

	/**
	 * Processes a script on every page
	 *
	 * The variables $pdf, $PAGE_NUM, and $PAGE_COUNT are available.
	 *
	 * This function can be used to add page numbers to all pages
	 * after the first one, for example.
	 *
	 * @param string $code the script code
	 * @param string $type the language type for script
	 */
	function page_script($code, $type = "text/php") {
		$_t = "script";
		$this->_page_text[] = compact("_t", "code", "type");
	}
}

// Workaround for idiotic limitation on statics...
\Dompdf\Adapter\TCPDF::$PAPER_SIZES = \Dompdf\Adapter\CPDF::$PAPER_SIZES;

/**
 * Class added to access the protected methods/variables of TCPDF
 *
 * It assumes that $this->page does not change while an object is opened
 */
class My_TCPDF extends \TCPDF { //***
	private $dompdf_num_objects = 0;
	private $dompdf_objects = array();

	private $dompdf_num_stack = 0;
	private $dompdf_stack = array();

	function getPageBuffer($page) {
		return parent::getPageBuffer($page);
	}

	function setPageBuffer($page, $data, $append=false) {
		parent::setPageBuffer($page, $data, $append);
	}

	/**
	 * save the TCPDF output buffer content in a stack and initialize it to an empty string
	 * the function will return an object ID
	 *
	 * NOTE: can this method be called again without first issuing a closeObject()?
	 */
	function openObject() {
		//Helpers::dompdf_debug("trace", "Enter My_TCPDF.openObject(state = $this->state)");

		if ($this->state == 2) {
			$curr_buffer = $this->getPageBuffer($this->page);
		}
		else {
			$curr_buffer = $this->getBuffer();
		}

		$this->dompdf_num_stack++;
		$this->dompdf_stack[$this->dompdf_num_stack] = array('c' => $curr_buffer, 'p' => $this->page, 'g' => $this->getGraphicVars());

		//Helpers::dompdf_debug("trace", "---------> " . $curr_buffer);

		if ($this->state == 2) {
			$this->setPageBuffer($this->page, '');
		}
		else {
			$this->buffer = '';
			$this->bufferlen = strlen($this->buffer);
		}
		$this->page = 1;	// some output is not done if page = 0 (e.g SetDrawColor())

		$this->dompdf_num_objects++;
		$this->dompdf_objects[$this->dompdf_num_objects] = array('c' => '', 'p' => 0, 'g' => null);

		return $this->dompdf_num_objects;
	}

	/**
	 * restore the saved TCPDF output buffer content
	 */
	function closeObject() {
		//Helpers::dompdf_debug("trace", "Enter My_TCPDF.closeObject(state = $this->state)");
		if ($this->dompdf_num_stack > 0) {

			if ($this->state == 2) {
				$curr_buffer = $this->getPageBuffer($this->page);
			}
			else {
				$curr_buffer = $this->getBuffer();
			}

			$this->dompdf_objects[$this->dompdf_num_objects]['c'] = $curr_buffer;
			$this->dompdf_objects[$this->dompdf_num_objects]['p'] = $this->page;
			$this->dompdf_objects[$this->dompdf_num_objects]['g'] = $this->getGraphicVars();

			//Helpers::dompdf_debug("trace", "--------- OBJECT buffer -------> " . $curr_buffer);

			$saved_stack = $this->dompdf_stack[$this->dompdf_num_stack];

			//Helpers::dompdf_debug("trace", "--------- saved buffer -------> " . $saved_stack['c']);

			if ($this->state == 2) {
				$this->setPageBuffer($this->page, $saved_stack['c']);
			}
			else {
				$this->buffer = $saved_stack['c'];
				$this->bufferlen = strlen($this->buffer);
			}
			$this->page = $saved_stack['p'];
			$this->setGraphicVars($saved_stack['g']);

			unset($this->dompdf_stack[$this->dompdf_num_stack]);
			$this->dompdf_num_stack--;
		}
	}


	/**
	 * reopen an existing object for editing
	 * save the TCPDF output buffer content in the stack and initialize it with the contents of the object being reopened
	 */
	function reopenObject($id) {
		//Helpers::dompdf_debug("trace", "Enter My_TCPDF.reopenObject($id)");

		if ($this->state == 2) {
			$curr_buffer = $this->getPageBuffer($this->page);
		}
		else {
			$curr_buffer = $this->getBuffer();
		}

		$this->dompdf_num_stack++;
		$this->dompdf_stack[$this->dompdf_num_stack] = array('c' => $curr_buffer, 'p' => $this->page, 'g' => $this->getGraphicVars());

		if ($this->state == 2) {
			$this->setPageBuffer($this->page, $this->dompdf_objects[$id]['c']);
		}
		else {
			$this->buffer = $this->dompdf_objects[$id]['c'];
			$this->bufferlen = strlen($this->buffer);
		}
		$this->page = 1;

		//$this->page = $this->dompdf_objects[$id]['p'];

		$this->setGraphicVars($this->dompdf_objects[$id]['g']);
	}

	function getObject($id) {
		//Helpers::dompdf_debug("trace", "Enter My_TCPDF.getObject($id)");
		return $this->dompdf_objects[$id];
	}
}

function endsWith($haystack,$needle,$case=true) {
	if($case){return (strcmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);}
	return (strcasecmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);
}