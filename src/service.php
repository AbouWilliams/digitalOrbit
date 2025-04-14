<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Service - Digital Orbit</title>
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
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
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
        
        .service-modules {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin: 40px 0;
        }
        
        .service-card {
            background: linear-gradient(145deg, rgba(30, 136, 229, 0.1), rgba(61, 26, 124, 0.2));
            border-radius: 15px;
            padding: 25px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
            overflow: hidden;
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 188, 212, 0.3);
        }
        
        .service-card::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(0, 188, 212, 0.1), transparent 70%);
            opacity: 0;
            transition: opacity 0.5s;
            pointer-events: none;
        }
        
        .service-card:hover::before {
            opacity: 1;
        }
        
        .service-card h3 {
            color: var(--orbit-teal);
            font-size: 1.5rem;
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }
        
        .service-card h3::after {
            content: '';
            position: absolute;
            width: 70%;
            height: 3px;
            bottom: -5px;
            left: 0;
            background: linear-gradient(90deg, var(--orbit-teal), transparent);
            border-radius: 2px;
        }
        
        .service-card p {
            color: var(--stardust-white);
            line-height: 1.6;
        }
        
        .service-card .icon {
            color: var(--nova-orange);
            font-size: 2rem;
            margin-bottom: 15px;
        }
        
        .faq-section {
            background: rgba(12, 20, 69, 0.7);
            border-radius: 20px;
            padding: 40px;
            margin: 60px 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(30, 136, 229, 0.2);
        }
        
        .faq-section h2 {
            color: var(--celestial-blue);
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
        }
        
        .faq-item {
            margin-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 20px;
        }
        
        .faq-question {
            color: var(--nova-orange);
            font-weight: bold;
            font-size: 1.2rem;
            margin-bottom: 10px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .faq-question:hover {
            color: var(--orbit-teal);
        }
        
        .faq-answer {
            color: var(--stardust-white);
            line-height: 1.6;
            padding-left: 20px;
            border-left: 3px solid var(--cosmic-purple);
            margin-top: 10px;
        }
        
        .support-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin: 50px 0;
        }
        
        .support-option {
            text-align: center;
            padding: 30px;
            background: linear-gradient(145deg, rgba(12, 20, 69, 0.8), rgba(55, 71, 79, 0.5));
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(30, 136, 229, 0.1);
        }
        
        .support-option:hover {
            transform: scale(1.05);
        }
        
        .support-option::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--cosmic-purple), var(--celestial-blue), var(--orbit-teal));
            opacity: 0;
            transition: opacity 0.3s;
        }
        
        .support-option:hover::after {
            opacity: 1;
        }
        
        .support-option h3 {
            color: var(--celestial-blue);
            margin-bottom: 15px;
            font-size: 1.5rem;
        }

        .support-option .icon {
            font-size: 3rem;
            color: var(--orbit-teal);
            margin-bottom: 20px;
            display: block;
        }
        
        .btn {
            display: inline-block;
            background: linear-gradient(90deg, var(--cosmic-purple), var(--celestial-blue));
            color: var(--stardust-white);
            padding: 12px 25px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            margin-top: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        
        .btn:hover {
            background: linear-gradient(90deg, var(--celestial-blue), var(--orbit-teal));
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(30, 136, 229, 0.4);
        }
        
        .returns-policy {
            background: rgba(55, 71, 79, 0.2);
            padding: 40px;
            border-radius: 20px;
            margin: 60px 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .returns-policy h2 {
            color: var(--celestial-blue);
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
        }
        
        .returns-policy p {
            margin-bottom: 20px;
            line-height: 1.7;
        }
        
        .returns-policy ul {
            padding-left: 20px;
            margin-bottom: 20px;
        }
        
        .returns-policy li {
            margin-bottom: 10px;
            position: relative;
            list-style-type: none;
            padding-left: 25px;
        }
        
        .returns-policy li::before {
            content: '✦';
            position: absolute;
            left: 0;
            color: var(--nova-orange);
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
    <div class="container">
        <div class="page-title">
            <h1>Customer Service Center</h1>
            <p>Your mission control for support and assistance across the digital universe</p>
        </div>
        
        <div class="cosmic-divider"></div>
        
        <div class="service-modules">
            <div class="service-card">
                <div class="icon">✦</div>
                <h3>Order Tracking</h3>
                <p>Monitor your shipment's journey across the digital galaxy with our real-time tracking system.</p>
                <a href="#" class="btn">Track Order</a>
            </div>
            
            <div class="service-card">
                <div class="icon">✦</div>
                <h3>Returns & Refunds</h3>
                <p>Simplified return process with our 30-day satisfaction guarantee on eligible products.</p>
                <a href="#" class="btn">Start Return</a>
            </div>
            
            <div class="service-card">
                <div class="icon">✦</div>
                <h3>Technical Support</h3>
                <p>Get expert assistance with product setup, troubleshooting, and technical issues.</p>
                <a href="#" class="btn">Get Help</a>
            </div>
        </div>
        
        <div class="support-options">
            <div class="support-option">
                <span class="icon">☎</span>
                <h3>Live Chat</h3>
                <p>Connect instantly with our support team through our cosmic communication channel.</p>
                <p>Available: 24/7</p>
                <a href="#" class="btn">Start Chat</a>
            </div>
            
            <div class="support-option">
                <span class="icon">✉</span>
                <h3>Email Support</h3>
                <p>Send your queries through the digital cosmos and receive a response within 24 hours.</p>
                <p>support@digitalorbit.com</p>
                <a href="mailto:support@digitalorbit.com" class="btn">Email Us</a>
            </div>
            
            <div class="support-option">
                <span class="icon">☏</span>
                <h3>Phone Support</h3>
                <p>Speak directly with our stellar support agents for immediate assistance.</p>
                <p>1-800-ORBIT-TECH</p>
                <a href="tel:18006724883" class="btn">Call Now</a>
            </div>
        </div>
        
        <div class="faq-section">
            <h2>Frequently Asked Questions</h2>
            
            <div class="faq-item">
                <div class="faq-question">
                    How long does shipping take?
                </div>
                <div class="faq-answer">
                    Standard shipping takes 3-5 business days across the continental US. Express shipping options are available for 1-2 day delivery. International shipping varies by destination, typically 7-14 business days.
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    What is your return policy?
                </div>
                <div class="faq-answer">
                    Digital Orbit offers a 30-day satisfaction guarantee on most products. Items must be in original condition with all packaging and accessories. Certain products like opened software, custom configurations, and clearance items may have different return policies.
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    Do you offer price matching?
                </div>
                <div class="faq-answer">
                    Yes! We'll match the price of identical products from major retailers. Simply contact our customer service with proof of the competitor's current price within 14 days of your purchase.
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    How do I check my order status?
                </div>
                <div class="faq-answer">
                    You can track your order by clicking the "Track Order" button above or by logging into your Digital Orbit account. You'll need your order number and email address if not logged in.
                </div>
            </div>
            
            <div class="faq-item">
                <div class="faq-question">
                    Do you ship internationally?
                </div>
                <div class="faq-answer">
                    Yes, Digital Orbit ships to over 180 countries worldwide. International shipping rates and delivery times vary by location. Import duties and taxes may apply depending on your country's regulations.
                </div>
            </div>
        </div>
        
        <div class="returns-policy">
            <h2>Returns & Warranty Policy</h2>
            
            <p>At Digital Orbit, we stand behind our products with confidence in their quality and performance. Our returns and warranty policies are designed to ensure your complete satisfaction with every purchase.</p>
            
            <h3>30-Day Return Policy</h3>
            <ul>
                <li>Most products can be returned within 30 days of delivery for a full refund</li>
                <li>Items must be in original condition with all packaging and accessories</li>
                <li>Return shipping is free for defective items</li>
                <li>Restocking fee may apply to non-defective returns (15% of purchase price)</li>
            </ul>
            
            <h3>Manufacturer Warranty</h3>
            <ul>
                <li>All products include their original manufacturer warranty</li>
                <li>Warranty periods vary by product category and brand</li>
                <li>Digital Orbit can facilitate warranty claims with manufacturers</li>
                <li>Extended warranty options available at checkout</li>
            </ul>
            
            <h3>Exclusions</h3>
            <p>Certain items have modified return policies:</p>
            <ul>
                <li>Opened software, digital downloads, and license keys are non-returnable</li>
                <li>Custom-configured systems have a 15-day return window</li>
                <li>Clearance and open-box items may have limited return eligibility</li>
            </ul>
            
            <a href="#" class="btn">Read Full Policy</a>
        </div>
    </div>
</body>
</html>
