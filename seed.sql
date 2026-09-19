-- seed.sql
-- Run AFTER schema.sql
-- Requires: run seed_users.php FIRST to create users with proper password hashes
-- Then run this for products (references user IDs 1-4)

INSERT INTO products (user_id, name, description, price, stock) VALUES
(1, 'Wireless Mouse', 'Ergonomic wireless mouse with USB receiver', 19.99, 150),
(1, 'Mechanical Keyboard', 'RGB backlit mechanical keyboard, blue switches', 59.99, 80),
(2, 'USB-C Hub', '7-in-1 USB-C hub with HDMI and card reader', 29.99, 60),
(2, 'Laptop Stand', 'Adjustable aluminum laptop stand', 24.99, 100),
(3, 'Webcam 1080p', 'Full HD webcam with built-in microphone', 34.99, 45),
(3, 'Desk Lamp', 'LED desk lamp with adjustable brightness', 15.99, 200),
(4, 'Bluetooth Speaker', 'Portable speaker with 12-hour battery', 39.99, 70),
(4, 'Phone Stand', 'Adjustable phone and tablet stand', 9.99, 300);