<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/webshop/jezgra/init.php';
unset($_SESSION['korisnik_id']);
header('Location: prijava.php')
?>