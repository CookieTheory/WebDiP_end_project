<?php
require_once './baza.php';

$zahtijevamPrijavu = true;
$trazenaUloga = 2;
$naslov = "Zahtjevi stranki";
require_once './_osnovno.php';
ispisiOstatak();
ispisiNavigaciju();

$odvjetnik_id = $_SESSION["id"];
echo "<input type='hidden' id='odvjetnik' value=" . $odvjetnik_id . ">";
?>

<script>
    function filtrirajZahtjev(forme) {

        var zahtjev = forme.zahtjev.value;
        var odvjetnik = $("#odvjetnik").val();
        $.ajax({
            url: 'data.php',
            type: 'post',
            data: {id: zahtjev, stranica: "filtrirajPrihvaceneZahtjeve", odvjetnik: odvjetnik},
            success: function (response) {

                $(".savjetovanja").html(response);
            }
        });
        return false;
    }
</script>

<script>
    function azuriraj(zahtjev) {

        var id = zahtjev;
        var odvjetnik = $("#odvjetnik").val();
        var dohvati = "#" + id;
        var argument = $(dohvati).val();
        
        //console.log(id);
        //console.log(odvjetnik);
        //console.log(dohvati);
        //console.log(argument);
        $.ajax({
            url: 'data.php',
            type: 'post',
            data: {id: id, stranica: "azurirajZahtjev", odvjetnik: odvjetnik, argument: argument},
            success: function (response) {

                $(".savjetovanja").html(response);
            }
        });
        return false;
    }
</script>

<script>
    function zakljucak(zahtjev, kraj) {

        var id = zahtjev;
        var odvjetnik = $("#odvjetnik").val();
        var dohvati = "#vrijeme" + id;
        var vrijeme = $(dohvati).val();
        var ispravljeno = vrijeme.replace("T", " ");
        vrijeme = ispravljeno + ':00';
        var kraj = kraj;
        
        //console.log(id);
        //console.log(odvjetnik);
        console.log(vrijeme);
        //console.log(kraj);
        $.ajax({
            url: 'data.php',
            type: 'post',
            data: {id: id, stranica: "zakljucajZahtjev", odvjetnik: odvjetnik, vrijeme: vrijeme, kraj: kraj},
            success: function (response) {

                $(".savjetovanja").html(response);
            }
        });
        return false;
    }
</script>

<h1 style="text-align: center">Zahtjevi za Vas</h1>

<section class="odvoji">
    <form class="forme-podaci" method="POST" onsubmit="return filtrirajZahtjev(this);">
        <h5>Filtriraj po ID zahtjeva:</h5>
        <label for="zahtjev">Zahtjev ID: </label>
        <input type="number" id="zahtjev" name="zahtjev" placeholder="0 za osvježavanje" min="0" required><br>

        <button type="submit"> Filtriraj </button><br><br>
    </form>
</section>

<section class="savjetovanja">
    <?php
    $bazaObj = new Baza();
    $rezultat = $bazaObj->standardUpit("SELECT z.zahtjev_id, z.status, z.argument_obrane, k.ime, k.prezime, s.status_id, s.datum_pocetak, s.datum_kraj, stat.naziv_statusa FROM zahtjev AS z JOIN sudski AS s ON s.sudski_id=z.sudski_id JOIN status AS stat ON stat.status_id=s.status_id JOIN korisnik AS k ON k.korisnik_id=z.stranka_id WHERE z.odvjetnik_id=" . $odvjetnik_id . " AND s.tuzitelj_id!=" . $odvjetnik_id . " AND z.status=1 ORDER BY z.status ASC");
    while ($row = mysqli_fetch_array($rezultat)) {
        $zahtjev_id = $row['zahtjev_id'];
        $argument_obrane = $row['argument_obrane'];
        $ime = $row['ime'];
        $prezime = $row['prezime'];
        $status = "Prihvaćeno";
        $datum1 = $row['datum_pocetak'];
        $datum2 = $row['datum_kraj'];
        $status_sudski = $row['status_id'];
        $rjesenje = $row['naziv_statusa'];
        
        echo '<div class="odvjetnik-card">
        <div class="odvjetnik-card__imeprezime">' . $zahtjev_id . ' - ' . $ime . ' ' . $prezime . '</div>
        <div class="odvjetnik-card__korime">' . $argument_obrane . '</div>
        <div class="odvjetnik-card__korime">' . $status . '</div>';
        if($status_sudski === '2'){
            echo '<textarea id="' . $zahtjev_id . '" name="' . $zahtjev_id . '" placeholder="Unesite/ažurirajte argumente obrane" rows="4" cols="40" maxlength="250"></textarea>
        <button onclick="azuriraj(' . $zahtjev_id . ')" class="odvjetnik-card__pitanja">Unesi/ažuriraj obranu</button>';
            echo '<label for="vrijeme">Vrijeme kraja: </label>
        <input type="datetime-local" id="vrijeme' . $zahtjev_id . '" name="vrijeme' . $zahtjev_id . '" placeholder="Vrijeme početka" required>
        <button onclick="zakljucak(' . $zahtjev_id . ',3)" class="odvjetnik-card__pitanja">Kriv</button>
        <button onclick="zakljucak(' . $zahtjev_id . ',4)" class="odvjetnik-card__pitanja">Nije kriv</button>';
        } else if ($status_sudski !== '2'){
            echo '<div class="odvjetnik-card__korime">' . $datum1 . ' - ' . $datum2 . '</div>
        <div class="odvjetnik-card__korime">' . $rjesenje . '</div>';
        }
        
        echo '</div>';
    }
    ?>
</section>



<?php
ispisiFooter();
?>