<?php require_once("../../resources/config.php") ?>
<?php include(TEMPLATE_BACK . "/header.php"); ?>
<?php 

// 18-1-26 http://mailpit:8025
if(!isset($_SESSION['username'])){

redirect("../..public");
}

?>
<div id="page-wrapper">

    <div class="container-fluid">
                <!-- /.row -->
<?php 
    if($_SERVER["REQUEST_URI"] == "/ecommerce2026/public/admin/" ||$_SERVER['REQUEST_URI'] == "/ecommerce2026/public/admin/index.php"){

        include(TEMPLATE_BACK . "/admin_content.php");
    }

    if(isset($_GET["orders"])){

            include(TEMPLATE_BACK . "/orders.php");

    }

    if(isset($_GET["products"])){

            include(TEMPLATE_BACK . "/products.php");

    }

    if(isset($_GET["add_products"])){

            include(TEMPLATE_BACK . "/orders.php");

    }

    if(isset($_GET["edit_product"])){

            include(TEMPLATE_BACK . "/edit_product.php");

    }

     if(isset($_GET["add_product"])){

            include(TEMPLATE_BACK . "/add_product.php");

    }

    if(isset($_GET["category"])){

            include(TEMPLATE_BACK . "/categories.php");

    }

    if(isset($_GET["user"])){

            include(TEMPLATE_BACK . "/users.php");

    }

     

     if(isset($_GET["add_user"])){

            include(TEMPLATE_BACK . "/add_user.php");

    }

    if(isset($_GET["edit_user"])){

            include(TEMPLATE_BACK . "/edit_user.php");

    }

    
    if(isset($_GET["reports"])){

            include(TEMPLATE_BACK . "/report.php");

    }

    if(isset($_GET["comment"])){

            include(TEMPLATE_BACK . "/item.php");

    }
?>
                 <!-- FIRST ROW WITH PANELS -->

               

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include(TEMPLATE_BACK . "/footer.php"); ?>
