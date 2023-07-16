<?php

if ($_SERVER["HTTPS"] != "on") {
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

if (isset($_POST["promijeni"])) {

    $korime = filter_input(INPUT_POST, "korime");
    $email = filter_input(INPUT_POST, "email");

    require_once './baza.php';

    try {
        $bazaObj = new Baza();
        $korisnikPostoji = $bazaObj->provjeriKorisnika($korime);
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }

    if ($korisnikPostoji) {
        try {
            $korisnik = $bazaObj->izvrsiUpit("SELECT * FROM korisnik WHERE korime = ? AND email = ?", "ss",
                    [$korime, $email]);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }

        if (empty($korisnik)) {
            $problem = "Ne postoji ta email adresa!";
        } else {
            $abeceda = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $lozinka = substr(str_shuffle($abeceda), 0, 8);
            //echo $lozinka;
            $sol = hash("sha256", random_bytes(25));
            $lozinka256 = hash("sha256", $lozinka . $sol);
            try {
                $promjena = $bazaObj->izvrsiUpit("UPDATE korisnik SET lozinka=? WHERE korime=? AND email=?", "sss",
                        [$lozinka, $korime, $email], true);
                $promjena2 = $bazaObj->izvrsiUpit("UPDATE korisnik SET sol=? WHERE korime=? AND email=?", "sss",
                        [$sol, $korime, $email], true);
                $promjena3 = $bazaObj->izvrsiUpit("UPDATE korisnik SET lozinka256=? WHERE korime=? AND email=?", "sss",
                        [$lozinka256, $korime, $email], true);
                $uspjeh = true;
            } catch (Exception $ex) {
                echo $ex->getMessage();
            }
            if ($uspjeh) {
                $poruka = "Uspješno promjenjena lozinka, provjerite e-mail!";
                $to = $email;
                $subject = 'Promjena lozinke';
                $message = '
Korisnicko ime: ' . $korime . '
Sifra: ' . $lozinka;

                $headers = 'From:ilucic@foi.hr' . "\r\n";
mail($to, $subject, $message, $headers); // onemoguceno zbog barke
            }
        }
    } else {
        $problem = "Ne postoji taj korisnik!";
    }
}

$naslov = "Zaboravljena lozinka";
require_once './_osnovno.php';
ispisiOstatak();
ispisiNavigaciju();
?>

<form class="forme-podaci" method="POST" action="">
    <label for="korime">Korisničko ime: </label>
    <input type="text" id="korime" name="korime" placeholder="Korisničko ime" required value="<?php echo @htmlspecialchars($korime) ?>"><br>
    <label for="email">Email adresa: </label>
    <input type="email" id="email" name="email" size="25" placeholder="ime.prezime@posluzitelj.xxx" required value="<?php echo @htmlspecialchars($email) ?>"><br>
    <button name="promijeni" type="submit"> Promijeni lozinku </button>
    <?php
    if (isset($problem)) {
        echo "<p style='color: red'>$problem</p>";
    } else if (isset($poruka)) {
        echo "<p style='color: green'>{$poruka}</p>";
    }
    ?>
</form>

<?php
ispisiFooter();
?>