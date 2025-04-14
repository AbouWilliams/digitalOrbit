<?php
//session_start();
include 'includes/header.php';
require 'includes/db_connect.php';
if (isset($_SESSION['id'])) {
    header('Location: index.php');
    exit;
}

$fname = '';
$lname = '';
$email = '';
$password = '';
$confirm_password = '';
$country = '';
$interest = '';
$terms = 0;
$newsletter = 0;
$errors = [];

if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email format is invalid";
    }

    $password = $_POST['password'];

    $stmt = $pdo->prepare("select * FROM users where email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    //print_r($user);

    $stmt = $pdo->prepare("select * FROM cart where user_id = :user_id");
    $stmt->execute([':user_id' => $user['id']]);
    $cart = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$cart) {
        $stmt = $pdo->prepare("insert into cart (user_id) values (:user_id)");
        $stmt->execute([':user_id' => $user['id']]);
    }  

    $stmt = $pdo->prepare("select * FROM cart where user_id = :user_id");
    $stmt->execute([':user_id' => $user['id']]);
    $cart = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['fname'] = $user['fname'];
        $_SESSION['lname'] = $user['lname'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['country'] = $user['country'];
        $_SESSION['interest'] = $user['interest'];
        $_SESSION['cart_id'] = $cart['cart_id'];
        setcookie('fname', $fname, time() + (86400 * 30), "/");
        setcookie('lname', $lname, time() + (86400 * 30), "/");
        setcookie('email', $email, time() + (86400 * 30), "/");
        setcookie('interest', $interest, time() + (86400 * 30), "/");
        setcookie('country', $country, time() + (86400 * 30), "/");
        header("Location: index.php");
//print_r($_SESSION);
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'includes/head.php' ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In - Digital Orbit</title>
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
            background-color: var(--deep-space);
            color: var(--stardust-white);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }
        
        .stars {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }
        
        .star {
            position: absolute;
            background-color: var(--stardust-white);
            border-radius: 50%;
            animation: twinkle 5s infinite;
        }
        
        @keyframes twinkle {
            0%, 100% { opacity: 0.2; }
            50% { opacity: 1; }
        }
        
        .orbit {
            position: absolute;
            border: 1px solid rgba(0, 188, 212, 0.3);
            border-radius: 50%;
        }
        
        header {
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(248, 249, 250, 0.1);
        }
        
        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--orbit-teal);
        }
        
        .logo-icon {
            width: 40px;
            height: 40px;
            background-color: var(--orbit-teal);
            border-radius: 50%;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .logo-ring {
            position: absolute;
            width: 70%;
            height: 70%;
            border: 2px solid var(--deep-space);
            border-radius: 50%;
            transform: rotate(45deg);
        }
        
        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }
        
        .login-container {
            background-color: rgba(55, 71, 79, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 2rem;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0 20px rgba(0, 188, 212, 0.3);
            border: 1px solid rgba(0, 188, 212, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .login-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(
                circle at center,
                rgba(30, 136, 229, 0.1) 0%,
                rgba(0, 0, 0, 0) 70%
            );
            z-index: -1;
        }
        
        h1 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: var(--stardust-white);
            font-size: 1.8rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--stardust-white);
            font-weight: 500;
        }
        
        input {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid rgba(0, 188, 212, 0.3);
            border-radius: 6px;
            background-color: rgba(12, 20, 69, 0.6);
            color: var(--stardust-white);
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        input:focus {
            outline: none;
            border-color: var(--orbit-teal);
            box-shadow: 0 0 10px rgba(0, 188, 212, 0.5);
        }
        
        .forgot-password {
            text-align: right;
            margin-bottom: 1.5rem;
        }
        
        .forgot-password a {
            color: var(--orbit-teal);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }
        
        .forgot-password a:hover {
            color: var(--celestial-blue);
            text-decoration: underline;
        }
        
        button {
            width: 100%;
            padding: 0.8rem;
            background-color: var(--celestial-blue);
            color: var(--stardust-white);
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }
        
        button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent
            );
            transition: 0.5s;
        }
        
        button:hover::before {
            left: 100%;
        }
        
        button:hover {
            background-color: var(--orbit-teal);
        }
        
        .register-link {
            text-align: center;
            margin-top: 1.5rem;
            color: var(--stardust-white);
            font-size: 0.9rem;
        }
        
        .register-link a {
            color: var(--orbit-teal);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .register-link a:hover {
            color: var(--celestial-blue);
            text-decoration: underline;
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            color: var(--stardust-white);
            opacity: 0.7;
        }
        
        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background-color: rgba(248, 249, 250, 0.2);
        }
        
        .divider span {
            padding: 0 10px;
            font-size: 0.9rem;
        }
        
        .social-login {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .social-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: rgba(248, 249, 250, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .social-btn:hover {
            background-color: rgba(0, 188, 212, 0.2);
            transform: translateY(-3px);
        }
        
        footer {
            text-align: center;
            padding: 1.5rem;
            color: rgba(248, 249, 250, 0.7);
            position: relative;
            margin-top: auto;
        }
        
        footer::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 50px;
            background: linear-gradient(to top, rgba(12, 20, 69, 0.8), transparent);
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="stars" id="stars"></div>
    
    <header>
        <div class="logo">
            <div class="logo-icon">
                <div class="logo-ring"></div>
            </div>
            Digital Orbit
        </div>
    </header>
    
    <main>
        <div class="login-container">
            <h1>Login</h1>
            <form method="post">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required placeholder="your@email.com" value=<?php
if (isset($_COOKIE['email'])) {
    echo $_COOKIE['email'] ;
}
?> >
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="••••••••">
                </div>
                

                <div class="forgot-password">
                    <a href="https://youareanidiot.cc">Forgot password?</a>
                </div>
                
                <button type="submit" name="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"></path>
                        <polyline points="10 17 15 12 10 7"></polyline>
                        <line x1="15" y1="12" x2="3" y2="12"></line>
                    </svg>
                    Onboard
                </button>
                
                
                <div class="register-link">
                    Don't have an account? <a href="register.php">Sign Up</a>
                </div>
            </form>
        </div>
    </main>
    
    <footer>
        &copy; 2025 Digital Orbit. All rights reserved.
    </footer>
    
    <script>
        // Create animated stars background
        const starsContainer = document.getElementById('stars');
        const starCount = 100;
        
        // Create stars
        for (let i = 0; i < starCount; i++) {
            const star = document.createElement('div');
            star.classList.add('star');
            
            // Random position
            const x = Math.random() * 100;
            const y = Math.random() * 100;
            
            // Random size
            const size = Math.random() * 3;
            
            // Random opacity and animation delay
            const opacity = Math.random() * 0.8 + 0.2;
            const animationDelay = Math.random() * 5;
            
            star.style.left = `${x}%`;
            star.style.top = `${y}%`;
            star.style.width = `${size}px`;
            star.style.height = `${size}px`;
            star.style.opacity = opacity;
            star.style.animationDelay = `${animationDelay}s`;
            
            starsContainer.appendChild(star);
        }
        
        // Create orbital rings
        for (let i = 0; i < 3; i++) {
            const orbit = document.createElement('div');
            orbit.classList.add('orbit');
            
            const size = 200 + (i * 100);
            const top = 50 - (size / 2);
            const left = Math.random() * 40;
            
            orbit.style.width = `${size}px`;
            orbit.style.height = `${size}px`;
            orbit.style.top = `${top}%`;
            orbit.style.left = `${left}%`;
            
            starsContainer.appendChild(orbit);
        }
    </script>
</body>
</html>
