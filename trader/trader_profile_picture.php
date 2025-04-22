<?php include '../start.php';
if (!isset($_SESSION['trader_username'])) {
    header('Location:sign_in_trader.php');
    exit();
}

include('connection.php');
$trader_id = $_SESSION['trader_id'];
$sql = "SELECT * FROM trader WHERE Trader_Id=$trader_id";


$qry = oci_parse($connection, $sql);
oci_execute($qry);





while ($r = oci_fetch_array($qry)) {


    $tname = $r['USERNAME'];
    $tuname = $r['NAME'];
    $email = $r['EMAIL'];
    $timage = $r['PROFILE_IMAGE'];

    $phone = $r['CONTACT'];
}



?>

<?php include 'theader.php';
include 'connection.php';
if (isset($_POST['submit'])) {
    $tid = $_SESSION['trader_id'];
    $Profile_Image = $_FILES['Profile_Image'];
    $filename = $Profile_Image['name'];
    $fileerror = $Profile_Image['error'];
    $filetmp = $Profile_Image['tmp_name'];

    $imgext = explode('.', $filename);
    $filecheck = strtolower(end($imgext));

    $fileextstored = array('png', 'jpg', 'jpeg');

    if (in_array($filecheck, $fileextstored)) {
        $destinationfile = 'images/' . $filename;
        $destinationfile1 = '../images/' . $filename;
        move_uploaded_file($filetmp, $destinationfile1);



        $sql = "UPDATE trader SET Profile_Image = '$destinationfile' where Trader_Id='$tid'";

        $query = oci_parse($connection, $sql);
        oci_execute($query);

        if ($query) {
            header('Location:index.php?msg=Profile Successfully Updated');
            exit();
        } else {
            header('Location:trader_profile_picture.php?msg=Sql Not Running');
            exit();
        }
    } else {
        echo "
        <div class='row border p-4 mt-4'> 
        <div class='col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center' style='color:red;'>";
        echo "Error while Uploading!</div></div>";
    }
}



?>

<div class="container mt-3">
    <div class="row">
        <div class="col-4 border">
            <?php echo " 
<img src='../$timage' class='img-fluid mx-auto d-block mt-3' alt='No Trader Image' style='height: 200px; width: 200px;  '   >";
            ?>
            <div style="text-align: center; margin-top: 10px;">


                <a href="trader_profile_picture.php">Change Profile Picture</a>
            </div>
            <p class="h3 mt-3">My Account</p>
            <p>Edit Account Information</p>




        </div>
        <div class="col border ml-4 float-right text-center">
            <h3>Change Profile Picture</h3>

            <form action="#" method="POST" enctype="multipart/form-data">
                <div class="row">

                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center">
                    <div class="form-group d-flex align-items-center justify-content-center">
                        <!-- <label for="ProductImage" class="h6 text-center mt-5">Choose your picture </label> -->
                        <input type="file" name="Profile_Image" id="ProductImage" class="form-control w-75 mt-5">
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center">
                    <input type="submit" name="submit" value="Submit" class="btn btn-success my-4" />
                </div>
            </form>






        </div>


    </div>
</div>