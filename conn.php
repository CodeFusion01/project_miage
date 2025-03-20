<?php 
    $localhost = "localhost";
    $username = "root";
    $password = "";
    $db_name = "prdatabase";

    $conn = mysqli_connect($localhost,$username,$password,$db_name);
    if(!$conn){
        echo "connection is not connected ...";
    }


?>