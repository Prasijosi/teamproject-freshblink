<?php include '../start.php' ?>

<?php
include 'theader.php';

if (!isset($_SESSION['trader_username'])) {
    header('Location:sign_in_trader.php');
    exit();
}

?>

<div class="container mt-3">
    <div class="row">
        <div class=" col-lg-12 col-12  ">
            <h3>Shop Overview</h3>
        </div>
    </div>
    <div class="row ">
        <div class="col-lg-12 ">All Shop</div>
    </div>

    <div class="row mt-2">
        <div class="col-2 ">
            <button type="button" class="btn btn-outline-primary">
                <a href="addshop.php" class="link-warning">Add Shop</a>
            </button>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-xl-12">
            <table class="table table-responsive-sm ">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">S ID</th>
                        <th scope="col">Shop Name</th>
                        <th scope="col">Shop Description</th>
                        <th scope="col">Location</th>
                        <th scope="col">Phone</th>
                    </tr>

                </thead>
                <tbody>
                    <?php
                    include 'connection.php';

                    $tn = $_SESSION['trader_username'];

                    $sql = "SELECT * FROM trader where Username='$tn' ";
                    $qry = oci_parse($connection, $sql);
                    oci_execute($qry);
                    while ($row = oci_fetch_assoc($qry)) {
                        $tid = $row['TRADER_ID'];
                        $tcontact = $row['CONTACT'];
                        $sql1 = "SELECT * FROM shop where Trader_id='$tid' and Shop_Verification='1' ";
                        $qry1 = oci_parse($connection, $sql1);
                        oci_execute($qry1);
                        $sid = 0;
                        while ($row = oci_fetch_assoc($qry1)) {
                            $sid = $sid + 1;

                            $sname = $row['SHOP_NAME'];
                            $sdesc = $row['SHOP_DESCRIPTION'];
                            $sloc = $row['SHOP_LOCATION'];
                            echo "      <tr class='border'>

       <th scope='row'>$sid</th>
       <td>$sname</td>
       <td>$sdesc</td>
       <td>$sloc</td>
       <td>$tcontact</td>

       </tr>";
                        }
                    }

                    ?>

















                </tbody>


            </table>


        </div>


    </div>
</div>





<?php include '../end.php'; ?>