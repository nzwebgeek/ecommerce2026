<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>
    <!-- Page Content -->
<div class="container">
       <!-- Side Navigation -->
<?php include(TEMPLATE_FRONT . DS . "side_nav.php"); ?>
<?php 
/*$query = query("SELECT * FROM products WHERE product_id=" . escape_string($_GET['product_id']) . " ");
confirm($query);*/
if (isset($_GET['product_id'])) {

    $product_id = escape_string($_GET['product_id']);
    $query = query("SELECT * FROM products WHERE product_id = {$product_id}");
    confirm($query);

} else {
    die("Product ID not found.");
}


while($row = fetch_array($query)):



?>


<div class="col-md-9" style="background-color: slategrey;">

<!--Row For Image and Short Description-->

<div class="row">

    <div class="col-md-7">
       <img class="img-responsive" src="../resources/<?php echo display_image($row['product_image']); ?>" alt="">

    </div>

    <div class="col-md-5">

        <div class="thumbnail">
         

    <div class="caption-full">
        <h4><a href="#"><?php echo $row['product_title']; ?></a> </h4>
        <hr>
        <h4 class=""><?php echo "&#36;" . $row['product_price']; ?></h4>

    <div class="ratings">
     
        <p>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star-empty"></span>
            4.0 stars
        </p>
    </div>
          
        <p><?php echo $row['product_description']; ?></p>

   
    <form action="">
        <div class="form-group">
            <a href="../resources/cart.php?add=<?php echo $row['product_id']; ?>" class="btn btn-primary">Add</a>
        </div>
    </form>

    </div>
 
</div>

</div>


</div><!--Row For Image and Short Description-->


        <hr>


<!--Row for Tab Panel-->

<div class="row">

<div role="tabpanel">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Description</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Reviews</a></li>

  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">

<p><?php echo $row['product_description']; ?></p>
           
    
    </div>
<!--ratings-->

<div role="tabpanel" class="tab-pane" id="profile">

  <div class="col-md-6">


<!--DISPLAY_RATINGS()-->
 <h3><?php totalComments() ?> Reviews From </h3>

        <hr>

        <div class="row">
           <?php display_ratings()?>
        </div>

        <hr>

    </div>

    <div class="col-md-6">
        
        <h3>Add A Review</h3>
<?php add_rating() ?>
<!--review fieldss-->

     <form action="" class="form-inline" method="post">
        <div class="form-group">
            <label for="">Name:&nbsp;</label>
                <input type="text" class="form-control" name="name" required>
            </div>
             <div class="form-group">
            <label for="">Email:&nbsp;</label>
                <input type="test" class="form-control" name="email" required>
            </div>

        <div>
            <h3>Your Rating</h3>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
            <span class="glyphicon glyphicon-star"></span>
        </div>

            <br>
            
             <div class="form-group center">
             <textarea name="comment" id="" cols="30" rows="5" class="form-control" required>
             
             </textarea>
            </div>

             <br>
              <br>
            <div class="form-group">
                <input type="submit" name="add_comment" class="btn btn-primary" value="SUBMIT">
            </div>
        </form>

    </div>

    </div>

 </div>

</div>


</div><!--Row for Tab Panel-->




</div><!--col-md-9-->
<?php endwhile; ?> <!--end while-->

</div>
    <!-- /.container -->

<?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>