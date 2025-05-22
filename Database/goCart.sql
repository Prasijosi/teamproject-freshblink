-- CLEANUP: DROP TABLES AND SEQUENCES
DROP TABLE wishlist_product CASCADE CONSTRAINTS;
DROP TABLE cart_product CASCADE CONSTRAINTS;
DROP TABLE order_product CASCADE CONSTRAINTS;
DROP TABLE discount CASCADE CONSTRAINTS;
DROP TABLE invoice CASCADE CONSTRAINTS;
DROP TABLE payment CASCADE CONSTRAINTS;
DROP TABLE orders CASCADE CONSTRAINTS;
DROP TABLE collection_slot CASCADE CONSTRAINTS;
DROP TABLE cart CASCADE CONSTRAINTS;
DROP TABLE wishlist CASCADE CONSTRAINTS;
DROP TABLE review CASCADE CONSTRAINTS;
DROP TABLE product CASCADE CONSTRAINTS;
DROP TABLE report CASCADE CONSTRAINTS;
DROP TABLE product_category CASCADE CONSTRAINTS;
DROP TABLE shop CASCADE CONSTRAINTS;
DROP TABLE admin CASCADE CONSTRAINTS;
DROP TABLE trader CASCADE CONSTRAINTS;
DROP TABLE customer CASCADE CONSTRAINTS;
DROP TABLE users CASCADE CONSTRAINTS;

--Drop Sequence
DROP SEQUENCE seq_user_id;
DROP SEQUENCE seq_shop_id;
DROP SEQUENCE seq_product_category_id;
DROP SEQUENCE seq_product_id;
DROP SEQUENCE seq_review_id;
DROP SEQUENCE seq_wishlist_id;
DROP SEQUENCE seq_cart_id;
DROP SEQUENCE seq_order_id;
DROP SEQUENCE seq_payment_id;
DROP SEQUENCE seq_invoice_id;
DROP SEQUENCE seq_discount_id;
DROP SEQUENCE seq_report_id;
DROP SEQUENCE seq_slot_id;

-- DROP SEQUENCES
CREATE SEQUENCE seq_cart_id START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE seq_discount_id START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE seq_invoice_id START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE seq_order_id START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE seq_payment_id START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE seq_product_category_id START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE seq_product_id START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE seq_report_id START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE seq_review_id START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE seq_shop_id START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE seq_slot_id START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE seq_user_id START WITH 1 INCREMENT BY 1;
CREATE SEQUENCE seq_wishlist_id START WITH 1 INCREMENT BY 1;

-- CREATE TABLES
CREATE TABLE users (
    user_id NUMBER PRIMARY KEY,
    user_name VARCHAR2(100) NOT NULL,
    date_of_birth DATE,
    contact_details VARCHAR2(100),
    email VARCHAR2(100) UNIQUE NOT NULL,
    password VARCHAR2(100) NOT NULL,
    address VARCHAR2(255),
    user_role VARCHAR2(20) CHECK (user_role IN ('admin', 'trader', 'customer')) NOT NULL
);

CREATE TABLE admin (
    user_id NUMBER PRIMARY KEY,
    admin_id VARCHAR2(30) UNIQUE,
    admin_type VARCHAR2(30),
    contact_number VARCHAR2(15),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE trader (
    user_id NUMBER PRIMARY KEY,
    trader_id VARCHAR2(30) UNIQUE,
    trader_type VARCHAR2(50),
    trader_status VARCHAR2(20),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE customer (
    user_id NUMBER PRIMARY KEY,
    customer_id VARCHAR2(30) UNIQUE,
    contact_number VARCHAR2(15),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE shop (
    shop_id NUMBER PRIMARY KEY,
    trader_id NUMBER,
    shop_name VARCHAR2(100),
    description VARCHAR2(255),
    location VARCHAR2(100),
    email VARCHAR2(100),
    created_at DATE DEFAULT SYSDATE,
    FOREIGN KEY (trader_id) REFERENCES trader(user_id)
);

CREATE TABLE product_category (
    product_category_id NUMBER PRIMARY KEY,
    parent_category_id NUMBER,
    product_name VARCHAR2(100),
    created_on DATE DEFAULT SYSDATE,
    updated_on DATE,
    FOREIGN KEY (parent_category_id) REFERENCES product_category(product_category_id)
);

CREATE TABLE product (
    product_id NUMBER PRIMARY KEY,
    shop_id NUMBER,
    product_category_id NUMBER,
    product_name VARCHAR2(100),
    description VARCHAR2(255),
    price NUMBER(10,2),
    brand VARCHAR2(50),
    stock NUMBER,
    allergy_info VARCHAR2(255),
    image_url VARCHAR2(255),
    min_order NUMBER DEFAULT 1,
    max_order NUMBER,
    created_on DATE DEFAULT SYSDATE,
    updated_on DATE,
    FOREIGN KEY (shop_id) REFERENCES shop(shop_id),
    FOREIGN KEY (product_category_id) REFERENCES product_category(product_category_id)
);

CREATE TABLE discount (
    discount_id NUMBER PRIMARY KEY,
    product_id NUMBER,
    discount_percent NUMBER(5,2),
    start_date DATE,
    end_date DATE,
    FOREIGN KEY (product_id) REFERENCES product(product_id)
);

CREATE TABLE review (
    review_id NUMBER PRIMARY KEY,
    customer_id NUMBER,
    product_id NUMBER,
    rating NUMBER CHECK (rating BETWEEN 1 AND 5),
    coment VARCHAR2(500),
    review_date DATE DEFAULT SYSDATE,
    FOREIGN KEY (customer_id) REFERENCES customer(user_id),
    FOREIGN KEY (product_id) REFERENCES product(product_id)
);

CREATE TABLE wishlist (
    wishlist_id NUMBER PRIMARY KEY,
    user_id NUMBER,
    created_on DATE DEFAULT SYSDATE,
    FOREIGN KEY (user_id) REFERENCES customer(user_id)
);

CREATE TABLE wishlist_product (
    wishlist_id NUMBER,
    product_id NUMBER,
    PRIMARY KEY (wishlist_id, product_id),
    FOREIGN KEY (wishlist_id) REFERENCES wishlist(wishlist_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES product(product_id) ON DELETE CASCADE
);

CREATE TABLE cart (
    cart_id NUMBER PRIMARY KEY,
    user_id NUMBER UNIQUE,
    created_on DATE DEFAULT SYSDATE,
    FOREIGN KEY (user_id) REFERENCES customer(user_id)
);

CREATE TABLE cart_product (
    cart_id NUMBER,
    product_id NUMBER,
    quantity NUMBER,
    PRIMARY KEY (cart_id, product_id),
    FOREIGN KEY (cart_id) REFERENCES cart(cart_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES product(product_id) ON DELETE CASCADE
);

CREATE TABLE collection_slot (
    collection_slot_id NUMBER PRIMARY KEY,
    slot_day VARCHAR2(20),
    slot_time VARCHAR2(20),
    max_orders NUMBER DEFAULT 20,
    current_orders NUMBER DEFAULT 0
);

CREATE TABLE orders (
    order_id NUMBER PRIMARY KEY,
    cart_id NUMBER,
    user_id NUMBER,
    no_of_products NUMBER,
    total_cost NUMBER(10,2),
    collection_slot_id NUMBER,
    order_date DATE DEFAULT SYSDATE,
    FOREIGN KEY (cart_id) REFERENCES cart(cart_id),
    FOREIGN KEY (user_id) REFERENCES customer(user_id),
    FOREIGN KEY (collection_slot_id) REFERENCES collection_slot(collection_slot_id)
);

CREATE TABLE order_product (
    order_id NUMBER,
    product_id NUMBER,
    quantity NUMBER,
    PRIMARY KEY (order_id, product_id),
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES product(product_id)
);

CREATE TABLE payment (
    payment_id NUMBER PRIMARY KEY,
    order_id NUMBER,
    amount NUMBER(10,2),
    payment_method VARCHAR2(50),
    payment_status VARCHAR2(20),
    payment_date DATE DEFAULT SYSDATE,
    FOREIGN KEY (order_id) REFERENCES orders(order_id)
);

CREATE TABLE invoice (
    invoice_id NUMBER PRIMARY KEY,
    order_id NUMBER,
    issued_on DATE DEFAULT SYSDATE,
    FOREIGN KEY (order_id) REFERENCES orders(order_id)
);

CREATE TABLE report (
    report_id NUMBER PRIMARY KEY,
    user_id NUMBER,
    order_id NUMBER,
    report_type VARCHAR2(50),
    description VARCHAR2(500),
    report_date DATE DEFAULT SYSDATE,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (order_id) REFERENCES orders(order_id)
);

-- INSERT SAMPLE DATA
-- Insert sample users
INSERT INTO users (user_name, date_of_birth, contact_details, email, password, address, user_role) 
VALUES ('admin1', TO_DATE('1990-01-01', 'YYYY-MM-DD'), '1234567890', 'admin@example.com', 'admin123', 'Admin Address', 'admin');

INSERT INTO users (user_name, date_of_birth, contact_details, email, password, address, user_role) 
VALUES ('trader1', TO_DATE('1991-02-02', 'YYYY-MM-DD'), '2345678901', 'trader@example.com', 'trader123', 'Trader Address', 'trader');

INSERT INTO users (user_name, date_of_birth, contact_details, email, password, address, user_role) 
VALUES ('customer1', TO_DATE('1992-03-03', 'YYYY-MM-DD'), '3456789012', 'customer@example.com', 'customer123', 'Customer Address', 'customer');

-- Insert sample admin
INSERT INTO admin (user_id, admin_id, admin_type, contact_number)
SELECT user_id, 'ADM001', 'Super Admin', '1234567890'
FROM users WHERE user_name = 'admin1';

-- Insert sample trader
INSERT INTO trader (user_id, trader_id, trader_type, trader_status)
SELECT user_id, 'TRD001', 'Premium', 'Active'
FROM users WHERE user_name = 'trader1';

-- Insert sample customer
INSERT INTO customer (user_id, customer_id, contact_number)
SELECT user_id, 'CUST001', '3456789012'
FROM users WHERE user_name = 'customer1';

-- Insert sample shop
INSERT INTO shop (trader_id, shop_name, description, location, email)
SELECT user_id, 'Fresh Foods', 'Fresh and Organic Foods', 'Kathmandu', 'shop@example.com'
FROM users WHERE user_name = 'trader1';

-- Insert sample product categories
INSERT INTO product_category (product_name) VALUES ('Fruits');
INSERT INTO product_category (product_name) VALUES ('Vegetables');
INSERT INTO product_category (product_name) VALUES ('Dairy');

-- Insert sample products
INSERT INTO product (shop_id, product_category_id, product_name, description, price, brand, stock, allergy_info, image_url, min_order, max_order)
SELECT 
    s.shop_id,
    pc.product_category_id,
    'Organic Apples',
    'Fresh Organic Apples',
    2.99,
    'Organic Farms',
    100,
    'None',
    'images/apples.jpg',
    1,
    10
FROM shop s, product_category pc 
WHERE s.shop_name = 'Fresh Foods' AND pc.product_name = 'Fruits';

INSERT INTO product (shop_id, product_category_id, product_name, description, price, brand, stock, allergy_info, image_url, min_order, max_order)
SELECT 
    s.shop_id,
    pc.product_category_id,
    'Fresh Milk',
    'Organic Fresh Milk',
    3.99,
    'Dairy Farms',
    50,
    'Lactose',
    'images/milk.jpg',
    1,
    5
FROM shop s, product_category pc 
WHERE s.shop_name = 'Fresh Foods' AND pc.product_name = 'Dairy';

-- Insert sample collection slots
INSERT INTO collection_slot (slot_day, slot_time, max_orders, current_orders)
VALUES ('Monday', '10:00-13:00', 20, 0);

INSERT INTO collection_slot (slot_day, slot_time, max_orders, current_orders)
VALUES ('Monday', '13:00-16:00', 20, 0);

INSERT INTO collection_slot (slot_day, slot_time, max_orders, current_orders)
VALUES ('Monday', '16:00-19:00', 20, 0);

-- Insert sample discount
INSERT INTO discount (product_id, discount_percent, start_date, end_date)
SELECT 
    p.product_id,
    10,
    SYSDATE,
    SYSDATE + 30
FROM product p 
WHERE p.product_name = 'Organic Apples';

-- Insert sample cart
INSERT INTO cart (user_id)
SELECT user_id 
FROM users 
WHERE user_name = 'customer1';

-- Insert sample cart products
INSERT INTO cart_product (cart_id, product_id, quantity)
SELECT 
    c.cart_id,
    p.product_id,
    2
FROM cart c, product p, users u
WHERE u.user_name = 'customer1' 
AND c.user_id = u.user_id
AND p.product_name = 'Organic Apples';









