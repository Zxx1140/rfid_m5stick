<?php  
//Connect to database
require 'connectDB.php';
date_default_timezone_set('Asia/Bangkok');
$d = date("Y-m-d");
$t = date("H:i:sa");

//get data
if (isset($_GET['key_uid']) && isset($_GET['device_token'])) {
    
    $key_uid = $_GET['key_uid'];
    $device_uid = $_GET['device_token'];

    $sql = "SELECT * FROM devices WHERE device_uid=?";

    $result = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($result, $sql)) {
        echo "SQL_Error_Select_device";
        exit();
    }
    else
    {
        mysqli_stmt_bind_param($result, "s", $device_uid);
        mysqli_stmt_execute($result);
        $resultl = mysqli_stmt_get_result($result);
        if ($row = mysqli_fetch_assoc($resultl)){
            $device_mode = $row['device_mode'];
            $device_dep = $row['device_dep'];
            
            if ($device_mode == 1) {
                $sql = "SELECT * FROM users WHERE password_user=?";
                $result = mysqli_stmt_init($conn);
                if (!mysqli_stmt_prepare($result, $sql)) {
                    echo "SQL_Error_Select_card";
                    exit();
                }
                else{
                    mysqli_stmt_bind_param($result, "s", $key_uid);
                    mysqli_stmt_execute($result);
                    $resultl = mysqli_stmt_get_result($result);
                    if ($row = mysqli_fetch_assoc($resultl)){
                        //*****************************************************
                        //IF detected key for login ro logout
                        if ($row['add_card'] == 1){
                        if ($row['device_uid'] == $device_uid || $row['device_uid'] == 0){
                                $Uname = $row['username'];
                                $Number = $row['serialnumber'];
                                $card_uid = $row['card_uid'];

                                
                                
                                
                                $sql_log = "SELECT * FROM rfidattendance.users_logs WHERE card_uid=? AND checkindate=? AND card_out=0";
                                $sql_log_m = "SELECT IF(ISNULL(ul.id), 0, ul.id) AS 'id' FROM rfidattendance.users_logs AS ul WHERE card_uid='$card_uid' AND checkindate='$d' AND card_out=0";
                                $result = mysqli_stmt_init($conn);
                                if (!mysqli_stmt_prepare($result, $sql_log)) 
                                {
                                    echo "SQL_Error_Select_logs";
                                    exit();
                                }
                                else
                                {
                                    mysqli_stmt_bind_param($result, "ss", $key_uid, $d);
                                    mysqli_stmt_execute($result);
                                    $resultl = mysqli_stmt_get_result($result);

                                    $find_check_in = mysqli_query($conn, $sql_log_m);
                                    $rows = mysqli_fetch_assoc($find_check_in);
                                    $user_log_id = $rows ? $rows['id'] : 0;
                                    if ($user_log_id == 0)
                                    {
                                        $sql = "INSERT INTO users_logs (username, serialnumber, card_uid, device_uid, device_dep, checkindate, timein, timeout,password_logs) VALUES (? ,?, ?, ?, ?, ?, ?, ?,?)";
                                        $result = mysqli_stmt_init($conn);
                                        if (!mysqli_stmt_prepare($result, $sql))
                                        {
                                            echo "SQL_Error_Select_login1";
                                            exit();
                                        } 
                                        else
                                        {
                                            $timeout = "00:00:00";
                                            mysqli_stmt_bind_param($result, "sdsssssss", $Uname, $Number, $card_uid, $device_uid, $device_dep, $d, $t, $timeout, $key_uid);
                                            mysqli_stmt_execute($result);

                                            echo "Login\r\n$Uname";
                                            exit();
                                        }
                                    }
                                    //*****************************************************
                                    else
                                    {
                                        $sql="UPDATE users_logs SET timeout=?, card_out=1 WHERE card_uid=? AND checkindate=? AND card_out=0";
                                        $result = mysqli_stmt_init($conn);
                                        if (!mysqli_stmt_prepare($result, $sql)) {
                                            echo "SQL_Error_insert_logout1";
                                            exit();
                                        }
                                        else
                                        {
                                            mysqli_stmt_bind_param($result, "sss", $t, $card_uid, $d);
                                            mysqli_stmt_execute($result);

                                            echo "LogOut\r\n$Uname";
                                            exit();
                                        }
                                    }
                                }
                            }
                            else {
                                echo "Not Allowed!";
                                exit();
                            }
                        }
                        
                    }
                    else{
                        echo "Not found!";
                        exit();
                    }
                }
            }
            
        }
        else{
            echo "Invalid Device!";
            exit();
        }
    }          
}
?>