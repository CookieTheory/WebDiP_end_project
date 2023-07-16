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
            data: {id: zahtjev, stranica: "filtrirajZahtjevStranke", odvjetnik: odvjetnik},
            success: function (response) {

                $(".savjetovanja").html(response);
            }
        });
        return false;
    }
</script>

<script>
    function prihvati(zahtjev) {

        var id = zahtjev;
        var odvjetnik = $("#odvjetnik").val();
        
        //console.log(dohvati);
        //console.log(argument);
        $.ajax({
            url: 'data.php',
            type: 'post',
            data: {id: id, stranica: "prihvatiZahtjev", odvjetnik: odvjetnik},
            success: function (response) {

                $(".savjetovanja").html(response);
            }
        });
        return false;
    }
</script>

<script>
    function odbij(zahtjev) {

        var id = zahtjev;
        var odvjetnik = $("#odvjetnik").val();
        
        //console.log(id);
        $.ajax({
            url: 'data.php',
            type: 'post',
            data: {id: id, stranica: "odbijZahtjev", odvjetnik: odvjetnik},
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
    $rezultat = $bazaObj->standardUpit("SELECT z.zahtjev_id, z.status, z.argument_obrane, k.ime, k.prezime FROM zahtjev AS z JOIN sudski AS s ON s.sudski_id=z.sudski_id JOIN korisnik AS k ON k.korisnik_id=z.stranka_id WHERE z.odvjetnik_id=" . $odvjetnik_id . " AND s.tuzitelj_id!=" . $odvjetnik_id . " ORDER BY z.status DESC");
    while ($row = mysqli_fetch_array($rezultat)) {
        $zahtjev_id = $row['zahtjev_id'];
        $status = $row['status'];
        $argument_obrane = $row['argument_obrane'];
        $ime = $row['ime'];
        $prezime = $row['prezime'];
        if ($status === NULL) {
            $status = "Niste još odlučili";
        } else if($status === '0') {
            $status = "Odbijeno";
        } else {
            $status = "Prihvaćeno";
        }
        echo '<div class="odvjetnik-card">
        <div class="odvjetnik-card__imeprezime">' . $zahtjev_id . ' - ' . $ime . ' ' . $prezime . '</div>
        <div class="odvjetnik-card__korime">' . $argument_obrane . '</div>
        <div class="odvjetnik-card__korime">' . $status . '</div>';
        if ($status === "Niste još odlučili") {
            echo '<button onclick="prihvati(' . $zahtjev_id . ')" class="odvjetnik-card__pitanja">Prihvati postupak</button>
            <button onclick="odbij(' . $zahtjev_id . ')" class="odvjetnik-card__pitanja">Odbij postupak</button>';
        }
        echo '</div>';
    }
    ?>
</section>



<?php
ispisiFooter();
?>