<?php
require_once '../baza.php';

$korisnici = new Baza();
$pronadi = $korisnici->standardUpit("SELECT * FROM korisnik");

?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset='utf-8'>
        <title>Korisnici</title>
        <link rel='icon' type='image/x-icon' href='materijali/favicon.ico'>
        <meta name='author' content='Ivan Lucić'>
        <meta name='description' content='1.6.2022.'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <link href='../css/ilucic.css' rel='stylesheet' type='text/css'>
        <script defer src='../javascript/ilucic.js'></script>
    </head>
    <body id='vrh'>
        <header>
            <a class='meni' href='#vrh'><img src='../materijali/menu.png' width='40' height='40' 
                                             alt='Menu'></a>
            <nav>
                <a href='../index.php'>Početna stranica</a>
                <a href='../prijava.php'>Prijava</a>
                <a href='../registracija.php'>Registracija</a>
            </nav>
            <div>
                <a href='index.php'><img src='../materijali/ured.png' width='200' height='100' 
                                         alt='Logo'></a>
            </div>
        </header>

        <main>

            <h1><a href="korisnici.php">Korisnici</a></h1>

            <section>

                <table class='center' border='1'>
                    <tr>
                        <th>ID korisnik</th>
                        <th>Ime</th>
                        <th>Prezime</th>
                        <th>Godina Rođenja</th>
                        <th>Korisničko ime</th>
                        <th>Lozinka</th>
                        <th>Email</th>
                        <th>Kolacici</th>
                        <th>Broj prijava</th>
                        <th>Uvjeti koristenja</th>
                        <th>Blokiran</th>
                        <th>Verificiran</th>
                        <th>Uloga</th>
                        <th>Sol</th>
                        <th>Lozinka256</th>
                    </tr>
                    <?php
                    while ($redovi = $pronadi->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $redovi['korisnik_id']; ?></td>
                            <td><?php echo $redovi['ime']; ?></td>
                            <td><?php echo $redovi['prezime']; ?></td>
                            <td><?php echo $redovi['godina_rodenja']; ?></td>
                            <td><?php echo $redovi['korime']; ?></td>
                            <td><?php echo $redovi['lozinka']; ?></td>
                            <td><?php echo $redovi['email']; ?></td>
                            <td><?php echo $redovi['kolacici']; ?></td>
                            <td><?php echo $redovi['broj_prijava']; ?></td>
                            <td><?php echo $redovi['uvjeti_koristenja']; ?></td>
                            <td><?php echo $redovi['blokiran']; ?></td>
                            <td><?php echo $redovi['verificiran']; ?></td>
                            <td><?php echo $redovi['uloga_uloga_id']; ?></td>
                            <td><?php echo $redovi['sol']; ?></td>
                            <td><?php echo $redovi['lozinka256']; ?></td>
                        </tr>

                        <?php
                    }
                    ?>
                </table>
            </section>
        </main>

        <footer>
            <address>Kontakt: <a href='mailto:ilucic@foi.hr'>Ivan Lucić</a></address>
            <p>&copy; 2022 I.Lucić</p>
        </footer>

    </body>
</html>