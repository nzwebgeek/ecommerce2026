<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>
<!-- Page Content -->
    <div class="container" style="background-color:  slategrey;">

        <!-- Jumbotron Header -->
        <header style="color: navy;">
            <h1>Shop</h1>
        </header>

        <hr>
        <!-- Title -->
        <!-- /.row -->
        <!-- Page Features -->
        <div class="row text-center" style="background-color: dimgray;" >
            <?php get_products_in_shop_page(); ?>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->

<?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>