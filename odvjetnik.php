<?php

require_once './baza.php';

if(isset($_GET["id"])){
    $idOdvjetnik = filter_input(INPUT_GET, "id");
} else {
    header("Location: ./index.php");
    exit();
}

$zahtijevamPrijavu = true;
$trazenaUloga = 3;
$naslov = "Savjetovanja";
require_once './_osnovno.php';
ispisiOstatak();
ispisiNavigaciju();
?>

<script>
    function dodaj(forme) {

        var razlog = forme.razlog.value;
        var opis = forme.opis.value;
        var odvjetnik = $("#odvjetnik").val();
        var stranka = $("#stranka").val();
        
        console.log(razlog);
        console.log(opis);
        console.log(odvjetnik);
        console.log(stranka);
        $.ajax({
            url: 'data.php',
            type: 'post',
            data: {columnName: razlog, columnName2: opis, stranica: "dodajSavjetovanje", odvjetnik: odvjetnik, stranka: stranka},
            success: function (response) {

                $(".savjetovanja").append(response);
            }
        });
        return false;
    }
</script>

<section class="odvoji"><?php
    echo "<input type='hidden' id='odvjetnik' value=" . $idOdvjetnik . ">";
    echo "<input type='hidden' id='stranka' value=" . $_SESSION['id'] . ">";
    ?>
    <form class="forme-podaci" method="POST" onsubmit="return dodaj(this);">
        <h5>Postavi pitanje</h5>
        <label for="razlog">Razlog savjetovanja: </label>
        <input type="text" id="razlog" name="razlog" placeholder="Razlog savjetovanja" required><br>
        <label for="opis">Opis problema: </label>
        <textarea id="opis" name="opis" placeholder="Opis problema" rows="4" cols="50" required></textarea><br>

        <button type="submit"> Postavi </button>
    </form>
</section>


<section class="savjetovanja">
    <?php 
    $bazaObj = new Baza();
    $rezultat = $bazaObj->standardUpit("SELECT * FROM savjetovanje WHERE odvjetnik_id=" . $idOdvjetnik . " ");
    while ($row = mysqli_fetch_array($rezultat)) {
            $razlog = $row['razlog'];
            $opis = $row['opis'];
            $odgovor = $row['odgovor'];
            if($odgovor === NULL) { $odgovor = "Nema odgovora trenutno"; }
        echo '<div class="odvjetnik-card">
        <div class="odvjetnik-card__imeprezime">' . $razlog . '</div>
        <div class="odvjetnik-card__korime">' . $opis . '</div>
        <div class="odvjetnik-card__odgovor"> Odgovor: ' . $odgovor . '</div>';
    echo '</div>';
    }
    ?>
</section>




<?php

ispisiFooter();
?>
