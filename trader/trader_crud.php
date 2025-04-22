<?php include '../start.php';
if (!isset($_SESSION['trader_username'])) {
    header('Location:sign_in_trader.php');
    exit();
}
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
    echo "<script>alert('" . $msg . "');</script>";
} else {
    echo "";
}
?>
<style type="text/css">



</style>

<?php include 'theader.php'; ?>
<div class="container mt-3">


    <?php

    if (isset($_SESSION['msg'])) {
        echo "<h4 style='text-align: center; color:green;'>" . $_SESSION['msg'] . "</h4>";
    }

    ?>


    <div class="row">
        <div class=" col-lg-12 col-12  ">

            <h3>Product Overview</h3>




        </div>
    </div>
    <div class="row">

        <div class="col-lg-12">All Products</div>

    </div>

    <div class="row mt-2">

        <div class="col-2 ">
            <a href="addproduct.php">
                <button type="button" class="btn btn-primary">Add Products</button>
            </a>

        </div>



        <div class="col-lg-2    ml-auto d-flex justify-content-end  ">Sort by</div>

        <div class="col-lg-2    ">
            <select id="sort" class="selectpicker form-control  ">
                <option value="All">All</option>
            </select>
        </div>







    </div>

    <div class="row mt-3">
        <div class="col-xl-12 w-100">
            <table border=1 cellpadding=5 cellspacing=5 class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">SN</th>
                        <th scope="col">Product Image</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Price</th>
                        <th scope="col">Stock</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>

                <?php
                $sn = 1;
                $i = 0;

                include 'connection.php';

                $trader_id = $_SESSION['trader_id'];

                $sql = "SELECT * FROM product, trader, shop where '$trader_id' = trader.Trader_id and trader.Trader_id = shop.Trader_id and shop.Shop_Id = product.Shop_Id";

                $result = oci_parse($connection, $sql);
                oci_execute($result);

                $count = oci_fetch_all($result,$connection);
                oci_execute($result);

                if ($count >= 1) {

                    while ($row = oci_fetch_assoc($result)) {
                        $product_id[$i] = $row['PRODUCT_ID'];
                        $product_image[$i] = $row['PRODUCT_IMAGE'];
                        $product_name[$i] = $row['PRODUCT_NAME'];
                        $product_category[$i] = $row['PRODUCT_TYPE'];
                        $price[$i] = $row['PRODUCT_PRICE'];
                        $stock[$i] = $row['STOCK'];
                        $verify[$i] = $row['PRODUCT_VERIFICATION'];
                        echo "<tbody>

        <tr class='border'>

        <th scope='row'>" . $sn . "</th>
      
        <td><img src='../" . $product_image[$i] . "' class='img-fluid mx-auto d-block' style='width: 10vw; '  ></td>
        <td class='text-center'>" . $product_name[$i] . "</td>
        <td>" . $product_category[$i] . "</td>
        <td>" . $price[$i] . "</td>
        <td>" . $stock[$i] . "</td>
        <td>";
                        if ($verify[$i] == 1) {
                            echo "Approved";
                        } else {
                            echo "Pending";
                        }
                        echo "</td>
        
        <td style=' vertical-align: middle;'><a href='editproducts.php?productID=" . $product_id[$i] . "' class='btn btn-primary'>Edit</a><br><a href='deleteproducts.php?productID=" . $product_id[$i] . "' class='btn btn-danger mt-1'>Delete</a></td>
        </tr>



        </tbody>";
                        $sn++;
                        $i++;
                    }
                } else {
                    echo "<script> alert('No Products Found');</script>";
                }


                ?>


            </table>


        </div>


    </div>
</div>


<?php
unset($_SESSION['msg']);
include '../end.php'; ?>