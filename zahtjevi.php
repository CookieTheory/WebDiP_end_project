<?php

require_once './baza.php';

$zahtijevamPrijavu = true;
$trazenaUloga = 3;
$naslov = "Zahtjevi";
require_once './_osnovno.php';
ispisiOstatak();
ispisiNavigaciju();

$stranka_id = $_SESSION["id"];

if(isset($_GET["poruka"])){
    $poruka = filter_input(INPUT_GET, "poruka");
    echo '<h4 style="text-align: center;color:blue;">' . $poruka . '</h4>';
}
?>

<h1 style="text-align: center">Zahtjevi</h1>

<section class="savjetovanja">
    <?php 
    $bazaObj = new Baza();
    $rezultat = $bazaObj->standardUpit("SELECT * FROM korisnik WHERE uloga_uloga_id='2'");
    while ($row = mysqli_fetch_array($rezultat)) {
            $ime = $row['ime'];
            $prezime = $row['prezime'];
            $korime = $row['korime'];
            $korid = $row['korisnik_id'];
            $link = "'./kreirajZahtjev.php?id=" . $korid . "'";
        echo '<div class="odvjetnik-card">
        <div class="odvjetnik-card__imeprezime">' . $ime . ' ' . $prezime . '</div>
        <div class="odvjetnik-card__korime">' . $korime . '</div>
        <button onclick="window.location.href=' . $link . '" class="odvjetnik-card__pitanja">Otvori zahtjev</button>
    </div>';
    }
    ?>
</section>

<h1 style="text-align: center">Vaši otvoreni zahtjevi</h1>

<section class="odvoji">
    
    <form class="forme-podaci" method="POST" enctype="multipart/form-data" action="update.php">
        <h5>Ažuriraj zahtjev</h5>
        <label for="zahtjev">ID zahtjeva: </label>
        <input type="number" id="zahtjev" name="zahtjev" placeholder="ID zahtjeva" min="1" required><br>
        <label for="slika">Promijeni sliku: </label>
        <input type="file" name="slika" id="slika"><br>
        <input type='hidden' name="stranka" id="stranka" value="<?php echo $stranka_id; ?>" >

        <button type="submit"> Ažuriraj </button>
    </form>
</section>

<section class="savjetovanja">
    <?php 
    $bazaObj = new Baza();
    $rezultat = $bazaObj->standardUpit("SELECT * FROM zahtjev WHERE stranka_id=" . $stranka_id . " ORDER BY zahtjev_id DESC");
    while ($row = mysqli_fetch_array($rezultat)) {
            $zahtjev_id = $row['zahtjev_id'];
            $status = $row['status'];
            $slika = $row['slika'];
            $argument = $row['argument_obrane'];
            $datum = $row['datum'];
        if ($status === NULL) {
            $status = "Nije još odlučeno";
        } else if($status === '0') {
            $status = "Odbijeno";
        } else {
            $status = "Prihvaćeno";
        }
        if ($argument !== NULL){
            $obrana = "Obrana: " . $argument;
        }
        else {
            $obrana = $argument;
        }
        echo '<div class="odvjetnik-card">
        <div class="odvjetnik-card__imeprezime">' . $zahtjev_id . ' - ' . $status . '</div>
        <div class="odvjetnik-card__korime">' . $obrana . '</div>
        <div class="odvjetnik-card__korime"><img src="./materijali/' . $slika . '" width="200" height="200"></div>
        <div class="odvjetnik-card__korime">' . $datum . '</div>
    </div>';
    }
    ?>
</section>



<?php

ispisiFooter();
?>