<?php
require_once './baza.php';

$zahtijevamPrijavu = true;
$trazenaUloga = 1;
$naslov = "Kategorije";
require_once './_osnovno.php';
ispisiOstatak();
ispisiNavigaciju();
?>

<script>
    function kreiranje(forma) {

        var nazivkat = forma.nazivkat.value;
        var opiskat = forma.opiskat.value;
        $.ajax({
            url: 'data.php',
            type: 'post',
            data: {columnName: nazivkat, columnName2: opiskat, stranica: "kreiranjeKategorije"},
            success: function (response) {

                $("#kategorije tr:not(:first)").remove();

                $("#kategorije").append(response);
            }
        });
        return false;
    }
</script>

<section class='odvoji'>
    <form class="forme-podaci" method="POST" onsubmit="return kreiranje(this);">
        <h5>Kreiraj novu kategoriju</h5>
        <label for="nazivkat">Naziv kategorije: </label>
        <input type="text" id="nazivkat" name="nazivkat" placeholder="Naziv kategorije" required><br>
        <label for="opiskat">Opis kategorije: </label>
        <textarea id="opiskat" name="opiskat" placeholder="Opis kategorije" rows="4" cols="50" required></textarea><br>

        <button type="submit"> Kreiraj </button>
    </form>
</section>

<script>
    function azuriranje(forme) {

        var idkat = forme.idkat.value;
        var katnaziv = forme.katnaziv.value;
        var opiskat = forme.opiskat.value;
        $.ajax({
            url: 'data.php',
            type: 'post',
            data: {columnName: katnaziv, columnName2: opiskat, stranica: "azuriranjeKategorije", id: idkat},
            success: function (response) {

                $("#kategorije tr:not(:first)").remove();

                $("#kategorije").append(response);
            }
        });
        return false;
    }
</script>

<section class='odvoji'>
    <form class="forme-podaci" method="POST" onsubmit="return azuriranje(this);">
        <h5>Ažuriraj kategoriju</h5>
        <label for="idkat">ID kategorije: </label>
        <input type="number" id="idkat" name="idkat" placeholder="ID kategorije" required><br>
        <label for="katnaziv">Naziv kategorije: </label>
        <input type="text" id="katnaziv" name="katnaziv" placeholder="Naziv kategorije" required><br>
        <label for="opiskat">Opis kategorije: </label>
        <textarea id="opiskat" name="opiskat" placeholder="Opis kategorije" rows="4" cols="50" required></textarea><br>

        <button type="submit"> Ažuriraj </button>
    </form>
</section>

<script>
    function dodjela(forme) {

        var idkat = forme.idkat.value;
        var korime = forme.korime.value;
        $.ajax({
            url: 'data.php',
            type: 'post',
            data: {columnName: korime, stranica: "dodjelaModa", id: idkat},
            success: function (response) {

                $("#kategorije tr:not(:first)").remove();

                $("#kategorije").append(response);
            }
        });
        return false;
    }
</script>

<section class='odvoji'>
    <form class="forme-podaci" method="POST" onsubmit="return dodjela(this);">
        <h5>Dodjeli moderatora</h5>
        <label for="idkat">ID kategorije: </label>
        <input type="number" id="idkat" name="idkat" placeholder="ID kategorije" required><br>
        <label for="korime">Korisničko ime moderatora: </label>
        <input type="text" id="korime" name="korime" placeholder="Korisničko ime moderatora" required><br>

        <button type="submit"> Dodaj/ažuriraj </button>
    </form>
</section>

<div>
    <table class='center' id='kategorije' border='1' cellpadding='10'>
        <tr>
            <th>ID kategorije</th>
            <th>Ime i prezime moderatora</th>
            <th>Korisničko ime</th>
            <th>ID moderatora</th>
            <th>Naziv kategorije</th>
            <th>Opis kategorije</th>
        </tr>
        <?php
        $bazaObj = new Baza();
        $result = $bazaObj->standardUpit("SELECT k.kategorija_id, kor.ime, kor.prezime, kor.korime, kor.korisnik_id, k.naziv, k.opis FROM kategorija AS k LEFT JOIN moderator_kategorije AS m ON k.kategorija_id=m.modkategorija_id LEFT JOIN korisnik AS kor ON kor.korisnik_id=m.modmoderator_id ORDER BY k.kategorija_id ASC");
        while ($row = mysqli_fetch_array($result)) {
            $id = $row['kategorija_id'];
            $ime = $row['ime'];
            $prezime = $row['prezime'];
            $korime = $row['korime'];
            $korisnik_id = $row['korisnik_id'];
            $naziv = $row['naziv'];
            $opis = $row['opis'];
            ?>
            <tr>
                <td><?php echo $id; ?></td>
                <td style='text-align: center;'><?php echo $ime . " " . $prezime; ?></td>
                <td><?php echo $korime; ?></td>
                <td><?php echo $korisnik_id; ?></td>
                <td><?php echo $naziv; ?></td>
                <td><?php echo $opis; ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>

<?php
ispisiFooter();
?>
