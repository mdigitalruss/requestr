<?
/*
 * 	example.php
 * 	Example for requesr lib, a simple PHP request/inclusion system
 *  Copyright (c) 2013 Razor Studios
 */
 
 	require("../lib/requestr.php");
	
	// Create the page using requesr
	//		First value is the GET param, this will be used as the class name too
	//		Second value is the GET param which will be used for the function we want to run
	//		Third value is the folder where your included pages are
	
	// If your url is ?action=home&subaction=news then you need to have:
	//	- action_home.php in /pages
	// - class action_home in action_home.php
	//	- function subaction_news() in class action_home
	
	$page = new requestr('action','subaction','pages');
	
?>
<!doctype html>
<html>
	<head><title>Requestr Example - By Razor Studios</title></head>
	<body>
		<h1>Requestr Example</h1>
		<hr/>
		<?
			$page->run();	// Run the function
		?>
		<hr/>
		<p>Above text was generated by requestr</p>
		<p style="text-align:Center; font-size:12px; color:#333;">Requestr - Copyright (c) 2013 Razor Studios</p>
		
	</body>
</html>