<?php
require 'includes/db_connect.php';
include 'includes/header.php';
?>

<div class="container my-5">
    <div class="jumbotron text-center">
        <h1 class="display-4">Welcome to Digital Orbit</h1>
        <p class="lead">Explore our wide range of products in fitness, electronics, and more!</p>
        <a class="btn btn-primary btn-lg" href="catalogue.php" role="button">Shop Now</a>
    </div>
    <h2 class="my-4">Featured Products</h2>
    <div class="row">
        <?php
        $stmt = $pdo->query("SELECT * FROM products WHERE category_id = 3 LIMIT 3");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
        ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="images/<?php echo htmlspecialchars($row['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['name']); ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($row['description']); ?></p>
                        <p class="card-text"><strong>$<?php echo number_format($row['price'], 2); ?></strong></p>
                        <a href="cart.php?action=add&id=<?php echo $row['id']; ?>" class="btn btn-primary add-to-cart">Add to Cart</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
