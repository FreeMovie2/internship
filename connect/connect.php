<?php
    error_reporting(0);
    $host = 'localhost'; //แก้ไขส่วนนนี้
    // $username = 'idwebonl_intership'; //แก้ไขส่วนนนี้
    // $password = 'kY95RZZNKerh6aehu6dE'; //แก้ไขส่วนนนี้
    // $database_name = 'idwebonl_intership'; //แก้ไขส่วนนนี้

    $username = 'root'; //แก้ไขส่วนนนี้
    $password = ''; //แก้ไขส่วนนนี้
    $database_name = 'student_internship'; //แก้ไขส่วนนนี้
    
    $conn = new mysqli($host,$username,$password,$database_name);

    if($conn->connect_errno){
        die("Connect failed" .$conn->connect_errno); 
    }
    
    $conn->set_charset('UTF8')

?>