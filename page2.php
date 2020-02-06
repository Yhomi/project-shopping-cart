<?php
    require "include/dbconfig.php";
    
    if(isset($_POST['action']) && isset($_POST['action'])== "order"){
        $name=mysqli_real_escape_string($conn,$_POST['name']);
        $email=mysqli_real_escape_string($conn,$_POST['email']);
        $phone=mysqli_real_escape_string($conn,$_POST['phone']);
        $address=mysqli_real_escape_string($conn,$_POST['address']);
        $products=mysqli_real_escape_string($conn,$_POST['products']);
        $grand_total=mysqli_real_escape_string($conn,$_POST['grand_total']);
        $pmode=$_POST['pmode'];
        $data="";
        $sql="INSERT INTO orders(name,email,phone,address,pmode,products,amount_paid) VALUES('$name','$email','$phone','$address','$pmode','$products','$grand_total')";
        mysqli_query($conn, $sql);
        $data .='<div class="text-center">
            <h1 class="display-4 mt-2 text-primary">Thank You For Your Patronage !</h1>
            <h2 class="text-success">Your Order has been placed successfully</h2>
            <h4 class="bg-danger text-light rounded p-2">Items purchased: '.$products.'</h4>
            <h4>Your Name: '.$name.'</h4>
            <h4>Your Email: '.$email.'</h4>
            <h4>Your Phone No: '.$phone.'</h4>
            <h4>Total Amount Paid: $'.number_format($grand_total,2).'</h4>
            <h4>Payment Mode: '.$pmode.'</h4>
        </div>';
        echo $data;
    }
?>