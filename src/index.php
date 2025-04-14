<?php
session_start();
ob_start();
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

//echo "login" . $is_login;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital Orbit | Explore the Universe of Tech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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
        
        @keyframes twinkling {
            0% { opacity: 0.3; }
            50% { opacity: 1; }
            100% { opacity: 0.3; }
        }
        
        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }
        
        @keyframes orbit {
            0% { transform: rotate(0deg) translateX(10px) rotate(0deg); }
            100% { transform: rotate(360deg) translateX(10px) rotate(-360deg); }
        }
        
        @keyframes shooting-star {
            0% { 
                transform: translateX(-100px) translateY(50px);
                opacity: 1;
            }
            70% {
                opacity: 1;
            }
            100% { 
                transform: translateX(calc(100vw + 100px)) translateY(-100px);
                opacity: 0;
            }
        }
        
        body {
            font-family: 'Exo 2', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--deep-space);
            color: var(--stardust-white);
            overflow-x: hidden;
        }
        
        /* Star background */
        .stars {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background-image: 
                radial-gradient(2px 2px at 20px 30px, #ffffff, rgba(0,0,0,0)),
                radial-gradient(2px 2px at 40px 70px, #ffffff, rgba(0,0,0,0)),
                radial-gradient(1px 1px at 90px 40px, #ffffff, rgba(0,0,0,0)),
                radial-gradient(2px 2px at 160px 120px, #ffffff, rgba(0,0,0,0)),
                radial-gradient(1px 1px at 230px 50px, #ffffff, rgba(0,0,0,0));
            background-repeat: repeat;
            background-size: 250px 250px;
        }
        
        .twinkling-star {
            position: absolute;
            width: 3px;
            height: 3px;
            background-color: white;
            border-radius: 50%;
            animation: twinkling 3s infinite ease-in-out;
        }
        
        .shooting-star {
            position: absolute;
            width: 100px;
            height: 2px;
            background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 50%, rgba(255,255,255,0) 100%);
            animation: shooting-star 8s linear infinite;
            animation-delay: calc(var(--delay) * 1s);
            top: calc(var(--top) * 1vh);
            opacity: 0;
        }
        
        /* Navbar */
        .navbar {
            background: linear-gradient(to right, var(--cosmic-purple), var(--deep-space));
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 0.8rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.6rem;
            display: flex;
            align-items: center;
            position: relative;
        }
        
        .navbar-brand .planet {
            display: inline-block;
            width: 30px;
            height: 30px;
            background: radial-gradient(circle at 30% 30%, var(--celestial-blue), var(--deep-space));
            border-radius: 50%;
            margin-right: 8px;
            position: relative;
        }
        
        .navbar-brand .ring {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-20deg);
            width: 40px;
            height: 40px;
            border: 2px solid rgba(255, 255, 255, 0.4);
            border-radius: 50%;
            border-top-color: transparent;
            border-bottom-color: transparent;
        }
        
        .navbar-brand span {
            background: linear-gradient(to right, var(--orbit-teal), var(--celestial-blue));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .nav-link {
            color: var(--stardust-white) !important;
            margin: 0 0.3rem;
            padding: 0.5rem 1rem !important;
            position: relative;
            border-radius: 4px;
            transition: all 0.3s ease;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--orbit-teal);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }
        
        .nav-link:hover {
            color: var(--orbit-teal) !important;
        }
        
        .nav-link:hover::after, 
        .nav-link.active::after {
            width: 70%;
        }
        
        .nav-link.active {
            color: var(--orbit-teal) !important;
            background: rgba(0, 188, 212, 0.1);
        }
        
        .cart-icon {
            position: relative;
        }
        
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--nova-orange);
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        /* Hero Section */
        .hero-section {
            min-height: 80vh;
            display: flex;
            align-items: center;
            padding: 8rem 0 4rem;
            position: relative;
            overflow: hidden;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-title {
            font-weight: 700;
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(to right, var(--stardust-white), var(--orbit-teal));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            line-height: 1.2;
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.9);
        }
        
        .hero-image {
            position: relative;
            animation: floating 6s infinite ease-in-out;
        }
        
        .hero-image img {
            border: 4px solid rgba(30, 136, 229, 0.3);
            border-radius: 20px;
            box-shadow: 0 0 30px rgba(30, 136, 229, 0.5);
        }
        
        .space-btn {
            background: linear-gradient(to right, var(--celestial-blue), var(--orbit-teal));
            border: none;
            padding: 0.8rem 2rem;
            font-weight: 600;
            border-radius: 50px;
            position: relative;
            overflow: hidden;
            z-index: 1;
            transition: all 0.4s ease;
            color: white;
            font-size: 1.1rem;
        }
        
        .space-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 0%;
            height: 100%;
            background: linear-gradient(to right, var(--nova-orange), var(--cosmic-purple));
            transition: all 0.4s ease;
            z-index: -1;
        }
        
        .space-btn:hover::before {
            width: 100%;
        }
        
        .space-btn:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 188, 212, 0.4);
        }
        
        /* Category Section */
        .categories-section {
            padding: 6rem 0;
            position: relative;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
            font-weight: 700;
        }
        
        .section-title h2 {
            color: var(--stardust-white);
            margin-bottom: 0.5rem;
            font-size: 2.5rem;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(to right, var(--orbit-teal), var(--celestial-blue));
        }
        
        .planet-category {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            position: relative;
            margin-bottom: 2rem;
        }
        
        .planet-orbit {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, var(--category-color), var(--deep-space));
            box-shadow: 0 0 20px rgba(var(--category-glow), 0.5);
            position: relative;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .planet-orbit::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-25deg);
            width: 180px;
            height: 180px;
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            border-top-color: transparent;
            border-bottom-color: transparent;
        }
        
        .planet-orbit::after {
            content: '';
            position: absolute;
            width: 15px;
            height: 15px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            top: 20px;
            right: 30px;
            box-shadow: 0 0 10px white;
        }
        
        .planet-category:hover .planet-orbit {
            transform: scale(1.05);
            box-shadow: 0 0 30px rgba(var(--category-glow), 0.8);
        }
        
        .planet-name {
            font-weight: 600;
            font-size: 1.2rem;
            color: var(--stardust-white);
            transition: all 0.3s ease;
        }
        
        .planet-category:hover .planet-name {
            color: var(--category-color);
        }
        
        /* Featured Products */
        .featured-section {
            padding: 6rem 0;
            background: linear-gradient(to bottom, var(--deep-space), var(--cosmic-purple), var(--deep-space));
            position: relative;
        }
        
        .product-card {
            background: rgba(12, 20, 69, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            position: relative;
            transition: all 0.4s ease;
            backdrop-filter: blur(10px);
            height: 100%;
        }
        
        .product-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to bottom right, rgba(30, 136, 229, 0.1), rgba(0, 188, 212, 0.1));
            z-index: -1;
            border-radius: 15px;
        }
        
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.3);
            border-color: var(--orbit-teal);
        }
        
        .product-image {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }
        
        .product-image img {
            transition: all 0.4s ease;
            border-radius: 10px;
        }
        
        .product-card:hover .product-image img {
            transform: scale(1.05);
        }
        
        .product-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: var(--nova-orange);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: 600;
        }
        
        .product-title {
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            color: var(--stardust-white);
        }
        
        .product-price {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--orbit-teal);
            margin-bottom: 1rem;
        }
        
        .product-rating {
            margin-bottom: 1rem;
            color: var(--nova-orange);
        }
        
        .product-btn {
            background: transparent;
            border: 2px solid var(--orbit-teal);
            color: var(--orbit-teal);
            padding: 0.5rem 1.5rem;
            border-radius: 30px;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 0.5rem;
        }
        
        .product-btn:hover {
            background: var(--orbit-teal);
            color: white;
        }
        
        /* Promo Section */
        .promo-section {
            padding: 6rem 0;
            position: relative;
        }
        
        .promo-card {
            background: linear-gradient(135deg, var(--cosmic-purple), var(--deep-space));
            border-radius: 15px;
            padding: 3rem;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .promo-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100' height='100' viewBox='0 0 100 100'%3E%3Cg fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath opacity='.5' d='M96 95h4v1h-4v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4h-9v4h-1v-4H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15v-9H0v-1h15V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h9V0h1v15h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9h4v1h-4v9zm-1 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm9-10v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-10 0v-9h-9v9h9zm-9-10h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9zm10 0h9v-9h-9v9z'/%3E%3Cpath d='M6 5V0H5v5H0v1h5v94h1V6h94V5H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        
        .promo-content {
            position: relative;
            z-index: 2;
        }
        
        .promo-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: white;
        }
        
        .promo-text {
            font-size: 1.1rem;
            margin-bottom: 2rem;
            color: rgba(255, 255, 255, 0.9);
        }
        
        .countdown {
            display: flex;
            margin-bottom: 2rem;
        }
        
        .countdown-item {
            background: rgba(0, 0, 0, 0.3);
            padding: 1rem;
            border-radius: 8px;
            margin-right: 1rem;
            min-width: 80px;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .countdown-number {
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
        }
        
        .countdown-label {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
        }
        
        /* Newsletter Section */
        .newsletter-section {
            padding: 6rem 0;
            background: var(--asteroid-gray);
            position: relative;
        }
        
        .newsletter-container {
            background: rgba(12, 20, 69, 0.8);
            border-radius: 15px;
            padding: 3rem;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .newsletter-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath fill-rule='evenodd' d='M0 0h40v40H0V0zm40 40h40v40H40V40zm0-40h2l-2 2V0zm0 4l4-4h2l-6 6V4zm0 4l8-8h2L40 10V8zm0 4L52 0h2L40 14v-2zm0 4L56 0h2L40 18v-2zm0 4L60 0h2L40 22v-2zm0 4L64 0h2L40 26v-2zm0 4L68 0h2L40 30v-2zm0 4L72 0h2L40 34v-2zm0 4L76 0h2L40 38v-2zm0 4L80 0v2L42 40h-2zm4 0L80 4v2L46 40h-2zm4 0L80 8v2L50 40h-2zm4 0l28-28v2L54 40h-2zm4 0l24-24v2L58 40h-2zm4 0l20-20v2L62 40h-2zm4 0l16-16v2L66 40h-2zm4 0l12-12v2L70 40h-2zm4 0l8-8v2l-6 6h-2zm4 0l4-4v2l-2 2h-2z'/%3E%3C/g%3E%3C/svg%3E") center center;
        }
        
        .newsletter-title {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 1rem;
        }
        
        .newsletter-text {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 2rem;
        }
        
        .newsletter-form .form-control {
            height: 50px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 50px;
            padding: 0 1.5rem;
        }
        
        .newsletter-form .form-control:focus {
            box-shadow: none;
            border-color: var(--orbit-teal);
            background: rgba(255, 255, 255, 0.15);
        }
        
        .newsletter-form .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        
        .newsletter-btn {
            height: 50px;
            border-radius: 50px;
            padding: 0 2rem;
            background: var(--nova-orange);
            border: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .newsletter-btn:hover {
            background: var(--orbit-teal);
            transform: translateY(-2px);
        }
        
        /* Footer */
        footer {
            background: var(--deep-space);
            padding: 5rem 0 2rem;
            position: relative;
        }
        
        .footer-planet {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 60px;
            background: linear-gradient(to top, var(--cosmic-purple), transparent);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .footer-logo {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .footer-logo .planet {
            width: 20px;
            height: 20px;
            background: radial-gradient(circle at 30% 30%, var(--celestial-blue), var(--deep-space));
            border-radius: 50%;
            margin-right: 8px;
            position: relative;
        }
        
        .footer-logo .text {
            font-weight: 700;
            font-size: 1.4rem;
            background: linear-gradient(to right, var(--orbit-teal), var(--celestial-blue));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        
        .footer-text {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 1.5rem;
            line-height: 1.7;
        }
        
        .footer-social {
            display: flex;
            margin-bottom: 2rem;
        }
        
        .social-icon {
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 0.75rem;
            transition: all 0.3s ease;
        }
        
        .social-icon:hover {
            background: var(--orbit-teal);
            transform: translateY(-3px);
        }
        
        .footer-title {
            color: white;
            font-weight: 600;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.75rem;
        }
        
        .footer-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background: var(--orbit-teal);
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .footer-links li {
            margin-bottom: 0.75rem;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }
        
        .footer-links a:hover {
            color: var(--orbit-teal);
            transform: translateX(5px);
        }
        
        .footer-contact {
            margin-bottom: 1rem;
            display: flex;
            align-items: flex-start;
        }
        
        .footer-contact i {
            color: var(--orbit-teal);
            margin-right: 1rem;
            font-size: 1.1rem;
        }
        
        .footer-contact p {
            color: rgba(255, 255, 255, 0.7);
            margin: 0;
        }
        
        .copyright {
            margin-top: 4rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-image {
                margin-top: 3rem;
                transform: scale(0.9);
            }
            
            .promo-card {
                padding: 2rem;
            }
            
            .countdown-item {
                min-width: 65px;
                padding: 0.75rem;
            }
            
            .countdown-number {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    
<?php include 'includes/header.php' ?>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 hero-content">
                    <h1 class="hero-title">Explore the Universe of Tech</h1>
                    <p class="hero-subtitle">Navigate through our vast galaxy of cutting-edge electronics, smart devices, and innovative gadgets. Your next technological adventure awaits.</p>
                    <div class="d-flex flex-wrap">
                        <a href="catalogue.php" class="space-btn">Begin Exploration</a>
                        <a href="about.php" class="btn btn-outline mt-3 mt-md-0">Mission Brief</a>
                    </div>
                </div>
                <div class="col-lg-6 hero-image">
                    <img src="img/futuristic.png" alt="Futuristic tech devices" class="img-fluid">
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories-section">
        <div class="container">
            <div class="section-title">
                <h2>Tech Galaxy Sectors</h2>
                <p class="text">Navigate through our specialized tech categories</p>
            </div>
            
            <div class="row">
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="planet-category" onclick="window.location.href='categories/phones.php'">
                        <div class="planet-orbit" style="--category-color: var(--celestial-blue); --category-glow: 30, 136, 229;"></div>
                        <h3 class="planet-name">Smartphones</h3>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="planet-category" onclick="window.location.href='categories/laptops.php'">
                        <div class="planet-orbit" style="--category-color: var(--nova-orange); --category-glow: 255, 109, 0;"></div>
                        <h3 class="planet-name">Laptops</h3>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="planet-category" onclick="window.location.href='categories/gadgets.php'">
                        <div class="planet-orbit" style="--category-color: var(--orbit-teal); --category-glow: 0, 188, 212;"></div>
                        <h3 class="planet-name">Smart Home</h3>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="planet-category" onclick="window.location.href='categories/audio.php'">
                        <div class="planet-orbit" style="--category-color: #9C27B0; --category-glow: 156, 39, 176;"></div>
                        <h3 class="planet-name">Audio</h3>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="planet-category" onclick="window.location.href='categories/wearables.php'">
                        <div class="planet-orbit" style="--category-color: #4CAF50; --category-glow: 76, 175, 80;"></div>
                        <h3 class="planet-name">Wearables</h3>
                    </div>
                </div>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="planet-category" onclick="window.location.href='categories/gaming.php'">
                        <div class="planet-orbit" style="--category-color: #F44336; --category-glow: 244, 67, 54;"></div>
                        <h3 class="planet-name">Gaming</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="featured-section">
        <div class="container">
            <div class="section-title">
                <h2>Featured Tech Discoveries</h2>
                <p class="text">Benefits of Using Our Technology</p>
            </div>
            
            <div class="row">
                <div class="col-md-6 col-lg-3">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="https://imageio.forbes.com/specials-images/dam/imageserve/1114941377/960x0.jpg?height=385&width=711&fit=bounds" alt="Product 1" class="img-fluid">
                        </div>
                        <h3 class="product-title">Improved Innovativeness</h3>
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span class="ms-2 text-muted">(42)</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="https://www.educationalneuroscience.org.uk/wordpress/wp-content/uploads/2017/03/intelligence_image.jpg" alt="Product 2" class="img-fluid">
                        </div>
                        <h3 class="product-title">Improved Intelligence</h3>
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <span class="ms-2 text-muted">(87)</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="https://centralexchange.org/wp-content/uploads/2020/03/friends_friends.png" alt="Product 3" class="img-fluid">
                        </div>
                        <h3 class="product-title">More Friends Gained</h3>
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="far fa-star"></i>
                            <span class="ms-2 text-muted">(34)</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="product-card">
                        <div class="product-image">
                            <img src="https://media.istockphoto.com/id/1151779376/photo/kid-is-measuring-the-growth.jpg?s=612x612&w=0&k=20&c=4jxyxBPJ4e5psjyunTmqNFq9n-MkSbLfCcOvbT78pj8=" alt="Product 4" class="img-fluid">
                        </div>
                        <h3 class="product-title">More Height</h3>
                        <div class="product-rating">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                            <span class="ms-2 text-muted">(56)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Promo Section -->
    <section class="promo-section">
        <div class="container">
            <div class="promo-card">
                <div class="row align-items-center">
                    <div class="col-lg-7 promo-content">
                        <h2 class="promo-title">Cosmic Tech Sale</h2>
                        <p class="promo-text">Limited time offer on our most advanced devices. Hurry before they vanish into another dimension!</p>
                        <div class="countdown">
                            <div class="countdown-item">
                                <div class="countdown-number">02</div>
                                <div class="countdown-label">Days</div>
                            </div>
                            <div class="countdown-item">
                                <div class="countdown-number">18</div>
                                <div class="countdown-label">Hours</div>
                            </div>
                            <div class="countdown-item">
                                <div class="countdown-number">45</div>
                                <div class="countdown-label">Minutes</div>
                            </div>
                            <div class="countdown-item">
                                <div class="countdown-number">22</div>
                                <div class="countdown-label">Seconds</div>
                            </div>
                        </div>
                        <a href="catalogue.php" class="space-btn">Shop Now</a>
                    </div>
                    <div class="col-lg-5 d-none d-lg-block">
                        <img src="https://www.transparentpng.com/thumb/special-offer/special-offer-tag-png-pictures-4.png" alt="Special offer" class="img-fluid rounded">
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Newsletter Section -->
    <section class="newsletter-section">
        <div class="container">
            <div class="newsletter-container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <h2 class="newsletter-title">Join Our Space Program</h2>
                        <p class="newsletter-text">Subscribe to our newsletter for exclusive deals, tech news, and special offers from across the universe.</p>
                    </div>
                    <div class="col-lg-6">
                        <form class="newsletter-form">
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="Your email address">
                                <button class="btn newsletter-btn" type="submit">Subscribe</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="footer-logo">
                        <div class="planet"></div>
                        <div class="text">Digital Orbit</div>
                    </div>
                    <p class="footer-text">Your premier hub for online advertising, cloud services, and e-commerce solutions. Navigate through our vast galaxy of cutting-edge technology.</p>
                    <div class="footer-social">
                        <a href="https://www.facebook.com/profile.php?id=61566936461960" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://www.youtube.com/@DigitalOrbit_do" class="social-icon"><i class="fab fa-youtube"></i></a>
                        <a href="https://www.instagram.com/digital_orbit/" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="https://www.linkedin.com/company/digitalorbit1/" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-md-4 col-lg-2 mb-4 mb-md-0">
                    <h5 class="footer-title">Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="catalogue.php">Shop</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="faq.php">FAQ</a></li>
                        <li><a href="contact.php">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4 col-lg-2 mb-4 mb-md-0">
                    <h5 class="footer-title">Categories</h5>
                    <ul class="footer-links">
                        <li><a href="categories/phones.php">Smartphones</a></li>
                        <li><a href="categories/laptops.php">Laptops</a></li>
                        <li><a href="categories/gadgets.php">Smart Home</a></li>
                        <li><a href="categories/audio.php">Audio</a></li>
                        <li><a href="#">Wearables</a></li>
                    </ul>
                </div>
                <div class="col-md-4 col-lg-4">
                    <h5 class="footer-title">Contact Info</h5>
                    <div class="footer-contact">
                        <i class="fas fa-map-marker-alt"></i>
                        <p>123 Tech Street, Digital City, Planet Earth</p>
                    </div>
                    <div class="footer-contact">
                        <i class="fas fa-phone-alt"></i>
                        <p>+1 (876) 699-6969</p>
                    </div>
                    <div class="footer-contact">
                        <i class="fas fa-envelope"></i>
                        <p>info@digitalorbit.com</p>
                    </div>
                </div>
            </div>
            <div class="copyright">
                <p>&copy; 2025 Digital Orbit. All rights reserved. | Navigating the digital frontier since 2020</p>
            </div>
        </div>
        <div class="footer-planet"></div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add random twinkling stars
        document.addEventListener('DOMContentLoaded', function() {
            // Create random stars
            for (let i = 0; i < 20; i++) {
                const star = document.createElement('div');
                star.classList.add('twinkling-star');
                star.style.top = Math.random() * 100 + '%';
                star.style.left = Math.random() * 100 + '%';
                star.style.animationDelay = (Math.random() * 3) + 's';
                document.body.appendChild(star);
            }
            
            // Animate shooting stars
            const shootingStars = document.querySelectorAll('.shooting-star');
            shootingStars.forEach(star => {
                setInterval(() => {
                    star.style.opacity = '1';
                    setTimeout(() => {
                        star.style.opacity = '0';
                    }, 2000);
                }, parseInt(star.style.getPropertyValue('--delay')) * 1000);
            });
            
            // Initialize countdown timer
            const countdownTimer = () => {
                const days = document.querySelector('.countdown-item:nth-child(1) .countdown-number');
                const hours = document.querySelector('.countdown-item:nth-child(2) .countdown-number');
                const minutes = document.querySelector('.countdown-item:nth-child(3) .countdown-number');
                const seconds = document.querySelector('.countdown-item:nth-child(4) .countdown-number');
                
                let daysVal = parseInt(days.textContent);
                let hoursVal = parseInt(hours.textContent);
                let minutesVal = parseInt(minutes.textContent);
                let secondsVal = parseInt(seconds.textContent);
                
                setInterval(() => {
                    secondsVal--;
                    
                    if (secondsVal < 0) {
                        secondsVal = 59;
                        minutesVal--;
                        
                        if (minutesVal < 0) {
                            minutesVal = 59;
                            hoursVal--;
                            
                            if (hoursVal < 0) {
                                hoursVal = 23;
                                daysVal--;
                                
                                if (daysVal < 0) {
                                    daysVal = 0;
                                    hoursVal = 0;
                                    minutesVal = 0;
                                    secondsVal = 0;
                                }
                            }
                        }
                    }
                    
                    days.textContent = daysVal.toString().padStart(2, '0');
                    hours.textContent = hoursVal.toString().padStart(2, '0');
                    minutes.textContent = minutesVal.toString().padStart(2, '0');
                    seconds.textContent = secondsVal.toString().padStart(2, '0');
                }, 1000);
            };
            
            countdownTimer();
        });
    </script>
</body>
</html>

