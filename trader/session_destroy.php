<?php
session_start();
session_destroy();
header('Location:sign_in_trader.php');
exit();
