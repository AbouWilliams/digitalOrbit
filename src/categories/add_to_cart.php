<?php
function addToCart($id) {
    if (!isset($_SESSION['cart_id'])) {
        header("Location: ../login.php");
    }
    global $pdo;

    /*
    $results = $pdo->query("select * from cart_items where product_id = '$id'");
    if ($results) {
        return;
    }
     */

    $stmt = $pdo->prepare("insert into cart_items(cart_id, product_id, quantity) values (:cart_id, :product_id, :quantity)"); 
    $results = $stmt->execute([':cart_id' => $_SESSION['cart_id'], ':product_id' => "$id", ':quantity' => '1']);
    //echo "Resulting " . $results;
}

if (isset($_POST['add_to_cart'])) {
    $id = $_POST['product_id'];
    addToCart($id);
}
$cart_id = $_SESSION['cart_id'];
$stmt = $pdo->query("select product_id from cart_items where cart_id = '$cart_id'");
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
$product_items = [];
foreach ($cart_items as $item) {
    $product_items[] = $item['product_id'];
}

