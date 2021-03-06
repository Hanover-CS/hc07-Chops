<?php
 
  //include the navbar, which in turn haas access to the functions file
  include $_SERVER['DOCUMENT_ROOT'] . '/chops/hc07-chops/navbar.php';

  //the navbar puts what table is being accessed in the URL of the page
  //So I "get" that field and that helps determine which database table to grab from
  $table = $_GET['table'];

  //determine how many content elements need to appear on the page
  $length = (Database::connect()->countRows($table))->num_rows;
 
?>
<!DOCTYPE HTML>
  <html>

    <head>
      <title>Chops/User <?php echo $student->getUsername(); ?></title>
 
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <!-- Bootstrap -->
        <link href='../css/bootstrap.min.css' rel='stylesheet' media='screen'>
 
    </head>
 
  <body>

  <div class="jumbotron">
        <div class="container">
          <!-- RUDIMENT BANNER -->
          <?php include $_SERVER['DOCUMENT_ROOT'] . '/chops/hc07-chops/Library/rudiment_banner.html'; ?>
        </div>
    </div>

  
    <div class="container">
 
      <div class="row">
 

 
      <?php
      
      //Using this counter as both a counter and
      //the ID fields of the database since they both start at 1
      //and go until the last row of the given $table
      for ($counter = 1; $counter <= $length; $counter++) 
      {

        //New Content Object
        $content = new Content($counter, $table);

        echo $twig->render('thumbnail_rudiment.html', 
            array('file_pic' => $content->getFileAddress(),
                  'name' => $content->getFileName(),
                  'ID' => $content->getRudimentID(),
                  'table' => $table
                ));
 
        //This is used to determine if/when a row should end. A row should only be 3 items, 
        //enough to fit nicely on a page.
        //When the 3 item limit is reached, it closes that row's div tag and opens another row. 
        if ($counter % 3 == 0)
        {
          //Close current ROW div and then reopen another ROW
          echo "</div>" . "<div class='row'>";
        }

      }?>

 
      </div>
 
    </div>
 
  </body>
 
</html>