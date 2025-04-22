<?php include '../start.php';
if (!isset($_SESSION['trader_username'])) {
  header('Location:sign_in_trader.php');
  exit();
}
?>
<style>
  /*
*{
    background-color: #ffffff;
    
   
    font-size: 1.171303074670571vw;

   
}
 */



  thead th {

    font-size: 16px;
  }


  tbody td {
    font-size: 16px;
    height: 20px;
  }

  tr td {


    height: 150px;
  }
</style>




<?php include 'theader.php'; ?>

<div class="container mt-3">

  <div class="row">
    <div class=" col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">


      <h3>Order Overview</h3>



    </div>
  </div>
  <div class="row">

    <?php
    include('connection.php');

    $tn = $_SESSION['trader_username'];

    $sql2 = "SELECT * FROM trader where Username='$tn' ";
    $qry2 = oci_parse($connection, $sql2);
    oci_execute($qry2);

    while ($row = oci_fetch_assoc($qry2)) {
      $tid = $row['TRADER_ID'];
    }
    $sql = "SELECT * FROM orders, product, shop,TIME_SLOT  where shop.Shop_Id=product.Shop_Id AND orders.Product_Id=product.Product_Id and orders.order_id=time_slot.order_id and shop.Trader_id='$tid'  ";
    $qry = oci_parse($connection, $sql);
    oci_execute($qry);
    $count2 = oci_fetch_all($qry, $connection);
    oci_execute($qry);

    echo " 

<div class='col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-start h6  '>$count2 Orders</div>
";
    ?>

    <form method="POST" action="#" class="ml-auto d-flex justify-content-end  ">
      <span class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center justify-content-end h6  mt-1">Sort By:</span>
      <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
        <select id="sort" class="selectpicker form-control  " name="cat">
          <option value="DESC" <?php echo (isset($_POST['cat']) && $_POST['cat'] == "DESC") ? 'selected="selected"' : ''; ?>>Recent Orders</option>
          <option value="ASC" <?php echo (isset($_POST['cat']) && $_POST['cat'] == "ASC") ? 'selected="selected"' : ''; ?>>Old Orders</option>


        </select>
      </div>
      <button class="btn btn-secondary" style="background-color:#212529; color: white;">Go</button>
    </form>










  </div>

  <div class='row mt-3'>
    <div class='col-md-12'>
      <table class='table table-responsive-sm'>
        <thead class='thead-dark'>
          <tr>
            <th>SN</th>
            <th>Order Date</th>
            <th>Order ID</th>
            <th>Product Information</th>
            <th>Collection SLot</th>
            <th>Buyer Details</th>
            <th>Quantity</th>
            <th>Total</th>
            <th>Status</th>
          </tr>

        </thead>

        <tbody>
          <?php
          include('connection.php');

          $tn = $_SESSION['trader_username'];

          $sql2 = "SELECT * FROM trader where Username='$tn' ";
          $qry2 = oci_parse($connection, $sql2);
          oci_execute($qry2);

          while ($row = oci_fetch_assoc($qry2)) {
            $tid = $row['TRADER_ID'];






            if (isset($_POST['cat'])) {
              $c = $_POST['cat'];




              if ($c == "DESC") {
                $s = "DESC";
              } elseif ($c == "ASC") {
                $s = "ASC";
              } else {
                $s = "";
              }


              $sql = "SELECT * FROM orders, product, shop,TIME_SLOT where shop.Shop_Id=product.Shop_Id AND orders.Product_Id=product.Product_Id and orders.order_id=time_slot.order_id and shop.Trader_id='$tid' ORDER BY Order_Date $s  ";
              $qry = oci_parse($connection, $sql);
              oci_execute($qry);

              $count2 = oci_fetch_all($qry, $connection);
              oci_execute($qry);

              $sn = 0;







              while ($row = oci_fetch_assoc($qry)) {


                $oid = $row['ORDER_ID'];
                $odate = $row['ORDER_DATE'];
                $quantity = $row['QUANTITY'];
                $total = $row['ORDER_PRICE'];
                $cid = $row['CUSTOMER_ID'];
                $pid = $row['PRODUCT_ID'];
                $pname = $row['PRODUCT_NAME'];
                $ds = $row['DELIVERY_STATUS'];
                $time=$row['TIME_SLOT_DATE'];

                include 'connection.php';

                $sql1 = "SELECT * FROM customer where Customer_ID ='$cid' ";
                $qry1 = oci_parse($connection, $sql1);
                oci_execute($qry1);

                while ($row = oci_fetch_assoc($qry1)) {
                  $cname = $row['USERNAME'];

                  echo " 
          <tr>
          ";

          ?>


                  <td><?php
                      $sn = $sn + 1;
                      echo $sn


                      ?></td>
                  <?php
                  echo " 
          <td>$odate</td>
          <td>$oid</td>
          <td>$pname</td>
          <td>$time</td>
          <td>$cname</td>
          <td>$quantity</td>
          <td>$total</td>
          <td> ";

                  if ($ds == 1) {
                    $d = 1;
                    echo " <a href='trader_delivery_status.php?orderID=$oid&d=$d' class='btn btn-success'>Delivered</a>";
                  } else {
                    $d = 0;
                    echo " <a href='trader_delivery_status.php?orderID=$oid&d=$d' class='btn btn-danger'>Not Delivered</a>";
                  }



                  echo " </td>

      </tr>
      ";
                }
              }
            } else {

              $sql = "SELECT * FROM orders, product, shop,TIME_SLOT where shop.Shop_Id=product.Shop_Id AND orders.Product_Id=product.Product_Id and orders.order_id=time_slot.order_id and shop.Trader_id='$tid'  ";
              $qry = oci_parse($connection, $sql);
              oci_execute($qry);
              $count2 = oci_fetch_all($qry, $connection);
              oci_execute($qry);

              $sn = 0;







              while ($row = oci_fetch_assoc($qry)) {


                $oid = $row['ORDER_ID'];
                $odate = $row['ORDER_DATE'];
                $quantity = $row['QUANTITY'];
                $total = $row['ORDER_PRICE'];
                $cid = $row['CUSTOMER_ID'];
                $pid = $row['PRODUCT_ID'];
                $pname = $row['PRODUCT_NAME'];
                $ds = $row['DELIVERY_STATUS'];
                $time=$row['TIME_SLOT_DATE'];


                include 'connection.php';

                $sql1 = "SELECT * FROM customer where Customer_ID ='$cid' ";
                $qry1 = oci_parse($connection, $sql1);
                oci_execute($qry1);

                while ($row = oci_fetch_assoc($qry1)) {
                  $cname = $row['USERNAME'];

                  echo " 
      <tr>
      ";

                  ?>


                  <td><?php
                      $sn = $sn + 1;
                      echo $sn


                      ?></td>
          <?php
                  echo " 
      <td>$odate</td>
      <td>$oid</td>
      <td>$pname</td>
      <td>$time</td>
      <td>$cname</td>
      <td>$quantity</td>
      <td>$total</td>
      <td> ";

                  if ($ds == 1) {
                    $d = 1;
                    echo " <a href='trader_delivery_status.php?orderID=$oid&d=$d' class='btn btn-success'>Delivered</a>";
                  } else {
                    $d = 0;
                    echo " <a href='trader_delivery_status.php?orderID=$oid&d=$d' class='btn btn-danger'>Not Delivered</a>";
                  }



                  echo " </td>

      </tr>
      ";
                }
              }
            }
          } //






          ?>










        </tbody>


      </table>


    </div>


  </div>
</div>









<?php
unset($_SESSION['ds']);
include '../end.php'; ?>