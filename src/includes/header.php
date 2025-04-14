<?php
session_start();
ob_start();
include 'db_connect.php';
$currentPage = basename($_SERVER['PHP_SELF']);
//print_r($_SESSION);
$fname = '';
$is_login = false;
if (isset($_SESSION['fname'])) {
    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname'];
    $is_login = true;
    //echo "fname: " . $fname;
} else {
    //echo "false";
    $fname = null;
    $is_login = false;
}

$cart_id = '';
if (isset($_SESSION['cart_id'])) {
    $cart_id = $_SESSION['cart_id'];
}

$stmt = $pdo->prepare('select * from cart_items where cart_id = :cart_id');
$stmt->execute([':cart_id' => $cart_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_amount = 0;
foreach ($cart_items as $c) {
    $total_amount += $c['quantity'];
}

$items_amount = $total_amount;
//echo "login" . $is_login;

?>

    <div class="stars"></div>
    
    <!-- Twinkling Stars -->
    <div class="twinkling-star" style="top: 15%; left: 20%; animation-delay: 0s;"></div>
    <div class="twinkling-star" style="top: 25%; left: 30%; animation-delay: 0.5s;"></div>
    <div class="twinkling-star" style="top: 10%; left: 40%; animation-delay: 1s;"></div>
    <div class="twinkling-star" style="top: 20%; left: 60%; animation-delay: 1.5s;"></div>
    <div class="twinkling-star" style="top: 5%; left: 70%; animation-delay: 2s;"></div>
    <div class="twinkling-star" style="top: 30%; left: 80%; animation-delay: 2.5s;"></div>
    <div class="twinkling-star" style="top: 40%; left: 15%; animation-delay: 0.2s;"></div>
    <div class="twinkling-star" style="top: 50%; left: 35%; animation-delay: 0.7s;"></div>
    <div class="twinkling-star" style="top: 55%; left: 55%; animation-delay: 1.2s;"></div>
    <div class="twinkling-star" style="top: 65%; left: 75%; animation-delay: 1.7s;"></div>
    <div class="twinkling-star" style="top: 75%; left: 25%; animation-delay: 2.2s;"></div>
    <div class="twinkling-star" style="top: 80%; left: 45%; animation-delay: 2.7s;"></div>
    <div class="twinkling-star" style="top: 85%; left: 65%; animation-delay: 1.3s;"></div>
    <div class="twinkling-star" style="top: 90%; left: 85%; animation-delay: 0.8s;"></div>
    
    <!-- Shooting Stars -->
    <div class="shooting-star" style="--delay: 2; --top: 20;"></div>
    <div class="shooting-star" style="--delay: 5; --top: 40;"></div>
    <div class="shooting-star" style="--delay: 8; --top: 60;"></div>
    <div class="shooting-star" style="--delay: 11; --top: 80;"></div>
    
    <!-- Navigation -->
<?php
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <div class="planet"><div class="ring"></div></div>
            <span>Digital Orbit</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'index.php' ? 'active' : '' ?>" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'catalogue.php' ? 'active' : '' ?>" href="catalogue.php">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'about.php' ? 'active' : '' ?>" href="about.php">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'faq.php' ? 'active' : '' ?>" href="faq.php">FAQ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $currentPage === 'contact.php' ? 'active' : '' ?>" href="contact.php">Contact</a>
                </li>
            </ul>
            <div class="d-flex">
                <?php
                    if (!$is_login) {
                        echo '<a href="login.php" class="nav-link me-3">Login</a>';
                        echo '<a href="register.php" class="nav-link me-3">Register</a>';
                    } else {
                        echo "<a href='cart.php' class='nav-link me-3'> $fname $lname</a>";
                        echo "<a href='logout.php' class='nav-link me-3'>Logout</a>";
                    }
                ?>
                <a href="cart.php" class="nav-link cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-badge"><?= $items_amount ?></span>
                </a>
            </div>
        </div>
    </div>
</nav>

