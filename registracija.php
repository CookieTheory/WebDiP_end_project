<?php
$problemi = "";

if (isset($_POST["registracija"])) {

    $noviKorisnik = array();

    foreach ($_POST as $key => $value) {

        if ($key == "registracija" || $key == "resetiraj")
            continue;

        $noviKorisnik[$key] = filter_input(INPUT_POST, $key);

        switch ($key) {
            case 'ime': {
                    if (strlen($value) < 3) {
                        $problemi .= "Ime mora biti najmanje 3 slova";
                    }
                    break;
                }
            case 'prezime': {
                    if (strlen($value) > 30) {
                        $problemi .= "Prezime ne može biti duže od 30 slova";
                    }
                    break;
                }
            case 'korime': {
                    if (!preg_match("/^.{3,45}$/", $value)) {
                        $problemi .= "Korisničko ime nije ispravno!<br>";
                    }
                    break;
                }
            case 'email': {
                    if (!preg_match("/^\w+@\w+\.\w{2,4}$/", $value)) {
                        $problemi .= "Mail nije ispravno!<br>";
                    }
                    break;
                }
            case 'lozinka2': {
                    if ($value !== $noviKorisnik["lozinka1"]) {
                        $problemi .= "Ponovljena lozinka nije ispravna!<br>";
                    }
                    break;
                }
        }
    }//foreach zavrsava


    if (isset($_POST['kolacici1'])) {
        $kolacici = 1;
    } else {
        $kolacici = 0;
        $problemi .= "Trebaju se prihvatiti nužni kolačići<br>";
    }
    if (isset($_POST['kolacici2'])) {
        $kolacici .= 1;
    } else {
        $kolacici .= 0;
    }
    if (isset($_POST['kolacici3'])) {
        $kolacici .= 1;
    } else {
        $kolacici .= 0;
    }
    if (!isset($_POST['uvjetiKoristenja'])) {
        $problemi .= "Uvjeti korištenja nisu prihvaćeni!<br>";
    } else {
        $uvjeti = 1;
    }

    if (isset($_POST['godina'])) {
        $godina = $_POST['godina'];
    } else {
        $godina = 0;
    }

    if (empty($problemi)) {
        require_once './baza.php';

        $sol = hash("sha256", random_bytes(25));
        $lozinka256 = hash("sha256", $noviKorisnik["lozinka1"] . $sol);

        try {
            $bazaObj = new Baza();
            $korisnikPostoji = $bazaObj->provjeriKorisnika($noviKorisnik["korime"]);
            if ($korisnikPostoji) {
                $problemi .= "Korisnik s tim imenom postoji!";
            } else {
                $bazaObj->izvrsiUpit("INSERT INTO korisnik(ime,prezime,godina_rodenja,korime,lozinka,sol,lozinka256,email,kolacici,broj_prijava,uvjeti_koristenja,blokiran,verificiran,uloga_uloga_id) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                        "ssisssssiisiii", [$noviKorisnik["ime"], $noviKorisnik["prezime"], $godina, $noviKorisnik["korime"], $noviKorisnik["lozinka1"], $sol, $lozinka256, $noviKorisnik["email"], $kolacici, 0, $uvjeti, 0, 0, 3],
                        true);
                $uspjeh = true;
                if ($uspjeh) {
                    $to = $noviKorisnik["email"];
                    $subject = 'Verifikacija';
                    $message = '
Korisnicko ime: ' . $noviKorisnik["korime"] . '
Sifra: ' . $noviKorisnik["lozinka1"] . '
  
Aktivacija:
http://barka.foi.hr/WebDiP/2021_projekti/WebDiP2021x066/verifikacija.php?email=' . $noviKorisnik["email"] . '&hash=' . $sol . '
  
';

                    $headers = 'From:ilucic@foi.hr' . "\r\n";
                    mail($to, $subject, $message, $headers); // onemoguceno zbog barke
                }
            }
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
}

$naslov = "Registracija";
require_once './_osnovno.php';
echo "<script async src='https://www.google.com/recaptcha/api.js'></script>";
echo '<script>
window.onload = function() {
    var $recaptcha = document.querySelector("#g-recaptcha-response");

    if($recaptcha) {
        $recaptcha.setAttribute("required", "required");
    }
};
</script>';
ispisiOstatak();
ispisiNavigaciju();
?>

<h1><a href="prijava.php">Registracija</a></h1>
<form class="forme-podaci" method="post" action="">
    <label for="ime">Ime: </label>
    <input type="text" id="ime" name="ime" placeholder="Ime" required value="<?php echo @htmlspecialchars($noviKorisnik["ime"]) ?>"><br>
    <span id="ime-problem" class='error'></span>
    <label for="prezime">Prezime: </label>
    <input type="text" id="prezime" name="prezime" placeholder="Prezime" required value="<?php echo @htmlspecialchars($noviKorisnik["prezime"]) ?>"><br>
    <span id="prezime-problem" class='error'></span>
    <label for="godina">Godina rođenja: </label>
    <input type="number" id="godina" min="1900"  name="godina" max="2099" step="1" value="2004"  required><br>
    <span id="godina-problem" class='error'></span>
    <label for="korime">Korisničko ime: </label>
    <input type="text" id="korime" name="korime" placeholder="Korisničko ime" required value="<?php echo @htmlspecialchars($noviKorisnik["korime"]) ?>"><br>
    <span id="korime-problem" class='error'></span>
    <label for="email">Email adresa: </label>
    <input type="email" id="email" name="email" size="25" placeholder="ime.prezime@posluzitelj.xxx" required value="<?php echo @htmlspecialchars($noviKorisnik["email"]) ?>"><br>
    <span id="email-problem" class='error'></span>
    <label for="lozinka1">Lozinka: </label>
    <input type="password" id="lozinka1" name="lozinka1" placeholder="lozinka" required value="<?php echo @htmlspecialchars($noviKorisnik["lozinka1"]) ?>"><br>
    <span id="lozinka1-problem" class='error'></span>
    <label for="lozinka2">Ponovi pozinku: </label>
    <input type="password" id="lozinka2" name="lozinka2" placeholder="lozinka" required><br>
    <span id="lozinka2-problem" class='error'></span>
    <label for="kolacici">Odaberi kolačiće: </label>
    <input id="kolacici1" name="kolacici1" value="1" type = "checkbox"> Nužni
    <input id="kolacici2" name="kolacici2" type = "checkbox" value="1"> Marketinški
    <input id="kolacici3" name="kolacici3" type = "checkbox" value="1"> Analitički <br>
    Prihvaćam uvjete korištenja <input id="uvjetiKoristenja" name="uvjetiKoristenja" value="0" type = "checkbox"> <br>
    <button name="registracija" type="submit"> Registriraj se </button>
    <button name="resetiraj" type="reset"> Obrisi upisano </button><br>
    <div id='captcha' class="g-recaptcha" data-sitekey="6LfUxmAgAAAAACWu6SUBim00sroRk7HtpDWk1ui8"></div>
    <?php
    if (!empty($problemi)) {
        echo "<p style='color: red'>$problemi</p>";
    } else if (isset($uspjeh)) {
        echo "<p style='color: green'>Dobrodošli</p>";
    }
    ?>
</form>

<?php
ispisiFooter();
?>
