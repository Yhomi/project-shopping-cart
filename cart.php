<?php

    session_start();
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cart System</title>
    <!-- Font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css" integrity="sha256-46qynGAkLSFpVbEBog43gvNhfrOj+BmwXdxFgVK/Kvc=" crossorigin="anonymous" />
    <!--Bootsrap CDN-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="index.php"><i class="fas fa-shopping-basket"></i> &nbsp; &nbsp; White Xpress</a>
        <a class="nav-link" href="">Home <span class="sr-only">(current)</span></a>
        <a class="nav-link" href="">Product <span class="sr-only">(current)</span></a> 
    
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link active" href="">Checkout</a>
        </li>
        <li class="nav-item">
        <a class="nav-link active" href=""><i class="fas fa-shopping-cart"></i> <span id="cart-item" class="badge badge-danger">0</span> </a>
        </li>
        
        </ul>
        </div>
    </nav> 
<br>
<div class="container ">
    
    <div class="row justify-content-center">
        <div class="col-lg-10">
        <?php if(isset($_SESSION['msg'])): ?>
            <div class="alert <?php echo $_SESSION['msgClass']; ?> alert-dismissible mt-5">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong><?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?></strong>
            </div>
    <?php endif ?>
            <div class="table-responsive mt-5">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <td colspan="7">
                                <h4 class="text-center text-info m-0">Products in your cart!</h4>
                            </td>
                        </tr>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            <th>
                                <a href="action.php?clear=all" class="btn btn-danger" onclick="return confirm('Are you sure you want to clear cart')">Clear Cart<i class="fas fa-trash p-1"></i></a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            require "include/dbconfig.php";
                            $sql="SELECT * FROM cart";
                            $result=mysqli_query($conn,$sql);
                            $grand_total=0;
                        ?>
                        <?php while($row=$result->fetch_assoc()): ;?>
                        
                        <tr>
                        
                            <td>
                                <?php echo $row['id']; ?>
                            </td>
                            
                            <input type="hidden" value="<?php echo $row['id']; ?>" class="pid">
                            <td><img src="<?php echo $row['product_image']; ?>" width="50"></td>
                            <td><?php echo $row['product_name']; ?></td>
                            <td>$<?php echo number_format($row['product_price'],2); ?></td>
                            <input type="hidden" value="<?php echo $row['product_price']; ?>" class="pprice">
                            <td>
                                <input type="number" value="<?php echo $row['Qty']; ?>" class="form-control w-25 itemQty">
                            </td>
                            <td>$<?php echo number_format($row['total_price'],2); ?></td>
                            <td>
                                <a href="action.php?remove=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are You Sure you want to remove this item from cart')"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                        <?php $grand_total+=$row['total_price']; ?>


<?php endwhile;?>
                        <tr>
                            <td colspan="3">
                                <a href="index.php" class="btn btn-success"><i class="fas fa-cart-plus"></i>Continue Shopping</a>
                            </td>
                            <td colspan="2"> 
                               <h4> Grand Total</h4>
                            </td>
                            <td>$<?php echo number_format($grand_total,2); ?> </td>
                            <td>
                                <a href="checkout.php" class="btn btn-info <?php ($grand_total > 1)? "":"disabled"; ?>"><i class="far fa-credit-card"></i>&nbsp;Checkout</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> 
<script src="jquery-3.3.1.min.js"></script>
<script>
    $(document).ready(function(){
        loadCartNum();
        $('.itemQty').on('change',function(){
            var $el=$(this).closest('tr');
            var pid=$el.find('.pid').val();
            var pprice=$el.find('.pprice').val();
            var quantity=$el.find('.itemQty').val();
            if(quantity <1){
                alert("Quantity can not go below one");
            }else{
                location.reload(true);
                $.ajax({
                    url:'page1.php',
                    method:'post',
                    data:{qty:quantity,pid:pid,pprice:pprice},
                    success:function(data){
                    }
                });
            }
            
        });
        loadCartNum();
    function loadCartNum(){
        $.ajax({
            url:'action.php',
            method:'GET',
            data:{cartItem:"cart_item"},
            success:function(response){
                $('#cart-item').html(response);
            }
        });
    }
    });
    
</script>
</body>
</html>