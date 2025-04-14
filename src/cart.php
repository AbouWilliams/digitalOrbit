<?php
//session_start();
include "includes/header.php";
ob_start();

require 'includes/db_connect.php';

if (!isset($_SESSION['cart_id'])) {
    header('Location: login.php');
    exit;
}

function removeFromCart($id) {
    global $pdo;

    $stmt = $pdo->prepare("insert into cart_items(cart_id, product_id, quantity) values (:cart_id, :product_id, :quantity)"); 
    $results = $stmt->execute([':cart_id' => $_SESSION['cart_id'], ':product_id' => "$id", ':quantity' => '1']);
    //echo "Resulting " . $results;
    $results = $pdo->query("delete from cart_items where product_id = '$id'");
}

if (isset($_POST['plus'])) {
    $quantity =  $_POST['quantity'];
    $stmt = $pdo->prepare("update cart_items set quantity = :quantity where cart_id = :cart_id and product_id = :product_id");
    $stmt->execute([
        ':quantity' => $quantity,
        ':cart_id' => $cart_id,
        ':product_id' => $_POST['prod_id2']
    ]);
}

if (isset($_POST['minus'])) {
    $quantity =  $_POST['quantity'];
    $stmt = $pdo->prepare("update cart_items set quantity = :quantity where cart_id = :cart_id and product_id = :product_id");
    $stmt->execute([
        ':quantity' => $quantity,
        ':cart_id' => $cart_id,
        ':product_id' => $_POST['prod_id2']
    ]);
}

if (isset($_POST['remove'])) {
    $id = $_POST['product_id'];
    removeFromCart($id);
}


$stmt = $pdo->prepare('select * from cart_items where cart_id = :cart_id');
$stmt->execute([':cart_id' => $_SESSION['cart_id']]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare('select * from products');
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
//print_r($products);
$stmt = $pdo->prepare('select * from categories');
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_amount = 0;
foreach ($cart_items as $c) {
    $total_amount += $c['quantity'];
}

$items_amount = $total_amount;

$subtotal = 0;
$shipping = 0;
foreach ($cart_items as $c) {
    $p = $products[$c['product_id'] - 1];
    $price = $p['price']; 
    //echo $price;
    $subtotal += $price * $c['quantity'];
}

$tax_rate = 0.2;
$tax = $subtotal * $tax_rate;
$shipping = 50 * count($cart_items);
$total = $subtotal + $tax + $shipping;

$prod_total = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'includes/head.php' ?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Digital Orbits - Shopping Cart</title>
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

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background: linear-gradient(to bottom, var(--deep-space), #1A237E);
      color: var(--stardust-white);
      min-height: 100vh;
      position: relative;
      overflow-x: hidden;
    }

    /* Star field background */
    body::before {
      content: "";
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-image: 
        radial-gradient(white, rgba(255,255,255,.2) 2px, transparent 3px),
        radial-gradient(white, rgba(255,255,255,.15) 1px, transparent 2px),
        radial-gradient(white, rgba(255,255,255,.1) 2px, transparent 3px);
      background-size: 550px 550px, 350px 350px, 250px 250px;
      background-position: 0 0, 40px 60px, 130px 270px;
      z-index: -1;
    }

    .cart-container {
      max-width: 1200px;
      margin: 0 auto;
        margin-top: 50px; 
      padding: 40px 20px;
    }

    .cart-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
      padding-bottom: 15px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .cart-title {
      font-size: 2rem;
      color: var(--stardust-white);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .cart-title svg {
      color: var(--orbit-teal);
    }

    .continue-shopping {
      display: flex;
      align-items: center;
      gap: 8px;
      color: var(--orbit-teal);
      text-decoration: none;
      font-size: 0.9rem;
      padding: 8px 12px;
      border: 1px solid var(--orbit-teal);
      border-radius: 5px;
      transition: all 0.2s ease;
    }

    .continue-shopping:hover {
      background-color: rgba(0, 188, 212, 0.1);
    }

    .cart-content {
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
    }

    .cart-items {
      flex: 1 1 65%;
      min-width: 300px;
    }

    .cart-summary {
      flex: 1 1 30%;
      min-width: 300px;
    }

    /* Cart Item Styles */
    .cart-item {
      display: flex;
      margin-bottom: 20px;
      padding: 20px;
      background: linear-gradient(135deg, rgba(12, 20, 69, 0.6), rgba(61, 26, 124, 0.4));
      border-radius: 15px;
      border: 1px solid rgba(255, 255, 255, 0.1);
      position: relative;
      overflow: hidden;
    }

    .cart-item::after {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 2px;
      background: linear-gradient(to right, transparent, var(--orbit-teal), transparent);
      animation: scan 2s linear infinite;
    }

    @keyframes scan {
      0% {
        transform: translateY(-100%);
      }
      100% {
        transform: translateY(800%);
      }
    }

    .item-image {
      width: 120px;
      height: 120px;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: rgba(255, 255, 255, 0.05);
      border-radius: 10px;
      margin-right: 20px;
      padding: 10px;
    }

    .item-image img {
      max-width: 100%;
      max-height: 100%;
    }

    .item-details {
      flex: 1;
      display: flex;
      flex-direction: column;
    }

    .item-top {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
    }

    .item-name {
      font-size: 1.2rem;
      color: var(--stardust-white);
      margin-bottom: 5px;
    }

    .item-category {
      font-size: 0.8rem;
      color: var(--orbit-teal);
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .item-price {
      font-size: 1.2rem;
      color: var(--nova-orange);
      font-weight: bold;
      margin-left: 10px;
    }

    .item-actions {
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      margin-top: auto;
    }

    .quantity-control {
      display: flex;
      align-items: center;
      background-color: rgba(30, 136, 229, 0.2);
      border-radius: 5px;
      overflow: hidden;
    }

    .quantity-btn {
      background: none;
      border: none;
      color: var(--stardust-white);
      width: 30px;
      height: 30px;
      display: flex;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .quantity-btn:hover {
      background-color: rgba(30, 136, 229, 0.4);
    }

    .quantity-input {
      width: 40px;
      height: 30px;
      border: none;
      background-color: rgba(30, 136, 229, 0.3);
      color: var(--stardust-white);
      text-align: center;
      font-size: 0.9rem;
    }

    .quantity-input:focus {
      outline: none;
    }

    .item-remove {
      background: none;
      border: none;
      color: rgba(255, 255, 255, 0.6);
      cursor: pointer;
      transition: all 0.2s ease;
      display: flex;
      align-items: center;
      gap: 5px;
      font-size: 0.9rem;
    }

    .item-remove:hover {
      color: var(--nova-orange);
    }

    .item-subtotal {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      justify-content: center;
      margin-left: 20px;
    }

    .subtotal-label {
      font-size: 0.8rem;
      color: rgba(255, 255, 255, 0.6);
      margin-bottom: 5px;
    }

    .subtotal-value {
      font-size: 1.3rem;
      color: var(--nova-orange);
      font-weight: bold;
    }

    /* Summary Styles */
    .summary-panel {
      background: linear-gradient(135deg, rgba(12, 20, 69, 0.8), rgba(61, 26, 124, 0.6));
      border-radius: 15px;
      padding: 25px;
      border: 1px solid rgba(255, 255, 255, 0.1);
      position: relative;
      overflow: hidden;
    }

    .summary-panel::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: radial-gradient(circle at top right, rgba(0, 188, 212, 0.15), transparent 70%);
      pointer-events: none;
    }

    .summary-title {
      font-size: 1.5rem;
      margin-bottom: 20px;
      color: var(--stardust-white);
      text-align: center;
      padding-bottom: 15px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .summary-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 15px;
      font-size: 1rem;
    }

    .summary-label {
      color: rgba(255, 255, 255, 0.8);
    }

    .summary-value {
      color: var(--stardust-white);
      font-weight: 500;
    }

    .summary-divider {
      height: 1px;
      background-color: rgba(255, 255, 255, 0.1);
      margin: 15px 0;
    }

    .summary-total {
      display: flex;
      justify-content: space-between;
      margin: 20px 0;
      font-size: 1.3rem;
    }

    .total-label {
      color: var(--stardust-white);
      font-weight: 500;
    }

    .total-value {
      color: var(--nova-orange);
      font-weight: bold;
    }

    .checkout-btn {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 8px;
      background-color: var(--celestial-blue);
      color: var(--stardust-white);
      font-size: 1.1rem;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s ease;
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 10px;
      margin-top: 20px;
    }

    .checkout-btn:hover {
      background-color: #1976D2;
      box-shadow: 0 0 15px rgba(30, 136, 229, 0.7);
    }

    .promo-code {
      margin-top: 25px;
    }

    .promo-title {
      font-size: 1rem;
      margin-bottom: 10px;
      color: var(--stardust-white);
    }

    .promo-input {
      display: flex;
      width: 100%;
      overflow: hidden;
      border-radius: 5px;
      margin-bottom: 10px;
    }

    .promo-field {
      flex: 1;
      padding: 10px;
      border: none;
      background-color: rgba(255, 255, 255, 0.1);
      color: var(--stardust-white);
      font-size: 0.9rem;
    }

    .promo-field::placeholder {
      color: rgba(255, 255, 255, 0.5);
    }

    .promo-field:focus {
      outline: none;
    }

    .apply-btn {
      padding: 0 15px;
      border: none;
      background-color: var(--orbit-teal);
      color: var(--stardust-white);
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .apply-btn:hover {
      background-color: #00ACC1;
    }

    .payment-methods {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-top: 20px;
    }

    .payment-icon {
      width: 40px;
      height: 25px;
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 4px;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 5px;
    }

    .empty-cart {
      text-align: center;
      padding: 40px 20px;
      background: linear-gradient(135deg, rgba(12, 20, 69, 0.6), rgba(61, 26, 124, 0.4));
      border-radius: 15px;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .empty-cart-icon {
      font-size: 5rem;
      color: var(--orbit-teal);
      margin-bottom: 20px;
      opacity: 0.7;
    }

    .empty-cart-title {
      font-size: 1.5rem;
      margin-bottom: 10px;
      color: var(--stardust-white);
    }

    .empty-cart-text {
      color: rgba(255, 255, 255, 0.7);
      margin-bottom: 25px;
    }

    .browse-btn {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      background-color: var(--celestial-blue);
      color: var(--stardust-white);
      padding: 10px 20px;
      border-radius: 5px;
      text-decoration: none;
      font-weight: 500;
      transition: all 0.2s ease;
    }

    .browse-btn:hover {
      background-color: #1976D2;
      box-shadow: 0 0 15px rgba(30, 136, 229, 0.7);
    }

    .cart-recommendation {
      margin-top: 40px;
    }

    .recommendation-title {
      font-size: 1.3rem;
      margin-bottom: 20px;
      color: var(--stardust-white);
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .recommendation-title svg {
      color: var(--orbit-teal);
    }

    .recommendation-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 20px;
    }

    .recommendation-card {
      background: linear-gradient(135deg, rgba(12, 20, 69, 0.6), rgba(61, 26, 124, 0.4));
      border-radius: 10px;
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      position: relative;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .recommendation-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(0, 188, 212, 0.3);
    }

    .recommendation-image {
      height: 140px;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: rgba(255, 255, 255, 0.05);
      padding: 10px;
    }

    .recommendation-image img {
      max-width: 100%;
      max-height: 120px;
    }

    .recommendation-details {
      padding: 10px 15px;
    }

    .recommendation-name {
      font-size: 1rem;
      margin-bottom: 5px;
      color: var(--stardust-white);
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .recommendation-price {
      font-size: 1.1rem;
      color: var(--nova-orange);
      font-weight: bold;
      margin-bottom: 10px;
    }

    .recommendation-add {
      width: 100%;
      background-color: rgba(30, 136, 229, 0.2);
      color: var(--stardust-white);
      border: 1px solid var(--celestial-blue);
      padding: 6px;
      border-radius: 5px;
      font-size: 0.9rem;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .recommendation-add:hover {
      background-color: rgba(30, 136, 229, 0.4);
    }

    /* Responsive Adjustments */
    @media (max-width: 768px) {
      .cart-content {
        flex-direction: column;
      }

      .cart-item {
        flex-direction: column;
      }

      .item-image {
        width: 100%;
        margin-right: 0;
        margin-bottom: 15px;
      }

      .item-subtotal {
        margin-left: 0;
        margin-top: 15px;
        align-items: flex-start;
      }

      .item-actions {
        flex-direction: column;
        align-items: flex-start;
        gap: 15px;
      }

      .cart-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
      }
    }
  </style>
</head>
<body>
  <div class="cart-container">
    <div class="cart-header">
      <h1 class="cart-title">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <circle cx="9" cy="21" r="1"></circle>
          <circle cx="20" cy="21" r="1"></circle>
          <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
        </svg>
        Space Cart
      </h1>
      <a href="catalogue.php" class="continue-shopping">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M19 12H5M12 19l-7-7 7-7"></path>
        </svg>
        Continue Exploring
      </a>
    </div>

    <div class="cart-content">
      <div class="cart-items">
        <!-- Cart Item 1 -->
<?php foreach($cart_items as $cart_item) : ?>
<?php $product = $products[$cart_item['product_id'] - 1]; 
$category = $categories[$product['category_id'] - 1];
?>
        <div class="cart-item">
          <div class="item-image">
          <img src="<?= $product['image_url'] ?>" alt="<?= $product['name'] ?>">
          </div>
          <div class="item-details">
            <div class="item-top">
              <div>
              <h3 class="item-name"> <?= $product['name'] ?> </h3>
              <span class="item-category"><?= $category['name'] ?></span>
              </div>
              <span class="item-price"><?= $product['price'] ?></span>
            </div>
            <div class="item-actions">
<form method="post">
              <div class="quantity-control">
                <button class="quantity-btn" type="submit" name="minus">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14"></path>
                  </svg>
                </button>
                <input type="text" class="quantity-input" value="<?= $cart_item['quantity'] ?>" name="quantity" readonly>
                <button class="quantity-btn" type="submit" name="plus">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14M5 12h14"></path>
                  </svg>
                </button>
              </div>
                <input hidden type="text" name="prod_id2" value="<?= $product['product_id'] ?>">
</form>
        <form method="post" action"">
       <input type="hidden" name="product_id" value="<?= $cart_item['product_id'] ?>"> 

              <button class="item-remove" name="remove" type="submit">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path>
                </svg>
                Remove
              </button>
        </form>
            </div>
          </div>
          <div class="item-subtotal">
            <span class="subtotal-label">Subtotal</span>
            <span class="subtotal-value">$<?= $product['price'] * $cart_item['quantity'] ?> </span>
          </div>
        </div>
<?php endforeach ?>

        <!-- Recommendations -->
        <div class="cart-recommendation">
          <h2 class="recommendation-title">
          </h2>
        </div>
      </div>

      <!-- Cart Summary -->
      <div class="cart-summary">
        <div class="summary-panel">
          <h2 class="summary-title">Cart Summary</h2>
          
          <div class="summary-row">
            <span class="summary-label">Items (<?= $items_amount ?>)</span>
            <span class="summary-value">$<?= $subtotal ?></span>
          </div>
          
          <div class="summary-row">
            <span class="summary-label">Shipping</span>
            <span class="summary-value">$<?= $shipping ?></span>
          </div>
          
          <div class="summary-row">
            <span class="summary-label">Tax</span>
            <span class="summary-value">$<?= $tax ?></span>
          </div>
          
          <div class="summary-divider"></div>
          
          <div class="summary-total">
            <span class="total-label">Total</span>
            <span class="total-value">$<?= $total ?></span>
          </div>
          
          <button class="checkout-btn" onclick="window.location='payment.php'">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M5 12h14M12 5l7 7-7 7"></path>
            </svg>
            Proceed to Checkout
          </button>
          
          
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
    // Initialize cart functionality
    document.addEventListener('DOMContentLoaded', function() {
      // Get all quantity buttons
      const minusButtons = document.querySelectorAll('.quantity-btn:first-child');
      const plusButtons = document.querySelectorAll('.quantity-btn:last-child');
      const removeButtons = document.querySelectorAll('.item-remove');
      const checkoutBtn = document.querySelector('.checkout-btn');
      const applyPromoBtn = document.querySelector('.apply-btn');
      const recommendAddBtns = document.querySelectorAll('.recommendation-add');
      
      // Decrease quantity
      minusButtons.forEach(button => {
        button.addEventListener('click', function() {
          const input = this.nextElementSibling;
          let value = parseInt(input.value);
          if (value > 1) {
            value--;
            input.value = value;
            updateSubtotal(this);
          }
        });
      });
      
      // Increase quantity
      plusButtons.forEach(button => {
        button.addEventListener('click', function() {
          const input = this.previousElementSibling;
          let value = parseInt(input.value);
          value++;
          input.value = value;
          updateSubtotal(this);
        });
      });
      
      // Remove item
      removeButtons.forEach(button => {
        button.addEventListener('click', function() {
          const cartItem = this.closest('.cart-item');
          cartItem.style.opacity = '0';
          setTimeout(() => {
            cartItem.remove();
            updateCartTotal();
            if (document.querySelectorAll('.cart-item').length === 0) {
              showEmptyCart();
            }
          }, 300);
        });
      });
      
      // Update subtotal based on quantity
      function updateSubtotal(button) {
        const cartItem = button.closest('.cart-item');
        const priceElement = cartItem.querySelector('.item-price');
        const price = parseFloat(priceElement.textContent.replace('$', ''));
        const quantity = parseInt(cartItem.querySelector('.quantity-input').value);
        const subtotalElement = cartItem.querySelector('.subtotal-value');
        const subtotal = price * quantity;
        subtotalElement.textContent = '$' + subtotal.toFixed(2);
        updateCartTotal();
      }
      
      // Update cart total
      function updateCartTotal() {
        const subtotals = document.querySelectorAll('.subtotal-value');
        let total = 0;
        subtotals.forEach(subtotal => {
          total += parseFloat(subtotal.textContent.replace('$', ''));
        });
        
        // Update items count and subtotal
        const itemsCount = document.querySelectorAll('.cart-item').length;
        document.querySelector('.summary-row:first-child .summary-label').textContent = `Items (${itemsCount})`;
        document.querySelector('.summary-row:first-child .summary-value').textContent = '$' + total.toFixed(2);
        
        // Calculate tax (8% for example)
        const tax = total * 0.08;
        document.querySelector('.summary-row:nth-child(3) .summary-value').textContent = '$' + tax.toFixed(2);
        
        // Update total
        const grandTotal = total + tax;
        document.querySelector('.total-value').textContent = '$' + grandTotal.toFixed(2);
      }
      
      // Show empty cart
      function showEmptyCart() {
        const cartItems = document.querySelector('.cart-items');
        cartItems.innerHTML = `
          <div class="empty-cart">
            <div class="empty-cart-icon">
              <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                <circle cx="9" cy="21" r="1"></circle>
                <circle cx="20" cy="21" r="1"></circle>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
              </svg>
            </div>
            <h2 class="empty-cart-title">Your Space Cart is Empty</h2>
            <p class="empty-cart-text">Looks like you haven't added any cosmic tech to your cart yet.</p>
            <a href="#" class="browse-btn">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 12H3M3 12l7 7M3 12l7-7"></path>
              </svg>
              Browse Products
            </a>
          </div>
        `;
        
        // Update summary
        document.querySelector('.summary-row:first-child .summary-label').textContent = 'Items (0)';
        document.querySelector('.summary-row:first-child .summary-value').textContent = '$0.00';
        document.querySelector('.summary-row:nth-child(3) .summary-value').textContent = '$0.00';
        document.querySelector('.total-value').textContent = '$0.00';
      }
      
      // Apply promo code
      applyPromoBtn.addEventListener('click', function() {
        const promoField = document.querySelector('.promo-field');
        const promoCode = promoField.value.trim().toUpperCase();
        
        if (promoCode === 'SPACE10') {
          // Add discount row if not exists
          if (!document.querySelector('.summary-row.discount')) {
            const discountRow = document.createElement('div');
            discountRow.className = 'summary-row discount';
            discountRow.innerHTML = `
              <span class="summary-label">Discount (10%)</span>
              <span class="summary-value discount-value">-$0.00</span>
            `;
            
            // Insert before tax row
            const taxRow = document.querySelector('.summary-row:nth-child(3)');
            taxRow.parentNode.insertBefore(discountRow, taxRow);
            
            // Apply discount
            applyDiscount(0.1);
            
            // Show success message
            showPromoMessage('Promo code applied successfully!', 'success');
          } else {
            showPromoMessage('Promo code already applied', 'info');
          }
        } else if (promoCode === '') {
          showPromoMessage('Please enter a promo code', 'info');
        } else {
          showPromoMessage('Invalid promo code', 'error');
        }
      });
      
      // Apply discount
      function applyDiscount(percent) {
        const subtotalValue = parseFloat(document.querySelector('.summary-row:first-child .summary-value').textContent.replace('$', ''));
        const discountAmount = subtotalValue * percent;
        document.querySelector('.discount-value').textContent = '-$' + discountAmount.toFixed(2);
        
        // Recalculate total
        const shipping = parseFloat(document.querySelector('.summary-row:nth-child(2) .summary-value').textContent.replace('$', ''));
        const tax = parseFloat(document.querySelector('.summary-row:nth-child(4) .summary-value').textContent.replace('$', ''));
        const total = subtotalValue - discountAmount + shipping + tax;
        document.querySelector('.total-value').textContent = '$' + total.toFixed(2);
      }
      
      // Show promo message
      function showPromoMessage(message, type) {
        const promoCode = document.querySelector('.promo-code');
        
        // Remove any existing message
        const existingMessage = document.querySelector('.promo-message');
        if (existingMessage) {
          existingMessage.remove();
        }
        
        // Create message element
        const messageElement = document.createElement('div');
        messageElement.className = `promo-message ${type}`;
        messageElement.textContent = message;
        messageElement.style.fontSize = '0.8rem';
        messageElement.style.marginTop = '5px';
        
        if (type === 'success') {
          messageElement.style.color = '#4CAF50';
        } else if (type === 'error') {
          messageElement.style.color = '#F44336';
        } else {
          messageElement.style.color = '#2196F3';
        }
        
        promoCode.appendChild(messageElement);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
          messageElement.remove();
        }, 3000);
      }
      
      // Add recommended product to cart
      recommendAddBtns.forEach(button => {
        button.addEventListener('click', function() {
          const card = this.closest('.recommendation-card');
          const productName = card.querySelector('.recommendation-name').textContent;
          const productPrice = card.querySelector('.recommendation-price').textContent;
          const productImg = card.querySelector('.recommendation-image img').src;
          
          // Create new cart item
          addToCart(productName, productPrice, productImg);
          
          // Show added message
          this.textContent = 'Added to Cart';
          this.style.backgroundColor = 'rgba(76, 175, 80, 0.2)';
          this.style.borderColor = '#4CAF50';
          
          setTimeout(() => {
            this.textContent = 'Add to Cart';
            this.style.backgroundColor = '';
            this.style.borderColor = '';
          }, 2000);
        });
      });
      
      // Add to cart function
      function addToCart(name, price, img) {
        const cartItems = document.querySelector('.cart-items');
        
        // Remove empty cart if exists
        const emptyCart = document.querySelector('.empty-cart');
        if (emptyCart) {
          emptyCart.remove();
        }
        
        // Create new cart item
        const newItem = document.createElement('div');
        newItem.className = 'cart-item';
        newItem.style.opacity = '0';
        newItem.innerHTML = `
          <div class="item-image">
            <img src="${img}" alt="${name}">
          </div>
          <div class="item-details">
            <div class="item-top">
              <div>
                <h3 class="item-name">${name}</h3>
                <span class="item-category">Added Item</span>
              </div>
              <span class="item-price">${price}</span>
            </div>
            <div class="item-actions">
              <div class="quantity-control">
                <button class="quantity-btn">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M5 12h14"></path>
                  </svg>
                </button>
                <input type="text" class="quantity-input" value="1" readonly>
                <button class="quantity-btn">
                  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14M5 12h14"></path>
                  </svg>
                </button>
              </div>
              <button class="item-remove">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M3 6h18M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path>
                </svg>
                Remove
              </button>
            </div>
          </div>
          <div class="item-subtotal">
            <span class="subtotal-label">Subtotal</span>
            <span class="subtotal-value">${price}</span>
          </div>
        `;
        
        // Add before recommendations
        const recommendations = document.querySelector('.cart-recommendation');
        cartItems.insertBefore(newItem, recommendations);
        
        // Fade in animation
        setTimeout(() => {
          newItem.style.opacity = '1';
        }, 10);
        
        // Add event listeners to new item
        const minusBtn = newItem.querySelector('.quantity-btn:first-child');
        const plusBtn = newItem.querySelector('.quantity-btn:last-child');
        const removeBtn = newItem.querySelector('.item-remove');
        
        minusBtn.addEventListener('click', function() {
          const input = this.nextElementSibling;
          let value = parseInt(input.value);
          if (value > 1) {
            value--;
            input.value = value;
            updateSubtotal(this);
          }
        });
        
        plusBtn.addEventListener('click', function() {
          const input = this.previousElementSibling;
          let value = parseInt(input.value);
          value++;
          input.value = value;
          updateSubtotal(this);
        });
        
        removeBtn.addEventListener('click', function() {
          const cartItem = this.closest('.cart-item');
          cartItem.style.opacity = '0';
          setTimeout(() => {
            cartItem.remove();
            updateCartTotal();
            if (document.querySelectorAll('.cart-item').length === 0) {
              showEmptyCart();
            }
          }, 300);
        });
        
        // Update totals
        updateCartTotal();
      }
      
      // Checkout button
      checkoutBtn.addEventListener('click', function() {
        alert('Redirecting to checkout...');
      });
    });
  </script>
<?php include 'includes/footer.php' ?>
</body>
</html>
