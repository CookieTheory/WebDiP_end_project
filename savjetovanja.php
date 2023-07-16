<?php

require_once './baza.php';

$zahtijevamPrijavu = true;
$trazenaUloga = 3;
$naslov = "Savjetovanja";
require_once './_osnovno.php';
ispisiOstatak();
ispisiNavigaciju();
?>

<section class="savjetovanja">
    <?php 
    $bazaObj = new Baza();
    $rezultat = $bazaObj->standardUpit("SELECT * FROM korisnik WHERE uloga_uloga_id='2'");
    while ($row = mysqli_fetch_array($rezultat)) {
            $ime = $row['ime'];
            $prezime = $row['prezime'];
            $korime = $row['korime'];
            $korid = $row['korisnik_id'];
            $link = "'./odvjetnik.php?id=" . $korid . "'";
        echo '<div class="odvjetnik-card">
        <div class="odvjetnik-card__imeprezime">' . $ime . ' ' . $prezime . '</div>
        <div class="odvjetnik-card__korime">' . $korime . '</div>
        <button onclick="window.location.href=' . $link . '" class="odvjetnik-card__pitanja">Pitanja</button>
    </div>';
    }
    ?>
</section>



<?php

ispisiFooter();
?>