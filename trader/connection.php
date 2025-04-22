<?php $connection = oci_connect('goCart_23', 'Admin123$', '//localhost/xe');
if (!$connection) {
   $m = oci_error();
   echo $m['message'], "\n";
   exit;
}
?>
