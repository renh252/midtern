use shopping_store;
-- 1. 插入商品分類 (Categories)
INSERT INTO Categories (
category_name, 
category_tag, 
category_description, 
parent_id) 
VALUES
('Electronics', 'ELEC', 'Electronic gadgets and devices', NULL),
('Fashion', 'FASH', 'Clothing and accessories', NULL),
('Smartphones', 'SMART', 'Latest smartphones', 1),
('Laptops', 'LAPTOP', 'Portable computers', 1),
('Shoes', 'SHOES', 'Different types of footwear', 2);

-- 2. 插入商品 (Products)
INSERT INTO Products (
product_name, 
product_description, 
price, category_id, 
product_status, 
image_url, 
stock_quantity)
VALUES
-- Electronics (category_id = 1)
('Electronic Product 1', 'Description for Electronic Product 1', 100, 1, '上架', 'https://placehold.co/100x100', 50),
('Electronic Product 2', 'Description for Electronic Product 2', 150, 1, '上架', 'https://placehold.co/100x100', 30),

-- Fashion (category_id = 2)
('Fashion Product 1', 'Description for Fashion Product 1', 80, 2, '上架', 'https://placehold.co/100x100', 70),
('Fashion Product 2', 'Description for Fashion Product 2', 120, 2, '上架', 'https://placehold.co/100x100', 40),

-- Smartphones (category_id = 3)
('Smartphone Product 1', 'Description for Smartphone Product 1', 200, 3, '上架', 'https://placehold.co/100x100', 20),
('Smartphone Product 2', 'Description for Smartphone Product 2', 250, 3, '上架', 'https://placehold.co/100x100', 25),

-- Laptops (category_id = 4)
('Laptop Product 1', 'Description for Laptop Product 1', 500, 4, '上架', 'https://placehold.co/100x100', 10),
('Laptop Product 2', 'Description for Laptop Product 2', 550, 4, '上架', 'https://placehold.co/100x100', 15),

-- Shoes (category_id = 5)
('Shoe Product 1', 'Description for Shoe Product 1', 60, 5, '上架', 'https://placehold.co/100x100', 80),
('Shoe Product 2', 'Description for Shoe Product 2', 70, 5, '上架', 'https://placehold.co/100x100', 90);



-- 3. 插入商品變體 (Product_Variants)
INSERT INTO Product_Variants (
product_id, 
variant_name, 
price, 
stock_quantity, 
image_url)
VALUES
-- Variants for Electronic Product 1 (product_id = 1)
(1, 'Electronic Product 1 - Variant A', 110, 20, 'https://placehold.co/100x100'),
(1, 'Electronic Product 1 - Variant B', 120, 15, 'https://placehold.co/100x100'),

-- Variants for Fashion Product 1 (product_id = 3)
(3, 'Fashion Product 1 - Variant A', 90, 50, 'https://placehold.co/100x100'),
(3, 'Fashion Product 1 - Variant B', 100, 40, 'https://placehold.co/100x100');



-- 插入假訂單
INSERT INTO Orders (
    order_id, user_id, total_price, order_status, 
    payment_method, payment_status, 
    invoice_method, invoice, 
    recipient_name, recipient_phone, recipient_email, 
    remark, shipping_method, shipping_address, 
    tracking_number, shipped_at, created_at, finish_at
)
VALUES
('ORD00001', 1, 5000, 'Completed', 'Credit Card', 'Paid', 'Electronic', 'INV00001', 'Alice', '123456789', 'alice@example.com', 'No remark', 'Standard Shipping', '123 Main St, City', 'TRK123456', NOW(), NOW(), NOW()),
('ORD00002', 2, 4500, 'Processing', 'PayPal', 'Pending', 'Paper', 'INV00002', 'Bob', '987654321', 'bob@example.com', 'Handle with care', 'Express Shipping', '456 Elm St, City', NULL, NULL, NOW(), NULL),
('ORD00003', 3, 3200, 'Shipped', 'Bank Transfer', 'Paid', 'Electronic', 'INV00003', 'Charlie', '112233445', 'charlie@example.com', 'Gift wrap', 'Standard Shipping', '789 Oak St, City', 'TRK789123', NOW(), NOW(), NULL),
('ORD00004', 4, 6200, 'Pending', 'Credit Card', 'Failed', 'Electronic', 'INV00004', 'Diana', '556677889', 'diana@example.com', 'No remark', 'Express Shipping', '101 Pine St, City', NULL, NULL, NOW(), NULL),
('ORD00005', 5, 2100, 'Completed', 'Cash', 'Paid', 'Paper', 'INV00005', 'Eve', '998877665', 'eve@example.com', 'Urgent', 'Standard Shipping', '202 Birch St, City', 'TRK456789', NOW(), NOW(), NOW());

-- 插入假訂單商品
INSERT INTO Order_Items (
    order_id, product_id, variant_id, quantity, price, return_status, returned_quantity
)
VALUES
-- 訂單 1
('ORD00001', 1, 1, 2, 1000, NULL, 0),
('ORD00001', 2, 2, 2, 1500, NULL, 0),
('ORD00001', 3, 3, 1, 500, NULL, 0),
('ORD00001', 4, 4, 1, 1000, NULL, 0),
('ORD00001', 5, 5, 1, 1000, NULL, 0),
-- 訂單 2
('ORD00002', 6, 6, 2, 1200, NULL, 0),
('ORD00002', 7, 7, 1, 800, NULL, 0),
('ORD00002', 8, 8, 1, 1000, NULL, 0),
('ORD00002', 9, 9, 1, 800, NULL, 0),
('ORD00002', 10, 10, 1, 700, NULL, 0),
-- 訂單 3
('ORD00003', 1, 1, 3, 900, NULL, 0),
('ORD00003', 2, 2, 1, 700, NULL, 0),
('ORD00003', 3, 3, 2, 800, NULL, 0),
('ORD00003', 4, 4, 1, 400, NULL, 0),
('ORD00003', 5, 5, 1, 400, NULL, 0),
-- 訂單 4
('ORD00004', 6, 6, 1, 2000, NULL, 0),
('ORD00004', 7, 7, 1, 1500, NULL, 0),
('ORD00004', 8, 8, 2, 1200, NULL, 0),
('ORD00004', 9, 9, 1, 800, NULL, 0),
('ORD00004', 1, 10, 1, 700, NULL, 0),
-- 訂單 5
('ORD00005', 1, 1, 1, 500, NULL, 0),
('ORD00005', 2, 2, 1, 400, NULL, 0),
('ORD00005', 3, 3, 2, 600, NULL, 0),
('ORD00005', 4, 4, 1, 300, NULL, 0),
('ORD00005', 5, 5, 1, 300, NULL, 0);


select * from Categories;
select * from Products;
select * from Product_Variants ;
select * from Orders ;
select * from Order_Items ;

