<?php
//session_start();

include '../includes/header.php';
include '../includes/db_connect.php';
$errors = [];

$category_filter = [];
$brand_filter = [];
$price_min = 0;
$price_max = 2000;
$rating_filter = [];
$availability = ['instock'];
$sort = 'popular';
$page = 1;
$items_per_page = 9;

include 'add_to_cart.php';

$query = "select p.*, c.name as category_name, b.name as brand_name
    from products p
    join categories c on p.category_id = c.category_id
    join brands b on p.brand_id = b.brand_id
    where 1=1";

if (!empty($category_filter)) {
    $placeholders = implode(',', array_fill(0, count($category_filter), '?'));
    $query .= " AND c.name IN ($placeholders)";
}
if (!empty($brand_filter)) {
    $placeholders = implode(',', array_fill(0, count($brand_filter), '?'));
    $query .= " AND b.name IN ($placeholders)";
}
$query .= " AND p.price BETWEEN ? AND ?";
if (!empty($rating_filter)) {
    $placeholders = implode(',', array_fill(0, count($rating_filter), '?'));
    $query .= " AND p.rating IN ($placeholders)";
}
if (in_array('instock', $availability) && !in_array('preorder', $availability)) {
    $query .= " AND p.in_stock = TRUE";
} elseif (!in_array('instock', $availability) && in_array('preorder', $availability)) {
    $query .= " AND p.pre_order = TRUE";
}

switch ($sort) {
    case 'newest':
        $query .= " ORDER BY p.created_at DESC";
        break;
    case 'price-low':
        $query .= " ORDER BY p.price ASC";
        break;
    case 'price-high':
        $query .= " ORDER BY p.price DESC";
        break;
    case 'rating':
        $query .= " ORDER BY p.rating DESC";
        break;
    default: // popular
        $query .= " ORDER BY p.product_id DESC"; // Assuming newer products are more popular
}

$query .= " LIMIT " . (($page - 1) * $items_per_page) . ", $items_per_page";

// Execute query with all parameters
$stmt = $pdo->prepare($query);
$paramIndex = 1;

if (!empty($category_filter)) {
    foreach ($category_filter as $category) {
        $stmt->bindValue($paramIndex++, $category);
    }
}
if (!empty($brand_filter)) {
    foreach ($brand_filter as $brand) {
        $stmt->bindValue($paramIndex++, $brand);
    }
}
$stmt->bindValue($paramIndex++, $price_min);
$stmt->bindValue($paramIndex++, $price_max);
if (!empty($rating_filter)) {
    foreach ($rating_filter as $rating) {
        $stmt->bindValue($paramIndex++, $rating);
    }
}

$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*
// Count total for pagination
$count_query = preg_replace('/SELECT p\.\*, c\.name as category_name, b\.name as brand_name/', 'SELECT COUNT(*)', $query);
$count_query = preg_replace('/LIMIT.*$/', '', $count_query);
$count_stmt = $pdo->prepare($count_query);
// Rebind all parameters...
$count_stmt->execute();
$total_products = $count_stmt->fetchColumn();
$total_pages = ceil($total_products / $items_per_page);

 */
// Get all categories and brands for filters
$categories = $pdo->query("SELECT * FROM categories ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
$brands = $pdo->query("SELECT * FROM brands ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>

<?php include '../includes/head.php' ?>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Digital Orbits - Product Catalog</title>
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

    .catalog-container {
      display: flex;
      max-width: 1400px;
      margin: 0 auto;
margin-top: 80px;
      padding: 20px;
    }

    /* Filter sidebar styles */
    .filter-sidebar {
      width: 250px;
      background-color: rgba(12, 20, 69, 0.8);
      border-radius: 15px;
      padding: 20px;
      margin-right: 20px;
      border: 1px solid rgba(255, 255, 255, 0.1);
      box-shadow: 0 0 20px rgba(0, 188, 212, 0.2);
    }

    .filter-title {
      font-size: 1.5rem;
      margin-bottom: 20px;
      color: var(--orbit-teal);
      text-align: center;
      text-transform: uppercase;
      letter-spacing: 1px;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      padding-bottom: 10px;
    }

    .filter-section {
      margin-bottom: 25px;
    }

    .filter-section h3 {
      color: var(--stardust-white);
      margin-bottom: 10px;
      font-size: 1rem;
      font-weight: 500;
      display: flex;
      align-items: center;
    }

    .filter-section h3::before {
      content: "⦿";
      color: var(--orbit-teal);
      margin-right: 8px;
    }

    .filter-option {
      display: flex;
      align-items: center;
      margin-bottom: 8px;
    }

    .filter-option input {
      margin-right: 8px;
      accent-color: var(--orbit-teal);
    }

    .filter-option label {
      color: rgba(248, 249, 250, 0.8);
      font-size: 0.9rem;
    }

    .price-range {
      display: flex;
      flex-direction: column;
      gap: 10px;
      padding: 0 5px;
    }

    .price-slider {
      width: 100%;
      accent-color: var(--orbit-teal);
    }

    .range-labels {
      display: flex;
      justify-content: space-between;
      color: var(--stardust-white);
      font-size: 0.8rem;
    }

    /* Main content area */
    .catalog-content {
      flex: 1;
    }

    .catalog-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
      background-color: rgba(55, 71, 79, 0.4);
      padding: 15px 20px;
      border-radius: 10px;
    }

    .catalog-title {
      font-size: 1.5rem;
      color: var(--stardust-white);
    }

    .sort-controls {
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .sort-controls label {
      font-size: 0.9rem;
      color: rgba(248, 249, 250, 0.8);
    }

    .sort-select {
      background-color: rgba(30, 136, 229, 0.2);
      border: 1px solid var(--celestial-blue);
      border-radius: 5px;
      color: var(--stardust-white);
      padding: 5px 10px;
      font-size: 0.9rem;
      cursor: pointer;
    }

    .sort-select option {
      background-color: var(--deep-space);
    }

    .view-toggle {
      display: flex;
      gap: 5px;
    }

    .view-button {
      background-color: rgba(30, 136, 229, 0.2);
      border: 1px solid var(--celestial-blue);
      border-radius: 5px;
      color: var(--stardust-white);
      width: 30px;
      height: 30px;
      display: flex;
      justify-content: center;
      align-items: center;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .view-button.active {
      background-color: var(--celestial-blue);
    }

    /* Product grid */
    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 25px;
    }

    .product-card {
      background: linear-gradient(135deg, rgba(12, 20, 69, 0.9), rgba(61, 26, 124, 0.8));
      border-radius: 15px;
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      position: relative;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .product-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 20px rgba(0, 188, 212, 0.3);
    }

    .product-card::after {
      content: "";
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(0, 188, 212, 0.1), transparent 70%);
      opacity: 0;
      transition: opacity 0.3s ease;
      pointer-events: none;
    }

    .product-card:hover::after {
      opacity: 1;
    }

    .product-image {
      height: 200px;
      background-color: rgba(248, 249, 250, 0.05);
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      position: relative;
      overflow: hidden;
    }

    .product-image img {
      max-width: 100%;
      max-height: 160px;
      transition: transform 0.3s ease;
    }

    .product-card:hover .product-image img {
      transform: scale(1.05);
    }

    .product-details {
      padding: 15px;
    }

    .product-category {
      font-size: 0.8rem;
      color: var(--orbit-teal);
      margin-bottom: 5px;
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .product-name {
      font-size: 1.1rem;
      margin-bottom: 10px;
      color: var(--stardust-white);
    }

    .product-price {
      font-size: 1.2rem;
      color: var(--nova-orange);
      font-weight: bold;
      margin-bottom: 15px;
    }

    .product-actions {
      display: flex;
      justify-content: space-between;
      gap: 10px;
    }

    .add-to-cart {
      flex: 1;
      background-color: var(--celestial-blue);
      color: var(--stardust-white);
      border: none;
      padding: 8px;
      border-radius: 5px;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.2s ease;
    }

    .add-to-cart:hover {
      background-color: #1976D2;
      box-shadow: 0 0 10px rgba(30, 136, 229, 0.5);
    }

    .quick-view {
      width: 38px;
      background-color: rgba(55, 71, 79, 0.8);
      color: var(--stardust-white);
      border: none;
      padding: 8px;
      border-radius: 5px;
      cursor: pointer;
      transition: all 0.2s ease;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .quick-view:hover {
      background-color: var(--asteroid-gray);
      box-shadow: 0 0 10px rgba(55, 71, 79, 0.5);
    }

    /* Pagination */
    .pagination {
      display: flex;
      justify-content: center;
      margin-top: 40px;
      gap: 5px;
    }

    .page-item {
      width: 36px;
      height: 36px;
      display: flex;
      justify-content: center;
      align-items: center;
      border-radius: 50%;
      background-color: rgba(55, 71, 79, 0.4);
      color: var(--stardust-white);
      font-size: 0.9rem;
      cursor: pointer;
      transition: all 0.2s ease;
      position: relative;
    }

    .page-item.active {
      background-color: rgba(0, 188, 212, 0.2);
    }

    .page-item.active::before {
      content: "";
      position: absolute;
      top: -3px;
      left: -3px;
      right: -3px;
      bottom: -3px;
      border: 1px solid var(--orbit-teal);
      border-radius: 50%;
      animation: orbit 4s linear infinite;
    }

    @keyframes orbit {
      from {
        transform: rotate(0deg);
      }
      to {
        transform: rotate(360deg);
      }
    }

    .page-item:hover:not(.active) {
      background-color: rgba(30, 136, 229, 0.3);
    }

    /* Badge and labels */
    .badge {
      position: absolute;
      top: 10px;
      right: 10px;
      padding: 5px 10px;
      font-size: 0.8rem;
      font-weight: bold;
      border-radius: 5px;
      z-index: 1;
    }

    .badge-new {
      background-color: var(--orbit-teal);
      color: var(--stardust-white);
    }

    .badge-sale {
      background-color: var(--nova-orange);
      color: var(--stardust-white);
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
      .catalog-container {
        flex-direction: column;
      }

      .filter-sidebar {
        width: 100%;
        margin-right: 0;
        margin-bottom: 20px;
      }

      .filter-options {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
      }

      .filter-section {
        flex: 1;
        min-width: 200px;
      }
    }

    @media (max-width: 768px) {
      .product-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      }

      .catalog-header {
        flex-direction: column;
        gap: 15px;
        align-items: flex-start;
      }

      .sort-controls {
        width: 100%;
        justify-content: space-between;
      }
    }
  </style>
</head>
<body>
  <div class="catalog-container">
    
    <!-- Main Catalog Area -->
    <div class="catalog-content">
      <div class="catalog-header">
        <h1 class="catalog-title">Gaming</h1>
          
      </div>
      
<div class="product-grid">
  <?php foreach ($products as $product): ?>
    <?php if($product['category_id'] == 7): ?>
  <div class="product-card">
    <div class="product-image">
      <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
      <?php if ($product['is_new']): ?>
      <span class="badge badge-new">NEW</span>
      <?php elseif ($product['is_sale']): ?>
      <span class="badge badge-sale">SALE</span>
      <?php endif; ?>
    </div>
    <div class="product-details">
      <div class="product-category"><?= htmlspecialchars($product['category_name']) ?></div>
      <h3 class="product-name"><?= htmlspecialchars($product['name']) ?></h3>
      <div class="product-price">$<?= number_format($product['price'], 2) ?></div>
      <div class="product-actions">
        <form method="post" action"">
       <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>"> 
<?php if(!in_array($product['product_id'], $product_items)) : ?>
        <button type="submit" class="add-to-cart" name="add_to_cart" data-product-id="<?= $product['product_id'] ?>">Add to Cart</button>
<?php else : ?>
        <button class="add-to-cart" disabled data-product-id="<?= $product['product_id'] ?>">Already In Cart</button>
<?php endif ?>
        </form>

          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
            <circle cx="12" cy="12" r="3"></circle>
          </svg>
        </button>
      </div>
    </div>
  </div>
<?php endif; ?>
  <?php endforeach; ?>
</div>
        
      <!-- Pagination -->
      <div class="pagination">
        <div class="page-item">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="15 18 9 12 15 6"></polyline>
          </svg>
        </div>
        <div class="page-item active">1</div>
        <div class="page-item">2</div>
        <div class="page-item">3</div>
        <div class="page-item">4</div>
        <div class="page-item">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="9 18 15 12 9 6"></polyline>
          </svg>
        </div>
      </div>
    </div>
  </div>
</body>
</html>


