<?php
    require "include/dbconfig.php";
    $grand_total=0;
    $items=array();
    $allitems="";

    $sql="SELECT CONCAT (product_name,'(',Qty,')' ) AS itemQty, total_price FROM cart ";
    $stmt=$conn->prepare($sql);
    $stmt->execute();
    $result=$stmt->get_result();
    while($row=$result->fetch_assoc()){
        $grand_total +=$row['total_price'];
        $items[]=$row['itemQty'];
    }
    // echo $grand_total;
    //  echo "<br>";
    //  print_r($items);
    $allitems= implode(',', $items);
    //echo $allitems;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> White Xpress</title>
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
      <a class="nav-link active" href="cart.php">Cart <i class="fas fa-shopping-cart"></i> <span id="cart-item" class="badge badge-danger">0</span> </a>
      </li>
     
    </ul>
     </div>
</nav> 
<hr>
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6 px-4 pb-4" id="order">
            <h4 class="text-center text-info p-2">Complete Your order</h4>
            <div class="jumbotron p-3 mb-2 text-center">
                <h6 class="m-2"><b>Product(s):</b></h6>
                <p><?php echo $allitems; ?></p>
                <h6>Delivery Charges: <b class="text-success">Free</b></h6>
                <h6>Amount Payable: $<?php echo number_format($grand_total,2); ?></h6>
            </div>
            <form action="" method="post" id="formid">
                <input type="hidden" name="products" value="<?php echo $allitems;?>">
                <input type="hidden" name="grand_total" value="<?php echo $grand_total;?>">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Enter Name" class="form-control" >
                </div>
                <div class="form-group">
                    <input type="text" name="email" placeholder="Enter E-mail" class="form-control" >
                </div>
                <div class="form-group">
                    <input type="tel" name="phone" placeholder="Enter Phone number" class="form-control" >
                </div>
                <div class="form-group">
                    <textarea name="address" class="form-control" rows="3" cols="10" placeholder="Enter Delivery Address here..."></textarea>
                </div>
                <h5 class="text-center lead">Select Payment Mode</h5>
                <div class="form-group">
                    <select class="form-control" name="pmode"> 
                        <option value="" selected disabled>-Select payment mode-</option>
                        <option value="cod">Cash on Delivery</option>
                        <option value="netbank">Internet Banking</option>
                        <option value="card">Debit/Credit Card</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Place Order" class="btn btn-danger btn-block" >
                </div>
            </form>
        </div>
    
    </div>
    
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> 
<script src="jquery-3.3.1.min.js"></script>
<script>
    $(document).ready(function(){
        $('#formid').submit(function(e){
            e.preventDefault();
            loadCartNum();
            $.ajax({
                url:'page2.php',
                method:'post',
                data:$('form').serialize()+ "&action=order",
                success:function(response){
                    $('#order').html(response);
                }
            })
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