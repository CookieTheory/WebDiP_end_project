<?php

@session_start();

if (isset($_SESSION["korime"]) == false && @$zahtijevamPrijavu == true) {
    header("Location: ./index.php");
    var_dump($_SESSION["korime"]);
    exit();
} elseif (@$zahtijevamPrijavu == true && $_SESSION['uloga'] > @$trazenaUloga) {
    header("Location: ./index.php");
    exit();
}

echo "<!DOCTYPE html>

<html>
    <head>
        <meta charset='utf-8'>
        <title>$naslov</title>
        <link rel='icon' type='image/x-icon' href='materijali/favicon.ico'>
        <meta name='author' content='Ivan Lucić'>
        <meta name='description' content='1.6.2022.'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link href='css/ilucic.css' rel='stylesheet' type='text/css'>
        <script defer src='javascript/ilucic.js'></script>
        <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js'></script> 
        ";

function ispisiOstatak() {
    echo "</head>
    <body id='vrh'>
        <header>
            <a class='meni' href='#vrh'><img src='materijali/menu.png' width='40' height='40' 
                                             alt='Menu'></a>
            <nav>
                <a href='index.php'>Početna stranica</a>";
    if (isset($_SESSION["korime"]) == true) {
        echo "<a href='informacije.php'>Informacije</a>
                <a href='galerija.php'>Galerija</a>";
    } else {
        echo "<a href='prijava.php'>Prijava</a>
                <a href='registracija.php'>Registracija</a>
                <a href='informacije.php'>Informacije</a>
                <a href='galerija.php'>Galerija</a>";
    }
}

function ispisiNavigaciju() {

    if (isset($_SESSION["korime"]) == true && $_SESSION['uloga'] < 4) {
        echo "<a href='popis.php'>Popis</a>";
        echo "<a href='savjetovanja.php'>Savjetovanja</a>";
        echo "<a href='zahtjevi.php'>Zahtjevi</a>";
    }
    if (isset($_SESSION["korime"]) == true && $_SESSION['uloga'] < 3) {
        echo "<a href='pitanja.php'>Pitanja</a>";
        echo "<a href='sudski.php'>Postupci</a>";
        echo "<a href='stranke.php'>Stranke</a>";
        echo "<a href='obrane.php'>Obrane</a>";
    }
    if (isset($_SESSION["korime"]) == true && $_SESSION['uloga'] === 1) {
        echo "<a href='otkljucavanje.php'>Otključavanje</a>
                <a href='kategorije.php'>Kategorije</a>
                <a href='dnevnikstranica.php'>Dnevnik</a>";
    }
    echo "</nav>
        " . (isset($_SESSION['korime']) ? "<a class='desno' style='color:red' href='odjava.php'>Odjava</a><span class='desno' style='color:green'>{$_SESSION['korime']}</span>" : "") . "
            <div>
                <a href='index.php'><img src='materijali/ured.png' width='200' height='100' 
                                         alt='Logo'></a>
            </div> 
        </header>

        <main>";
}

function ispisiFooter() {
    echo "</main>

        <footer>
            <address>Kontakt: <a href='mailto:ilucic@foi.hr'>Ivan Lucić</a></address><br>
            <a href='o_autoru.html'>O autoru</a><br>
            <a href='dokumentacija.html'>Dokumentacija</a>
            <p>&copy; 2022 I.Lucić</p>
        </footer>

    </body>
    </html>";
}
