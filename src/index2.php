<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Digital Orbit | Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body {
        background-color: #F5F5F5;
    }

    .bg-primary-dark {
        background-color: #0A2342 !important;
    }

    .text-sky {
        color: #1CA9C9;
    }
    </style>
</head>

<body>
    <header class="bg-primary-dark text-white text-center py-4">
        <h1>Welcome to Digital Orbit</h1>
        <p>Your hub for online advertising, cloud services, and e-commerce</p>
    </header>

    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #1CA9C9;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Digital Orbit</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="faq.php">FAQ</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="catalogue.php">Catalogue</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container my-5 text-center">
        <h2 class="text-sky mb-4">Explore Our Store</h2>
        <p>From cutting-edge electronics to top-selling fitness gadgets, shop confidently with Digital Orbit.</p>
        <a href="catalogue.php" class="btn btn-dark mt-3">Browse Catalogue</a>
    </main>

    <footer class="bg-primary-dark text-white text-center py-3">
        <p>&copy; 2025 Digital Orbit. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>