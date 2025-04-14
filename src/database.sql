CREATE DATABASE digital_orbit;
USE digital_orbit;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    status VARCHAR(20) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Insert sample categories
INSERT INTO categories (name) VALUES ('Fitness'), ('Electronics'), ('Top Sellers'), ('Fashion'), ('Home'), ('Books');

-- Insert sample products
INSERT INTO products (category_id, name, description, price, image) VALUES
(1, 'Yoga Mat', 'High-quality yoga mat for fitness enthusiasts.', 29.99, 'yoga_mat.jpg'),
(1, 'Dumbbells Set', 'Adjustable dumbbells for home workouts.', 59.99, 'dumbbells.jpg'),
(2, 'Smartphone', 'Latest model with advanced features.', 699.99, 'smartphone.jpg'),
(2, 'Wireless Earbuds', 'Noise-cancelling earbuds.', 129.99, 'earbuds.jpg'),
(3, 'Fitness Tracker', 'Top-selling fitness tracker.', 49.99, 'fitness_tracker.jpg'),
(3, 'LED TV', '4K Ultra HD Smart TV.', 499.99, 'led_tv.jpg');
