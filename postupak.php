<?php

require_once './baza.php';

if(isset($_GET["id"])){
    $idKategorija = filter_input(INPUT_GET, "id");
} else {
    header("Location: ./index.php");
    exit();
}

$zahtijevamPrijavu = true;
$trazenaUloga = 2;
$naslov = "Savjetovanja";
require_once './_osnovno.php';
ispisiOstatak();
ispisiNavigaciju();

$odvjetnik_id = $_SESSION["id"];
?>

<script>
    function dodaj(forme) {

        var id = forme.jedinstveni.value;
        if(id==="") { id="0"; }
        var nazivSudskog = forme.nazivSudskog.value;
        var radnja = forme.radnja.value;
        var dokaz = forme.dokaz.value;
        var vrijeme = forme.vrijeme.value;
        var ispravljeno = vrijeme.replace("T", " ");
        vrijeme = ispravljeno + ':00';
        var odvjetnik = $("#odvjetnik").val();
        var kategorija = $("#kategorija").val();
        
        console.log(id);
        console.log(nazivSudskog);
        console.log(radnja);
        console.log(dokaz);
        console.log(vrijeme);
        console.log(odvjetnik);
        console.log(kategorija);
        $.ajax({
            url: 'data.php',
            type: 'post',
            data: {id: id, nazivSudskog: nazivSudskog, stranica: "dodajPostupak", radnja: radnja, dokaz: dokaz, vrijeme: vrijeme, odvjetnik: odvjetnik, kategorija: kategorija},
            success: function (response) {

                $(".savjetovanja").html(response);
            }
        });
        return false;
    }
</script>

<section class="odvoji"><?php
    echo "<input type='hidden' id='odvjetnik' value=" . $odvjetnik_id . ">";
    echo "<input type='hidden' id='kategorija' value=" . $idKategorija . ">";
    ?>
    <form class="forme-podaci" method="POST" onsubmit="return dodaj(this);">
        <h4>Dodaj sudski postupak</h4>
        <h6>Ažurira se s istim brojem sudskog postupka</h6>
        <label for="jedinstveni">Jedinstveni broj sudskog postupka: </label><br>
        <input style="width:250px;" type="number" id="jedinstveni" name="jedinstveni" min="1" placeholder="Ostaviti prazno za automatsko"><br>
        <label for="nazivSudskog">Naziv sudskog postupka: </label><br>
        <input type="text" id="nazivSudskog" name="nazivSudskog" size="30" placeholder="Naziv sudskog postupka" required><br>
        <label for="radnja">Radnja: </label>
        <textarea id="radnja" name="radnja" placeholder="Radnja" rows="2" cols="50" maxlength="45" required></textarea><br>
        <label for="dokaz">Dokaz: </label>
        <input type="text" id="dokaz" name="dokaz" placeholder="Dokaz" required><br>
        <label for="vrijeme">Vrijeme početka: </label>
        <input type="datetime-local" id="vrijeme" name="vrijeme" placeholder="Vrijeme početka" required><br>

        <button type="submit"> Postavi/ažuriraj </button>
    </form>
</section>

<section class="savjetovanja">
    <?php 
    $bazaObj = new Baza();
    $rezultat = $bazaObj->standardUpit("SELECT * FROM sudski JOIN status AS s ON s.status_id=sudski.status_id WHERE tuzitelj_id=" . $odvjetnik_id . " AND kategorija_id=" . $idKategorija . " ");
    while ($row = mysqli_fetch_array($rezultat)) {
            $sudski_id = $row['sudski_id'];
            $naziv = $row['naziv'];
            $radnja = $row['radnja'];
            $dokaz = $row['dokaz'];
            $datum1 = $row['datum_pocetak'];
            $datum2 = $row['datum_kraj'];
            $status = $row['naziv_statusa'];
            if($datum2 === NULL) { $datum2 = "Nije jos završio"; }
        echo '<div class="odvjetnik-card">
        <div class="odvjetnik-card__imeprezime">' . $sudski_id . ' - ' . $naziv . '</div>
        <div class="odvjetnik-card__korime">' . $dokaz . '</div>
        <div class="odvjetnik-card__korime">' . $datum1 . '-' . $datum2 . '</div>
        <div class="odvjetnik-card__odgovor"> Status: ' . $status . '</div>';
    echo '</div>';
    }
    ?>
</section>


<?php

ispisiFooter();
?>
