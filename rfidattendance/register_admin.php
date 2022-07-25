<?php
require 'connectDB.php';
session_start();  


?>
<?php

if(isset($_POST['register'])){

    if(empty($_POST["admin_name"]) || empty($_POST["admin_email"]) || empty($_POST["admin_password"]))  
      {  
           echo '<script>alert("ต้องระบุทั้งสามช่อง")</script>';  

      }  
      else  
      {  
        $admin_name =   $_POST["admin_name"];
        $admin_email =  $_POST["admin_email"];
        $admin_password = $_POST["admin_password"];
        $admin_password = password_hash($admin_password, PASSWORD_DEFAULT);
        $query = "INSERT INTO admin(admin_name, admin_email, admin_pwd) VALUES('$admin_name','$admin_email','$admin_password')";
        
        if(mysqli_query($conn,$query)){
            echo '<script>alert("Registration Done")</script>';  
           

        }

}
}
?>
<!DOCTYPE html>  
 <html>  
      <head>  
           <title>Register</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
      </head>  
      <body>  
           <br /><br />  
           <div class="container" style="width:500px;">  
                
                <br />  
               
                <h3 align="center">Register</h3>  
                <br />  
                <form method="post">  
                     <label>Enter NAME</label>  
                     <input type="text" name="admin_name" class="form-control" />  
                     <br />


                     <label>Enter Email</label>  
                     <input type="text" name="admin_email" class="form-control" />  
                     <br />    


                     <label>Enter Password</label>  
                     <input type="text" name="admin_password" class="form-control" />  
                     <br />  


                     <input type="submit" name="register"  value="Register" class="btn btn-info" />  
                     <br />  
                     <p align="center"><a href="login.php">Back</a></p>  
                </form>  
              
            
                 
           </div>  
      </body>  
 </html>  