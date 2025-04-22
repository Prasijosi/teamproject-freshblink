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
<img src='../$timage' class='img-fluid mx-auto d-block mt-3' style='height: 200px; width: 200px;  '   >";
            ?>

            <p class="h3 mt-3">My Account</p>
            <p>Edit Account Information</p>




        </div>
        <div class="col border ml-4 float-right text-center">
            <h3>Change Password</h3>
            <?php


            if (isset($_SESSION['msg'])) {
                echo "<h4 style='text-align: center; color:green;'>" . $_SESSION['msg'] . "</h4>";
            }

            if (isset($_SESSION['error'])) {
                echo "<h4 style='text-align: center; color:red;'>" . $_SESSION['error'] . "</h4>";
            }

            ?>


            <div class="row">

                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center">
                    <form class="mt-2" method="POST" action="trader_change_password_process.php">
                        <div class="form-group row">
                            <label for="inputPassword" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-form-label">Password</label>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <input type="password" class="form-control" id="inputPassword" placeholder="Enter your Password" name="password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword1" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-form-label">Re-enter your Password</label>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <input type="password" class="form-control" id="inputPassword1" placeholder="Re-enter your Password" name="repassword">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 d-flex align-items-center justify-content-center ml-2">
                                <button type="submit" class="btn btn-success" name="submit">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>






    </div>


</div>
</div>

<?php
unset($_SESSION['msg']);
unset($_SESSION['error']);
?>