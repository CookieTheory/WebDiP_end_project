<?php
if ($_SERVER["HTTPS"] != "on") {
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

if (isset($_POST["prijava"])) {

    $korime = filter_input(INPUT_POST, "korime");
    $lozinka = filter_input(INPUT_POST, "lozinka");
    $upamti = filter_input(INPUT_POST, "upamti");

    require_once './baza.php';

    try {
        $bazaObj = new Baza();
        $korisnikPostoji = $bazaObj->provjeriKorisnika($korime);
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }

    if ($korisnikPostoji) {
        try {
            $prekoracenje = $bazaObj->izvrsiUpit('SELECT broj_prijava FROM korisnik WHERE korime = ?', "s",
                            [$korime])[0]["broj_prijava"];
            $blokiran = $bazaObj->izvrsiUpit('SELECT blokiran FROM korisnik WHERE korime = ?', "s",
                            [$korime])[0]["blokiran"];
            $verificiran = $bazaObj->izvrsiUpit('SELECT verificiran FROM korisnik WHERE korime = ?', "s",
                            [$korime])[0]["verificiran"];
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        if ($blokiran) {
            $problem = "Račun blokiran!";
        } elseif (!$verificiran) {
            $problem = "Račun nije verificiran!";
        } else {
            try {
                $sol = $bazaObj->izvrsiUpit('SELECT sol FROM korisnik WHERE korime = ?', "s",
                                [$korime])[0]["sol"];
            } catch (Exception $ex) {
                echo $ex->getMessage();
            }

            $sha256lozinka = hash("sha256", $lozinka . $sol);

            try {
                $korisnik = $bazaObj->izvrsiUpit("SELECT * FROM korisnik WHERE korime = ? AND lozinka256 = ?", "ss",
                        [$korime, $sha256lozinka]);
            } catch (Exception $ex) {
                echo $ex->getMessage();
            }

            if (empty($korisnik)) {
                try {
                    $brojPrijava = $bazaObj->izvrsiUpit('SELECT broj_prijava FROM korisnik WHERE korime = ?', "s",
                                    [$korime])[0]["broj_prijava"];
                    $novePrijave = $brojPrijava + 1;
                    $prijave = $bazaObj->izvrsiUpit("UPDATE korisnik SET broj_prijava=? WHERE korime=? ", "is",
                            [$novePrijave, $korime], true);
                    if ($novePrijave > 2) {
                        $bazaObj->izvrsiUpit("UPDATE korisnik SET blokiran=? WHERE korime=? ", "is",
                                [1, $korime], true);
                    }
                } catch (Exception $ex) {
                    echo $ex->getMessage();
                }
                $problem = "Neuspjela prijava!";
            } else {
                $poruka = "Dobrodošli!";
                try {
                    $vrati = $bazaObj->izvrsiUpit("UPDATE korisnik SET broj_prijava=? WHERE korime=? ", "is",
                            [0, $korime], true);
                } catch (Exception $ex) {
                    echo $ex->getMessage();
                }
                session_start();
                session_regenerate_id();
                $_SESSION["korime"] = $korisnik[0]["korime"];
                $_SESSION["uloga"] = $korisnik[0]["uloga_uloga_id"];
                $_SESSION["id"] = $korisnik[0]["korisnik_id"];
                if ($_POST['upamti'] === "1") {
                    setcookie("korime", $korisnik[0]["korime"]);
                }
                header("Location: ./index.php");
                exit();
            }
        }
    } else {
        $problem = "<a style='text-decoration: none;color: red;' href='./registracija.php'>Registrirajte se!</a>";
    }
}

$naslov = "Prijava";
require_once './_osnovno.php';
ispisiOstatak();
ispisiNavigaciju();
?>

<h1><a href="prijava.php">Prijava</a></h1>
<form class="forme-podaci" method="POST" action="">
    <label for="korime">Korisničko ime: </label>
    <input type="text" id="korime" name="korime" placeholder="Korisničko ime" required><br>
    <label for="lozinka">Lozinka: </label>
    <input type="password" id="lozinka" name="lozinka" placeholder="lozinka" required><br>
    <span>Zapamti prijavu:</span> DA 
    <input type="radio" id="upamti" name="upamti" value="1"> NE 
    <input type="radio" id="upamtine" name="upamti" value="0" checked><br>
    <button name="prijava" type="submit"> Prijavi se </button>
    <button type="reset"> Obrisi upisano </button>
    <?php
    if (isset($problem)) {
        echo "<p style='color: red'>$problem</p>";
    } else if (isset($poruka)) {
        echo "<p style='color: green'>Uspjeh, dobrodošli {$_POST['korime']}!</p>";
    }
    ?>

    <h3><a href="lozinka.php">Zaboravljena lozinka?</a></h3>
</form>

<?php
ispisiFooter();
?>