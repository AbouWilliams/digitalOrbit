<?php include 'includes/header.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'includes/head.php' ?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FAQ - Digital Orbit</title>
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
      font-family: 'Montserrat', sans-serif;
      margin: 0;
      padding: 0;
      background-color: var(--deep-space);
      color: var(--stardust-white);
      overflow-x: hidden;
    }
    
    .stars-bg {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
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
margin-top: 40px;
      padding: 2rem;
    }
    
    .orbit-circle {
      position: absolute;
      border-radius: 50%;
      border: 1px dashed var(--orbit-teal);
      opacity: 0.3;
      z-index: -1;
      animation: rotate 120s linear infinite;
    }
    
    @keyframes rotate {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }
    
    .orbit-1 {
      width: 600px;
      height: 600px;
      top: -200px;
      right: -200px;
    }
    
    .orbit-2 {
      width: 400px;
      height: 400px;
      bottom: -200px;
      left: -200px;
      border-color: var(--cosmic-purple);
      animation-direction: reverse;
      animation-duration: 90s;
    }
    
    h1, h2, h3 {
      font-weight: 700;
      color: var(--stardust-white);
    }
    
    h1 {
      font-size: 3rem;
      margin-bottom: 2rem;
      position: relative;
      text-align: center;
    }
    
    h1:after {
      content: '';
      position: absolute;
      bottom: -0.5rem;
      left: 50%;
      transform: translateX(-50%);
      width: 80px;
      height: 4px;
      background: linear-gradient(90deg, var(--orbit-teal), var(--celestial-blue));
    }
    
    .faq-header {
      text-align: center;
      padding: 3rem 0;
    }
    
    .faq-description {
      max-width: 700px;
      margin: 0 auto 3rem;
      text-align: center;
      font-size: 1.1rem;
      line-height: 1.6;
    }
    
    .faq-categories {
      display: flex;
      justify-content: center;
      gap: 1rem;
      flex-wrap: wrap;
      margin-bottom: 3rem;
    }
    
    .category-button {
      padding: 0.75rem 1.5rem;
      background: rgba(12, 20, 69, 0.7);
      border: 1px solid var(--celestial-blue);
      border-radius: 50px;
      color: var(--stardust-white);
      cursor: pointer;
      transition: all 0.3s ease;
    }
    
    .category-button:hover, .category-button.active {
      background: rgba(30, 136, 229, 0.2);
      border-color: var(--orbit-teal);
      transform: translateY(-3px);
      box-shadow: 0 5px 15px rgba(0, 188, 212, 0.3);
    }
    
    .category-button.active {
      background: rgba(0, 188, 212, 0.2);
    }
    
    .search-bar {
      max-width: 600px;
      margin: 0 auto 4rem;
      position: relative;
    }
    
    .search-bar input {
      width: 100%;
      padding: 1rem 1rem 1rem 3rem;
      border-radius: 50px;
      border: 1px solid var(--asteroid-gray);
      background: rgba(12, 20, 69, 0.7);
      color: var(--stardust-white);
      font-size: 1rem;
      transition: all 0.3s ease;
    }
    
    .search-bar input:focus {
      outline: none;
      border-color: var(--orbit-teal);
      box-shadow: 0 0 15px rgba(0, 188, 212, 0.3);
    }
    
    .search-icon {
      position: absolute;
      left: 1rem;
      top: 50%;
      transform: translateY(-50%);
      color: var(--orbit-teal);
      font-size: 1.2rem;
    }
    
    .faq-content {
      margin-bottom: 5rem;
    }
    
    .faq-category {
      margin-bottom: 4rem;
    }
    
    .category-title {
      font-size: 1.8rem;
      color: var(--orbit-teal);
      margin-bottom: 2rem;
      position: relative;
    }
    
    .category-title:after {
      content: '';
      position: absolute;
      bottom: -0.5rem;
      left: 0;
      width: 60px;
      height: 3px;
      background: linear-gradient(90deg, var(--orbit-teal), transparent);
    }
    
    .faq-list {
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
    }
    
    .faq-item {
      background: rgba(12, 20, 69, 0.7);
      border-radius: 12px;
      border: 1px solid var(--asteroid-gray);
      overflow: hidden;
      transition: all 0.3s ease;
    }
    
    .faq-item:hover {
      border-color: var(--celestial-blue);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }
    
    .faq-question {
      padding: 1.5rem;
      cursor: pointer;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-weight: 600;
      font-size: 1.1rem;
    }
    
    .faq-question span {
      flex: 1;
    }
    
    .question-icon {
      width: 24px;
      height: 24px;
      position: relative;
      transition: transform 0.3s ease;
    }
    
    .question-icon:before, .question-icon:after {
      content: '';
      position: absolute;
      background-color: var(--orbit-teal);
      transition: all 0.3s ease;
    }
    
    .question-icon:before {
      width: 100%;
      height: 2px;
      top: 50%;
      left: 0;
      transform: translateY(-50%);
    }
    
    .question-icon:after {
      width: 2px;
      height: 100%;
      top: 0;
      left: 50%;
      transform: translateX(-50%);
    }
    
    .faq-item.active .question-icon:after {
      transform: translateX(-50%) scaleY(0);
    }
    
    .faq-item.active .question-icon {
      transform: rotate(180deg);
    }
    
    .faq-answer {
      padding: 0 1.5rem;
      height: 0;
      overflow: hidden;
      transition: height 0.3s ease;
      line-height: 1.7;
    }
    
    .faq-item.active .faq-answer {
      padding: 0 1.5rem 1.5rem;
      height: auto;
    }
    
    .faq-item.active {
      border-color: var(--orbit-teal);
      box-shadow: 0 5px 15px rgba(0, 188, 212, 0.2);
    }
    
    .contact-section {
      text-align: center;
      margin: 5rem 0;
      padding: 3rem;
      background: rgba(12, 20, 69, 0.6);
      border-radius: 12px;
      position: relative;
      overflow: hidden;
    }
    
    .cta-orbit {
      position: absolute;
      border-radius: 50%;
      border: 1px dashed var(--orbit-teal);
      opacity: 0.2;
      z-index: -1;
    }
    
    .cta-orbit-1 {
      width: 300px;
      height: 300px;
      top: -150px;
      right: -100px;
      animation: rotate 60s linear infinite;
    }
    
    .cta-orbit-2 {
      width: 200px;
      height: 200px;
      bottom: -100px;
      left: -50px;
      border-color: var(--nova-orange);
      animation: rotate 40s linear infinite reverse;
    }
    
    .contact-title {
      font-size: 2rem;
      margin-bottom: 1.5rem;
    }
    
    .contact-description {
      max-width: 600px;
      margin: 0 auto 2rem;
      font-size: 1.1rem;
    }
    
    .contact-options {
      display: flex;
      justify-content: center;
      gap: 2rem;
      flex-wrap: wrap;
      margin-top: 2rem;
    }
    
    .contact-option {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 1.5rem;
      background: rgba(12, 20, 69, 0.7);
      border-radius: 12px;
      min-width: 200px;
      border: 1px solid var(--celestial-blue);
      transition: all 0.3s ease;
    }
    
    .contact-option:hover {
      transform: translateY(-5px);
      border-color: var(--orbit-teal);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
    
    .contact-icon {
      font-size: 2rem;
      color: var(--orbit-teal);
      margin-bottom: 1rem;
    }
    
    .contact-label {
      font-weight: 600;
      margin-bottom: 0.5rem;
    }
    
    .contact-value {
      color: var(--celestial-blue);
    }
    
    .btn {
      display: inline-block;
      padding: 1rem 2.5rem;
      background: linear-gradient(135deg, var(--celestial-blue), var(--orbit-teal));
      color: var(--stardust-white);
      font-weight: 600;
      text-decoration: none;
      border-radius: 50px;
      font-size: 1.1rem;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      text-transform: uppercase;
      letter-spacing: 1px;
      box-shadow: 0 5px 15px rgba(0, 188, 212, 0.4);
      margin-top: 2rem;
    }
    
    .btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(0, 188, 212, 0.6);
    }
    
    @media (max-width: 768px) {
      .faq-question {
        font-size: 1rem;
        padding: 1.2rem;
      }
      
      .category-title {
        font-size: 1.5rem;
      }
      
      .faq-header {
        padding: 2rem 0;
      }
      
      h1 {
        font-size: 2.5rem;
      }
    }
  </style>
</head>
<body>
  <div class="stars-bg"></div>
  
  <div class="orbit-circle orbit-1"></div>
  <div class="orbit-circle orbit-2"></div>
  
  <div class="container-2">
    <header class="faq-header">
      <h1>Frequently Asked Questions</h1>
      <p class="faq-description">Explore our universe of information below to find answers to common questions about Digital Orbit products, shipping, returns, and more.</p>
      
      <div class="faq-categories">
        <button class="category-button active" data-category="all">All Questions</button>
        <button class="category-button" data-category="products">Products</button>
        <button class="category-button" data-category="shipping">Shipping & Delivery</button>
        <button class="category-button" data-category="returns">Returns & Warranty</button>
        <button class="category-button" data-category="account">Account & Orders</button>
      </div>
      
      <div class="search-bar">
        <div class="search-icon">🔍</div>
        <input type="text" placeholder="Search for answers...">
      </div>
    </header>
    
    <div class="faq-content">
      <div class="faq-category" id="products">
        <h2 class="category-title">Products</h2>
        
        <div class="faq-list">
          <div class="faq-item">
            <div class="faq-question">
              <span>Are Digital Orbit products compatible with all devices?</span>
              <div class="question-icon"></div>
            </div>
            <div class="faq-answer">
              <p>Digital Orbit products are designed to be compatible with most modern devices. Our Stellar Audio Series works with any device that supports Bluetooth 5.0 or higher, as well as devices with standard 3.5mm audio jacks. For specific compatibility information, please check the product specifications on individual product pages or contact our support team.</p>
            </div>
          </div>
          
          <div class="faq-item">
            <div class="faq-question">
              <span>What makes Digital Orbit products unique compared to other tech brands?</span>
              <div class="question-icon"></div>
            </div>
            <div class="faq-answer">
              <p>Digital Orbit products stand out through our signature space-inspired designs, premium build quality, and innovative features. Our products are created by a team of former aerospace engineers who integrate cosmic aesthetics with cutting-edge technology. For example, our Gravity Charging Stations use our patented orbital floating design, while our Celestial Smart Lights can accurately recreate astronomical phenomena in your home.</p>
            </div>
          </div>
          
          <div class="faq-item">
            <div class="faq-question">
              <span>How long do batteries last in Digital Orbit wireless products?</span>
              <div class="question-icon"></div>
            </div>
            <div class="faq-answer">
              <p>Battery life varies by product, but we prioritize long-lasting performance across our range:</p>
              <ul>
                <li>Cosmic Orbit Pro Headsets: Up to 40 hours of continuous playback</li>
                <li>Nebula Earbuds: 8 hours per charge with 32 additional hours from the charging case</li>
                <li>Solar Flare Power Banks: Provide up to 5 full charges for most smartphones</li>
                <li>Galaxy Home Hub: Designed to be plugged in, but includes a 12-hour backup battery</li>
              </ul>
              <p>For specific battery performance details, please check individual product specifications.</p>
            </div>
          </div>
          
          <div class="faq-item">
            <div class="faq-question">
              <span>Do Digital Orbit products work with both iOS and Android?</span>
              <div class="question-icon"></div>
            </div>
            <div class="faq-answer">
              <p>Yes, all Digital Orbit products are designed to work seamlessly with both iOS and Android devices. Our companion app, Digital Orbit Connect, is available on both the App Store and Google Play Store, offering full functionality across all platforms. Some advanced features may have slight variations between operating systems, but core functionality remains consistent.</p>
            </div>
          </div>
          
          <div class="faq-item">
            <div class="faq-question">
              <span>How often do you release new products?</span>
              <div class="question-icon"></div>
            </div>
            <div class="faq-answer">
              <p>Digital Orbit typically refreshes our product lines annually, with major new releases occurring every 18-24 months. We also introduce limited edition collections throughout the year, often inspired by astronomical events or space exploration milestones. To stay informed about upcoming releases, sign up for our newsletter or follow us on social media.</p>
            </div>
          </div>
        </div>
      </div>
      
      <div class="faq-category" id="shipping">
        <h2 class="category-title">Shipping & Delivery</h2>
        
        <div class="faq-list">
          <div class="faq-item">
            <div class="faq-question">
              <span>How long does shipping take?</span>
              <div class="question-icon"></div>
            </div>
            <div class="faq-answer">
              <p>Shipping times vary based on your location and selected shipping method:</p>
              <ul>
                <li><strong>Standard Shipping (Free on orders over $75):</strong> 5-7 business days within the continental US</li>
                <li><strong>Express Shipping:</strong> 2-3 business days within the continental US</li>
                <li><strong>Priority Shipping:</strong> 1-2 business days within the continental US</li>
                <li><strong>International Shipping:</strong> 10-15 business days depending on location</li>
              </ul>
              <p>All orders are processed within 1-2 business days. You'll receive a tracking number once your order ships.</p>
            </div>
          </div>
          
          <div class="faq-item">
            <div class="faq-question">
              <span>Do you offer international shipping?</span>
              <div class="question-icon"></div>
            </div>
            <div class="faq-answer">
              <p>Yes, Digital Orbit ships to over 50 countries worldwide. International shipping costs are calculated at checkout based on destination and order weight. Please note that international customers may be responsible for import duties, taxes, and customs clearance fees, which are not included in our shipping charges. Delivery times for international orders typically range from 10-15 business days after shipping.</p>
            </div>
          </div>
          
          <div class="faq-item">
            <div class="faq-question">
              <span>Can I track my order?</span>
              <div class="question-icon"></div>
            </div>
            <div class="faq-answer">
              <p>Absolutely! Once your order ships, you'll automatically receive an email with tracking information. You can also view your order status and tracking details by logging into your Digital Orbit account and visiting the "Order History" section. Our tracking system provides real-time updates on your package's journey, from our warehouse to your orbit.</p>
            </div>
          </div>
          
          <div class="faq-item">
            <div class="faq-question">
              <span>What if my package is damaged during shipping?</span>
              <div class="question-icon"></div>
            </div>
            <div class="faq-answer">
              <p>We take great care in packaging our products to ensure they arrive safely. However, if you receive a damaged package, please:</p>
              <ol>
                <li>Take photos of the damaged package and product</li>
                <li>Contact our Customer Support team within 48 hours of delivery</li>
                <li>Provide your order number and the photos of the damage</li>
              </ol>
              <p>Our team will promptly arrange for a replacement to be sent to you. In most cases, you won't need to return the damaged item.</p>
            </div>
          </div>
        </div>
      </div>
      
      <div class="faq-category" id="returns">
        <h2 class="category-title">Returns & Warranty</h2>
        
        <div class="faq-list">
          <div class="faq-item">
            <div class="faq-question">
              <span>What is your return policy?</span>
              <div class="question-icon"></div>
            </div>
            <div class="faq-answer">
              <p>Digital Orbit offers a 30-day satisfaction guarantee on all products. If you're not completely satisfied with your purchase, you can return it within 30 days of delivery for a full refund or exchange. Items must be in their original condition and packaging with all accessories included. Return shipping is free for customers in the continental US.</p>
              <p>To initiate a return, log into your account and select "Return Item" from your order history, or contact our Customer Support team.</p>
            </div>
          </div>
          
          <div class="faq-item">
            <div class="faq-question">
              <span>How long is the warranty period for Digital Orbit products?</span>
              <div class="question-icon"></div>
            </div>
            <div class="faq-answer">
              <p>All Digital Orbit products come with a standard 2-year limited warranty that covers manufacturing defects and hardware failures under normal use. Our Nova Laptops and Galaxy Home Hub come with an extended 3-year warranty. The warranty period begins on the date of purchase.</p>
              <p>Additionally, customers can purchase our Stellar Protection Plan for extended coverage up to 5 years, which includes accidental damage protection for select products.</p>
            </div>
          </div>
          
          <div class="faq-item">
            <div class="faq-question">
              <span>How do I claim warranty service?</span>
              <div class="question-icon"></div>
            </div>
            <div class="faq-answer">
              <p>To claim warranty service:</p>
              <ol>
                <li>Visit our Support Center at support.digitalorbit.com</li>
                <li>Select "Warranty Claim" and log in to your account</li>
                <li>Provide your order details and a description of the issue</li>
                <li>Our support team will evaluate your claim and provide instructions for repair or replacement</li>
              </ol>
              <p>Most warranty claims are processed within 3-5 business days. Depending on the product and issue, we may offer advance replacement, repair service, or store credit.</p>
            </div>
          </div>
          
          <div class="faq-item">
            <div class="faq-question">
              <span>Are refurbished products covered by warranty?</span>
              <div class="question-icon"></div>
            </div>
            <div class="faq-answer">
              <p>Yes, certified refurbished Digital Orbit products come with a 1-year limited warranty. These products have been thoroughly tested and restored to like-new condition by our technical team. The warranty covers the same manufacturing defects and hardware failures as our standard warranty, but for a shorter period.</p>
            </div>
          </div>
        </div>
      </div>
      
      <div class="faq-category" id="account">
        <h2 class="category-title">Account & Orders</h2>
        
        <div class="faq-list">
          <div class="faq-item">
            <div class="faq-question">
              <span>How do I create a Digital Orbit account?</span>
              <div class="question-icon"></div>
            </div>
            <div class="faq-answer">
              <p>Creating a Digital Orbit account is simple:</p>
              <ol>
                <li>Click the "Account" icon in the top right corner of our website</li>
                <li>Select "Create Account"</li>
                <li>Enter your email address and create a password</li>
                <li>Complete your profile with shipping and payment information (optional)</li>
              </ol>
              <p>You can also create an account during checkout. Having an account allows you to track orders, save favorite products, access exclusive offers, and manage your Digital Orbit devices.</p>
            </div>
          </div>
          
          <div class="faq-item">
            <div class="faq-question">
              <span>How can I check the status of my order?</span>
              <div class="question-icon"></div>
            </div>
            <div class="faq-answer">
              <p>You can check your order status in several ways:</p>
              <ul>
                <li>Log into your Digital Orbit account and visit the "Order History" section</li>
                <li>Click the tracking link in your shipment confirmation email</li>
                <li>Contact our Customer Support team with your order number</li>
              </ul>
              <p>Orders typically show the following statuses: Processing, Preparing to Ship, Shipped, Out for Delivery, and Delivered.</p>
            </div>
          </div>
          
          <div class="faq-item">
            <div class="faq-question">
              <span>Can I modify or cancel my order after placing it?</span>
              <div class="question-icon"></div>
            </div>
            <div class="faq-answer">
              <p>Order modifications or cancellations can be made within 2 hours of placing your order. To modify or cancel, log into your account, go to "Order History," and select the appropriate option for your recent order.</p>
              <p>After the 2-hour window, orders enter our processing system and cannot be modified or canceled. In this case, you'll need to wait for your order to arrive and then initiate a return if necessary.</p>
            </div>
          </div>
          
          <div class="faq-item">
            <div class="faq-question">
              <span>Do you offer a loyalty or rewards program?</span>
              <div class="question-icon"></div>
            </div>
            <div class="faq-answer">
              <p>Yes! Our Cosmic Explorer Rewards Program offers points for purchases, reviews, and social media engagement. Points can be redeemed for discounts, exclusive products, early access to new releases, and more. The program has three tiers:</p>
              <ul>
                <li><strong>Orbit Traveler:</strong> Entry level with 1 point per $1 spent</li>
                <li><strong>Solar Explorer:</strong> After $500 in purchases, earning 1.5 points per $1</li>
                <li><strong>Galactic Pioneer:</strong> After $1,000 in purchases, earning 2 points per $1 and free priority shipping</li>
              </ul>
              <p>Sign up in your account settings under "Rewards Program."</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="contact-section">
      <div class="cta-orbit cta-orbit-1"></div>
      <div class="cta-orbit cta-orbit-2"></div>
      
      <h2 class="contact-title">Still Need Help?</h2>
      <p class="contact-description">If you couldn't find the answer you're looking for, our support team is ready to assist you through various channels.</p>
      
      <div class="contact-options">
        <div class="contact-option">
          <div class="contact-icon">✉️</div>
          <div class="contact-label">Email Us</div>
          <div class="contact-value">support@digitalorbit.com</div>
        </div>
        
        <div class="contact-option">
          <div class="contact-icon">📞</div>
          <div class="contact-label">Call Us</div>
          <div class="contact-value">1-800-ORBIT-TECH</div>
        </div>
        
        <div class="contact-option">
          <div class="contact-icon">💬</div>
          <div class="contact-label">Live Chat</div>
          <div class="contact-value">Available 24/7</div>
        </div>
      </div>
      
      <a href="contact.php" class="btn">Contact Support</a>
    </div>
  </div>
  
  <script>
    // JavaScript for FAQ functionality
    document.addEventListener('DOMContentLoaded', function() {
      // FAQ accordion functionality
      const faqItems = document.querySelectorAll('.faq-item');
      
      faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');
        
        question.addEventListener('click', () => {
          const isActive = item.classList.contains('active');
          
          // Close all items
          faqItems.forEach(faqItem => {
            faqItem.classList.remove('active');
          });
          
          // If the clicked item wasn't active, open it
          if (!isActive) {
            item.classList.add('active');
          }
        });
      });
      
      // Category filter functionality
      const categoryButtons = document.querySelectorAll('.category-button');
      const faqCategories = document.querySelectorAll('.faq-category');
      
      categoryButtons.forEach(button => {
        button.addEventListener('click', () => {
          // Remove active class from all buttons
          categoryButtons.forEach(btn => btn.classList.remove('active'));
          
          // Add active class to clicked button
          button.classList.add('active');
          
          const category = button.getAttribute('data-category');
          
          if (category === 'all') {
            // Show all categories
            faqCategories.forEach(cat => cat.style.display = 'block');
          } else {
            // Hide all categories
            faqCategories.forEach(cat => cat.style.display = 'none');
            
            // Show only the selected category
            document.getElementById(category).style.display = 'block';
          }
        });
      });
      
      // Search functionality
      const searchInput = document.querySelector('.search-bar input');
      
      searchInput.addEventListener('input', () => {
      const searchTerm = searchInput.value.toLowerCase();
        
        if (searchTerm.length > 2) {
          // Show all categories when searching
          faqCategories.forEach(cat => cat.style.display = 'block');
          
          // Reset category buttons
          categoryButtons.forEach(btn => btn.classList.remove('active'));
          document.querySelector('[data-category="all"]').classList.add('active');
          
          // Filter FAQ items based on search term
          faqItems.forEach(item => {
            const questionText = item.querySelector('.faq-question span').textContent.toLowerCase();
            const answerText = item.querySelector('.faq-answer').textContent.toLowerCase();
            
            if (questionText.includes(searchTerm) || answerText.includes(searchTerm)) {
              item.style.display = 'block';
              // Highlight the item that matches search
              item.classList.add('active');
            } else {
              item.style.display = 'none';
            }
          });
        } else {
          // Reset display if search term is too short
          faqItems.forEach(item => {
            item.style.display = 'block';
            item.classList.remove('active');
          });
        }
      });
      
      // Initialize - Open first item in each category
      faqCategories.forEach(category => {
        const firstItem = category.querySelector('.faq-item');
        if (firstItem) {
          firstItem.classList.add('active');
        }
      });
      
      // Add smooth scrolling for anchor links
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
          e.preventDefault();
          
          const targetId = this.getAttribute('href').substring(1);
          const targetElement = document.getElementById(targetId);
          
          if (targetElement) {
            window.scrollTo({
              top: targetElement.offsetTop - 100,
              behavior: 'smooth'
            });
          }
        });
      });
    });
  </script>
<?php include 'includes/footer.php' ?>
</body>
</html>
