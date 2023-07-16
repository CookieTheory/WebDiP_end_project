<?php
require_once './baza.php';

$zahtijevamPrijavu = true;
$trazenaUloga = 3;
$naslov = "Popis";
require_once './_osnovno.php';
ispisiOstatak();
ispisiNavigaciju();
?>

<script>
    function sortirajTablicu(imeStupca) {

        var sort = $("#sort").val();
        $.ajax({
            url: 'data.php',
            type: 'post',
            data: {columnName: imeStupca, sort: sort, stranica: "popis"},
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
    <input type='hidden' id='sort' value='DESC'>
    <table class='center' id='odvjetnici' border='1' cellpadding='10'>
        <tr>
            <th>Ime i prezime</th>
            <th class='poredati' ><span onclick='return sortirajTablicu("zahtjev_id");'>Zahtjev ID</span></th>
            <th class='poredati' ><span onclick='return sortirajTablicu("status");'>Status</span></th>
            <th class='poredati' ><span onclick='return sortirajTablicu("datum");'>Vrijeme</span></th>
        </tr>
        <?php
        $bazaObj = new Baza();
        $result = $bazaObj->standardUpit("SELECT k.ime, k.prezime, z.zahtjev_id, z.status, z.datum FROM zahtjev AS z JOIN korisnik AS k ON k.korisnik_id=z.odvjetnik_id ORDER BY z.status DESC");
        while ($row = mysqli_fetch_array($result)) {
            $ime = $row['ime'];
            $prezime = $row['prezime'];
            $zahtjev = $row['zahtjev_id'];
            $status = $row['status'];
            if($status === "0"){ $status = "Odbijen"; } else if($status === NULL) { $status = "Neodgovoreno"; } else { $status = "Prihvaćen"; }
            $vrijeme = $row['datum'];
            ?>
            <tr>
                <td><?php echo $ime . " " . $prezime; ?></td>
                <td><?php echo $zahtjev; ?></td>
                <td><?php echo $status; ?></td>
                <td><?php echo $vrijeme; ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>

<?php
ispisiFooter();
?>