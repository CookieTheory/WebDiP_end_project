<?php

require_once './baza.php';

if(isset($_GET["id"])){
    $odvjetnik_id = filter_input(INPUT_GET, "id");
} else {
    header("Location: ./index.php");
    exit();
}

$zahtijevamPrijavu = true;
$trazenaUloga = 3;
$naslov = "Zahtjevi";
require_once './_osnovno.php';
ispisiOstatak();
ispisiNavigaciju();

$stranka_id = $_SESSION["id"];
?>

<section class="odvoji">
    
    <form class="forme-podaci" method="POST" enctype="multipart/form-data" action="upload.php">
        <h5>Postavi zahtjev</h5>
        <label for="sudski_id">ID sudskog postupka protiv Vas: </label>
        <input type="number" id="sudski_id" name="sudski_id" placeholder="ID sudskog" min="0" required><br>
        <label for="slika">Dodaj sliku: </label>
        <input type="file" name="slika" id="slika"><br>
        <input type='hidden' name="odvjetnik" id='odvjetnik' value="<?php echo $odvjetnik_id; ?>" >
        <input type='hidden' name="stranka" id='stranka' value="<?php echo $stranka_id; ?>" >

        <button type="submit"> Postavi </button>
    </form>
</section>




<?php

ispisiFooter();
?>
