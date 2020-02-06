<?php
require_once('./include/dbconfig.php');
session_start();
    if(isset($_POST['pid'])){
        $pid=$_POST['pid'];
        $pname=$_POST['pname'];
        $pprice=$_POST['pprice'];
        $pimage=$_POST['pimage'];
        $pcode=$_POST['pcode'];
        $qty=1;
       // echo "Product name= ".$pname;
    //   $sql="SELECT * FROM cart where product_code=$pcode";
    //   $result=mysqli_query($conn,$sql);
    //   $resultCheck=mysqli_num_rows($result);
    //   if($resultCheck > 0){
    //       echo "Product Already in the cart";
    //   }else{
    //       echo "Product Added";
    //   }

        $stmt=$conn->prepare("SELECT product_code FROM cart where product_code=?");
        $stmt->bind_param("s",$pcode);
        $stmt->execute();
        $result=$stmt->get_result();
        $r=$result->fetch_assoc();
        $code=$r['product_code'];
        if(!$code){
            $sql=$conn->prepare("INSERT INTO cart (product_name,product_price,product_image,Qty,total_price,product_code) VALUES(?,?,?,?,?,?)");
            $sql->bind_param('sssiss',$pname,$pprice,$pimage,$qty,$pprice,$pcode);
            $sql->execute();
            echo '<div class="alert alert-success alert-dismissible mt-2">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Item added to your cart!</strong>
                    </div>';

        }else{
            echo '<div class="alert alert-danger alert-dismissible mt-2">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Item already added to your cart!</strong>
                    </div>';
        }
    }
    if(isset($_GET['cartItem'])&& isset($_GET['cartItem']) == "cart_item"){
        $stmt=$conn->prepare("SELECT * FROM cart");
        $stmt->execute();
        $stmt->store_result();
        $rows=$stmt->num_rows;
        echo $rows;
    }
    $_SESSION['msg']="";
    $_SESSION['msgClass']="";
    if(isset($_GET['remove'])){
        $id=$_GET['remove'];
        $sql="DELETE FROM cart WHERE id='$id'";
        mysqli_query($conn,$sql);
        $_SESSION['msg']="Item has been remove from cart";
        $_SESSION['msgClass']="alert-success";
        header("Location:cart.php");
    }
    if(isset($_GET['clear'])){
        $sql="DELETE FROM cart";
        $result=mysqli_query($conn,$sql);
        $_SESSION['msg']="Your cart has been cleared";
        $_SESSION['msgClass']="alert-success";
        header("Location:cart.php");
    }
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

</body>
</html>