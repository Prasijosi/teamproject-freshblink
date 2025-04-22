<?php include '../start.php' ?>
<?php
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



    .fa-star {
        color: orange;
        font-size: 1.5vw;
    }

    .checked {
        color: orange;
    }

    /*
.container-fluid{
overflow: hidden;
}

*/
    .border-1 {
        border-width: 3px !important;

    }



    .border {
        border: 1px solid #dee2e6 !important;
    }

    .border-secondary {
        border-color: #6c757d !important;
    }
</style>


</head>

<body>
    <?php include 'theader.php'; ?>
    <div class="container mt-3">
        <div class="row">
            <div class=" col-lg-12  ">


                <h3>Customer Reviews</h3>



            </div>
        </div>

        <div class="row mt-3">
            <form method="POST" action="#" class=" d-flex   col-4">
                <span class="col-4  mt-1">Sort By:</span>
                <select id="sort" class="selectpicker form-control  " name="cat">
                    <option value="DESC" <?php echo (isset($_POST['cat']) && $_POST['cat'] == "DESC") ? 'selected="selected"' : ''; ?>>Recent reviews</option>
                    <option value="ASC" <?php echo (isset($_POST['cat']) && $_POST['cat'] == "ASC") ? 'selected="selected"' : ''; ?>>Old reviews</option>


                </select>
                <button class="btn btn-secondary" style="background-color:#212529; color: white;">Go</button>
            </form>





        </div>

        <?php
        include('connection.php');

        $tn = $_SESSION['trader_username'];

        $sql = "SELECT * FROM trader where Username='$tn'";
        $qry = oci_parse($connection, $sql);
        oci_execute($qry);

        while ($row = oci_fetch_assoc($qry)) {
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

                $sql1 = "SELECT * FROM review, product, shop WHERE shop.Shop_Id=product.Shop_Id AND review.Product_Id=product.Product_Id AND shop.Trader_id='$tid' ORDER BY Dates $s ";
                $qry1 = oci_parse($connection, $sql1);
                oci_execute($qry1);

                while ($row = oci_fetch_assoc($qry1)) {
                    $pname = $row['PRODUCT_NAME'];
                    $rating2 = $row['RATING'];
                    $review = $row['DESCRIPTION'];
                    $rdate = $row['DATES'];
                    $pimage = $row['PRODUCT_IMAGE'];


                    echo " 
       <div class='container border border-secondary mt-3 mb-3 p-3'>   <!-- border -->
       <div class='row mt-0 ' >
       
       
       <div class='col-lg-4'>
       <h3>";
                    include '../condition_checker/rating_conditional_2.php';
                    echo "<span class='ml-3 badge badge-secondary'>$rdate</span></h3>
       </div>
       </div>
       
           <div class='row'>
           <div class='col-lg-12'>
       
           
           <h4>$review</h4>
           
           </div>
       
           </div>
       
           <div class='row mb-2' >
           <div class='col-lg-2 '>
           <img src='../$pimage' class='img-fluid' style='width: 130px;'>
           </div>
       
           <div class='col-lg-3 '>
           <div class=''>$pname </div>
           <div class='form-group '>
           
           <input type='text' style='height:100px' class='form-control ' id='example2' placeholder='Reply to the customer'>
            </div>
           <div class='btn btn-primary btn-default  mt-0'>Reply</div>
           </div>
       
           <div class='col-lg-1 '></div> <!-- leaving bank div for spce -->
       
            <div class='col-lg-4 p-5'>
            <span class='h6'>Product Star Rating</span>
                <br>
               ";

                    include '../condition_checker/rating_conditional_2.php';

                    echo "
           
           </div>
       
           </div>
       
        
           </div>    <!-- border -->
           ";
                }
            } else {

                $sql1 = "SELECT * FROM review, product, shop WHERE shop.Shop_Id=product.Shop_Id AND review.Product_Id=product.Product_Id AND shop.Trader_id='$tid'";
                $qry1 = oci_parse($connection, $sql1);
                oci_execute($qry1);

                while ($row = oci_fetch_assoc($qry1)) {
                    $pname = $row['PRODUCT_NAME'];
                    $rating2 = $row['RATING'];
                    $review = $row['DESCRIPTION'];
                    $pimage = $row['PRODUCT_IMAGE'];


                    echo " 
        <div class='container border border-secondary mt-3 mb-3 p-3'>   <!-- border -->
        <div class='row mt-0 ' >
        
        
        <div class='col-lg-4'>
        <h3>";

                    include '../condition_checker/rating_conditional_2.php';
                    echo "
        <span class='ml-3 badge badge-secondary'>2021/01/12</span></h3>
       
        
        </div>
        </div>
        
            <div class='row'>
            <div class='col-lg-12'>
        
            
            <h4>$review</h4>
            
            </div>
        
            </div>
        
            <div class='row mb-2' >
            <div class='col-lg-2 '>
            <img src='../$pimage' class='img-fluid' style='width: 130px;'>
            </div>
        
            <div class='col-lg-3 '>
            <div class=''>$pname </div>
            <div class='form-group '>
            
            <input type='text' style='height:100px' class='form-control ' id='example2' placeholder='Reply to the customer'>
             </div>
            <div class='btn btn-primary btn-default  mt-0'>Reply</div>
            </div>
        
            <div class='col-lg-1 '></div> <!-- leaving bank div for spce -->
        
            <div class='col-lg-4 p-5'>
            <span class='h6'>Product Star Rating</span>
                <br>
               ";

                    include '../condition_checker/rating_conditional_2.php';

                    echo "
            
            </div>
        
            </div>
        
         
            </div>    <!-- border -->
            ";
                }
            }
        }  //




        ?>























    </div>
    <?php include '../end.php'; ?>