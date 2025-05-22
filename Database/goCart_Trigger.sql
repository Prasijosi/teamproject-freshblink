-- CREATE TRIGGERS
CREATE OR REPLACE TRIGGER trg_user_id
BEFORE INSERT ON users
FOR EACH ROW
BEGIN
  SELECT seq_user_id.NEXTVAL INTO :new.user_id FROM dual;
END;
/

CREATE OR REPLACE TRIGGER trg_shop_id
BEFORE INSERT ON shop
FOR EACH ROW
BEGIN
  SELECT seq_shop_id.NEXTVAL INTO :new.shop_id FROM dual;
END;
/

CREATE OR REPLACE TRIGGER trg_product_category_id
BEFORE INSERT ON product_category
FOR EACH ROW
BEGIN
  SELECT seq_product_category_id.NEXTVAL INTO :new.product_category_id FROM dual;
END;
/

CREATE OR REPLACE TRIGGER trg_product_id
BEFORE INSERT ON product
FOR EACH ROW
BEGIN
  SELECT seq_product_id.NEXTVAL INTO :new.product_id FROM dual;
END;
/

CREATE OR REPLACE TRIGGER trg_review_id
BEFORE INSERT ON review
FOR EACH ROW
BEGIN
  SELECT seq_review_id.NEXTVAL INTO :new.review_id FROM dual;
END;
/

CREATE OR REPLACE TRIGGER trg_wishlist_id
BEFORE INSERT ON wishlist
FOR EACH ROW
BEGIN
  SELECT seq_wishlist_id.NEXTVAL INTO :new.wishlist_id FROM dual;
END;
/

CREATE OR REPLACE TRIGGER trg_cart_id
BEFORE INSERT ON cart
FOR EACH ROW
BEGIN
  SELECT seq_cart_id.NEXTVAL INTO :new.cart_id FROM dual;
END;
/

CREATE OR REPLACE TRIGGER trg_order_id
BEFORE INSERT ON orders
FOR EACH ROW
BEGIN
  SELECT seq_order_id.NEXTVAL INTO :new.order_id FROM dual;
END;
/

CREATE OR REPLACE TRIGGER trg_payment_id
BEFORE INSERT ON payment
FOR EACH ROW
BEGIN
  SELECT seq_payment_id.NEXTVAL INTO :new.payment_id FROM dual;
END;
/

CREATE OR REPLACE TRIGGER trg_invoice_id
BEFORE INSERT ON invoice
FOR EACH ROW
BEGIN
  SELECT seq_invoice_id.NEXTVAL INTO :new.invoice_id FROM dual;
END;
/

CREATE OR REPLACE TRIGGER trg_discount_id
BEFORE INSERT ON discount
FOR EACH ROW
BEGIN
  SELECT seq_discount_id.NEXTVAL INTO :new.discount_id FROM dual;
END;
/

CREATE OR REPLACE TRIGGER trg_report_id
BEFORE INSERT ON report
FOR EACH ROW
BEGIN
  SELECT seq_report_id.NEXTVAL INTO :new.report_id FROM dual;
END;
/

CREATE OR REPLACE TRIGGER trg_slot_id
BEFORE INSERT ON collection_slot
FOR EACH ROW
BEGIN
  SELECT seq_slot_id.NEXTVAL INTO :new.collection_slot_id FROM dual;
END;
/

-- =========================================
--           FRESHBLINK INTEGRATED TRIGGERS
-- =========================================

-- 1. CHECK PRODUCT QUANTITY IN ORDER_PRODUCT
CREATE OR REPLACE TRIGGER trg_check_order_quantity
BEFORE INSERT OR UPDATE ON order_product
FOR EACH ROW
BEGIN
  IF :NEW.quantity < 1 OR :NEW.quantity > 20 THEN
    RAISE_APPLICATION_ERROR(-20010, 'Quantity must be between 1 and 20.');
  END IF;
END;
/

-- 2. VALIDATE EMAIL FORMAT ON USERS
CREATE OR REPLACE TRIGGER trg_check_email
BEFORE INSERT OR UPDATE ON users
FOR EACH ROW
BEGIN
  IF REGEXP_COUNT(:NEW.email, '@') != 1 OR NOT REGEXP_LIKE(:NEW.email, '^[^@]+@gmail\.com$') THEN
    RAISE_APPLICATION_ERROR(-20011, 'Email must be a valid Gmail address (e.g., example@gmail.com)');
  END IF;
END;
/

-- 3. VALIDATE PHONE NUMBER FORMAT ON USERS
CREATE OR REPLACE TRIGGER trg_check_phone
BEFORE INSERT OR UPDATE ON users
FOR EACH ROW
BEGIN
  IF LENGTH(:NEW.contact_details) != 10 OR NOT REGEXP_LIKE(:NEW.contact_details, '^[0-9]+$') THEN
    RAISE_APPLICATION_ERROR(-20012, 'Phone number must be exactly 10 digits.');
  END IF;
END;
/

-- 4. CHECK DATE LOGIC FOR DISCOUNT
CREATE OR REPLACE TRIGGER trg_check_discount_dates
BEFORE INSERT OR UPDATE ON discount
FOR EACH ROW
BEGIN
  IF :NEW.end_date < :NEW.start_date THEN
    RAISE_APPLICATION_ERROR(-20013, 'Discount end date cannot be earlier than start date.');
  END IF;
END;
/

-- 5. AUTO-SET DATE FIELDS FOR WISHLIST
CREATE OR REPLACE TRIGGER trg_date_wishlist
BEFORE INSERT ON wishlist
FOR EACH ROW
BEGIN
  :NEW.created_on := SYSDATE;
END;
/

-- 6. AUTO-SET REVIEW DATE
CREATE OR REPLACE TRIGGER trg_date_review
BEFORE INSERT ON review
FOR EACH ROW
BEGIN
  :NEW.review_date := TRUNC(SYSDATE);
END;
/

-- 7. ENFORCE ROLE CHECK TRIGGERS
CREATE OR REPLACE TRIGGER trg_check_admin_role
BEFORE INSERT ON admin
FOR EACH ROW
DECLARE
  v_role users.user_role%TYPE;
BEGIN
  SELECT user_role INTO v_role FROM users WHERE user_id = :NEW.user_id;
  IF v_role != 'admin' THEN
    RAISE_APPLICATION_ERROR(-20001, 'User is not assigned admin role.');
  END IF;
END;
/

CREATE OR REPLACE TRIGGER trg_check_trader_role
BEFORE INSERT ON trader
FOR EACH ROW
DECLARE
  v_role users.user_role%TYPE;
BEGIN
  SELECT user_role INTO v_role FROM users WHERE user_id = :NEW.user_id;
  IF v_role != 'trader' THEN
    RAISE_APPLICATION_ERROR(-20002, 'User is not assigned trader role.');
  END IF;
END;
/

CREATE OR REPLACE TRIGGER trg_check_customer_role
BEFORE INSERT ON customer
FOR EACH ROW
DECLARE
  v_role users.user_role%TYPE;
BEGIN
  SELECT user_role INTO v_role FROM users WHERE user_id = :NEW.user_id;
  IF v_role != 'customer' THEN
    RAISE_APPLICATION_ERROR(-20003, 'User is not assigned customer role.');
  END IF;
END;
/

-- 8. PREVENT OUT-OF-STOCK ORDER
CREATE OR REPLACE TRIGGER trg_prevent_out_of_stock
BEFORE INSERT ON order_product
FOR EACH ROW
DECLARE
  v_stock NUMBER;
BEGIN
  SELECT stock INTO v_stock FROM product WHERE product_id = :NEW.product_id;
  IF v_stock < :NEW.quantity THEN
    RAISE_APPLICATION_ERROR(-20014, 'Cannot order product: not enough stock.');
  END IF;
END;
/

-- 9. SET DEFAULT PAYMENT METHOD AND FIELDS
CREATE OR REPLACE TRIGGER trg_date_payment
BEFORE INSERT ON payment
FOR EACH ROW
BEGIN
  IF :NEW.payment_method IS NULL THEN
    :NEW.payment_method := 'PayPal';
  END IF;
END;
/

-- 10. INVOICE: AUTOSET DATE
CREATE OR REPLACE TRIGGER trg_date_invoice
BEFORE INSERT OR UPDATE ON invoice
FOR EACH ROW
BEGIN
  IF INSERTING THEN
    :NEW.issued_on := SYSDATE;
  END IF;
END;
/

-- 11. REPORT: SET report_date
CREATE OR REPLACE TRIGGER trg_date_report
BEFORE INSERT ON report
FOR EACH ROW
BEGIN
  :NEW.report_date := SYSDATE;
END;
/
