<?php

require_once './baza.php';

try {
    $bazaObj = new Baza();
} catch (Exception $ex) {
    echo $ex->getMessage();
}

if (isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])) {
    $email = $_GET['email'];
    $hash = $_GET['hash'];

    $korisnik = $bazaObj->standardUpit("SELECT * FROM korisnik WHERE email='" . $email . "' AND sol='" . $hash . "' AND verificiran='0'");

    $potvrde = mysqli_num_rows($korisnik);
}

$row = $korisnik->fetch_assoc();
$vrijemeIspravno = false;
$timestamp = strtotime($row["datum_registracije"]);

if ($timestamp > (time() - 25200)) {  //7 sati
    $vrijemeIspravno = true;
}

if (($potvrde > 0) && ($vrijemeIspravno == true)) {
    $korisnik = $bazaObj->standardUpit("UPDATE korisnik SET verificiran='1' WHERE email='" . $email . "' AND sol='" . $hash . "' AND verificiran='0'");
    echo '<div style="text-align:center;color:green;">Racun je aktiviran</div>';
} else {
    if ($vrijemeIspravno == false) {
        echo '<div style="text-align:center;color:red;">Vrijeme je isteklo</div>';
    }
}

$naslov = "Početna stranica";
require_once './_osnovno.php';
ispisiOstatak();
ispisiNavigaciju();
?>

<h1><a href="index.php">Početna stranica</a></h1>


<?php
ispisiFooter();
?>