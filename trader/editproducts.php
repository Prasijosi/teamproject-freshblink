<?php include '../start.php';
if (!isset($_SESSION['trader_username'])) {
    header('Location:sign_in_trader.php');
    exit();
}

include 'connection.php';

if (isset($_GET['productID'])) {

    $productID = $_GET['productID'];

    $sql = "select *  from product, shop where product.Product_Id='$productID' and product.Shop_Id = shop.Shop_Id";

    $result = oci_parse($connection, $sql);
    oci_execute($result);

    while ($row = oci_fetch_assoc($result)) {
        $shop_name =  $row['SHOP_NAME'];
        $product_id = $row['PRODUCT_ID'];
        $product_name = $row['PRODUCT_NAME'];
        $product_category = $row['PRODUCT_TYPE'];
        $product_details = $row['PRODUCT_DETAILS'];
        $product_price = $row['PRODUCT_PRICE'];
        $stock = $row['STOCK'];
        $product_image = $row['PRODUCT_IMAGE'];
    }
}

if (isset($_POST['submit1'])) {

    $productID = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $pprice = $_POST['product_price'];
    $pdetails = $_POST['product_details'];
    $pstock = $_POST['stock'];

    $Product_Image = $_FILES['product_image'];
    $filename = $Product_Image['name'];
    $fileerror = $Product_Image['error'];
    $filetmp = $Product_Image['tmp_name'];

    $imgext = explode('.', $filename);
    $filecheck = strtolower(end($imgext));
    $fileextstored = array('png', 'jpg', 'jpeg');

    if (in_array($filecheck, $fileextstored)) {
        $destinationfile = 'images/' . $filename;
        $destinationfile1 = '../images/' . $filename;
        move_uploaded_file($filetmp, $destinationfile1);

        $sql1 = "UPDATE product SET Product_Name='$product_name' , Product_Price='$pprice' , Product_Details='$pdetails' , Stock='$pstock', Product_Image = '$destinationfile' where Product_Id='$productID'";

        $result1 = oci_parse($connection, $sql1);
        oci_execute($result1);

        if ($result1) {
            header('Location:trader_crud.php?msg=Product Successfully Edited');
            exit();
        } else {
            header('Location:trader_crud.php?msg=Sql Not Running');
            exit();
        }
    } else {
        header('trader_crud.php?msg=Location:trader_crud.php?msg=Error while Uploading Image!');
        exit();
    }
}
?>
<div class="container">
    <?php include 'theader.php'; ?>
    <div class="container w-100 d-flex align-items-center justify-content-center">
        <div class="row mt-2">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-left mt-1">
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-left mt-1">
                <form class="border p-5 mt-1 w-100" method="POST" action="editproducts.php?productID=<?php echo $productID ?>" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-left">
                            <div class="h4 mt-3">Edit Product
                                <h6 class="mt-3">Basic Information</h6>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <label for="shop_name">Shop Name</label>
                        <input type="text" class="form-control" id="shop_name" placeholder="Shop Name" disabled="disabled" name="shop_name" value="<?php echo $shop_name ?>">
                    </div>
                    <div class="form-group mt-1">
                        <label for="product_name">Product Name</label>
                        <input type="hidden" class="form-control" id="product_id" placeholder="Product id" name="product_id" value="<?php echo $product_id ?>">
                        <input type="text" class="form-control" id="product_name" placeholder="Product Name" name="product_name" value="<?php echo $product_name ?>">
                    </div>
                    <div class="form-group">
                        <label for="product_category">Product Category</label>
                        <input type="text" class="form-control" id="product_category" placeholder="Product Category" disabled="disabled" name="product_category" value="<?php echo $product_category ?>">
                    </div>
                    <div class="form-group">
                        <div class="my-3">
                            <label for="product_details" class="form-label">Product Details</label>
                            <textarea class="form-control" id="product_details" rows="3" name="product_details"><?php echo $product_details ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="product_price" class="form-label">Product Price</label>
                            <input type="number" class="form-control" id="product_price" placeholder="Product Price" name="product_price" value="<?php echo $product_price ?>">
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="number" class="form-control" id="stock" placeholder="Stock" name="stock" value="<?php echo $stock ?>">
                        </div>
                    </div>
                    <div class="form-group mx-auto mt-2">
                        <label for="product_image">Product Image</label>
                        <br>
                        <input type="file" id="file" name="product_image" required value="<?php echo $product_image ?>">
                    </div>
                    <br>
                    <div class="form-group row">
                        </br>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center ml-2">
                            <button type="submit" class="btn btn-success" name="submit1">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include '../end.php'; ?>