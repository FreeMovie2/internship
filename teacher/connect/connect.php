<?php
error_reporting(0);
    $conn = new mysqli('localhost','idwebonl_intership','kY95RZZNKerh6aehu6dE','idwebonl_intership');

    if($conn->connect_errno){
        die("Connect failed" .$conn->connect_errno); 
    }
    
    $conn->set_charset('UTF8')

?>
