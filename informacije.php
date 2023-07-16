<?php
require_once './baza.php';

$naslov = "Informacije";
require_once './_osnovno.php';
ispisiOstatak();
ispisiNavigaciju();
?>

<script>
    function filtriraj(forma) {

        var datum1 = forma.datum1.value;
        var datum2 = forma.datum2.value;
        var sort = $("#sort").val();
        $.ajax({
            url: 'data.php',
            type: 'post',
            data: {datum1: datum1, datum2: datum2, sort: sort, stranica: "filtrirajInformacije"},
            success: function (response) {

                $("#odvjetnici tr:not(:first)").remove();

                $("#odvjetnici").append(response);
                if (sort === "ASC") {
                    $("#sort").val("DESC");
                } else {
                    $("#sort").val("ASC");
                }
            }
        });
        return false;
    }
</script>

<section class='odvoji'>
        <form class="forme-podaci" method="POST" onsubmit="return filtriraj(this);">
            <label for="datum1">Od datuma: </label>
            <input type="date" id="datum1" name="datum1" placeholder="Od" required><br>
            <label for="datum2">Do datuma: </label>
            <input type="date" id="datum2" name="datum2" placeholder="Do" required><br>

            <button type="submit"> Filtriraj </button>
        </form>
    </section>

<script>
    function sortirajTablicu(imeStupca) {

        var sort = $("#sort").val();
        $.ajax({
            url: 'data.php',
            type: 'post',
            data: {columnName: imeStupca, sort: sort, stranica: "informacije"},
            success: function (response) {

                $("#odvjetnici tr:not(:first)").remove();

                $("#odvjetnici").append(response);
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
    

    <input type='hidden' id='sort' value='ASC'>
    <table class='center' id='odvjetnici' border='1' cellpadding='10'>
        <tr>
            <th class='poredati'><span onclick='return sortirajTablicu("k.ime");'>Ime</span></th>
            <th class='poredati'><span onclick='return sortirajTablicu("k.prezime");'>Prezime</span></th>
            <th class='poredati'><span onclick='return sortirajTablicu("p.broj_prihvacenih");'>Broj zahtjeva</span></th>
        </tr>
        <?php
        $bazaObj = new Baza();
        $result = $bazaObj->standardUpit("SELECT k.ime, k.prezime, p.broj_prihvacenih FROM korisnik as k LEFT JOIN (SELECT odvjetnik_id, COUNT(*) as broj_prihvacenih FROM zahtjev WHERE status=1 GROUP BY odvjetnik_id) as p ON k.korisnik_id=p.odvjetnik_id WHERE k.uloga_uloga_id=2 ORDER BY p.broj_prihvacenih DESC");
        while ($row = mysqli_fetch_array($result)) {
            $ime = $row['ime'];
            $prezime = $row['prezime'];
            $broj_zahtjeva = $row['broj_prihvacenih'];
            if (!$broj_zahtjeva) {
                $broj_zahtjeva = 0;
            }
            ?>
            <tr>
                <td><?php echo $ime; ?></td>
                <td><?php echo $prezime; ?></td>
                <td><?php echo $broj_zahtjeva; ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>

<?php
ispisiFooter();
?>