<?php
session_start();
if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $pincode = $_POST['pincode'];
    if (!empty($email) && !empty($pincode)) {

        include('../connection.php');

        $sql = "SELECT * FROM customer WHERE Email='$email' and Email_Verify='$pincode'";
        $result = oci_parse($connection, $sql);
        oci_execute($result);

        $count = oci_fetch_all($result, $connection);
        oci_execute($result);

        if ($count >= 1) {
            echo $count;

            include '../connection.php';
            $sql2 = "UPDATE CUSTOMER set EMAIL_VERIFY='0' where EMAIL = '$email' and EMAIL_VERIFY='$pincode'";
            $qry = oci_parse($connection, $sql2);
            oci_execute($qry);
            header('Location:../sign_in_customer.php?message=Email Successfully Verified');
            exit();
        } else {
            header('Location:../customer_email_verify.php?msg=Invalid Email / Pin Code');
            exit();
        }
    } else {
        header('Location:customer_email_verify_process.php?msg=User not Registered!');
        exit();
    }
}
?>