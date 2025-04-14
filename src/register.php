<?php
include 'includes/header.php';
//session_start();
ob_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';
require 'includes/db_connect.php';

$mail = new PHPMailer(true);

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
    $fname = trim($_POST['fname']); 
    $lname = trim($_POST['lname']); 
    $country = trim($_POST['country']); 
    $interest = trim($_POST['interest']); 

    if (isset($_POST['terms'])) {
        $terms = 1;
    } else {
        $terms = 0;
        $errors[] = "You must agree to our terms";
    }

    if (isset($_POST['newsletter'])) {
        $newsletter = 1;
    } else {
        $newsletter = 0;
    }

    $email = trim($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email format is invalid";
    }

    $password = $_POST['password'];
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters";
    }

    $confirm_password = $_POST['confirm-password'];
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }

    $stmt = $pdo->prepare("select id from users where email = :email");
    $stmt->execute([':email' => $email]);
    if ($stmt->fetch()) {
        $errors[] = "Email already exists";
    }

    if (empty($errors)) {
        $hashed_password  = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare(
            "insert into users (fname, lname, email, password, country, interest, terms, newsletter) values" .
            "(:fname, :lname, :email, :password, :country, :interest, :terms, :newsletter)" 
        ); 
        //if ($stmt->execute([$fname, $lname, $email, $password, $country, $interest, $terms, $newsletter])) {
            $results = $stmt->execute([
                ':fname' => $fname,
                ':lname' => $lname,
                ':email' => $email,
                ':password' => $hashed_password,
                ':country' => $country,
                ':interest' => $interest,
                ':terms' => $terms,
                ':newsletter' => $newsletter
            ]);
        /*
        if ($results) {

            $to = $email;
            $subject = 'Welcome to Digital Orbit';
            $message = "Dear $fname, thank you for registering for Digital Orbit";
            $headers = "From: garybryan2021@gmail.com";
            if (mail($to, $subject, $message, $headers)) {
                echo "Email sent successfully.";
            } else {
                $errors[] = "Email sending failed.";
            } 
        } else {
            $errors[] = "Registration failed. Please try again.";
            echo "Failure to load";
            print_r($errors);
        }
         */
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'kynggary15@gmail.com'; // SMTP username
            $mail->Password = 'cfen tdrp agyb ttxh'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('kynggary15@gmail.com', 'Gary Bryan');
            $mail->addAddress($email, $fname . ' ' . $lname);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Welcome To Digital Orbits';
            $mail->Body    = 'This is to congratulate you on joining our powerhouse of a business.';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
        header("location: index.php");
    } else {
            echo "Failure to load";
            print_r($errors);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'includes/head.php' ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Digital Orbit</title>
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
        
        .planet {
            position: absolute;
            border-radius: 50%;
            box-shadow: 0 0 20px rgba(0, 188, 212, 0.5);
            animation: rotate 120s linear infinite;
        }
        
        @keyframes rotate {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
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
        
        .register-container {
            background-color: rgba(55, 71, 79, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 12px;
            padding: 2rem;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 0 20px rgba(0, 188, 212, 0.3);
            border: 1px solid rgba(0, 188, 212, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .register-container::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(
                circle at center,
                rgba(255, 109, 0, 0.1) 0%,
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
        
        form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        .form-group.full {
            grid-column: span 2;
        }
        
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--stardust-white);
            font-weight: 500;
        }
        
        input, select {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid rgba(0, 188, 212, 0.3);
            border-radius: 6px;
            background-color: rgba(12, 20, 69, 0.6);
            color: var(--stardust-white);
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        input:focus, select:focus {
            outline: none;
            border-color: var(--orbit-teal);
            box-shadow: 0 0 10px rgba(0, 188, 212, 0.5);
        }
        
        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23F8F9FA' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1em;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 1.5rem 0;
            grid-column: span 2;
        }
        
        .checkbox-group input {
            width: auto;
        }
        
        button {
            padding: 0.8rem;
            background-color: var(--nova-orange);
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
            grid-column: span 2;
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
        
        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            color: var(--stardust-white);
            font-size: 0.9rem;
            grid-column: span 2;
        }
        
        .login-link a {
            color: var(--orbit-teal);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }
        
        .login-link a:hover {
            color: var(--celestial-blue);
            text-decoration: underline;
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            color: var(--stardust-white);
            opacity: 0.7;
            grid-column: span 2;
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
        
        .social-signup {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
            grid-column: span 2;
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
            background-color: rgba(255, 109, 0, 0.2);
            transform: translateY(-3px);
        }
        
        .feature-list {
            margin-top: 1.5rem;
            padding: 1rem;
            background-color: rgba(30, 136, 229, 0.1);
            border-radius: 8px;
            grid-column: span 2;
        }
        
        .feature-list h3 {
            font-size: 1rem;
            margin-bottom: 0.8rem;
            color: var(--stardust-white);
        }
        
        .feature-list ul {
            list-style: none;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.8rem;
        }
        
        .feature-list li {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }
        
        .feature-list li svg {
            color: var(--orbit-teal);
            flex-shrink: 0;
        }
        
        .password-strength {
            height: 4px;
            width: 100%;
            background-color: rgba(248, 249, 250, 0.1);
            border-radius: 2px;
            margin-top: 0.5rem;
            overflow: hidden;
            grid-column: span 2;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0;
            transition: width 0.3s ease, background-color 0.3s ease;
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
        
        @media (max-width: 600px) {
            form {
                grid-template-columns: 1fr;
            }
            
            .form-group.full,
            .feature-list,
            .feature-list ul,
            .checkbox-group,
            button,
            .login-link {
                grid-column: span 1;
            }
            
            .feature-list ul {
                grid-template-columns: 1fr;
            }
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
        <div class="register-container">
            <h1>Register</h1>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="fname">First Name</label>
                    <input type="text" id="fname" name="fname" required placeholder="John">
                </div>
                
                <div class="form-group">
                    <label for="lname">Last Name</label>
                    <input type="text" id="lname" name="lname" required placeholder="Doe">
                </div>
                
                <div class="form-group full">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required placeholder="your@email.com">
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="••••••••">
                </div>
                
                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <input type="password" id="confirm-password" name="confirm-password" required placeholder="••••••••">
                </div>
                
                <div class="form-group full">
                    <div class="password-strength">
                        <div class="password-strength-bar" id="password-bar"></div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="country">Country (Supported)</label>
                    <select id="country" name="country" required>
                        <option value="" selected disabled>Select your country</option>
                        <option value="jm">Jamaica</option>
                        <option value="sm">Saint Martin</option>
                        <option value="tt">Trinidad</option>
                        <option value="oo">Ohio (A whole other planet bruv)</option>
                        <option value="us">United States</option>
                        <option value="ca">Canada</option>
                        <option value="uk">United Kingdom</option>
                        <option value="au">Australia</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="interest">Main Interest</label>
                    <select id="interest" name="interest">
                        <option value="" selected disabled>What are you into?</option>
                        <option value="laptops">Laptops & Computers</option>
                        <option value="phones">Smartphones & Tablets</option>
                        <option value="accessories">Tech Accessories</option>
                        <option value="gadgets">Smart Gadgets</option>
                        <option value="parts">Computer Parts</option>
                    </select>
                </div>
                
                <div class="checkbox-group">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">I agree to the <a href="#" style="color: var(--orbit-teal);">Terms of Service</a> and <a href="#" style="color: var(--orbit-teal);">Privacy Policy</a></label>
                </div>
                
                <div class="checkbox-group">
                    <input type="checkbox" id="newsletter" name="newsletter">
                    <label for="newsletter">Sign me up for the newsletter to receive updates about new products and exclusive offers</label>
                </div>
                
                <button type="submit" name="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
                    </svg>
                    Launch Your Account
                </button>
                
                <div class="feature-list">
                    <h3>Join Digital Orbit and get:</h3>
                    <ul>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            Fast shipping on all orders
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            Exclusive member deals
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            Early access to new products
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                            Tech support & advice
                        </li>
                    </ul>
                </div>
                
                <div class="login-link">
                    Already have an account? <a href="login.php">Log In</a>
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
        
        // Create planets
        const planet = document.createElement('div');
        planet.classList.add('planet');
        planet.style.width = '100px';
        planet.style.height = '100px';
        planet.style.bottom = '-20px';
        planet.style.right = '-20px';
        planet.style.background = 'radial-gradient(circle at 30% 30%, var(--nova-orange), var(--cosmic-purple))';
        starsContainer.appendChild(planet);
        
        // Password strength indicator
        const passwordInput = document.getElementById('password');
        const passwordBar = document.getElementById('password-bar');
        
        passwordInput.addEventListener('input', function() {
            const value = this.value;
            let strength = 0;
            
            if (value.length > 6) strength += 20;
            if (value.length > 10) strength += 20;
            if (/[A-Z]/.test(value)) strength += 20;
            if (/[0-9]/.test(value)) strength += 20;
            if (/[^A-Za-z0-9]/.test(value)) strength += 20;
            
            passwordBar.style.width = `${strength}%`;
            
            if (strength <= 40) {
                passwordBar.style.backgroundColor = '#FF5252';
            } else if (strength <= 80) {
                passwordBar.style.backgroundColor = '#FFC107';
            } else {
                passwordBar.style.backgroundColor = '#4CAF50';
            }
        });
    </script>
</body>
</html>
