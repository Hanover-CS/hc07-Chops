<?php
   require_once 'login.php'
?>

<html>
   
   <head>

      <title>Login Page</title>
      
   </head>
   
   <body>
	
      <div align = "center">
         <div style = "width:300px; border: solid 1px #333333; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
				
            <div style = "margin:30px">
               
               <form action = "" method = "POST">
                  <label>Username  :</label><input type = "text" name = "username" class = "box" /><br>
                  <label>Password  :</label><input type = "password" name = "password" class = "box" /><br>
                  <input type = "submit" value = " Submit "/><br>
                  <p>Not registered yet? <a href='reg.php'>Sign Up Here</a></p>
               </form>
					
            </div>
				
         </div>
			
      </div>

   </body>
</html>