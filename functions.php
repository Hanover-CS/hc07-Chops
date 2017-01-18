<?php
	//session_start();
	require_once 'dbconnect.php';

	//get the file address from the library tables
	function get_file_address($id, $table, $conn)
	{
		$query = "SELECT file FROM $table WHERE id = '$id'";
		$result = mysqli_fetch_array( mysqli_query($conn, $query) );
		return $result[0];
	}


	//get the user's ID by using their username and password
	function get_id($user, $pass, $conn)
	{
   		$get_id = "SELECT id FROM chops_students WHERE username= '$user' and password= '$pass'";

   		//execute then convert the get query into an array
   		$result = mysqli_fetch_array(mysqli_query($conn, $get_id));
   
   		//then access the 'id' field of that array from the query
   		return $result[0];
	}


	//get person's name
	function get_fname($user, $conn)
	{
		$get_name = "SELECT name FROM chops_students WHERE username= '$user'";

		 //execute then convert the get query into an array
   		$result = mysqli_fetch_array(mysqli_query($conn, $get_name));
   
   		//then access the 'name' field of that array from the query
   		return $result[0];

	}


	//get the file name from the library tables
	function get_file_name($id, $table, $conn)
	{
		$query = "SELECT name FROM $table WHERE id = '$id'";
		$result = mysqli_fetch_array( mysqli_query($conn, $query) );
		return $result[0];
	}


	//get the etude composer from the library tables
	function get_file_composer($id, $conn)
	{
		$query = "SELECT composer FROM chops_etudes WHERE id = '$id'";
		$result = mysqli_fetch_array( mysqli_query($conn, $query) );
		return $result[0];
	}


	//get the etude page number (if any)
	function get_page_num($id, $conn)
	{
		$query = "SELECT page FROM chops_etudes WHERE id = '$id'";
		$result = mysqli_fetch_array( mysqli_query($conn, $query) );
		return $result[0];
	}


	//get the audio's BPM from the library tables
	function get_audio_bpm($id, $conn)
	{
		$query = "SELECT BPM FROM chops_audio WHERE id = '$id'";
		$result = mysqli_fetch_array( mysqli_query($conn, $query) );
		return $result[0];
	}


	//get the rudiment_id from the library table
	function get_rudiment_id($id, $table, $conn)
	{
		$query = "SELECT rudiment_id FROM $table WHERE id = '$id'";
		$result = mysqli_fetch_array( mysqli_query($conn, $query) );
		return $result[0];
	}


	//get the user's ID by using their username and password
	function get_file_id($file, $table, $conn)
	{
   		$get_id = "SELECT id FROM $table WHERE file= '$file'";

   		//execute then convert the get query into an array
   		$result = mysqli_fetch_array(mysqli_query($conn, $get_id));
   
   		//then access the 'id' field of that array from the query
   		return $result[0];
	}


	//library_builder helper function -- Adds the starting html
	function html_starter()
	{
		echo 	"<!DOCTYPE HTML>
			  	<html>

			  	<head>
				<title>Chops/User/";

		echo $_SESSION['username'];

		echo 	"</title>
				<meta name='viewport' content='width=device-width, initial-scale=1.0'>

    			<!-- Bootstrap -->
    			<link href='css/bootstrap.min.css' rel='stylesheet' media='screen'>
				</head>";
	}


	//thumbnail builder template
	function thumbnail_open()
	{
		echo "<html>
  				<body>
        			<div class='col-sm-6 col-md-4'>
      	  				<div class='thumbnail'>";
	}


	//thumbnail builder back-end
	function thumbnail_close()
	{
		echo "  		</div>
    				</div>
  				</body>
			</html>";
	}


	//Favorite Button
	function favorite_button($file, $table, $ID, $conn)
	{
		$query = "SELECT file FROM chops_favorites as f JOIN chops_students as s ON s.id = f.student_id WHERE s.id = $ID";
   		$result = mysqli_fetch_array( mysqli_query($conn, $query) );
   		
   		for ($fav_count = 0; $fav_count < (count($result))-1; $fav_count++)
   		{

   			if ($file == $result[$fav_count])
   			{
   				echo "<button type='button' class='btn btn-default btn-lg'>
    				<span class='glyphicon glyphicon-star' aria-hidden='true'></span> Favorited </button>";
   			} 
   		}

   		if ($file != $result[0])
   		{
   					echo "<form action = 'add_Favorites.php?table='"; echo $table; echo "method = 'POST'>
               			<button type='button' class='btn btn-default btn-lg'>
    			  			<span class='glyphicon glyphicon-star-empty' aria-hidden='true'></span>
                  			<input type = 'hidden' name = 'file' value = '$file'/>
                  			<input type = 'hidden' name = 'table' value = '$table'/>
                  			<input type = 'submit' value = ' Favorite! '/></button>";
               		echo "</form>";
   		}
	}


	//Add a file to Favorites
	function add_Favorite($file, $ID, $file_id, $conn)
	{
		$query = "INSERT INTO chops_favorites (student_id, file_id, file) VALUES ($ID, $file_id, '$file')";
		$result = mysqli_query($conn, $query);

		if (!$result)
		{
			echo "alert ('Cannot Add to Favorites at this time!')";
		}

		header("Location: index.php");

	}




	//get Favorites section
	function get_Favorites($ID, $table, $conn)
	{
		// --- FIX THIS ---
		$query = "SELECT f.file, f.file_id FROM chops_favorites as f 
					JOIN chops_students as s ON s.id = f.student_id 
					JOIN $table as t ON t.file = f.file 
					WHERE f.student_id = $ID";

		$result = mysqli_fetch_array( mysqli_query($conn, $query) );


		if ($result)
		{
			if ($table == 'chops_etudes')
			{
				thumbnail_open();
				favorite_button($result[0], $table, $ID, $conn);
				display_Etudes($result[1], 'chops_etudes', $conn);
				thumbnail_close();
			}
		} else {
			echo "<center><h5>You don't have anything <font color = 'red'>Favorited</font> yet! Check out the content Libraries above!</h5></center>";
		}
	}


	//for use in the library builder --- ETUDES
	function display_Etudes($counter, $table, $conn)
	{
		//thumbnail image
  		echo "<img src=";
  		echo get_file_address($counter, $table, $conn); 
  		// The space inbetwee the open " and the alt='Etude' is IMPORTANT
  		echo " alt='Etude' style='width:242px; height:200px;'>";
     	echo "<div class='caption'>";

     	//Etude Title
        echo '<h3>"';
        echo get_file_name($counter, $table, $conn); 
        echo '"</h3>';

        //Etude Composer
    	echo "<p>Composer: ";
    	echo get_file_composer($counter, $conn); 
    	echo "</p>";


    	$page = get_page_num($counter, $conn);
    	if ($page)
    	{
    		//Page #
    		echo "<p>Page: ";
    		echo $page;
    		echo "</p>";
    	}

    	//Link to access JPG image of the Etude
    	echo "<p><a href=";
    	echo get_file_address($counter, $table, $conn);
    	// The space inbetwee the open " and the class='bin is IMPORTANT
    	echo " class='btn btn-primary' role='button'>Check it out!</a></p>";
	}


	//for use in the library builder --- AUDIO
	function display_Audio($counter, $table, $conn)
	{
		//Audio player
  		echo "<audio controls> <source src=";
  		echo get_file_address($counter, $table, $conn); 
  		// The space inbetwee the open " and the type='audio' is IMPORTANT
  		echo " type='audio/wav'> 
  		Your browser does not support the audio element.	
		</audio>;";
     	echo "<div class='caption'>";

     	//Audio's Title
        echo "<h3>";
        echo get_file_name($counter, $table, $conn); 
        echo "</h3>";

        //Audio's BPM
    	echo "<p>";
    	echo get_audio_bpm($counter, $conn); 
    	echo " BPM</p>";

	}



	//for use in the library builder --- VIDEOS
	function display_Videos($counter, $table, $conn)
	{
		//Video thumbnail
  		echo "<video width='320' height='240' controls>
  		<source src=";
  		echo get_file_address($counter, $table, $conn); 
  		// The space inbetwee the open " and the alt='Etude' is IMPORTANT
  		echo " type='video/mp4'>
  		Your browser does not support the video tag.
		</video>";
     	echo "<div class='caption'>";

     	//Video Title
        echo "<h3>";
        echo get_file_name($counter, $table, $conn); 
        echo "</h3>";

        //Video's Rudiment
    	echo "<p> Rudiment Presented: ";
    	echo get_rudiment_id($counter, $table, $conn); 
    	echo "</p>";

    	//Link to access video player
    	echo "<p><a href=";
    	echo get_file_address($counter, $table, $conn);
    	// The space inbetwee the open " and the class='bin is IMPORTANT
    	echo " class='btn btn-primary' role='button'>Click Here for Full Screen</a></p>";
	}


	//Building the "homepage" for the Rudiments
	function display_Rudi($counter, $table, $conn)
	{
		$file = get_file_address($counter, $table, $conn);

		//Rudiment preview thumbnail
		echo "<img src=";
  		echo $file; 
  		// The space inbetwee the open " and the alt='Rudiment' is IMPORTANT
  		echo " alt='Rudiment' style='width:242px; height:200px;'>";
     	echo "<div class='caption'>";

     	//Rudiment
    	echo "<h3> Rudiment #";
    	echo get_file_id($file, $table, $conn); 
    	echo "</h3>";

    	//Link to access Rudiment page
    	echo "<p><a href=rudiment.php?id="; echo $counter; //--- FIX THIS ---
    	//echo get_rudi_page($counter, $table, $conn);
    	// The space inbetwee the open " and the class='bin is IMPORTANT
    	echo " class='btn btn-primary' role='button'>Click Here to learn this Rudiment</a></p>";
	}
	            
	//more functions go here...

?>