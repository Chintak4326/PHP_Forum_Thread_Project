<?php
    include('db_connect.php');
    $showError = "false";
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $user_email = $_POST['email'];
        $pass = $_POST['password'];
        $cpass = $_POST['cpassword'];

        // check whether this email exists
        $existsSql = "SELECT * FROM `users` WHERE user_email = '$user_email'";
        $result = mysqli_query($conn,$existsSql);
        $numRows = mysqli_num_rows($result);
        if($numRows>0){
            $showError = "Email already in use";
        }else{
            if($pass == $cpass){
                $hash = password_hash($pass, PASSWORD_DEFAULT);
                $sql = "INSERT INTO `users` (`user_email`, `user_pass`, `timestamp`) VALUES ('$user_email', '$hash', CURRENT_TIMESTAMP())";
                $result = mysqli_query($conn,$sql);
                // echo $result;
                // die;
                if($result){
                    $showAlert = true;
                    header("location: /forum/index.php?signupsuccess=true");
                    exit();
                }
            }else{
                $showError = "Password do not match";
            }
        }
        header("location: /forum/index.php?signupsuccess=false&error=$showError");
    }
?>