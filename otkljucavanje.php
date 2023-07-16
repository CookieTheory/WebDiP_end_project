<?php
require_once './baza.php';

$zahtijevamPrijavu = true;
$trazenaUloga = 1;
$naslov = "Otkljucavanje";
require_once './_osnovno.php';
ispisiOstatak();
ispisiNavigaciju();
?>

<script>
    function otkljucavanja(forma) {

        var idkorisnika = forma.blokiraj.value;
        $.ajax({
            url: 'data.php',
            type: 'post',
            data: {columnName: idkorisnika, stranica: "otkljucavanjeBlokiraj"},
            success: function (response) {

                $("#otkljucavanje tr:not(:first)").remove();

                $("#otkljucavanje").append(response);
            }
        });
        return false;
    }
</script>

<section class='odvoji'>
    <form class="forme-podaci" method="POST" onsubmit="return otkljucavanja(this);">
        <label for="blokiraj">Id korisnika: </label>
        <input type="number" id="blokiraj" name="blokiraj" placeholder="ID korisnika" required><br>

        <button type="submit" value='1'> Blokiraj/Otključaj </button>
    </form>
</section>

<script>
    function sortirajTablicu(imeStupca) {

        var sort = $("#sort").val();
        $.ajax({
            url: 'data.php',
            type: 'post',
            data: {columnName: imeStupca, sort: sort, stranica: "otkljucavanjestranica"},
            success: function (response) {

                $("#otkljucavanje tr:not(:first)").remove();

                $("#otkljucavanje").append(response);
                if (sort === "ASC") {
                    $("#sort").val("DESC");
                } else {
                    $("#sort").val("ASC");
                }
            }
        });
    }
</script>

<div>
    <input type='hidden' id='sort' value='DESC'>
    <table class='center' id='otkljucavanje' border='1' cellpadding='10'>
        <tr>
            <th class='poredati'><span onclick='return sortirajTablicu("korisnik_id");'>ID korisnika</span></th>
            <th class='poredati'><span onclick='return sortirajTablicu("korime");'>Korisničko ime</span></th>
            <th class='poredati'><span onclick='return sortirajTablicu("broj_prijava");'>Broj prijava</span></th>
            <th>Blokiran</th>
        </tr>
        <?php
        $bazaObj = new Baza();
        $result = $bazaObj->standardUpit("SELECT * FROM korisnik WHERE blokiran=1 ORDER BY korisnik_id ASC");
        while ($row = mysqli_fetch_array($result)) {
            $id = $row['korisnik_id'];
            $ime = $row['korime'];
            $broj_prijava = $row['broj_prijava'];
            $blokiran = $row['blokiran'];
            if($blokiran === "0"){ $blokiran = "Otključan"; } else { $blokiran = "Blokiran"; }
            ?>
            <tr>
                <td><?php echo $id; ?></td>
                <td><?php echo $ime; ?></td>
                <td><?php echo $broj_prijava; ?></td>
                <td><?php echo $blokiran; ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>

<?php

ispisiFooter();
?>
