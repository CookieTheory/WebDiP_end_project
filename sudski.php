<?php

require_once './baza.php';

$zahtijevamPrijavu = true;
$trazenaUloga = 2;
$naslov = "Sudski postupci";
require_once './_osnovno.php';
ispisiOstatak();
ispisiNavigaciju();

$odvjetnik_id = $_SESSION["id"];
?>

<h1 style="text-align: center">Kategorije postupaka</h1>

<section class="savjetovanja">
    <?php 
    $bazaObj = new Baza();
    $rezultat = $bazaObj->standardUpit("SELECT k.kategorija_id, m.modmoderator_id, k.naziv, kor.korime, kor.ime, kor.prezime FROM kategorija AS k JOIN moderator_kategorije AS m ON m.modkategorija_id=k.kategorija_id JOIN korisnik AS kor ON kor.korisnik_id=m.modmoderator_id WHERE kor.korisnik_id=" . $odvjetnik_id . " ");
    while ($row = mysqli_fetch_array($rezultat)) {
            $ime = $row['ime'];
            $prezime = $row['prezime'];
            $korime = $row['korime'];
            $naziv = $row['naziv'];
            $kategorija_id = $row['kategorija_id'];
            $link = "'./postupak.php?id=" . $kategorija_id . "'";
        echo '<div class="odvjetnik-card">
        <div class="odvjetnik-card__imeprezime">' . $ime . ' ' . $prezime . '</div>
        <div class="odvjetnik-card__korime">' . $korime . '</div>
        <div class="odvjetnik-card__korime">' . $naziv . '</div>
        <button onclick="window.location.href=' . $link . '" class="odvjetnik-card__pitanja">Napravi postupak</button>
    </div>';
    }
    ?>
</section>



<?php

ispisiFooter();
?>