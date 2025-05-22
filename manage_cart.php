<?php
session_start();

if (isset($_GET['d'])) {
    // Clear cart from database
    if (isset($_SESSION['username'])) {
        include('connection.php');
        $username = $_SESSION['username'];
        
        // Get user_id and cart_id
        $sql = "SELECT u.user_id, ct.cart_id 
                FROM users u 
                JOIN customer c ON u.user_id = c.user_id 
                JOIN cart ct ON c.user_id = ct.user_id 
                WHERE u.user_name = :username";
        $stmt = oci_parse($connection, $sql);
        oci_bind_by_name($stmt, ':username', $username);
        oci_execute($stmt);
        
        if ($row = oci_fetch_assoc($stmt)) {
            $cart_id = $row['CART_ID'];
            
            // Delete cart products
            $sql2 = "DELETE FROM cart_product WHERE cart_id = :cart_id";
            $stmt2 = oci_parse($connection, $sql2);
            oci_bind_by_name($stmt2, ':cart_id', $cart_id);
            oci_execute($stmt2);
            
            if ($stmt2) {
                echo "<script>
                    alert('Cart Cleared');
                    window.location.href='index.php';
                </script>";
            } else {
                echo "<script>
                    alert('Error clearing cart');
                    window.location.href='index.php';
                </script>";
            }
        }
    }
}

if (isset($_POST['clear_cart'])) {
    unset($_SESSION['cart']);
    echo " <script>
    alert('Cart Cleared');
    window.location.href='index.php';
    </script>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['addtoCart'])) {
        if (isset($_SESSION['username'])) {
            include('connection.php');
            $username = $_SESSION['username'];
            $item_name = $_POST['itemname'];
            $quantity = $_POST['quantity'];
            
            // Get user_id
            $sql = "SELECT u.user_id 
                    FROM users u 
                    JOIN customer c ON u.user_id = c.user_id 
                    WHERE u.user_name = :username";
            $stmt = oci_parse($connection, $sql);
            oci_bind_by_name($stmt, ':username', $username);
            oci_execute($stmt);
            
            if ($row = oci_fetch_assoc($stmt)) {
                $user_id = $row['USER_ID'];
                
                // Get product_id
                $sql2 = "SELECT product_id FROM product WHERE product_name = :item_name";
                $stmt2 = oci_parse($connection, $sql2);
                oci_bind_by_name($stmt2, ':item_name', $item_name);
                oci_execute($stmt2);
                
                if ($row2 = oci_fetch_assoc($stmt2)) {
                    $product_id = $row2['PRODUCT_ID'];
                    
                    // Check if cart exists
                    $sql3 = "SELECT cart_id FROM cart WHERE user_id = :user_id";
                    $stmt3 = oci_parse($connection, $sql3);
                    oci_bind_by_name($stmt3, ':user_id', $user_id);
                    oci_execute($stmt3);
                    
                    if ($row3 = oci_fetch_assoc($stmt3)) {
                        $cart_id = $row3['CART_ID'];
                        
                        // Check if product already in cart
                        $sql4 = "SELECT * FROM cart_product WHERE cart_id = :cart_id AND product_id = :product_id";
                        $stmt4 = oci_parse($connection, $sql4);
                        oci_bind_by_name($stmt4, ':cart_id', $cart_id);
                        oci_bind_by_name($stmt4, ':product_id', $product_id);
                        oci_execute($stmt4);
                        
                        if (oci_fetch_assoc($stmt4)) {
                            echo "<script>
                                alert('Item Already Added');
                                window.location.href='product_details.php?product_id=$product_id';
                            </script>";
                        } else {
                            // Add product to cart
                            $sql5 = "INSERT INTO cart_product(cart_id, product_id, quantity) 
                                    VALUES (:cart_id, :product_id, :quantity)";
                            $stmt5 = oci_parse($connection, $sql5);
                            oci_bind_by_name($stmt5, ':cart_id', $cart_id);
                            oci_bind_by_name($stmt5, ':product_id', $product_id);
                            oci_bind_by_name($stmt5, ':quantity', $quantity);
                            oci_execute($stmt5);
                            
                            if ($stmt5) {
                                echo "<script>
                                    alert('Item Added');
                                    window.location.href='cart.php';
                                </script>";
                            }
                        }
                    } else {
                        // Create new cart
                        $sql6 = "INSERT INTO cart(user_id) VALUES (:user_id)";
                        $stmt6 = oci_parse($connection, $sql6);
                        oci_bind_by_name($stmt6, ':user_id', $user_id);
                        oci_execute($stmt6);
                        
                        if ($stmt6) {
                            // Get new cart_id
                            $sql7 = "SELECT cart_id FROM cart WHERE user_id = :user_id";
                            $stmt7 = oci_parse($connection, $sql7);
                            oci_bind_by_name($stmt7, ':user_id', $user_id);
                            oci_execute($stmt7);
                            
                            if ($row7 = oci_fetch_assoc($stmt7)) {
                                $cart_id = $row7['CART_ID'];
                                
                                // Add product to new cart
                                $sql8 = "INSERT INTO cart_product(cart_id, product_id, quantity) 
                                        VALUES (:cart_id, :product_id, :quantity)";
                                $stmt8 = oci_parse($connection, $sql8);
                                oci_bind_by_name($stmt8, ':cart_id', $cart_id);
                                oci_bind_by_name($stmt8, ':product_id', $product_id);
                                oci_bind_by_name($stmt8, ':quantity', $quantity);
                                oci_execute($stmt8);
                                
                                if ($stmt8) {
                                    echo "<script>
                                        alert('Item Added');
                                        window.location.href='cart.php';
                                    </script>";
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    if (isset($_POST['Mod_Quantity'])) {  //while refreshing page , quantity value was reseting so to fix
        foreach ($_SESSION['cart'] as $key => $value) {  //from here we get index value of array  , only key then whole data aaray shows if value added then index
            //print_r($key) ;
            if ($value['item_name'] == $_GET['value']) {
                $_SESSION['cart'][$key]['quantity'] = $_POST['Mod_Quantity']; //cart ko key index ko quantity laii post bata send gareko value ma chnage garne
            }
        }
    }
} else {
    echo "";
}

if (isset($_GET['value'])) {
    // Remove item from cart
    if (isset($_SESSION['username'])) {
        include('connection.php');
        $username = $_SESSION['username'];
        $item_name = $_GET['value'];
        
        // Get user_id and cart_id
        $sql = "SELECT u.user_id, ct.cart_id 
                FROM users u 
                JOIN customer c ON u.user_id = c.user_id 
                JOIN cart ct ON c.user_id = ct.user_id 
                WHERE u.user_name = :username";
        $stmt = oci_parse($connection, $sql);
        oci_bind_by_name($stmt, ':username', $username);
        oci_execute($stmt);
        
        if ($row = oci_fetch_assoc($stmt)) {
            $cart_id = $row['CART_ID'];
            
            // Get product_id
            $sql2 = "SELECT product_id FROM product WHERE product_name = :item_name";
            $stmt2 = oci_parse($connection, $sql2);
            oci_bind_by_name($stmt2, ':item_name', $item_name);
            oci_execute($stmt2);
            
            if ($row2 = oci_fetch_assoc($stmt2)) {
                $product_id = $row2['PRODUCT_ID'];
                
                // Delete from cart_product
                $sql3 = "DELETE FROM cart_product 
                        WHERE cart_id = :cart_id AND product_id = :product_id";
                $stmt3 = oci_parse($connection, $sql3);
                oci_bind_by_name($stmt3, ':cart_id', $cart_id);
                oci_bind_by_name($stmt3, ':product_id', $product_id);
                oci_execute($stmt3);
                
                if ($stmt3) {
                    echo "<script>
                        alert('Item Removed');
                        window.location.href='cart.php';
                    </script>";
                } else {
                    echo "<script>
                        alert('Error removing item');
                        window.location.href='cart.php';
                    </script>";
                }
            }
        }
    }
}
?>
