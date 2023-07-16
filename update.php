<?php

require_once './baza.php';
$zahtjev = filter_input(INPUT_POST, "zahtjev");
$stranka = filter_input(INPUT_POST, "stranka");
$slika = basename($_FILES["slika"]["name"]);

$bazaObj = new Baza();
$poruka = "";

$staro = $bazaObj->standardUpit("SELECT * FROM zahtjev WHERE zahtjev_id=" . $zahtjev . " ");
while ($row = mysqli_fetch_array($staro)) {
    $staroime = $row['slika'];
}

$direktorij = "./materijali/";
$datoteka = $direktorij . basename($_FILES["slika"]["name"]);
$staraslika = $direktorij . $staroime;
$uploadOk = 1;
$fileType = strtolower(pathinfo($datoteka, PATHINFO_EXTENSION));

if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["slika"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $poruka .= "Datoteka nije slika";
        $uploadOk = 0;
    }
}

if (file_exists($datoteka)) {
    $poruka .= "Datoteka već postoji!";
    $uploadOk = 0;
}

if ($_FILES["slika"]["size"] > 500000) {
    $poruka .= "Datoteka je prevelika (iznad 500KB)";
    $uploadOk = 0;
}

if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif") {
    $poruka .= "Datoteka smije biti samo JPG, JPEG, PNG & GIF.";
    $uploadOk = 0;
}

if ($uploadOk == 0) {
    $poruka .= "Datoteka nije uploadana.";
} else {
    if ($bazaObj->provjeriZahtjev($zahtjev, $stranka)) {
        $delete = unlink($staraslika);
        if ($delete) {
            $poruka .= "Stara slika obrisana, ";
        } else {
            $poruka .= "Stara slika nije uspješno obrisana, ";
        }
        if (move_uploaded_file($_FILES["slika"]["tmp_name"], $datoteka)) {
            $osvjezi = "UPDATE zahtjev SET slika='" . $slika . "' WHERE zahtjev_id=" . $zahtjev . " ";
            $bazaObj->standardUpit($osvjezi);
            $poruka .= "zahtjev ažuriran, a nova slika " . htmlspecialchars(basename($_FILES["slika"]["name"])) . " uploadana.";
        } else {
            $poruka .= "Datoteka nije uploadana.";
        }
    } else {
        $poruka .= "Zahtjev ne postoji ili Vi niste upravitelj zahtjeva!";
    }
}

header("Location: ./zahtjevi.php?poruka=" . $poruka);
exit();
?>