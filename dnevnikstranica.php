<?php
require_once './baza.php';

$zahtijevamPrijavu = true;
$trazenaUloga = 1;
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
            data: {columnName: imeStupca, sort: sort, stranica: "dnevnikstranica"},
            success: function (response) {

                $("#odvjetnici tr:not(:first)").remove();

                $("#odvjetnici").append(response);
                if (sort === "asc") {
                    $("#sort").val("desc");
                } else {
                    $("#sort").val("asc");
                }
            }
        });
    }
</script>

<div>
    <input type='hidden' id='sort' value='asc'>
    <table class='center' id='odvjetnici' border='1' cellpadding='10'>
        <tr>
            <th class='poredati' ><span onclick='return sortirajTablicu("dnevnik_id");'>ID dnevnik</span></th>
            <th>ID korisnik</th>
            <th class='poredati' ><span onclick='return sortirajTablicu("vrijeme");'>Vrijeme</span></th>
            <th>ID tipa akcije</th>
        </tr>
        <?php
        $bazaObj = new Baza();
        $result = $bazaObj->standardUpit("SELECT * FROM dnevnik AS d JOIN radnja AS r ON d.radnja_id=r.radnja_id ORDER BY d.dnevnik_id ASC");
        while ($row = mysqli_fetch_array($result)) {
            $id = $row['dnevnik_id'];
            $korisnik_id = $row['korisnik_id'];
            $vrijeme = $row['vrijeme'];
            $radnja = $row['radnja'];
            ?>
            <tr>
                <td><?php echo $id; ?></td>
                <td><?php echo $korisnik_id; ?></td>
                <td><?php echo $vrijeme; ?></td>
                <td><?php echo $radnja; ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>

<?php
ispisiFooter();
?>