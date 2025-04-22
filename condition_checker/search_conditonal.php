<?php
$count = 0;
include 'connection.php';
$search_Cat = "";
$search_Txt = "";
$product_Category = "";
$traders = "";

if (isset($_GET['search_Cat']) || isset($_GET['search_Txt'])) {

    $search_Cat = $_GET['search_Cat'];

    @$search_Txt = $_GET['search_Txt'];


    if ($search_Txt == "" && $search_Cat == "all") {
        $query = "select * from product and product_verification='1'";
    } elseif ($search_Cat == "all" && $search_Txt) {
        $query = "select * from product where Product_Name LIKE'%$search_Txt%' and product_verification='1'";
    } elseif ($search_Cat && $search_Txt) {
        $query = "select * from product where Product_Name LIKE '%$search_Txt%' and Product_Type LIKE '%$search_Cat%' and product_verification='1'";
    } else {
        $query = "select * from product where Product_Type LIKE '%$search_Cat%' and product_verification='1'";
    }

    $result = oci_parse($connection, $query);
    oci_execute($result);

    while ($row = oci_fetch_assoc($result)) {
        $product_id[$count] = $row['PRODUCT_ID'];
        $product_type[$count] = $row['PRODUCT_TYPE'];
        $product_name[$count] = $row['PRODUCT_NAME'];
        $product_price[$count] = $row['PRODUCT_PRICE'];
        $product_details[$count] = $row['PRODUCT_DETAILS'];
        $stock[$count] = $row['STOCK'];
        $product_image[$count] = $row['PRODUCT_IMAGE'];
        $shop_id[$count] = $row['SHOP_ID'];
        $count = $count + 1;
    }
} elseif (isset($_POST['submit1'])) {
    $product_Category = $_POST['product_Category'];
    if ($product_Category) {

        $query = "select * from product where Product_Type LIKE '%$product_Category%' and product_verification='1'";

        $result = oci_parse($connection, $query);
        oci_execute($result);

        while ($row = oci_fetch_assoc($result)) {
            $product_id[$count] = $row['PRODUCT_ID'];
            $product_type[$count] = $row['PRODUCT_TYPE'];
            $product_name[$count] = $row['PRODUCT_NAME'];
            $product_price[$count] = $row['PRODUCT_PRICE'];
            $product_details[$count] = $row['PRODUCT_DETAILS'];
            $stock[$count] = $row['STOCK'];
            $product_image[$count] = $row['PRODUCT_IMAGE'];
            $shop_id[$count] = $row['SHOP_ID'];
            $count = $count + 1;
        }
    }
} elseif (isset($_POST['submit2'])) {
    $traders = $_POST['traders'];
    if ($traders) {

        $query = "select * from trader,shop,product where Name LIKE '%$traders%' and trader.Trader_Id = shop.Trader_id and shop.Shop_Id = product.Shop_Id and trader_verification ='1' and product_verification='1'";

        $result = oci_parse($connection, $query);
        oci_execute($result);

        while ($row = oci_fetch_assoc($result)) {
            $product_id[$count] = $row['PRODUCT_ID'];
            $product_type[$count] = $row['PRODUCT_TYPE'];
            $product_name[$count] = $row['PRODUCT_NAME'];
            $product_price[$count] = $row['PRODUCT_PRICE'];
            $product_details[$count] = $row['PRODUCT_DETAILS'];
            $stock[$count] = $row['STOCK'];
            $product_image[$count] = $row['PRODUCT_IMAGE'];
            $shop_id[$count] = $row['SHOP_ID'];
            $count = $count + 1;
        }
    }
} else {
    header('Location:search_product.php?search_Txt=&search_Cat=all');
    exit();
}
