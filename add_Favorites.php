<?php
	require_once 'dbconnect.php';
	include 'navbar.php';
	//include 'functions.php';


	$file = $_GET['file'];
	$table = $_GET['table'];
	$file_id = get_file_id($file, $table, $conn);

	//get the user's current location so clicking the Favorite button won't take them away to another page
	$library = "library.php?table=";
	$location = $library . $table;

	//get student's ID to add the entry for the current student
	$ID = get_id($_SESSION['username'], $_SESSION['password'], $conn);

	//Function adds the file into the database with a forigen key to the chops_students table for the student who clicked the Favorite button
	add_Favorite($file, $ID, $file_id, $conn);

?>