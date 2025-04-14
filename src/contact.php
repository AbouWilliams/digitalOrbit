<?php 
include 'includes/header.php' ;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$successMessage = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));
    $order = htmlspecialchars(trim($_POST['order']));

    if (empty($name) || empty($email) || empty($message)) {
        $errorMessage = "Please fill out all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Please enter a valid email address.";
    } else {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';        
            $mail->SMTPAuth = true;
            $mail->Username = 'kynggary15@gmail.com';
            $mail->Password = 'cfen tdrp agyb ttxh';   
            $mail->SMTPSecure = 'tls';             
            $mail->Port = 587;                      

            $mail->setFrom($email, $name);
            $mail->addAddress('kynggary15@gmail.com', 'Gary Bryan');

            $mail->isHTML(true);
            $mail->Subject = "Contact Form: " . ucfirst($subject);
            $mail->Body = "
                <h2>Contact Form Submission</h2>
                <p><strong>Name:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Subject:</strong> $subject</p>
                <p><strong>Message:</strong><br>$message</p>" .
                (!empty($order) ? "<p><strong>Order Number:</strong> $order</p>" : "");

            $mail->send();
            $successMessage = "Thank you! Your message has been sent.";
        } catch (Exception $e) {
            $errorMessage = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
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
    <title>Contact Us - Digital Orbit</title>
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
        }
        
        .container-2 {
            max-width: 1200px;
            margin: 0 auto;
            margin-top: 50px;
            padding: 20px;
        }
        
        .page-title {
            text-align: center;
            margin: 40px 0;
        }
        
        .page-title h1 {
            font-size: 2.5rem;
            color: var(--stardust-white);
            margin-bottom: 10px;
            text-shadow: 0 0 15px var(--celestial-blue);
        }
        
        .cosmic-divider {
            height: 4px;
            background: linear-gradient(90deg, transparent, var(--celestial-blue), var(--orbit-teal), var(--celestial-blue), transparent);
            margin: 30px auto;
            border-radius: 2px;
            width: 80%;
        }
        
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            margin: 60px 0;
        }
        
        @media (max-width: 768px) {
            .contact-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .contact-form-container-2 {
            background: rgba(12, 20, 69, 0.7);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(30, 136, 229, 0.2);
            position: relative;
            overflow: hidden;
        }
        
        .contact-form-container-2::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--cosmic-purple), var(--celestial-blue), var(--orbit-teal));
            z-index: 1;
        }
        
        .contact-form-container-2 h2 {
            color: var(--celestial-blue);
            margin-bottom: 30px;
            font-size: 1.8rem;
            position: relative;
            display: inline-block;
        }
        
        .form-group {
            margin-bottom: 25px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--orbit-teal);
            font-weight: bold;
        }
        
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            background: rgba(55, 71, 79, 0.3);
            border: 1px solid rgba(30, 136, 229, 0.3);
            border-radius: 8px;
            color: var(--stardust-white);
            font-family: inherit;
            transition: all 0.3s;
        }
        
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--celestial-blue);
            box-shadow: 0 0 10px rgba(30, 136, 229, 0.5);
            background: rgba(55, 71, 79, 0.5);
        }
        
        .form-group textarea {
            min-height: 150px;
            resize: vertical;
        }
        
        .btn {
            display: inline-block;
            background: linear-gradient(90deg, var(--cosmic-purple), var(--celestial-blue));
            color: var(--stardust-white);
            padding: 12px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        
        .btn:hover {
            background: linear-gradient(90deg, var(--celestial-blue), var(--orbit-teal));
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(30, 136, 229, 0.4);
        }
        
        .contact-info {
            background: linear-gradient(145deg, rgba(12, 20, 69, 0.8), rgba(61, 26, 124, 0.5));
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .contact-info h2 {
            color: var(--celestial-blue);
            margin-bottom: 30px;
            font-size: 1.8rem;
        }
        
        .contact-method {
            margin-bottom: 30px;
            position: relative;
            padding-left: 45px;
        }
        
        .contact-method:last-child {
            margin-bottom: 0;
        }
        
        .contact-method .icon {
            position: absolute;
            left: 0;
            top: 0;
            font-size: 1.8rem;
            color: var(--nova-orange);
        }
        
        .contact-method h3 {
            color: var(--orbit-teal);
            margin-bottom: 10px;
            font-size: 1.3rem;
        }
        
        .contact-method p {
            color: var(--stardust-white);
            line-height: 1.6;
        }
        
        .contact-method a {
            color: var(--celestial-blue);
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .contact-method a:hover {
            color: var(--orbit-teal);
            text-decoration: underline;
        }
        
        .social-media {
            margin-top: 40px;
        }
        
        .social-media h3 {
            color: var(--orbit-teal);
            margin-bottom: 15px;
            font-size: 1.3rem;
        }
        
        .social-links {
            display: flex;
            gap: 15px;
        }
        
        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(30, 136, 229, 0.2);
            border-radius: 50%;
            color: var(--stardust-white);
            font-size: 1.2rem;
            transition: all 0.3s;
            text-decoration: none;
        }
        
        .social-link:hover {
            background: var(--celestial-blue);
            transform: translateY(-5px);
        }
        
        .map-section {
            margin: 60px 0;
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.5);
            height: 400px;
            border: 3px solid rgba(30, 136, 229, 0.3);
        }
        
        .map-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(12, 20, 69, 0.7), rgba(12, 20, 69, 0.3));
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
        }
        
        .map-message {
            background: rgba(12, 20, 69, 0.8);
            padding: 20px 40px;
            border-radius: 10px;
            text-align: center;
            border: 1px solid var(--celestial-blue);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.5);
        }
        
        .map-message h3 {
            color: var(--orbit-teal);
            margin-bottom: 10px;
        }
        
        .office-locations {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin: 60px 0;
        }
        
        .office-card {
            background: linear-gradient(145deg, rgba(12, 20, 69, 0.8), rgba(55, 71, 79, 0.5));
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(30, 136, 229, 0.1);
            text-align: center;
            transition: transform 0.3s;
        }
        
        .office-card:hover {
            transform: translateY(-10px);
        }
        
        .office-card h3 {
            color: var(--celestial-blue);
            margin-bottom: 15px;
            font-size: 1.5rem;
        }
        
        .office-card .icon {
            font-size: 2.5rem;
            color: var(--nova-orange);
            margin-bottom: 20px;
        }
        
        .office-card address {
            font-style: normal;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .hours-section {
            background: rgba(55, 71, 79, 0.2);
            border-radius: 20px;
            padding: 40px;
            margin: 60px 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .hours-section h2 {
            color: var(--celestial-blue);
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
        }
        
        .hours-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }
        
        .hours-card {
            background: rgba(12, 20, 69, 0.5);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(30, 136, 229, 0.1);
        }
        
        .hours-card h3 {
            color: var(--nova-orange);
            margin-bottom: 15px;
            text-align: center;
            font-size: 1.3rem;
        }
        
        .hours-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .hours-list li {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .hours-list li:last-child {
            border-bottom: none;
        }
        
        .orbit-animation {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: -1;
            opacity: 0.2;
        }
    </style>
</head>
<body>
    <div class="container-2">
        <div class="page-title">
            <h1>Contact Digital Orbit</h1>
            <p>Connect with our mission control team across the digital universe</p>
        </div>
        
        <div class="cosmic-divider"></div>
        
        <div class="contact-grid">
            <div class="contact-form-container-2">
                <h2>Send Us a Message</h2>
                
<?php if (!empty($successMessage)): ?>
    <div class="alert alert-success"><?= $successMessage ?></div>
<?php endif; ?>

<?php if (!empty($errorMessage)): ?>
    <div class="alert alert-danger"><?= $errorMessage ?></div>
<?php endif; ?>

                <form action="" method="post">
                    <div class="form-group">
                        <label for="name">Your Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <select id="subject" name="subject">
                            <option value="general">General Inquiry</option>
                            <option value="support">Technical Support</option>
                            <option value="orders">Order Status</option>
                            <option value="returns">Returns & Refunds</option>
                            <option value="feedback">Product Feedback</option>
                            <option value="business">Business Opportunities</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Your Message</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="order" class="optional">Order Number (if applicable)</label>
                        <input type="text" id="order" name="order">
                    </div>
                    
                    <button type="submit" class="btn">Send Message</button>
                </form>
            </div>
            
            <div class="contact-info">
                <div>
                    <h2>Get in Touch</h2>
                    
                    <div class="contact-method">
                        <span class="icon">✉</span>
                        <h3>Email Us</h3>
                        <p>General Inquiries: <a href="mailto:info@digitalorbit.com">info@digitalorbit.com</a></p>
                        <p>Customer Support: <a href="mailto:support@digitalorbit.com">support@digitalorbit.com</a></p>
                        <p>Business Opportunities: <a href="mailto:business@digitalorbit.com">business@digitalorbit.com</a></p>
                    </div>
                    
                    <div class="contact-method">
                        <span class="icon">☏</span>
                        <h3>Call Us</h3>
                        <p>Toll-Free: <a href="tel:18006724883">1-800-ORBIT-TECH</a></p>
                        <p>International: <a href="tel:+12125557890">+1 (876) 699-6969</a></p>
                        <p>Technical Support: <a href="tel:18008887777">+1 (658) 699-6969</a></p>
                    </div>
                    
                    <div class="contact-method">
                        <span class="icon">⌚</span>
                        <h3>Customer Service Hours</h3>
                        <p>Monday to Friday: 8:00 AM - 8:00 PM EST</p>
                        <p>Saturday: 9:00 AM - 6:00 PM EST</p>
                        <p>Sunday: 10:00 AM - 5:00 PM EST</p>
                    </div>
                </div>
                
                <div class="social-media">
                    <h3>Connect With Us</h3>
                    <div class="social-links">
                        <a href="https://www.facebook.com/profile.php?id=61566936461960" class="social-link">FB</a>
                        <a href="https://www.instagram.com/digital_orbit/" class="social-link">IG</a>
                        <a href="https://www.youtube.com/@DigitalOrbit_do" class="social-link">YT</a>
                        <a href="https://www.linkedin.com/company/digitalorbit1/" class="social-link">LI</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="map-section">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/11/Manchester_in_Jamaica.svg/1200px-Manchester_in_Jamaica.svg.png" alt="Map location of Digital Orbit headquarters" style="width: 100%; height: 100%; object-fit: cover;">
            <div class="map-overlay">
                <div class="map-message">
                    <h3>Visit Our Launch Pad</h3>
                    <p>888 Astro World, Innovation District, Mancehster, JM 94107</p>
                </div>
            </div>
        </div>
        
        <div class="office-locations">
            <div class="office-card">
                <span class="icon">◊</span>
                <h3>Manchester Headquarters</h3>
                <address>
                    1234 Tech Way, Innovation District<br>
                    San Francisco, CA 94107<br>
                    Jamaica
                </address>
                <a href="tel:+14155557890" class="btn">+1 (415) 555-7890</a>
            </div>
            
            <div class="office-card">
                <span class="icon">◊</span>
                <h3>Kingston Office</h3>
                <address>
                    567 Digital Avenue, Tech Plaza<br>
                    Kingston, KG 10022<br>
                    Jamaica
                </address>
                <a href="tel:+12125559876" class="btn">+1 (212) 555-9876</a>
            </div>
            
            <div class="office-card">
                <span class="icon">◊</span>
                <h3>Montego Bay</h3>
                <address>
                    89 Silicon Street, Tech Hub<br>
                    St. James, EC2A 4PU<br>
                    Jamaica
                </address>
                <a href="tel:+442078889999" class="btn">+44 (207) 888-9999</a>
            </div>
        </div>
        
        <div class="hours-section">
            <h2>Operation Hours</h2>
            
            <div class="hours-grid">
                <div class="hours-card">
                    <h3>Customer Service</h3>
                    <ul class="hours-list">
                        <li><span>Monday - Friday</span> <span>8:00 AM - 8:00 PM EST</span></li>
                        <li><span>Saturday</span> <span>9:00 AM - 6:00 PM EST</span></li>
                        <li><span>Sunday</span> <span>10:00 AM - 5:00 PM EST</span></li>
                    </ul>
                </div>
                
                <div class="hours-card">
                    <h3>Technical Support</h3>
                    <ul class="hours-list">
                        <li><span>Monday - Friday</span> <span>24 Hours</span></li>
                        <li><span>Saturday</span> <span>8:00 AM - 10:00 PM EST</span></li>
                        <li><span>Sunday</span> <span>10:00 AM - 8:00 PM EST</span></li>
                    </ul>
                </div>
                
                <div class="hours-card">
                    <h3>Corporate Office</h3>
                    <ul class="hours-list">
                        <li><span>Monday - Friday</span> <span>9:00 AM - 6:00 PM Local</span></li>
                        <li><span>Saturday</span> <span>Closed</span></li>
                        <li><span>Sunday</span> <span>Closed</span></li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="cosmic-divider"></div>
        
        <div style="text-align: center; margin: 40px 0;">
            <h2>We're Here to Help You Navigate the Digital Universe</h2>
            <p>At Digital Orbit, we're committed to providing stellar customer support. Don't hesitate to reach out through any of our communication channels.</p>
            <a href="contact.php" class="btn">Live Chat with an Agent</a>
        </div>
    </div>
</body>
</html>
