<?php  
session_start();
?>
<div class="table-responsive" style="max-height: 500px;"> 
  <table class="table">
    <thead class="table-primary">
      <tr>
        
        <th>Name</th>
        <th>Serial Number</th>
        <th>Card UID</th>
        <th>Device Dep</th>
        <th>Student ID</th>
        <th>Date</th>
        <th>Time In</th>
        <th>Time Out</th>
        <th>image</th>
      </tr>
    </thead>
    <tbody class="table-secondary">
      <?php

        //Connect to database
        require 'connectDB.php';


  
        $sql = "SELECT * FROM users_logs WHERE id ORDER BY id DESC";
        $sql_image=mysqli_query($conn,"SELECT * FROM rfidattendance.image_logs WHERE id_image ORDER BY id_image DESC");
      //  $sql ="SELECT * FROM users_logs LEFT JOIN image_logs on users_logs.id= image_logs.id_image;";
        $result = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($result, $sql)) {
            echo '<p class="error">SQL Error</p>';
        }
        else{
         
            mysqli_stmt_execute($result);
            $resultl = mysqli_stmt_get_result($result);
            if (mysqli_num_rows($resultl) > 0){
                while (($row = mysqli_fetch_assoc($resultl)) && ($row_image=mysqli_fetch_array($sql_image)) ){
        ?>
                  <TR>
               
                  <TD><?php echo $row['username'];?></TD>
                  <TD><?php echo $row['serialnumber'];?></TD>
                  <TD><?php echo $row['card_uid'];?></TD>
                  <TD><?php echo $row['device_dep'];?></TD>
                  <TD><?php echo $row['password_logs'];?></TD>
                  <TD><?php echo $row['checkindate'];?></TD>
                  <TD><?php echo $row['timein'];?></TD>
                  <TD><?php echo $row['timeout'];?></TD>
                  
                 

                  <TD><?php echo "<img src='  ".$row_image['filename']."  ' style='width: 100px;'>"?></TD>
                  
                </TR>
      <?php
                }
              
              
                }
            }
      
      ?>
      
    </tbody>
  </table>
</div>