<?php
    require "include/dbconfig.php";
    if(isset($_POST['qty'])){
        $qty=$_POST['qty'];
        $pid=$_POST['pid'];
        $pprice=$_POST['pprice'];

        $totalPrice= $pprice*$qty;

        $sql="UPDATE cart SET Qty='$qty',total_price='$totalPrice' WHERE id='$pid'";
        mysqli_query($conn, $sql);
    }
?>