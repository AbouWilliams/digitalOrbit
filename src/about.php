<?php
session_start();
include 'includes/header.php'
?>
<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'includes/head.php' ?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us - Digital Orbit</title>
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
      padding: 2rem;
    }
    
    section {
      margin: 6rem 0;
      position: relative;
    }
    
    h1, h2, h3 {
      font-weight: 700;
      color: var(--stardust-white);
    }
    
    h1 {
      font-size: 3rem;
      margin-bottom: 2rem;
      position: relative;
    }
    
    h1:after {
      content: '';
      position: absolute;
      bottom: -0.5rem;
      left: 0;
      width: 80px;
      height: 4px;
      background: linear-gradient(90deg, var(--orbit-teal), var(--celestial-blue));
    }
    
    h2 {
      font-size: 2.2rem;
      margin-bottom: 1.5rem;
      color: var(--orbit-teal);
    }
    
    h3 {
      font-size: 1.5rem;
      color: var(--celestial-blue);
      margin-bottom: 1rem;
    }
    
    p {
      line-height: 1.8;
      margin-bottom: 1.5rem;
      font-size: 1.1rem;
    }
    
    .highlight {
      color: var(--orbit-teal);
      font-weight: 500;
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
      width: 800px;
      height: 800px;
      top: -200px;
      right: -400px;
    }
    
    .orbit-2 {
      width: 500px;
      height: 500px;
      bottom: -200px;
      left: -200px;
      border-color: var(--cosmic-purple);
      animation-direction: reverse;
      animation-duration: 90s;
    }
    
    .hero {
      height: 60vh;
      min-height: 400px;
      display: flex;
      align-items: center;
      position: relative;
      overflow: hidden;
    }
    
    .hero-content {
      max-width: 600px;
    }
    
    .hero h1 {
      font-size: 3.5rem;
      line-height: 1.2;
      margin-bottom: 1.5rem;
    }
    
    .hero p {
      font-size: 1.3rem;
      max-width: 500px;
    }
    
    .planet-graphic {
      position: absolute;
      right: -100px;
      top: 50%;
      transform: translateY(-50%);
      width: 500px;
      height: 500px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--cosmic-purple), var(--celestial-blue));
      box-shadow: 0 0 60px rgba(30, 136, 229, 0.4);
      overflow: hidden;
    }
    
    .planet-rings {
      position: absolute;
      width: 700px;
      height: 150px;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%) rotate(30deg);
      border-radius: 50%;
      border: 20px solid rgba(255, 255, 255, 0.1);
      box-shadow: inset 0 0 20px rgba(0, 188, 212, 0.5);
    }
    
    .mission-vision {
      display: flex;
      gap: 2rem;
      flex-wrap: wrap;
    }
    
    .mission, .vision {
      flex: 1;
      min-width: 300px;
      background: rgba(12, 20, 69, 0.7);
      border-radius: 12px;
      padding: 2rem;
      border: 1px solid var(--orbit-teal);
      box-shadow: 0 0 25px rgba(0, 188, 212, 0.15);
    }
    
    .values-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 2rem;
      margin-top: 3rem;
    }
    
    .value-card {
      background: rgba(12, 20, 69, 0.7);
      border-radius: 12px;
      padding: 2rem;
      border: 1px solid var(--celestial-blue);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .value-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
      border-color: var(--orbit-teal);
    }
    
    .value-icon {
      font-size: 2.5rem;
      margin-bottom: 1rem;
      color: var(--orbit-teal);
    }
    
    .timeline {
      position: relative;
      padding: 2rem 0;
    }
    
    .timeline::before {
      content: '';
      position: absolute;
      width: 2px;
      background: linear-gradient(to bottom, transparent, var(--orbit-teal), var(--celestial-blue), transparent);
      top: 0;
      bottom: 0;
      left: 50%;
      margin-left: -1px;
    }
    
    .timeline-item {
      margin-bottom: 3rem;
      position: relative;
    }
    
    .timeline-item::after {
      content: '';
      display: block;
      clear: both;
    }
    
    .timeline-content {
      position: relative;
      width: 45%;
      padding: 2rem;
      background: rgba(12, 20, 69, 0.7);
      border-radius: 12px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
      transition: transform 0.3s ease;
    }
    
    .timeline-content:hover {
      transform: translateY(-5px);
    }
    
    .timeline-item:nth-child(odd) .timeline-content {
      float: left;
      border-left: 3px solid var(--orbit-teal);
    }
    
    .timeline-item:nth-child(even) .timeline-content {
      float: right;
      border-right: 3px solid var(--celestial-blue);
    }
    
    .timeline-year {
      position: absolute;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      background: var(--cosmic-purple);
      top: 50%;
      transform: translateY(-50%);
      text-align: center;
      line-height: 60px;
      font-weight: bold;
      border: 3px solid var(--orbit-teal);
      z-index: 1;
    }
    
    .timeline-item:nth-child(odd) .timeline-year {
      right: -30px;
    }
    
    .timeline-item:nth-child(even) .timeline-year {
      left: -30px;
    }
    
    .products-section {
      margin-top: 6rem;
    }
    
    .product-categories {
      display: flex;
      flex-wrap: wrap;
      gap: 2rem;
      margin-top: 3rem;
    }
    
    .product-category {
      flex: 1;
      min-width: 250px;
      border-radius: 12px;
      overflow: hidden;
      background: rgba(12, 20, 69, 0.8);
      border: 1px solid var(--celestial-blue);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .product-category:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
      border-color: var(--orbit-teal);
    }
    
    .category-image {
      height: 200px;
      background: linear-gradient(45deg, var(--deep-space), var(--cosmic-purple));
      position: relative;
      overflow: hidden;
    }
    
    .category-content {
      padding: 1.5rem;
    }
    
    .category-title {
      margin-top: 0;
      margin-bottom: 0.5rem;
      font-size: 1.3rem;
    }
    
    .product-list {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    
    .product-list li {
      margin-bottom: 0.5rem;
      position: relative;
      padding-left: 1.5rem;
    }
    
    .product-list li:before {
      content: '•';
      position: absolute;
      left: 0;
      color: var(--orbit-teal);
      font-size: 1.2rem;
    }
    
    .team-section {
      margin-top: 6rem;
    }
    
    .team-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
      gap: 2rem;
      margin-top: 3rem;
    }
    
    .team-member {
      background: rgba(12, 20, 69, 0.7);
      border-radius: 12px;
      overflow: hidden;
      border: 1px solid var(--celestial-blue);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .team-member:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
      border-color: var(--orbit-teal);
    }
    
    .member-image {
      height: 250px;
      background: linear-gradient(45deg, var(--deep-space), var(--cosmic-purple));
      position: relative;
    }

.member-image img, .category-image img {
  width: 260px;
  height: 260px;
  object-fit: cover;
}


    .member-details {
      padding: 1.5rem;
    }
    
    .member-name {
      margin-top: 0;
      margin-bottom: 0.25rem;
    }
    
    .member-title {
      color: var(--orbit-teal);
      margin-bottom: 1rem;
      font-style: italic;
    }
    
    .cta-section {
      text-align: center;
      margin: 8rem 0;
      padding: 4rem 2rem;
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
      width: 400px;
      height: 400px;
      top: -200px;
      right: -100px;
      animation: rotate 60s linear infinite;
    }
    
    .cta-orbit-2 {
      width: 300px;
      height: 300px;
      bottom: -150px;
      left: -100px;
      border-color: var(--nova-orange);
      animation: rotate 40s linear infinite reverse;
    }
    
    .cta-heading {
      font-size: 2.5rem;
      margin-bottom: 1.5rem;
    }
    
    .cta-text {
      max-width: 700px;
      margin: 0 auto 2rem;
      font-size: 1.2rem;
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
    }
    
    .btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(0, 188, 212, 0.6);
    }
    
    @media (max-width: 768px) {
      .timeline::before {
        left: 30px;
      }
      
      .timeline-content {
        width: calc(100% - 90px);
        float: right;
      }
      
      .timeline-item:nth-child(odd) .timeline-content {
        float: right;
        border-left: none;
        border-right: 3px solid var(--orbit-teal);
      }
      
      .timeline-year {
        left: 0;
      }
      
      .timeline-item:nth-child(odd) .timeline-year {
        right: auto;
        left: 0;
      }
      
      .planet-graphic {
        opacity: 0.4;
        right: -200px;
      }
    }
  </style>
</head>
<body>
  <div class="stars-bg"></div>
  
  <div class="orbit-circle orbit-1"></div>
  <div class="orbit-circle orbit-2"></div>
  
  <section class="hero">
    <div class="container-2">
      <div class="hero-content">
        <h1>Exploring the Universe of Technology</h1>
        <p>Digital Orbit brings the wonder of the cosmos to your everyday tech experience with innovative, space-inspired products.</p>
      </div>
      
      <div class="planet-graphic">
        <div class="planet-rings"></div>
      </div>
    </div>
  </section>
  
  <section class="about-section">
    <div class="container-2">
      <h2>Our Story</h2>
      <p>Digital Orbit was born in 2020 when a team of former aerospace engineers and tech enthusiasts gathered in Austin, Texas with a shared vision: to create technology products that inspire the same sense of wonder and innovation that space exploration brings to humanity.</p>
      
      <p>What began as a small startup has grown into a recognized name in premium tech accessories and devices, known for our distinctive space-themed designs and cutting-edge technology that pushes the boundaries of what's possible.</p>
      
      <p>As lifelong admirers of the cosmos, our founders wanted to create more than just another tech company—they wanted to build products that would remind users of the infinite possibilities that technology represents, just as the stars remind us of the infinite universe waiting to be explored.</p>
    </div>
  </section>
  
  <section class="mission-vision-section">
    <div class="container-2">
      <div class="mission-vision">
        <div class="mission">
          <h3>Our Mission</h3>
          <p>To bring the wonder of the cosmos to everyday technology, creating products that inspire curiosity and innovation while delivering exceptional performance and reliability.</p>
        </div>
        
        <div class="vision">
          <h3>Our Vision</h3>
          <p>A world where technology enhances human potential and inspires users to reach for the stars—both literally and figuratively—in their pursuits and passions.</p>
        </div>
      </div>
    </div>
  </section>
  
  <section class="values-section">
    <div class="container-2">
      <h2>Our Core Values</h2>
      
      <div class="values-grid">
        <div class="value-card">
          <div class="value-icon">★</div>
          <h3>Innovation</h3>
          <p>Like the ever-expanding universe, we constantly push boundaries in both design and functionality, exploring new frontiers in technology.</p>
        </div>
        
        <div class="value-card">
          <div class="value-icon">✦</div>
          <h3>Quality</h3>
          <p>Just as stars can shine for billions of years, we create durable, high-performance products built to stand the test of time.</p>
        </div>
        
        <div class="value-card">
          <div class="value-icon">♾</div>
          <h3>Sustainability</h3>
          <p>We're committed to eco-friendly manufacturing and packaging, preserving our home planet while drawing inspiration from the cosmos.</p>
        </div>
        
        <div class="value-card">
          <div class="value-icon">☄</div>
          <h3>Education</h3>
          <p>We support STEM education initiatives and space science awareness, inspiring the next generation of explorers and innovators.</p>
        </div>
      </div>
    </div>
  </section>
  
  <section class="journey-section">
    <div class="container-2">
      <h2>Our Journey</h2>
      
      <div class="timeline">
        <div class="timeline-item">
          <div class="timeline-content">
            <h3>The Launch</h3>
            <p>Digital Orbit was founded by a team of four former aerospace engineers and tech entrepreneurs with a shared passion for space and technology.</p>
          </div>
          <div class="timeline-year">2020</div>
        </div>
        
        <div class="timeline-item">
          <div class="timeline-content">
            <h3>First Product Line</h3>
            <p>We released our first collection of products—the Cosmo Audio Series—which quickly gained recognition for its unique design and superior sound quality.</p>
          </div>
          <div class="timeline-year">2021</div>
        </div>
        
        <div class="timeline-item">
          <div class="timeline-content">
            <h3>Expansion</h3>
            <p>Our team grew to 25 employees and we expanded our product lines to include computer peripherals and mobile accessories, all with our signature cosmic design.</p>
          </div>
          <div class="timeline-year">2022</div>
        </div>
        
        <div class="timeline-item">
          <div class="timeline-content">
            <h3>Innovation Award</h3>
            <p>Digital Orbit received the Tech Innovator Award for our Gravity Charging Station, which features our patented orbital floating design.</p>
          </div>
          <div class="timeline-year">2023</div>
        </div>
        
        <div class="timeline-item">
          <div class="timeline-content">
            <h3>Global Reach</h3>
            <p>We expanded internationally, bringing our space-inspired technology to customers across North America, Europe, and Asia.</p>
          </div>
          <div class="timeline-year">2024</div>
        </div>
        
        <div class="timeline-item">
          <div class="timeline-content">
            <h3>New Frontiers</h3>
            <p>Today, we continue to explore new technological frontiers with our expanding product ecosystem and growing community of space tech enthusiasts.</p>
          </div>
          <div class="timeline-year">2025</div>
        </div>
      </div>
    </div>
  </section>
  
  <section class="products-section">
    <div class="container-2">
      <h2>Our Products</h2>
      <p>At Digital Orbit, we create space-inspired technology that combines aesthetic beauty with functional excellence. Each product line represents a different aspect of cosmic exploration and discovery.</p>
      
      <div class="product-categories">
        <div class="product-category">
          <div class="category-image">
<img src="https://www.yankodesign.com/images/design_news/2024/11/futuristic-audio-designs/top_10_futuristic_audio_yanko_design_07.jpg" >
</div>
          <div class="category-content">
            <h3 class="category-title">Cosmo Audio Series</h3>
            <ul class="product-list">
              <li>Cosmic Orbit Pro Headsets</li>
              <li>Nebula Earbuds</li>
              <li>Pulsar Speakers</li>
            </ul>
          </div>
        </div>
        
        <div class="product-category">
          <div class="category-image">
<img src="https://d2kbvjszk9d5ln.cloudfront.net/yshop/upload/pic/Future-of-Tablet-20240929105636867.jpg">
</div>
          <div class="category-content">
            <h3 class="category-title">Quantum Computing</h3>
            <ul class="product-list">
              <li>Nova Laptops</li>
              <li>Cosmo SSDs & Storage</li>
              <li>Meteor Mice & Peripherals</li>
            </ul>
          </div>
        </div>
        
        <div class="product-category">
          <div class="category-image">
<img src="https://images-wixmp-ed30a86b8c4ca887773594c2.wixmp.com/f/e36b69a2-a218-4f43-97c0-dd316a21c699/dinbj5w-7bb52d80-bfcd-4434-830c-c1a140b49414.jpg/v1/fill/w_1131,h_707,q_70,strp/futuristic_smartphone_by_pickgameru_dinbj5w-pre.jpg?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOiJ1cm46YXBwOjdlMGQxODg5ODIyNjQzNzNhNWYwZDQxNWVhMGQyNmUwIiwiaXNzIjoidXJuOmFwcDo3ZTBkMTg4OTgyMjY0MzczYTVmMGQ0MTVlYTBkMjZlMCIsIm9iaiI6W1t7ImhlaWdodCI6Ijw9ODAwIiwicGF0aCI6IlwvZlwvZTM2YjY5YTItYTIxOC00ZjQzLTk3YzAtZGQzMTZhMjFjNjk5XC9kaW5iajV3LTdiYjUyZDgwLWJmY2QtNDQzNC04MzBjLWMxYTE0MGI0OTQxNC5qcGciLCJ3aWR0aCI6Ijw9MTI4MCJ9XV0sImF1ZCI6WyJ1cm46c2VydmljZTppbWFnZS5vcGVyYXRpb25zIl19.ZviBkSVpXjqb2QSGsHseaOuqw0gyCDQMDRbfadbomSo" >
</div>
          <div class="category-content">
            <h3 class="category-title">Orbit Mobile Accessories</h3>
            <ul class="product-list">
              <li>Asteroid Phone Cases</li>
              <li>Gravity Charging Stations</li>
              <li>Solar Flare Power Banks</li>
            </ul>
          </div>
        </div>
        
        <div class="product-category">
          <div class="category-image">
<img src="https://bernardmarr.com/wp-content/uploads/2024/12/AdobeStock_556468321-scaled.jpeg" >
</div>
          <div class="category-content">
            <h3 class="category-title">Constellation Smart Home</h3>
            <ul class="product-list">
              <li>Celestial Smart Lights</li>
              <li>Galaxy Home Hub</li>
              <li>Satellite Sensors</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <section class="team-section">
    <div class="container-2">
      <h2>Our Team</h2>
      <p>The brilliant minds behind Digital Orbit bring diverse expertise from aerospace engineering, product design, software development, and consumer electronics.</p>
      
      <div class="team-grid">
        <div class="team-member">
          <div class="member-image">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT_PFR95IMHjrbDknyB-qoRfp-xSya5g7x5sw&s" alt="Gary Bryan">
            </div>
          <div class="member-details">
            <h3 class="member-name">Gary Bryan</h3>
            <div class="member-title">CEO & Co-Founder</div>
            <p>Former aerospace engineer with a passion for bringing space technology to consumer products.</p>
          </div>
        </div>
        
        <div class="team-member">
          <div class="member-image">

            <img src="https://alexmoreland.co.uk/wp-content/uploads/2024/04/star-trek-discovery-michael-burnham-sonequa-martin-green-interview-1800701027-e1712419130690.jpeg" alt="Abou Williams">
</div>
          <div class="member-details">
            <h3 class="member-name">Abou Williams</h3>
            <div class="member-title">CTO & Co-Founder</div>
            <p>Tech innovator with background in satellite communications and consumer electronics.</p>
          </div>
        </div>
        
        <div class="team-member">
          <div class="member-image">

            <img src="https://img.artpal.com/660252/4-22-7-12-8-22-47m.jpg" alt="Gary Bryan">
</div>
          <div class="member-details">
            <h3 class="member-name">David Hosin</h3>
            <div class="member-title">Chief Design Officer</div>
            <p>Award-winning industrial designer who translates cosmic beauty into functional tech.</p>
          </div>
        </div>
        
        <div class="team-member">
          <div class="member-image">
            <img src="https://pps.whatsapp.net/v/t61.24694-24/485046851_597138896659755_7262905542375591455_n.jpg?ccb=11-4&oh=01_Q5Aa1QExYAIV2OElpwEre99xgko1nok_YjekMwITiSG_3PvJdw&oe=680922F5&_nc_sid=5e03e0&_nc_cat=100" alt="Halle Francis">
        </div>
          <div class="member-details">
            <h3 class="member-name">Halle Francis</h3>
            <div class="member-title">Head of Product Development</div>
            <p>Product visionary with expertise in creating innovative tech ecosystems.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  
  <section class="cta-section">
    <div class="cta-orbit cta-orbit-1"></div>
    <div class="cta-orbit cta-orbit-2"></div>
    
    <h2 class="cta-heading">Join Our Orbit</h2>
    <p class="cta-text">Discover the perfect fusion of cosmic design and cutting-edge technology. Explore our universe of products and elevate your tech experience to stellar new heights.</p>
    <a href="catalogue.php" class="btn">Shop Now</a>
  </section>
<?php include 'includes/footer.php' ?>
</body>
</html>
