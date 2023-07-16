<?php

require_once './baza.php';
$odvjetnik_id = filter_input(INPUT_POST, "odvjetnik");
$stranka_id = filter_input(INPUT_POST, "stranka");
$sudski_id = filter_input(INPUT_POST, "sudski_id");
$slika = basename($_FILES["slika"]["name"]);

$bazaObj = new Baza();
$poruka = "";

$direktorij = "./materijali/";
$datoteka = $direktorij . basename($_FILES["slika"]["name"]);
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
    if ($bazaObj->provjeriSudskiITuzitelja($sudski_id, $odvjetnik_id)) {
        if (move_uploaded_file($_FILES["slika"]["tmp_name"], $datoteka)) {
            $unesi = "INSERT INTO zahtjev (slika, datum, sudski_id, stranka_id, odvjetnik_id) VALUES ('" . $slika . "', CURRENT_TIMESTAMP, " . $sudski_id . ", " . $stranka_id . ", " . $odvjetnik_id . ") ";
            $bazaObj->standardUpit($unesi);
            $poruka .= "Zahtjev je kreiran te je datoteka " . htmlspecialchars(basename($_FILES["slika"]["name"])) . " uploadana.";
        } else {
            $poruka .= "Datoteka nije uploadana.";
        }
    } else {
        $poruka .= "Sudski postupak ne postoji/već je započeo ili je odabrani odvjetnik tužitelj na odabranom sudskom postupku!";
    }
}

header("Location: ./zahtjevi.php?poruka=" . $poruka);
exit();
?>