<?php

$dbServerName = "localhost";
$dbUserName   = "root";
$dbPassword   = "";
$dbName       = "fastmeal";


$konekcija = mysqli_connect($dbServerName,$dbUserName,$dbPassword,$dbName);

if(!$konekcija){
    die("Konekcija nije uspela: ".mysqli_connect_error());
}

?>