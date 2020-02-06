<?php
require_once('./include/dbconfig.php');

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
    <div id="message"></div>
    <div class="row mt-5 pb-5">
        <?php
            $sql="SELECT * FROM product";
            $result=mysqli_query($conn,$sql);
            $resultCheck=mysqli_num_rows($result);
            if($resultCheck > 0){
                while($row= mysqli_fetch_assoc($result)){
                    // echo $row['product_name']."<br>";
                    echo '<div class="col-sm-6 col-md-4 col-lg-3 mb-2 ">
                    <div class="card-deck">
                        <div class="card p-2 border-secondary mb-2">
                            <img class="img fluid" src="'.$row['product_image'].'">
                            <div class="card-body p-1">
                                <h4 class="card-title text-center text-info">'.$row['product_name'].'</h4>
                                <h5 class="card-text text-center text-danger">$'.number_format($row['product_price'],2).'</h5>
                            </div>
                            <div class="card-footer p-1">
                                <form action="" class="form-submit"> 
                                    <input type="hidden" class="pid" value="'.$row['id'].'">
                                    <input type="hidden" class="pname" value="'.$row['product_name'].'">
                                    <input type="hidden" class="pprice" value="'.$row['product_price'].'">
                                    <input type="hidden" class="pimage" value="'.$row['product_image'].'">
                                    <input type="hidden" class="pcode" value="'.$row['product_code'].'">
                                    <button class="btn btn-info btn-block addItemBtn"><i class="fas fa-cart-plus"></i>add to cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>';
                }
            }
            
        ?>
        <!-- <div class="col-lg-3">
            <div class="card-deck">
                <card class="card p-2 border-secondary mb-2">

                </card>
            </div>
        </div> -->
        <!-- <div class="card-body p-1">
            <h4 class="card-title text-center text-info"></h4>
            <h5 class="card-text text-center text-danger"></h5>
            
        </div> -->
    </div>
</div>



 

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> 
<script src="jquery-3.3.1.min.js"></script>
<script>
$('document').ready(function(){
    //var cart=0;
    $('.addItemBtn').click(function(e){
        e.preventDefault();
        
        //cart++;
        //$('#cart-item').text(cart);
        var $form=$(this).closest('.form-submit');
        var pid=$form.find('.pid').val();
        var pname=$form.find('.pname').val();
        var pprice=$form.find('.pprice').val();
        var pimage=$form.find('.pimage').val();
        var pcode=$form.find('.pcode').val();
        $.ajax({
            url:'action.php',
            method:"POST",
            data:{pid:pid,pname:pname,pprice:pprice,pimage:pimage,pcode:pcode},
            success:function(response){
                $('#message').html(response);
                window.scrollTo(0,0);
                loadCartNum();
            }
        });
    });
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

</script>
</body>
</html>