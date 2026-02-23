<?php  require_once("../resources/config.php");  ?>
<?php include(TEMPLATE_FRONT . DS . "/header.php"); ?>

<?php 
   // if(isset($_SESSION["product_1"])){
        //echo $_SESSION["product_1"];
       // echo $_SESSION["item_total"];
   // }
?>
    <!-- Page Content -->
    <div class="container">


<!-- /.row --> 

<div class="row">
    <h3 class="text-center bg-danger"><?php get_message(); ?></h3>
      <h1 style="color: navy;">Checkout</h1>

<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
    <INPUT TYPE="hidden" name="variableName" value="allowedValue">
    <input type="hidden" name="cmd" value="_cart">
    <input type="hidden" name="business" value="sellerseller2@business.example.com">
    <input type="hidden" name="currency_code" value="MXN">
    <input type="hidden" name="upload" value="1">
     
    <table class="table table-striped">
        <thead>
          <tr>
           <th>Product</th>
           <th>Price</th>
           <th>Quantity</th>
           <th>Sub-total</th>
     
          </tr>
        </thead>
        <tbody>
            <?php cart(); ?>
        </tbody>
    </table>
    <input type="image" name="upload"
    src="https://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif"
    alt="PayPal - The safer, easier way to pay online">
    <img alt="" width="1" height="1"
    src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >


</form>



<!--  ***********CART TOTALS*************-->
            
<div class="col-xs-4 pull-right ">
<h2>Cart Totals</h2>

<table class="table table-bordered" cellspacing="0">

<tr class="cart-subtotal">
<th>Items:</th>
<td><span class="amount"><?php echo isset($_SESSION['item_quantity']) ? $_SESSION['item_quantity'] : "0"; ?></span></td>
</tr>
<tr class="shipping">
<th>Shipping and Handling</th>
<td>Free Shipping</td>
</tr>

<tr class="order-total">
<th>Order Total</th>
<td><strong><span class="amount">
    <?php 
        echo isset($_SESSION['item_total']) ? "$" . $_SESSION['item_total'] : "$0";
    ?>
</span></strong> </td>
</tr>


</tbody>

</table>

</div><!-- CART TOTALS-->


 </div><!--Main Content-->


        


    </div>
    <!-- /.container -->

 <?php  include(TEMPLATE_FRONT . DS . "/footer.php");  ?>