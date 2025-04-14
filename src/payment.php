<?php
//session_start();
include 'includes/db_connect.php';
include 'includes/header.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

if ($items_amount == 0) {
    header("Location: cart.php");
}

$cart_id = $_SESSION['cart_id'];
$cart_item_list = $pdo->query("select * from cart_items where cart_id = '$cart_id'");
$product_list = $pdo->query("select * from products");
$category_list = $pdo->query("select * from categories");
$categories = [];
$products = [];
foreach ($category_list as $category) {
    $categories[] = $category;
}
foreach ($product_list as $product) {
    $products[] = $product;
}
//print_r($products[0]['name']);
//print_r($categories[0]['name']);
//echo "Cart: " ;
/*
$cart_list = ($cart_item_list->fetchAll(PDO::FETCH_ASSOC));
$prod_list = ($product_list->fetchAll(PDO::FETCH_ASSOC));
$cat_list = $category_list->fetchAll(PDO::FETCH_ASSOC);
*/

$error_list = '';
$stmt = $pdo->prepare("select * from products");
$stmt->execute();
$prod_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("select * from categories");
$stmt->execute();
$category_list = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare("select * from cart_items where cart_id = :cart_id");
$stmt->execute([':cart_id' => $cart_id]);
$cart_list = $stmt->fetchAll(PDO::FETCH_ASSOC);
$tax_rate = 0.2;
$subtotal = 0;
foreach ($cart_list as $c) {
    $p = $prod_list[$c['product_id'] - 1];
    $price = $p['price']; 
    //echo $price;
    $subtotal += $price * $c['quantity'];
}
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

$errors = [];
$tax = $subtotal * $tax_rate;
$shipping = 50 * count($cart_list);
$total = $subtotal + $tax + $shipping;
//echo $_SESSION['errors'];
$card_name_error = '';
if (isset($_POST['complete_purchase'])) {

    $cardholder = sanitize_input($_POST['cardholder_name'] ?? '');
    $card_number = sanitize_input($_POST['card_number'] ?? '');
    $exp_date = sanitize_input($_POST['exp_date'] ?? '');
    $cvv = sanitize_input($_POST['cvv'] ?? '');
    $street = sanitize_input($_POST['street_address'] ?? '');
    $apt = sanitize_input($_POST['apt'] ?? '');
    $country = sanitize_input($_POST['country'] ?? '');
    $city = sanitize_input($_POST['city'] ?? '');
    $state = sanitize_input($_POST['state'] ?? '');
    $zip = sanitize_input($_POST['zip'] ?? '');
    if (empty($cardholder)) $errors[] = "Cardholder name is required.";
    if (!preg_match('/^\d{16}$/', str_replace(' ', '', $card_number))) {
        $error = "Card number must be exactly 16 digits.";
        $card_name_error = $error;
    }
    if (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $exp_date)) {
        $errors[] = "Expiration date must be in MM/YY format.";
    }
    if (!preg_match('/^\d{3}$/', $cvv)) {
        $errors[] = "Invalid CVV.";
    }

    if (empty($street)) $errors[] = "Street address is required.";
    if (empty($country)) $errors[] = "Country is required.";
    if (empty($city)) $errors[] = "City is required.";
    if (empty($state)) $errors[] = "State/Parish is required.";
    if (empty($zip)) $errors[] = "ZIP code is required.";

    if (!empty($errors)) {
        $error_list = "<ul style='color:red;'>";
        foreach ($errors as $error) {
            $error_list .= "<li>$error</li>";
        }
        $error_list .= "</ul>";
        //exit;
    } 

//	order_id	user_id	order_date	subtotal	tax	shipping	total
    //
    $stmt = $pdo->prepare("insert into orders (user_id, subtotal, tax, shipping, total) values (:user_id, :subtotal, :tax, :shipping, :total)");
    $result = $stmt->execute([
        ':user_id' => $_SESSION['user_id'],
        ':subtotal' => $subtotal,
        ':tax' => $tax,
        ':shipping' => $subtotal,
        ':total' => $total
    ]);
    if (!$result) {
        echo "Failed";
        //exit;
    }
    $order_id = $pdo->lastInsertId();

    //	payment_id	order_id	payment_date	amount	transaction_id	last_four	shipping_address	billing_address
    $stmt = $pdo->prepare("insert into payments (order_id, amount, last_four, shipping_address, billing_address) values (:order_id, :amount, :last_four, :shipping_address, :billing_address)");
    $result = $stmt->execute([
        ':order_id' => $order_id,
        ':amount' => $total,
        ':last_four' => substr($_POST['card_number'], -4),
        ':shipping_address' => $_POST['street_address'],
        ':billing_address' => $_POST['city']
    ]);

    if (!$result) {
        echo "Failed 2";
        //exit;
    }

    foreach($cart_item_list as $c) {
        //	order_item_id	order_id	product_id	quantity	price
        $stmt = $pdo->prepare("insert into order_items (order_id, product_id, quantity, price) values (:order_id, :product_id, :quantity, :price)");
        $result = $stmt->execute([
            ':order_id' => $order_id,
            ':product_id' => $c['product_id'],
            ':quantity' => $c['quantity'],
            ':price' => $subtotal
            ]);
    }
    header('Location: index.php');
    if (!$result) {
        echo "Failed 3";
        //exit;


    }
    $result = $pdo->query("delete from cart_items where cart_id = '$cart_id'");
    if (!$result) {
        echo "Failed 4";
    }



$successMessage = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_SESSION['fname'] . ' ' . $_SESSION['lname'];
    $email = $_SESSION['email'];
    $subject = 'Order Successful';
    $items_msg = "<br>";
    foreach ($cart_list as $c) {
        $prod = $prod_list[$c['product_id']];
       $items_msg .= $prod['name'] . ' x' . $c['quantity'] . ' :' . $prod['price'] * $c['quantity'] . "<br>";
    }
    $message = "You have successfully ordered your products <br>" .
        $items_msg . "Subtotal: $subtotal <br> Tax<strong>: $tax <br> Total: $total";

    $message .= "<br> Thank you for shopping at Digital Orbit";

    $order = $order_id;
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';        
        $mail->SMTPAuth = true;
        $mail->Username = 'kynggary15@gmail.com';
        $mail->Password = 'cfen tdrp agyb ttxh';   
        $mail->SMTPSecure = 'tls';             
        $mail->Port = 587;                      

        $mail->setFrom($mail->Username, "Digital Orbit");
        $mail->addAddress($email, $name);

        $mail->isHTML(true);
        $mail->Subject = "Order Results: " . ucfirst($subject);
        $mail->Body = "
                <h2>Order Summary</h2>
                <p><strong>Name:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Subject:</strong> $subject</p>
                <p><strong>Message:</strong><br>$message</p>" .
                (!empty($order) ? "<p><strong>Order Number:</strong> $order</p>" : "");

            $mail->send();
            $successMessage = "Order Went through successfully";
        } catch (Exception $e) {
            $errorMessage = "Order could not go through. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'includes/head.php' ?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Digital Orbit - Payment</title>
  <style>
    :root {
      --deep-space: #0C1445;
      --cosmic-purple: #3D1A7C;
      --celestial-blue: #1E88E5;
      --nova-orange: #FF6D00;
      --asteroid-gray: #37474F;
      --stardust-white: #F8F9FA;
      --orbit-teal: #00BCD4;
    }
    
    body {
      font-family: 'Arial', sans-serif;
      margin: 0;
      padding: 0;
      background-color: var(--deep-space);
      color: var(--stardust-white);
      background-image: 
        radial-gradient(white, rgba(255,255,255,.2) 2px, transparent 40px),
        radial-gradient(white, rgba(255,255,255,.15) 1px, transparent 30px),
        radial-gradient(white, rgba(255,255,255,.1) 2px, transparent 40px);
      background-size: 550px 550px, 350px 350px, 250px 250px;
      background-position: 0 0, 40px 60px, 130px 270px;
      min-height: 100vh;
    }
    
    .container-2 {
      max-width: 1200px;
      margin: 0 auto;
        margin-top: 60px;
      padding: 2rem;
    }
    
    .checkout-container-2 {
      display: flex;
      flex-direction: column;
      gap: 2rem;
    }
    
    @media (min-width: 768px) {
      .checkout-container-2 {
        flex-direction: row;
      }
    }
    
    .checkout-form {
      flex: 2;
      background: rgba(12, 20, 69, 0.8);
      border-radius: 12px;
      padding: 2rem;
      border: 1px solid var(--orbit-teal);
      box-shadow: 0 0 15px rgba(0, 188, 212, 0.3);
    }
    
    .order-summary {
      flex: 1;
      background: rgba(12, 20, 69, 0.8);
      border-radius: 12px;
      padding: 2rem;
      border: 1px solid var(--orbit-teal);
      box-shadow: 0 0 15px rgba(0, 188, 212, 0.3);
      align-self: flex-start;
    }
    
    h2 {
      color: var(--orbit-teal);
      margin-top: 0;
      font-size: 1.8rem;
      position: relative;
      padding-bottom: 0.5rem;
    }
    
    h2::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 0;
      width: 60px;
      height: 3px;
      background: linear-gradient(90deg, var(--orbit-teal), transparent);
    }
    
    .form-section {
      margin-bottom: 2rem;
    }
    
    .section-title {
      color: var(--celestial-blue);
      border-bottom: 1px solid rgba(30, 136, 229, 0.3);
      padding-bottom: 0.5rem;
      margin-bottom: 1rem;
      font-size: 1.2rem;
    }
    
    .form-group {
      margin-bottom: 1.2rem;
    }
    
    label {
      display: block;
      margin-bottom: 0.5rem;
      color: var(--stardust-white);
    }
    
    input, select {
      width: 100%;
      padding: 0.75rem;
      border-radius: 6px;
      border: 1px solid var(--asteroid-gray);
      background: rgba(55, 71, 79, 0.3);
      color: var(--stardust-white);
      transition: all 0.3s ease;
    }
    
    input:focus, select:focus {
      outline: none;
      border-color: var(--celestial-blue);
      box-shadow: 0 0 8px rgba(30, 136, 229, 0.5);
    }
    
    .form-row {
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
    }
    
    .form-row .form-group {
      flex: 1 1 200px;
    }
    
    .card-icons {
      display: flex;
      gap: 0.5rem;
      margin-bottom: 1rem;
    }
    
    .card-icon {
      width: 40px;
      height: 25px;
      background: var(--stardust-white);
      border-radius: 4px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.7rem;
      color: var(--deep-space);
    }
    
    .order-item {
      display: flex;
      justify-content: space-between;
      margin-bottom: 1rem;
      padding-bottom: 1rem;
      border-bottom: 1px solid rgba(248, 249, 250, 0.1);
    }
    
    .item-image {
      width: 60px;
      height: 60px;
      background: var(--asteroid-gray);
      border-radius: 8px;
      margin-right: 1rem;
    }
    
    .item-details {
      flex: 1;
    }
    
    .item-name {
      margin: 0 0 0.25rem;
      font-weight: bold;
font-size: 20px;
    }
    
    .item-price {
      color: var(--orbit-teal);
      font-weight: bold;
    }
    
    .order-total {
      margin-top: 1.5rem;
      padding-top: 1.5rem;
      border-top: 1px solid rgba(248, 249, 250, 0.2);
    }
    
    .total-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 0.5rem;
    }
    
    .total-label {
      color: var(--stardust-white);
    }
    
    .total-value {
      font-weight: bold;
    }
    
    .grand-total {
      font-size: 1.2rem;
      color: var(--orbit-teal);
    }
    
    .btn {
      display: inline-block;
      padding: 1rem 2rem;
      border: none;
      border-radius: 50px;
      font-weight: bold;
      cursor: pointer;
      transition: all 0.3s ease;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
    
    .btn-primary {
      background: linear-gradient(135deg, var(--celestial-blue), var(--orbit-teal));
      color: var(--stardust-white);
      box-shadow: 0 4px 15px rgba(30, 136, 229, 0.4);
    }
    
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(30, 136, 229, 0.6);
    }
    
    .payment-progress {
      display: flex;
      justify-content: space-between;
      margin-bottom: 2rem;
      position: relative;
    }
    
    .progress-step {
      flex: 1;
      text-align: center;
      position: relative;
      z-index: 1;
    }
    
    .step-number {
      width: 30px;
      height: 30px;
      background: var(--asteroid-gray);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 0.5rem;
      color: var(--stardust-white);
      font-weight: bold;
      position: relative;
      z-index: 1;
    }
    
    .active .step-number {
      background: var(--celestial-blue);
    }
    
    .completed .step-number {
      background: var(--orbit-teal);
    }
    
    .step-name {
      font-size: 0.8rem;
    }
    
    .progress-bar {
      position: absolute;
      top: 15px;
      left: 15%;
      right: 15%;
      height: 2px;
      background: var(--asteroid-gray);
      z-index: 0;
    }
    
    .progress-completed {
      position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      width: 100%;
      background: var(--orbit-teal);
    }
    
    .security-badge {
      display: flex;
      align-items: center;
      margin-top: 2rem;
      color: var(--stardust-white);
      opacity: 0.7;
      font-size: 0.9rem;
    }
    
    .security-badge i {
      margin-right: 0.5rem;
      color: var(--orbit-teal);
    }
    
    .orbit-animation {
      position: absolute;
      width: 200px;
      height: 200px;
      border-radius: 50%;
      border: 1px dashed var(--orbit-teal);
      opacity: 0.3;
      animation: rotate 60s linear infinite;
      z-index: -1;
    }
    
    @keyframes rotate {
      from {
        transform: rotate(0deg);
      }
      to {
        transform: rotate(360deg);
      }
    }
    
    .checkout-wrapper {
      position: relative;
      overflow: hidden;
    }
    
    .orbit-1 {
      top: 10%;
      right: -100px;
      width: 300px;
      height: 300px;
    }
    
    .orbit-2 {
      bottom: -50px;
      left: -150px;
      width: 400px;
      height: 400px;
      border-color: var(--cosmic-purple);
      animation-duration: 80s;
    }

    .payment-methods {
      display: flex;
      gap: 1rem;
      margin-bottom: 1.5rem;
    }

    .payment-method {
      padding: 1rem;
      border: 1px solid var(--asteroid-gray);
      border-radius: 8px;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .payment-method.active {
      border-color: var(--orbit-teal);
      background: rgba(0, 188, 212, 0.1);
    }

    .payment-method:hover {
      border-color: var(--celestial-blue);
    }
    
    .promo-code {
      margin-top: 1.5rem;
      display: flex;
      gap: 0.5rem;
    }
    
    .promo-code input {
      flex: 1;
    }
    
    .promo-code button {
      background: var(--asteroid-gray);
      color: var(--stardust-white);
      border: none;
      border-radius: 6px;
      padding: 0 1rem;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    
    .promo-code button:hover {
      background: var(--cosmic-purple);
    }
  </style>
</head>
<body>
  <div class="container-2">
      
      <h2>Complete Your Purchase</h2>
      
<form method="post" action="">
      <div class="checkout-container-2">
        <div class="checkout-form">
          <div class="form-section">

            <div class="section-title">Payment</div>
            <div class="payment-methods">
              <div class="payment-method active">
                <div class="card-icon">CC</div>
                Credit Card
              </div>
            </div>
            
            
            <div class="form-group">
              <label for="cardholder">Cardholder Name</label>
              <input required type="text" name="cardholder_name" id="cardholder" placeholder="As it appears on your card">
            </div>
            
            <div class="form-group">
              <label for="cardnumber">Card Number (16 digits)</label>
              <input required type="text" name="card_number" pattern="\d{16}"  id="cardnumber" placeholder="•••• •••• •••• ••••">
            </div>
            
            <div class="form-row">
              <div class="form-group">
                <label  for="expiry">Expiration Date</label>
                <input required type="date" name="exp_date" id="expiry" placeholder="MM/YY">
              </div>
              <div class="form-group">
                <label  for="cvv">Security Code (3 digits)</label>
                <input required type="text" name="cvv" id="cvv" pattern="\d{3}"  placeholder="123">
              </div>
            </div>
          </div>
          
          <div class="form-section">
            <div class="section-title">Billing Address</div>
            <div class="form-group">
              <label for="billing-address">Street Address</label>
              <input required type="text" name="street_address" id="billing-address" placeholder="1234 Cosmic Avenue">
            </div>
            
            <div class="form-group">
              <label for="billing-apt">Apt/Suite (optional)</label>
              <input  required type="text" name="apt" id="billing-apt" placeholder="Apt #">
            </div>
            
            <div class="form-group">
              <label for="billing-apt">Country</label>
              <input required type="text" name="country" id="billing-country" placeholder="Jamaica">
            </div>
              
              <div class="form-group">
                <label for="billing-city">City</label>
                <input required type="text" name="city" id="billing-city" placeholder="City">
              </div>

            <div class="form-group">
              <label for="billing-state">State/Parish</label>
              <input required type="text" name="state" id="billing-state" placeholder="Manchester">
            </div>
              
              <div class="form-group">
                <label for="billing-zip">ZIP Code</label>
                <input required type="text" id="billing-zip" placeholder="ZIP">
              </div>
            </div>
          
          <div class="security-badge">
            <i>🔒</i> Your payment information is encrypted and secure
          </div>
        </div>
        
        <div class="order-summary">
          <div class="section-title">Order Summary</div>

<?php foreach($cart_list as $cart_item) :?>
          <div class="order-item">
            <div class="item-image"></div>
            <div class="item-details">
<?php //print_r($products[$cart_item['product_id'] - 1 ]['name']) ?>
<?php //print_r($categories[$products[0]['category_id']]['name']) ?>
            <h4 class="item-name"> <?= 
//print_r($category_list);
$prod_list[$cart_item['product_id'] - 1]['name'] . '  (x' . $cart_item['quantity'] . ')'; 
?> </h4>
            <div class="item-specs"> <?= 
            //$categories[$products[$cart_item['cart_id']]['category_id']]['name'] 
            $category_list[$prod_list[$cart_item['product_id'] - 1]['category_id'] - 1]['name'];

?></div>
            </div>
            <div class="item-price">
<?php 
$price = $prod_list[$cart_item['product_id'] - 1]['price'] * $cart_item['quantity']; 
echo '$' . $price ;
?>
</div>
          </div>
<?php endforeach ?>
          
          <div class="order-total">
            <div class="total-row">
              <div class="total-label">Subtotal</div>
              <div class="total-value">$<?= strval($subtotal) ?>
            </div>
            </div>
            <div class="total-row">
              <div class="total-label">Shipping</div>
              <div class="total-value">$<?= strval($shipping) ?></div>
            </div>
            <div class="total-row">
              <div class="total-label">Tax</div>
              <div class="total-value">$<?= strval($tax) ?></div>
            </div>
            <div class="total-row grand-total">
              <div class="total-label">Total</div>
              <div class="total-value">$<?= strval($total) ?></div>
            </div>
          </div>
          
          <button type="submit" name="complete_purchase" class="btn btn-primary" style="width: 100%; margin-top: 1.5rem;">Complete Purchase</button>
</form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
