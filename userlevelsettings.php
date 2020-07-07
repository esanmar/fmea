<?php

/**
 * PHPMaker 2020 user level settings
 */
namespace PHPMaker2020\fmeaPRD;

// User level info
$USER_LEVELS = [["-2","Anonymous"],
	["0","Default"]];

// User level priv info
$USER_LEVEL_PRIVS = [["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}fmea","-2","104"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}fmea","0","239"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}processf","-2","104"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}processf","0","239"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}actions","-2","104"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}actions","0","239"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}severity","-2","104"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}severity","0","238"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}occurrence","-2","104"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}occurrence","0","238"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}detection","-2","104"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}detection","0","238"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}causes","-2","104"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}causes","0","238"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}reportfmea","-2","104"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}reportfmea","0","232"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}employees","-2","104"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}employees","0","108"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}factories","-2","104"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}factories","0","108"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}userlevelpermissions","-2","0"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}userlevelpermissions","0","0"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}userlevels","-2","0"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}userlevels","0","0"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}issue","-2","72"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}issue","0","239"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}workcenters","-2","0"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}workcenters","0","0"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}KPI","-2","0"],
	["{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}KPI","0","104"]];

// User level table info
$USER_LEVEL_TABLES = [["fmea","fmea","FMEA",true,"{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}"],
	["processf","processf","Process",true,"{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}"],
	["actions","actions","Actions (Man, Method, Material, Machine, Mother Nature, Meassurement)",true,"{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}"],
	["severity","severity","Severity Colour",true,"{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}"],
	["occurrence","occurrence","Occurrence Colour",true,"{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}"],
	["detection","detection","Detection Colour",true,"{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}"],
	["causes","causes","Causes",true,"{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}"],
	["reportfmea","reportfmea","Search",true,"{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}"],
	["employees","employees","Employees",true,"{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}"],
	["factories","factories","Factories",true,"{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}"],
	["userlevelpermissions","userlevelpermissions","User Permissions",true,"{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}"],
	["userlevels","userlevels","User Levels",true,"{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}"],
	["issue","issue","Issue",true,"{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}"],
	["workcenters","workcenters","workcenters",true,"{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}"],
	["KPI","KPI","KPI",true,"{192A25D1-CFC2-43DE-9FA2-22CF8EED3A4D}"]];