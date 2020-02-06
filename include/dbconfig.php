<?php
 $conn=mysqli_connect('localhost','root','','shop_db');
 if(mysqli_connect_error($conn)){
     echo "Connection error".mysqli_error();
 }else{
     //echo "Connection Good";
 }