<?php
require_once './baza.php';

$naslov = "Početna stranica";
require_once './_osnovno.php';
ispisiOstatak();
ispisiNavigaciju();
?>

<h1><a href="index.php">Početna stranica</a></h1>


<?php
if (isset($_SESSION["korime"]) == false){
    echo '<section>
    <p style="text-align: center;"><a href="prijava.php">Prijavite se</a> ili <a href="registracija.php">Registrirajte</a></p>
</section>';
}
?>
<br><br>

<section class="savjetovanja">
    <?php
    $bazaObj = new Baza();
    //$rezultat = $bazaObj->standardUpit("SELECT z.slika, s.sudski_id, s.datum_pocetak, s.datum_kraj, kor.korime, k.naziv, status.naziv_statusa, IF((s.datum_kraj IS NULL), DATEDIFF(CURRENT_TIMESTAMP, s.datum_pocetak), DATEDIFF(s.datum_kraj, s.datum_pocetak)) AS vrijeme FROM sudski AS s LEFT JOIN zahtjev AS z ON z.sudski_id=s.sudski_id JOIN kategorija AS k ON k.kategorija_id=s.kategorija_id JOIN korisnik AS kor ON kor.korisnik_id=s.tuzitelj_id JOIN status AS status ON status.status_id=s.status_id GROUP BY s.sudski_id ORDER BY vrijeme DESC ");
    $rezultat = $bazaObj->standardUpit("SELECT z.slika, s.sudski_id, s.datum_pocetak, s.datum_kraj, kor.korime, k.naziv, status.naziv_statusa FROM zahtjev AS z LEFT JOIN sudski AS s ON z.sudski_id=s.sudski_id JOIN kategorija AS k ON k.kategorija_id=s.kategorija_id JOIN korisnik AS kor ON kor.korisnik_id=s.tuzitelj_id JOIN status AS status ON status.status_id=s.status_id ORDER BY RAND() LIMIT 3");
    while ($row = mysqli_fetch_array($rezultat)) {
        $slika = $row['slika'];
        $sudski_id = $row['sudski_id'];
        $datum1 = $row['datum_pocetak'];
        $datum2 = $row['datum_kraj'];
        $tuzitelj = $row['korime'];
        $knaziv = $row['naziv'];
        $status = $row['naziv_statusa'];
        if ($datum2 === NULL) {
            $datum2 = "Nije jos završio";
        }
        if ($slika !== NULL) {
            echo '<div class="odvjetnik-card">
        <div class="odvjetnik-card__imeprezime">' . $tuzitelj . '</div>
        <div class="odvjetnik-card__korime">' . $datum1 . '</div>
        <div class="odvjetnik-card__korime">-</div>
        <div class="odvjetnik-card__korime">' . $datum2 . '</div>
        <div class="odvjetnik-card__korime"><img src="./materijali/' . $slika . '" width="200" height="200"></div>
        <div class="odvjetnik-card__korime"> Kategorija: ' . $knaziv . '</div>
        <div class="odvjetnik-card__korime"> Status: ' . $status . '</div>';
            echo '</div>';
        }
    }
    ?>
</section>


<?php
ispisiFooter();
?>
