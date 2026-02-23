<?php require_once("../resources/config.php"); ?>
<?php include(TEMPLATE_FRONT . DS . "header.php"); ?>
<!-- Page Content -->
    <div class="container" style="background-color: slategrey;">

        <!-- Jumbotron Header -->
        <header class="jumbotron hero-spacer">
            <h1>Marthas Cuisine 2026</h1>
            <p>We offer a wide range of delicious dishes. Choose which every one you like and pay now we will deliver within 1-3 days of purchase.</p>
            <p><a class="btn btn-primary btn-large">Call to action!</a>
            </p>
        </header>

        <hr>

        <!-- Title -->
        <div class="row">
            <div class="col-lg-12">
                <h3>Latest Features</h3>
            </div>
        </div>
        <!-- /.row -->

        <!-- Page Features -->
        <div class="row text-center">

            <?php get_products_in_cat_page(); ?>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->

<?php include(TEMPLATE_FRONT . DS . "footer.php"); ?>