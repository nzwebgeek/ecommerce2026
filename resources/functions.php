<?php
// Removed PHPMailer dependency - using basic mail() function instead

$upload_directory = "uploads";

// Email configuration constants
if (!defined('EMAIL_FROM_EMAIL')) {
    define('EMAIL_FROM_EMAIL', 'noreply@yourdomain.com');
}
if (!defined('EMAIL_FROM_NAME')) {
    define('EMAIL_FROM_NAME', 'Your Website Name');
}

// Helper functions
function last_id(){
    global $connection;

    return mysqli_insert_id($connection);
}

function set_message($msg) {
    if(!empty($msg)) {
        $_SESSION['message'] = $msg;
    } else {
        $msg = "";
    }
}   
function get_message() {
    if(isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
        //session_destroy(); // kill session so message doesn't show up in other pages
    }
}
function redirect($location) {
    header("Location: {$location}");
}   
function query($sql) {
    global $connection;
    return mysqli_query($connection, $sql);
}
function confirm($result) {
    global $connection;
    if(!$result) {
        die("QUERY FAILED ." . mysqli_error($connection));
    }
}

function escape_string($string) {
    global $connection;
    return mysqli_real_escape_string($connection, $string);
}

function fetch_array($result) {
    return mysqli_fetch_array($result);
} 
 // get products
 function get_products() {
$query = query("SELECT * FROM products");
confirm($query);

while($row = fetch_array($query)){
     $product_image = display_image($row['product_image']);

        $product = <<<DELIMETER
<div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
    <div class="card product-card h-100">
        <a href="item.php?product_id={$row['product_id']}">
            <img src="../resources/{$product_image}" class="card-img-top img-fluid" alt="{$row['product_title']}">
        </a>
        <div class="card-body">
            <h6 class="card-title text-truncate mb-1">{$row['product_title']}</h6>
            <p class="card-text text-muted small mb-2">{$row['product_description']}</p>
            <div class="d-flex justify-content-between align-items-center">
                <span class="font-weight-bold text-primary">&#36;{$row['product_price']}</span>
                <a class="btn btn-sm btn-primary" target="_blank" href="../resources/cart.php?add={$row['product_id']}">Add To Cart</a>
            </div>
        </div>
    </div>
</div>
DELIMETER;

echo $product;
    }

 }

function get_categories(){
  $query = query("SELECT * FROM categories");
    confirm($query);

    while($row = fetch_array($query)) {
        $category_links
         = <<<DELIMETER
        <a href='category.php?id={$row['cat_id']}' class='list-group-item'>{$row['cat_title']}</a>
DELIMETER;
        echo $category_links;
    }  
}

function display_image($picture){
global $upload_directory;
return $upload_directory . DIRECTORY_SEPARATOR . $picture;


}
function get_products_in_cat_page(){
    $query = query("SELECT * FROM products WHERE product_category_id =" . escape_string($_GET['id']) . " ");
    confirm($query);

while($row = fetch_array($query)){
$product_image = display_image($row['product_image']);
/*$cat_products = <<<DELIMETER
        
<div class="col-md-3 col-sm-6 hero-feature">
    <div class="thumbnail">
        <img src="../resources/{$product_image}" alt="{$row['product_title']}">
        <div class="caption">
            <h3>{$row['product_title']}</h3>
            <p>{$row['product_description']}</p>
            <p>
               <a href="item.php?product_id={$row['product_id']}" class="btn btn-primary">Buy Now!</a> <a href="item.php?product_id={$row['product_id']}" class="btn btn-default">More Info</a>
            </p>
        </div>
    </div>
</div>
DELIMETER;*/
$cat_products = <<<DELIMETER
<div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
    <div class="card product-card h-100">
        <img src="../resources/{$product_image}" class="card-img-top img-fluid" alt="{$row['product_title']}">
        <div class="card-body">
            <h6 class="card-title text-truncate mb-1">{$row['product_title']}</h6>
            <p class="card-text text-muted small mb-2">{$row['product_description']}</p>
        </div>
        <div class="card-footer text-center">
            <a href="item.php?product_id={$row['product_id']}" class="btn btn-primary btn-sm">Buy Now</a>
            <a href="item.php?product_id={$row['product_id']}" class="btn btn-secondary btn-sm">More Info</a>
        </div>
    </div>
</div>

DELIMETER;
echo $cat_products;
    }
}

function get_products_in_shop_page(){
    $query = query("SELECT * FROM products");
    confirm($query);

while($row = fetch_array($query)){
$product_image = display_image($row['product_image']);
$cat_products = <<<DELIMETER
<div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
    <div class="card product-card h-100">
        <img src="../resources/{$product_image}" alt="{$row['product_title']}" class="card-img-top img-fluid">
        <div class="card-body">
            <h6 class="card-title text-truncate mb-1">{$row['product_title']}</h6>
            <p class="card-text text-muted small mb-2">{$row['product_description']}</p>
        </div>
        <div class="card-footer text-center">
            <a href="item.php?product_id={$row['product_id']}" class="btn btn-primary btn-sm">Buy Now!</a>
            <a href="item.php?product_id={$row['product_id']}" class="btn btn-secondary btn-sm">More Info</a>
        </div>
    </div>
</div>
DELIMETER;
echo $cat_products;
    }
}

function login_user(){
    if(isset($_POST['submit'])) {
        $username = escape_string($_POST['username']);
        $password = escape_string($_POST['password']);

        $query = query("SELECT * FROM users WHERE username = '{$username}' ");
        confirm($query);

        if(mysqli_num_rows($query) == 0) {
            set_message("Your Password or Username are wrong");
            redirect("login.php");
        } else {
            $row = fetch_array($query);
            if(password_verify($password, $row['user_password'])) {
                $_SESSION['username'] = $username;
                set_message("Welcome to Admin {$username}");
                redirect("admin");
            } else {
                set_message("Your Password or Username are wrong");
                redirect("login.php");
            }
        }
    }
}

function send_message(){
    if(isset($_POST['submit'])) {
        $name        = $_POST['name'];
        $email       = $_POST['email'];
        $subject     = $_POST['subject'];
        $message     = $_POST['message'];
        
        // Use Gmail SMTP to send email
        $result = send_email_gmail($email, $name, $subject, $message);
        
        if($result) {
            set_message("Your Message has been sent successfully!");
            redirect("contact.php");
        } else {
            set_message("Failed to send message. Please try again.");
            redirect("contact.php");
        }
    }
}

function send_email_gmail($to_email, $to_name, $subject, $message, $from_email = null, $from_name = null) {
    // Use default sender if not provided
    if (!$from_email) {
        $from_email = EMAIL_FROM_EMAIL;
        $from_name = EMAIL_FROM_NAME;
    }
    
    // Email headers
    $headers = "From: {$from_name} <{$from_email}>\r\n";
    $headers .= "Reply-To: {$to_name} <{$to_email}>\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    // Email body with HTML formatting
    $email_body = "
    <html>
    <head>
        <title>{$subject}</title>
    </head>
    <body>
        <h2>New Contact Form Message</h2>
        <p><strong>Name:</strong> {$to_name}</p>
        <p><strong>Email:</strong> {$to_email}</p>
        <p><strong>Subject:</strong> {$subject}</p>
        <hr>
        <p><strong>Message:</strong></p>
        <p>" . nl2br(htmlspecialchars($message)) . "</p>
        <hr>
        <p><em>This message was sent from your website contact form.</em></p>
    </body>
    </html>
    ";
    
    // Use basic mail() function
    return mail($to_email, $subject, $email_body, $headers);
}

// Enhanced email function for different types of emails
function send_notification_email($to_email, $to_name, $subject, $message, $email_type = 'general') {
    switch($email_type) {
        case 'order_confirmation':
            $subject = "Order Confirmation - " . $subject;
            $message = "<h3>Thank you for your order!</h3><p>Your order has been received and is being processed.</p><p>Order Details: {$message}</p>";
            break;
        case 'password_reset':
            $subject = "Password Reset Request";
            $message = "<h3>Password Reset</h3><p>To reset your password, click the link below:</p><p>{$message}</p>";
            break;
        case 'user_registration':
            $subject = "Welcome to Our Website!";
            $message = "<h3>Welcome {$to_name}!</h3><p>Thank you for registering with us. Your account has been created successfully.</p><p>Your login details: Email: {$to_email}</p>";
            break;
    }
    
    return send_email_gmail($to_email, $to_name, $subject, $message);
}
/*Back End Functions*/

function display_orders(){
$query = query("SELECT * FROM orders");
confirm($query);

while($row = fetch_array($query)){

$oders = <<<DELIMETER
<br><br> <br>              
<tr>
    <td>{$row['order_id']}</td>
    <td>{$row['order_amount']}</td>
    <td>{$row['order_transaction']}</td>
    <td>{$row['order_currency']}</td>
    <td>{$row['order_status']}</td>
    <td><a class="btn btn-danger" href="../../resources/templates/back/delete_orders.php?id={$row['order_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
</tr>

DELIMETER;

echo $oders;
    }
}
/*Admin products*/
function get_products_in_admin() {

$query = query("SELECT * FROM products");
confirm($query);


while($row = fetch_array($query)){

 $category =   show_product_category_title($row['product_category_id']);

 $product_image = display_image($row['product_image']);
    
 $product = <<<DELIMETER
     
        <tr>
            <td>{$row['product_id']}</td>
            <td>{$row['product_title']} <br>
             <a href="index.php?edit_product&id={$row['product_id']}"><img width="200px" src="../../resources/{$product_image}" alt=""></a> 
            </td>
            <td>{$category}</td>
            <td>{$row['product_price']}</td>
            <td>{$row['product_quantity']}</td>
            <td><a class="btn btn-danger" href="../../resources/templates/back/delete_product.php?id={$row['product_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>

        </tr>
      
   
DELIMETER;

echo $product;
    }

 }


 function show_product_category_title($product_category_id){
 $category_query = query("SELECT * FROM categories WHERE cat_id = '{$product_category_id}' ");
    confirm($category_query);

    while($category_row = fetch_array($category_query)){
        return $category_row['cat_title'];
    }
}

 function add_product_now(){
    if(isset($_POST['publish'])){

        $product_title = escape_string($_POST['product_title']);
        $product_category_id = escape_string($_POST['product_category_id']);//
        $product_price = escape_string($_POST['product_price']);
        $product_description = escape_string($_POST['product_description']);
        $short_description = escape_string($_POST['short_description']); //
        $product_quantity = escape_string($_POST['product_quantity']);//
        $product_image = ($_FILES['product_image']['name']);
        $image_temp_location = ($_FILES['product_image']['tmp_name']);
       
        move_uploaded_file($image_temp_location,UPLOAD_DIRECTORY . DS . $product_image);
        // filename , destination

        $query= query("INSERT INTO products(product_title, product_category_id, product_price, product_description, short_description, product_quantity, product_image) VALUES('{$product_title}', '{$product_category_id}', '{$product_price}', '{$product_description}', '{$short_description}', '{$product_quantity}', '{$product_image}')");
        $lastId = last_id();
        confirm($query);
        set_message("New Product with id {$lastId} Added");
        redirect("index.php?products");
    }
    
 }

 function show_categories_add_product_page(){
  $query = query("SELECT * FROM categories");
    confirm($query);

    while($row = fetch_array($query)) {
        $category_options = <<<DELIMETER
<option value="{$row['cat_id']}">{$row['cat_title']}</option>

DELIMETER;
        echo $category_options;
    }  
}

 function update_product_now(){
    if(isset($_POST['update'])){

        $product_title = escape_string($_POST['product_title']);
        $product_category_id = escape_string($_POST['product_category_id']);//
        $product_price = escape_string($_POST['product_price']);
        $product_description = escape_string($_POST['product_description']);
        $short_description = escape_string($_POST['short_description']); //
        $product_quantity = escape_string($_POST['product_quantity']);//
        $product_image = escape_string($_FILES['product_image']['name']);
        $image_temp_location = ($_FILES['product_image']['tmp_name']);
       
        if(empty($product_image)){

            $get_pic = query("SELECT product_image FROM products WHERE product_id =".escape_string($_GET['id'])."");
            confirm($get_pic);

                while ($pic = fetch_array($get_pic)) {
                    $product_image = $pic['product_image'];
                }

            }

        move_uploaded_file($image_temp_location,UPLOAD_DIRECTORY . DS . $product_image);
        // filename , destination
        $query = "UPDATE products SET ";
        $query .= "product_title = '{$product_title}',";
        $query .= "product_category_id ='{$product_category_id}',";
        $query .= "product_price ='{$product_price}',";
        $query .= "product_description ='{$product_description}',";
        $query .= "short_description ='{$short_description}',";
        $query .= "product_quantity ='{$product_quantity}',";
        $query .= "product_image ='{$product_image}'";
        $query .= "WHERE product_id =" . escape_string($_GET['id']);
       
        $send_update_query = query($query);
        confirm($send_update_query);
        set_message("Product Updated");
        redirect("index.php?products");
    }
    
 }

 // Categories
 function show_categories_in_admin(){

    $query = "SELECT * FROM categories";
    $category_query = query($query);
    confirm($category_query);

    while ($row = fetch_array($category_query)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];


        $category = <<<DELIMETER
        <tr>
            <td>{$cat_id}</td>
            <td>{$cat_title}</td>
            <td><a class="btn btn-danger" href="../../resources/templates/back/delete_category.php?id={$row['cat_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>

        </tr>
DELIMETER;
echo $category;
    }

 }

 function add_category_to_list(){
    if(isset($_POST['add_category'])){
        $cat_title = escape_string($_POST['cat_title']);
       if(empty($cat_title) || $cat_title == " "){
        echo "<h3 class='bg-danger'>Cannot Be Empty!</h3>";
       }
        else{
        $insert_query = query("INSERT INTO categories(cat_title) VALUES('{$cat_title}') ");
        confirm($insert_query);
        //redirect("index.php?categories");
        set_message("Category Created");
        
        //redirect("index.php?category");
        }

    }
 }

 function display_users(){
    $users_query = query("SELECT * FROM users");
    confirm($users_query);

    while ($row = fetch_array($users_query)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $email = $row['email'];

        $user = <<< DELIMETER
              
     
        <tr>
            <td>{$user_id}</td>
            <td>{$username}</td>
            <td>{$email}</td>
            <td><a class="btn btn-danger" href="../../resources/templates/back/delete_user.php?id={$row['user_id']}"
           onclick="return confirm('Are you sure you want to delete this user?');" ><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>

    DELIMETER;
    echo $user;
    }
 }

 function add_user(){
    if(isset($_POST['add_user'])){
       $username     = escape_string($_POST['username']);
        $email       = escape_string($_POST['email']);
       $password     = escape_string($_POST['password']);
       // $user_photo = escape_string($_FILES['file']['name']);
        //$photo_temp = escape_string($_FILES['file']['tmp_name']);
      
       // move_uploaded_file($photo_temp, UPLOAD_DIRECTORY . DS . $user_photo);

        $query = query("INSERT INTO users(username,email,user_password) VALUES('{$username}','{$email}','{$password}')");
        confirm($query);
        set_message('User Created!');
        redirect('index.php?user');
    }
 }


 function get_reports_in_admin() {

$query = query("SELECT * FROM reports");
confirm($query);


while($row = fetch_array($query)){
    
 $report = <<<DELIMETER
            
        <tr>
            <td>{$row['report_id']}</td>
            <td>{$row['product_id']}</td>
            <td>{$row['order_id']} 
            <td>{$row['product_price']}</td>
            <td>{$row['product_title']}</td>
            <td>{$row['product_quantity']}</td>
            <td><a class="btn btn-danger" href="../../resources/templates/back/delete_report.php?id={$row['report_id']}"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>
      
   
DELIMETER;

echo $report;
    }

 }

 function display_new_orders(){
$query = query("SELECT * FROM orders");
confirm($query);

while($row = fetch_array($query)){

$oders = <<<DELIMETER

<tr>
    
    <td>{$row['order_status']}</td>
</tr>

DELIMETER;

echo $oders;
    }
}

function count_orders(){
  
$sql = "SELECT COUNT(*) AS total FROM orders";
//$result = $conn->query($sql);
$result = query($sql);

$row = $result->fetch_assoc();
$totalProducts = $row['total'];

echo $totalProducts;

}

function count_products(){
  
$sql = "SELECT COUNT(*) AS total FROM products";
//$result = $conn->query($sql);
$result = query($sql);

$row = $result->fetch_assoc();
$totalProducts = $row['total'];

echo $totalProducts;

}

function count_categories(){
  
$sql = "SELECT COUNT(*) AS total FROM categories";
//$result = $conn->query($sql);
$result = query($sql);

$row = $result->fetch_assoc();
$totalProducts = $row['total'];

echo $totalProducts;

}

/*******************************display ratings*********************************/
function add_rating(){
    if(isset($_POST['add_comment'])){
        $name =escape_string($_POST['name']);
        $email = escape_string($_POST['email']);
        $comment =  escape_string($_POST['comment']);
        
        $query = query("INSERT INTO comments (name, email, comment, created_at)
        VALUES ('{$name}', '{$email}', '{$comment}', NOW());");
        confirm($query);
        set_message('Rating Created!');
        redirect('index.php?comment');
    }
    
 }
 
 function display_ratings(){

$query = query("SELECT * FROM comments");
confirm($query);

while($row = fetch_array($query)){

$comments = <<<DELIMETER
<br> <br>       
 <div class="col-md-12">
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star"></span>
                <span class="glyphicon glyphicon-star-empty"></span>
                {$row['name']}
                <span class="pull-right">{$row['created_at']} (Date Posted)</span>
                <p>{$row['comment']}</p>
            </div>
DELIMETER;

echo $comments;
    }
}

function totalComments(){
    $sql = "SELECT COUNT(*) AS total FROM comments";
//$result = $conn->query($sql);
$result = query($sql);

$row = $result->fetch_assoc();
$totalComments = $row['total'];

echo $totalComments;
}
