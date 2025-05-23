import serial
import oracledb
from datetime import datetime

oracledb.init_oracle_client(lib_dir=r"C:\oracle\instantclient_19_11")

# Arduino Serial Port Settings
SERIAL_PORT = 'COM3'  # Update with your actual COM port
BAUD_RATE = 9600

# Oracle DB Connection
DB_USER = "admin"
DB_PASS = "Tester2!"
DB_CONN = "localhost/XE"   
 

def get_serial_uid():
    try:
        arduino = serial.Serial(SERIAL_PORT, BAUD_RATE, timeout=10)
        print("Waiting for RFID UID scan...")
        while True:
            line = arduino.readline().decode('utf-8').strip()
            if line.startswith("RFID Tag UID:"):
                uid = line.replace("RFID Tag UID:", "").strip()
                arduino.close()
                return uid
    except serial.SerialException as e:
        print(f"Error reading serial port: {e}")
        return None

def check_uid_exists(cursor, uid):
    # Check by product name or other unique attributes as PRODUCT_UID doesn't exist
    cursor.execute("SELECT COUNT(*) FROM PRODUCT WHERE DESCRIPTION = :1", (uid,))
    result = cursor.fetchone()
    return result[0] > 0

def insert_product(cursor, uid):
    print("Enter product details:")
    # Product_Id will be auto-generated from sequence starting at 1100
    product_type = input("Product Type (e.g., Bakery, Butcher, etc.): ")
    product_name = input("Product Name: ")
    product_price = float(input("Price: "))
    product_details = input("Product Details: ")
    stock = int(input("Stock Quantity: "))
    product_image = input("Product Image path (e.g., images/bakery_01.png): ")
    shop_id = input("Shop ID: ")
    product_verification = input("Product Verification (0 or 1): ") or 0

    # Save UID in product details if needed
    product_details_with_uid = f"{product_details} (RFID: {uid})"

    sql = """
        INSERT INTO Product (
            Product_Id, Product_Type, Product_Name, Product_Price,
            Product_Details, Stock, Product_Image, Shop_Id, Product_Verification
        ) VALUES (
            Product_Id_seq.NEXTVAL, :product_type, :product_name, :product_price,
            :product_details, :stock, :product_image, :shop_id, :product_verification
        )
    """
    cursor.execute(sql, {
        'product_type': product_type,
        'product_name': product_name,
        'product_price': product_price,
        'product_details': product_details_with_uid,
        'stock': stock,
        'product_image': product_image,
        'shop_id': shop_id,
        'product_verification': product_verification
    })

def main():
    try:
        conn = oracledb.connect(user=DB_USER, password=DB_PASS, dsn=DB_CONN)
        cursor = conn.cursor()
        print("Connected to Oracle DB successfully.")
    except oracledb.DatabaseError as e:
        print(f"Database connection error: {e}")
        return

    try:
        while True:
            uid = get_serial_uid()
            if not uid:
                print("No UID read. Try again.")
                continue

            print(f"Scanned UID: {uid}")

            if check_uid_exists(cursor, uid):
                print("Item already in the database. Please scan a unique item.")
            else:
                print("UID is new. Let's add the product.")
                insert_product(cursor, uid)
                conn.commit()
                print("🎉 Product inserted successfully.")

            cont = input("Scan another? (y/n): ")
            if cont.lower() != 'y':
                break
    except KeyboardInterrupt:
        print("\nProcess interrupted by user.")
    finally:
        cursor.close()
        conn.close()
        print("Connection closed.")

if __name__ == "__main__":
    main()

