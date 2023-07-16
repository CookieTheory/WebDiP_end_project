<?php

require_once './baza.php';


$zahtijevamPrijavu = true;
$trazenaUloga = 2;
$naslov = "Pitanja";
require_once './_osnovno.php';
ispisiOstatak();
ispisiNavigaciju();

$odvjetnik_id = $_SESSION["id"];
?>

<script>
    function odgovori(forma) {

        var id = forma.savjetovanje.value;
        var odgovor = forma.odgovor.value;
        var odvjetnik = $("#odvjetnik").val();
        
        //console.log(odgovor);
        //console.log(odvjetnik);
        //console.log(id);
        $.ajax({
            url: 'data.php',
            type: 'post',
            data: {id: id, stranica: "odgovoriPitanje", odvjetnik: odvjetnik, odgovor:odgovor},
            success: function (response) {

                $(".savjetovanja").html(response);
            }
        });
        return false;
    }
</script>

<?php
echo '<input type="hidden" id="odvjetnik" value=' . $odvjetnik_id . '>';
?>

<section class="savjetovanja">
    <?php 
    $bazaObj = new Baza();
    $rezultat = $bazaObj->standardUpit("SELECT * FROM savjetovanje WHERE odvjetnik_id=" . $odvjetnik_id . " ");
    while ($row = mysqli_fetch_array($rezultat)) {
            $id = $row['savjetovanje_id'];
            $razlog = $row['razlog'];
            $opis = $row['opis'];
            $odgovor = $row['odgovor'];
            if($odgovor === NULL) { $odgovor = '<form style="padding-top:10px;" method="POST" onsubmit="return odgovori(this);">'
                    . '<input type="hidden" id="savjetovanje" name="savjetovanje" value=' . $id . '>'
                    . '<textarea id="odgovor" name="odgovor" placeholder="Odgovor na pitanje" rows="4" cols="40" maxlength="250" required></textarea>'
                    . '<button type="submit">Dodaj odgovor</button>'
                    . '</form>'; }
        echo '<div class="odvjetnik-card">
        <div class="odvjetnik-card__imeprezime">' . $razlog . '</div>
        <div class="odvjetnik-card__korime">' . $opis . '</div>
        <div class="odvjetnik-card__odgovor"> Odgovor: ' . $odgovor . '</div>';
        echo '';
    echo '</div>';
    }
    ?>
</section>


<?php

ispisiFooter();
?>
