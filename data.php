<?php

require_once './baza.php';
$bazaObj = new Baza();

switch ($_POST['stranica']) {
    case 'informacije': {
            $columnName = $_POST['columnName'];
            $sort = $_POST['sort'];

            $select_query = "SELECT k.ime, k.prezime, p.broj_prihvacenih FROM korisnik as k LEFT JOIN (SELECT odvjetnik_id, COUNT(*) as broj_prihvacenih FROM zahtjev WHERE status=1 GROUP BY odvjetnik_id) as p ON k.korisnik_id=p.odvjetnik_id WHERE k.uloga_uloga_id=2 ORDER BY " . $columnName . " " . $sort . " ";

            $result = $bazaObj->standardUpit($select_query);

            $html = '';
            while ($row = mysqli_fetch_array($result)) {
                $ime = $row['ime'];
                $prezime = $row['prezime'];
                $broj_zahtjeva = $row['broj_prihvacenih'];
                if (!$broj_zahtjeva) {
                    $broj_zahtjeva = 0;
                }

                $html .= "<tr>
    <td>" . $ime . "</td>
    <td>" . $prezime . "</td>
    <td>" . $broj_zahtjeva . "</td>
  </tr>";
            }
            break;
        }
    case 'filtrirajInformacije': {
            $datum1 = $_POST['datum1'];
            $datum2 = $_POST['datum2'];
            $sort = $_POST['sort'];

            $select_query = "SELECT k.ime, k.prezime, p.broj_prihvacenih FROM korisnik as k LEFT JOIN (SELECT odvjetnik_id, COUNT(*) as broj_prihvacenih FROM zahtjev WHERE zahtjev.datum>'" . $datum1 . " 00:00:00' AND zahtjev.datum<'" . $datum2 . " 00:00:00' AND status=1 GROUP BY odvjetnik_id) as p ON k.korisnik_id=p.odvjetnik_id WHERE k.uloga_uloga_id=2 ORDER BY p.broj_prihvacenih " . $sort . " ";

            $result = $bazaObj->standardUpit($select_query);

            $html = '';
            while ($row = mysqli_fetch_array($result)) {
                $ime = $row['ime'];
                $prezime = $row['prezime'];
                $broj_zahtjeva = $row['broj_prihvacenih'];
                if (!$broj_zahtjeva) {
                    $broj_zahtjeva = 0;
                }

                $html .= "<tr>
    <td>" . $ime . "</td>
    <td>" . $prezime . "</td>
    <td>" . $broj_zahtjeva . "</td>
  </tr>";
            }
            break;
        }
    case 'galerija': {
            $columnName = $_POST['columnName'];
            $sort = $_POST['sort'];

            $select_query = "SELECT * FROM zahtjev ORDER BY " . $columnName . " " . $sort . " ";

            $result = $bazaObj->standardUpit($select_query);

            $html = '';
            while ($row = mysqli_fetch_array($result)) {
                $id = $row['sudski_postupak_idsudski_postupak'];
                $slika = $row['slika'];

                $html .= "<tr>
    <td>" . $id . "</td>
    <td> <img src='materijali/" . $slika . "' width='200' height='100' 
                                         alt='slika'> </td>
  </tr>";
            }
            break;
        }
    case 'filtrirajTuziteljGalerija': {
            $korime = $_POST['columnName'];

            $bazaObj = new Baza();
            $rezultat = $bazaObj->standardUpit("SELECT z.slika, s.sudski_id, s.datum_pocetak, s.datum_kraj, kor.korime, k.naziv, status.naziv_statusa FROM sudski AS s LEFT JOIN zahtjev AS z ON z.sudski_id=s.sudski_id JOIN kategorija AS k ON k.kategorija_id=s.kategorija_id JOIN korisnik AS kor ON kor.korisnik_id=s.tuzitelj_id JOIN status AS status ON status.status_id=s.status_id WHERE kor.korime='" . $korime . "' GROUP BY s.sudski_id ");
            $html = "";
            while ($row = mysqli_fetch_array($rezultat)) {
                $slika = $row['slika'];
                $sudski_id = $row['sudski_id'];
                $datum1 = $row['datum_pocetak'];
                $datum2 = $row['datum_kraj'];
                $tuzitelj = $row['korime'];
                $knaziv = $row['naziv'];
                $status = $row['naziv_statusa'];
                if ($datum2 === NULL) {
                    $datum2 = "Nije jos završio";
                }
                if ($slika !== NULL) {
                    $html .= '<div class="odvjetnik-card">
        <div class="odvjetnik-card__imeprezime">' . $tuzitelj . '</div>
        <div class="odvjetnik-card__korime">' . $datum1 . '</div>
        <div class="odvjetnik-card__korime">-</div>
        <div class="odvjetnik-card__korime">' . $datum2 . '</div>
        <div class="odvjetnik-card__korime"><img src="./materijali/' . $slika . '" width="200" height="200"></div>
        <div class="odvjetnik-card__korime"> Kategorija: ' . $knaziv . '</div>
        <div class="odvjetnik-card__korime"> Status: ' . $status . '</div>';
                    $html .= '</div>';
                }
            }
            break;
        }
    case 'sortirajDatumGalerija': {
            $sort = $_POST['sort'];

            $html = "";
            $bazaObj = new Baza();
            $rezultat = $bazaObj->standardUpit("SELECT z.slika, s.sudski_id, s.datum_pocetak, s.datum_kraj, kor.korime, k.naziv, status.naziv_statusa, IF((s.datum_kraj IS NULL), DATEDIFF(CURRENT_TIMESTAMP, s.datum_pocetak), DATEDIFF(s.datum_kraj, s.datum_pocetak)) AS vrijeme FROM sudski AS s LEFT JOIN zahtjev AS z ON z.sudski_id=s.sudski_id JOIN kategorija AS k ON k.kategorija_id=s.kategorija_id JOIN korisnik AS kor ON kor.korisnik_id=s.tuzitelj_id JOIN status AS status ON status.status_id=s.status_id GROUP BY s.sudski_id ORDER BY vrijeme " . $sort . " ");
            while ($row = mysqli_fetch_array($rezultat)) {
                $slika = $row['slika'];
                $sudski_id = $row['sudski_id'];
                $datum1 = $row['datum_pocetak'];
                $datum2 = $row['datum_kraj'];
                $tuzitelj = $row['korime'];
                $knaziv = $row['naziv'];
                $status = $row['naziv_statusa'];
                if ($datum2 === NULL) {
                    $datum2 = "Nije jos završio";
                }
                if ($slika !== NULL) {
                    $html .= '<div class="odvjetnik-card">
        <div class="odvjetnik-card__imeprezime">' . $tuzitelj . '</div>
        <div class="odvjetnik-card__korime">' . $datum1 . '</div>
        <div class="odvjetnik-card__korime">-</div>
        <div class="odvjetnik-card__korime">' . $datum2 . '</div>
        <div class="odvjetnik-card__korime"><img src="./materijali/' . $slika . '" width="200" height="200"></div>
        <div class="odvjetnik-card__korime"> Kategorija: ' . $knaziv . '</div>
        <div class="odvjetnik-card__korime"> Status: ' . $status . '</div>';
                    $html .= '</div>';
                }
            }
            break;
        }
    case 'sortirajStatusGalerija': {
            $sort = $_POST['sort'];

            $html = "";
            $bazaObj = new Baza();
            $rezultat = $bazaObj->standardUpit("SELECT z.slika, s.sudski_id, s.datum_pocetak, s.datum_kraj, kor.korime, k.naziv, status.naziv_statusa FROM sudski AS s LEFT JOIN zahtjev AS z ON z.sudski_id=s.sudski_id JOIN kategorija AS k ON k.kategorija_id=s.kategorija_id JOIN korisnik AS kor ON kor.korisnik_id=s.tuzitelj_id JOIN status AS status ON status.status_id=s.status_id GROUP BY s.sudski_id ORDER BY status.status_id " . $sort . " ");
            while ($row = mysqli_fetch_array($rezultat)) {
                $slika = $row['slika'];
                $sudski_id = $row['sudski_id'];
                $datum1 = $row['datum_pocetak'];
                $datum2 = $row['datum_kraj'];
                $tuzitelj = $row['korime'];
                $knaziv = $row['naziv'];
                $status = $row['naziv_statusa'];
                if ($datum2 === NULL) {
                    $datum2 = "Nije jos završio";
                }
                if ($slika !== NULL) {
                    $html .= '<div class="odvjetnik-card">
        <div class="odvjetnik-card__imeprezime">' . $tuzitelj . '</div>
        <div class="odvjetnik-card__korime">' . $datum1 . '</div>
        <div class="odvjetnik-card__korime">-</div>
        <div class="odvjetnik-card__korime">' . $datum2 . '</div>
        <div class="odvjetnik-card__korime"><img src="./materijali/' . $slika . '" width="200" height="200"></div>
        <div class="odvjetnik-card__korime"> Kategorija: ' . $knaziv . '</div>
        <div class="odvjetnik-card__korime"> Status: ' . $status . '</div>';
                    $html .= '</div>';
                }
            }
            break;
        }
    case 'odgovoriPitanje': {
            $id = $_POST['id'];
            $odgovor = $_POST['odgovor'];
            $odvjetnik_id = $_POST['odvjetnik'];

            $update = $bazaObj->standardUpit("UPDATE savjetovanje SET odgovor='" . $odgovor . "' WHERE savjetovanje_id=" . $id . " AND odvjetnik_id=" . $odvjetnik_id . " ");

            $rezultat = $bazaObj->standardUpit("SELECT * FROM savjetovanje WHERE odvjetnik_id=" . $odvjetnik_id . " ");
            $html = "";
            while ($row = mysqli_fetch_array($rezultat)) {
                $id = $row['savjetovanje_id'];
                $razlog = $row['razlog'];
                $opis = $row['opis'];
                $odgovor = $row['odgovor'];
                if ($odgovor === NULL) {
                    $odgovor = '<form style="padding-top:10px;" method="POST" onsubmit="return odgovori(this);">'
                            . '<input type="hidden" id="savjetovanje" name="savjetovanje" value=' . $id . '>'
                            . '<textarea id="odgovor" name="odgovor" placeholder="Odgovor na pitanje" rows="4" cols="40" maxlength="250" required></textarea>'
                            . '<button type="submit">Dodaj odgovor</button>'
                            . '</form>';
                }
                $html .= '<div class="odvjetnik-card">
        <div class="odvjetnik-card__imeprezime">' . $razlog . '</div>
        <div class="odvjetnik-card__korime">' . $opis . '</div>
        <div class="odvjetnik-card__odgovor"> Odgovor: ' . $odgovor . '</div>';
                $html .= '</div>';
            }
            break;
        }
    case 'otkljucavanjeBlokiraj': {
            $columnName = $_POST['columnName'];

            $korisnikPostoji = $bazaObj->provjeriID($columnName);
            if ($korisnikPostoji) {
                $select_query = "SELECT * FROM korisnik WHERE korisnik_id=" . $columnName . " ";
                $result = $bazaObj->standardUpit($select_query);
                $pronaden = mysqli_fetch_array($result);
                $pronadenBlokiran = $pronaden["blokiran"];
                if ($pronadenBlokiran) {
                    $select_query = "UPDATE korisnik SET broj_prijava=0, blokiran=0 WHERE korisnik_id=" . $columnName . " ";
                    $result = $bazaObj->standardUpit($select_query);
                } else {
                    $select_query = "UPDATE korisnik SET blokiran=1 WHERE korisnik_id=" . $columnName . " ";
                    $result = $bazaObj->standardUpit($select_query);
                }
            }

            $select_query = "SELECT * FROM korisnik WHERE blokiran=1 ORDER BY korisnik_id ASC";

            $result = $bazaObj->standardUpit($select_query);

            $html = '';
            while ($row = mysqli_fetch_array($result)) {
                $id = $row['korisnik_id'];
                $ime = $row['korime'];
                $broj_prijava = $row['broj_prijava'];
                $blokiran = $row['blokiran'];
                if ($blokiran === "0") {
                    $blokiran = "Otključan";
                } else {
                    $blokiran = "Blokiran";
                }

                $html .= "<tr>
    <td>" . $id . "</td>
    <td>" . $ime . "</td>
    <td>" . $broj_prijava . "</td>
    <td>" . $blokiran . "</td>
  </tr>";
            }
            break;
        }
    case 'otkljucavanjestranica': {
            $columnName = $_POST['columnName'];
            $sort = $_POST['sort'];

            $select_query = "SELECT * FROM korisnik WHERE blokiran=1 ORDER BY " . $columnName . " " . $sort . " ";

            $result = $bazaObj->standardUpit($select_query);

            $html = '';
            while ($row = mysqli_fetch_array($result)) {
                $id = $row['korisnik_id'];
                $ime = $row['korime'];
                $broj_prijava = $row['broj_prijava'];
                $blokiran = $row['blokiran'];
                if ($blokiran === "0") {
                    $blokiran = "Otključan";
                } else {
                    $blokiran = "Blokiran";
                }

                $html .= "<tr>
    <td>" . $id . "</td>
    <td>" . $ime . "</td>
    <td>" . $broj_prijava . "</td>
    <td>" . $blokiran . "</td>
  </tr>";
            }
            break;
        }
    case 'kreiranjeKategorije': {
            $nazivkat = $_POST['columnName'];
            $opiskat = $_POST['columnName2'];

            $insert = "INSERT INTO kategorija (naziv, opis) VALUES ('" . $nazivkat . "', '" . $opiskat . "')";

            $izvrsi = $bazaObj->standardUpit($insert);

            $select_query = "SELECT k.kategorija_id, kor.ime, kor.prezime, kor.korime, kor.korisnik_id, k.naziv, k.opis FROM kategorija AS k LEFT JOIN moderator_kategorije AS m ON k.kategorija_id=m.modkategorija_id LEFT JOIN korisnik AS kor ON kor.korisnik_id=m.modmoderator_id ORDER BY k.kategorija_id ASC";

            $result = $bazaObj->standardUpit($select_query);

            $html = '';
            while ($row = mysqli_fetch_array($result)) {
                $id = $row['kategorija_id'];
                $ime = $row['ime'];
                $prezime = $row['prezime'];
                $korime = $row['korime'];
                $korisnik_id = $row['korisnik_id'];
                $naziv = $row['naziv'];
                $opis = $row['opis'];

                $html .= "<tr>
    <td>" . $id . "</td>
    <td style='text-align: center;'>" . $ime . " " . $prezime . "</td>
    <td>" . $korime . "</td>
    <td>" . $korisnik_id . "</td>
    <td>" . $naziv . "</td>
    <td>" . $opis . "</td>
  </tr>";
            }
            break;
        }
    case 'azuriranjeKategorije': {
            $columnName = $_POST['columnName'];
            $columnName2 = $_POST['columnName2'];
            $idkat = $_POST['id'];

            $kategorijaPostoji = $bazaObj->provjeriKategoriju($idkat);
            if ($kategorijaPostoji) {
                $update = "UPDATE kategorija SET naziv='" . $columnName . "', opis='" . $columnName2 . "' WHERE kategorija_id='" . $idkat . "' ";

                $result = $bazaObj->standardUpit($update);
            }

            $select_query = "SELECT k.kategorija_id, kor.ime, kor.prezime, kor.korime, kor.korisnik_id, k.naziv, k.opis FROM kategorija AS k LEFT JOIN moderator_kategorije AS m ON k.kategorija_id=m.modkategorija_id LEFT JOIN korisnik AS kor ON kor.korisnik_id=m.modmoderator_id ORDER BY k.kategorija_id ASC";

            $result = $bazaObj->standardUpit($select_query);

            $html = '';
            while ($row = mysqli_fetch_array($result)) {
                $id = $row['kategorija_id'];
                $ime = $row['ime'];
                $prezime = $row['prezime'];
                $korime = $row['korime'];
                $korisnik_id = $row['korisnik_id'];
                $naziv = $row['naziv'];
                $opis = $row['opis'];

                $html .= "<tr>
    <td>" . $id . "</td>
    <td style='text-align: center;'>" . $ime . " " . $prezime . "</td>
    <td>" . $korime . "</td>
    <td>" . $korisnik_id . "</td>
    <td>" . $naziv . "</td>
    <td>" . $opis . "</td>
  </tr>";
            }
            break;
        }
    case 'dodajSavjetovanje': {
            $razlog = $_POST['columnName'];
            $opis = $_POST['columnName2'];
            $odvjetnik = $_POST['odvjetnik'];
            $stranka = $_POST['stranka'];

            $insert = "INSERT INTO savjetovanje (razlog, opis, stranka_id, odvjetnik_id) VALUES ('" . $razlog . "', '" . $opis . "', '" . $stranka . "', '" . $odvjetnik . "')";

            $izvrsi = $bazaObj->standardUpit($insert);

            $bazaObj = new Baza();
            $rezultat = $bazaObj->standardUpit("SELECT * FROM savjetovanje WHERE odvjetnik_id=" . $odvjetnik . " ");
            while ($row = mysqli_fetch_array($rezultat)) {
                $razlog = $row['razlog'];
                $opis = $row['opis'];
                $odgovor = $row['odgovor'];
                if ($odgovor === NULL) {
                    $odgovor = "Nema odgovora trenutno";
                }
                $html = "";
                $html .= '<div class="odvjetnik-card">
        <div class="odvjetnik-card__imeprezime">' . $razlog . '</div>
        <div class="odvjetnik-card__korime">' . $opis . '</div>
        <div class="odvjetnik-card__korime"> Odgovor: ' . $odgovor . '</div>';
                $html .= '</div>';
            }
            break;
        }
    case 'dodajPostupak': {
            $id = $_POST['id'];
            $nazivSudskog = $_POST['nazivSudskog'];
            $radnja = $_POST['radnja'];
            $dokaz = $_POST['dokaz'];
            $vrijeme = $_POST['vrijeme'];
            $odvjetnik = $_POST['odvjetnik'];
            $kategorija = $_POST['kategorija'];

            if ($id === '0') {
                $insert = "INSERT INTO sudski (naziv, radnja, dokaz, datum_pocetak, tuzitelj_id, status_id, kategorija_id) VALUES ('" . $nazivSudskog . "', '" . $radnja . "', '" . $dokaz . "', '" . $vrijeme . "', '" . $odvjetnik . "', '2', '" . $kategorija . "') ";
                $izvrsi = $bazaObj->standardUpit($insert);
            } else {
                $postoji = $bazaObj->provjeriSudski($id);
                if (!$postoji) {
                    $insert = "INSERT INTO sudski (sudski_id, naziv, radnja, dokaz, datum_pocetak, tuzitelj_id, status_id, kategorija_id) VALUES ('" . $id . "', '" . $nazivSudskog . "', '" . $radnja . "', '" . $dokaz . "', '" . $vrijeme . "', '" . $odvjetnik . "', '2', '" . $kategorija . "') ";
                    $izvrsi = $bazaObj->standardUpit($insert);
                } else {
                    $update = "UPDATE sudski SET naziv='" . $nazivSudskog . "', radnja='" . $radnja . "', dokaz='" . $dokaz . "', datum_pocetak='" . $vrijeme . "' WHERE sudski_id=" . $id . " ";
                    $izvrsi = $bazaObj->standardUpit($update);
                }
            }

            $html = "";
            $rezultat = $bazaObj->standardUpit("SELECT * FROM sudski JOIN status AS s ON s.status_id=sudski.status_id WHERE tuzitelj_id=" . $odvjetnik . " AND kategorija_id=" . $kategorija . " ");
            while ($row = mysqli_fetch_array($rezultat)) {
                $sudski_id = $row['sudski_id'];
                $naziv = $row['naziv'];
                $radnja = $row['radnja'];
                $dokaz = $row['dokaz'];
                $datum1 = $row['datum_pocetak'];
                $datum2 = $row['datum_kraj'];
                $status = $row['naziv_statusa'];
                if ($datum2 === NULL) {
                    $datum2 = "Nije jos završio";
                }
                $html .= '<div class="odvjetnik-card">
        <div class="odvjetnik-card__imeprezime">' . $sudski_id . ' - ' . $naziv . '</div>
        <div class="odvjetnik-card__korime">' . $dokaz . '</div>
        <div class="odvjetnik-card__korime">' . $datum1 . '-' . $datum2 . '</div>
        <div class="odvjetnik-card__odgovor"> Status: ' . $status . '</div>';
                $html .= '</div>';
            }
            break;
        }
    case 'dodjelaModa': {
            $columnName = $_POST['columnName'];
            $idkat = $_POST['id'];

            $kategorijaPostoji = $bazaObj->provjeriKategoriju($idkat);
            $moderatorPostoji = $bazaObj->provjeriModeratora($columnName);
            if ($kategorijaPostoji) {
                if ($moderatorPostoji) {
                    $select_query = "SELECT * FROM korisnik WHERE korime='" . $columnName . "' AND uloga_uloga_id='2'";
                    $result = $bazaObj->standardUpit($select_query);
                    $red = mysqli_fetch_array($result);
                    $korid = $red['korisnik_id'];
                    $postojiKombinacija = $bazaObj->provjeriModeratoraKategorije($idkat);
                    if ($postojiKombinacija) {
                        $update = "UPDATE moderator_kategorije SET modmoderator_id='" . $korid . "' WHERE modkategorija_id='" . $idkat . "' ";
                        $result = $bazaObj->standardUpit($update);
                    } else {
                        $update = "INSERT INTO moderator_kategorije (modkategorija_id, modmoderator_id) VALUES ('" . $idkat . "', '" . $korid . "') ";
                        $result = $bazaObj->standardUpit($update);
                    }
                } else {
                    $poruka = "Ne postoji taj moderator";
                }
            } else {
                $poruka = "Ne postoji ta kategorija";
            }

            $select_query = "SELECT k.kategorija_id, kor.ime, kor.prezime, kor.korime, kor.korisnik_id, k.naziv, k.opis FROM kategorija AS k LEFT JOIN moderator_kategorije AS m ON k.kategorija_id=m.modkategorija_id LEFT JOIN korisnik AS kor ON kor.korisnik_id=m.modmoderator_id ORDER BY k.kategorija_id ASC";

            $result = $bazaObj->standardUpit($select_query);

            $html = '';
            while ($row = mysqli_fetch_array($result)) {
                $id = $row['kategorija_id'];
                $ime = $row['ime'];
                $prezime = $row['prezime'];
                $korime = $row['korime'];
                $korisnik_id = $row['korisnik_id'];
                $naziv = $row['naziv'];
                $opis = $row['opis'];

                $html .= "<tr>
    <td>" . $id . "</td>
    <td style='text-align: center;'>" . $ime . " " . $prezime . "</td>
    <td>" . $korime . "</td>
    <td>" . $korisnik_id . "</td>
    <td>" . $naziv . "</td>
    <td>" . $opis . "</td>
  </tr>";
            }
            break;
        }
    case 'popis': {
            $columnName = $_POST['columnName'];
            $sort = $_POST['sort'];

            $select_query = "SELECT k.ime, k.prezime, z.zahtjev_id, z.status, z.datum FROM zahtjev AS z JOIN korisnik AS k ON k.korisnik_id=z.odvjetnik_id ORDER BY z." . $columnName . " " . $sort . " ";

            $result = $bazaObj->standardUpit($select_query);

            $html = '';
            while ($row = mysqli_fetch_array($result)) {
                $ime = $row['ime'];
                $prezime = $row['prezime'];
                $zahtjev = $row['zahtjev_id'];
                $status = $row['status'];
                if ($status === "0") {
                    $status = "Odbijen";
                } else if ($status === NULL) {
                    $status = "Neodgovoreno";
                } else {
                    $status = "Prihvaćen";
                }
                $vrijeme = $row['datum'];

                $html .= "<tr>
    <td>" . $ime . " " . $prezime . "</td>
    <td>" . $zahtjev . "</td>
    <td>" . $status . "</td>
    <td>" . $vrijeme . "</td>
  </tr>";
            }
            break;
        }
    case 'prihvatiZahtjev': {
            $id = $_POST['id'];
            $odvjetnik_id = $_POST['odvjetnik'];

            $update = "UPDATE zahtjev SET status=1 WHERE zahtjev_id =" . $id . " ";
            $bazaObj->standardUpit($update);

            $select = "SELECT z.zahtjev_id, z.status, z.argument_obrane, k.ime, k.prezime FROM zahtjev AS z JOIN sudski AS s ON s.sudski_id=z.sudski_id JOIN korisnik AS k ON k.korisnik_id=z.stranka_id WHERE z.odvjetnik_id=" . $odvjetnik_id . " AND s.tuzitelj_id!=" . $odvjetnik_id . " ORDER BY z.status DESC";
            $result = $bazaObj->standardUpit($select);

            $html = '';
            while ($row = mysqli_fetch_array($result)) {
                $zahtjev_id = $row['zahtjev_id'];
                $status = $row['status'];
                $argument_obrane = $row['argument_obrane'];
                $ime = $row['ime'];
                $prezime = $row['prezime'];
                if ($status === NULL) {
                    $status = "Niste još odlučili";
                } else if ($status === '0') {
                    $status = "Odbijeno";
                } else {
                    $status = "Prihvaćeno";
                }
                $html .= '<div class="odvjetnik-card">
        <div class="odvjetnik-card__imeprezime">' . $zahtjev_id . ' - ' . $ime . ' ' . $prezime . '</div>
        <div class="odvjetnik-card__korime">' . $argument_obrane . '</div>
        <div class="odvjetnik-card__korime">' . $status . '</div>';
                if ($status === "Niste još odlučili") {
                    $html .= '<button onclick="prihvati(' . $zahtjev_id . ')" class="odvjetnik-card__pitanja">Prihvati postupak</button>
            <button onclick="odbij(' . $zahtjev_id . ')" class="odvjetnik-card__pitanja">Odbij postupak</button>';
                }
                $html .= '</div>';
            }
            break;
        }
    case 'odbijZahtjev': {
            $id = $_POST['id'];
            $odvjetnik_id = $_POST['odvjetnik'];

            $update = "UPDATE zahtjev SET status=0 WHERE zahtjev_id =" . $id . " ";
            $bazaObj->standardUpit($update);

            $select = "SELECT z.zahtjev_id, z.status, z.argument_obrane, k.ime, k.prezime FROM zahtjev AS z JOIN sudski AS s ON s.sudski_id=z.sudski_id JOIN korisnik AS k ON k.korisnik_id=z.stranka_id WHERE z.odvjetnik_id=" . $odvjetnik_id . " AND s.tuzitelj_id!=" . $odvjetnik_id . " ORDER BY z.status DESC";
            $result = $bazaObj->standardUpit($select);

            $html = '';
            while ($row = mysqli_fetch_array($result)) {
                $zahtjev_id = $row['zahtjev_id'];
                $status = $row['status'];
                $argument_obrane = $row['argument_obrane'];
                $ime = $row['ime'];
                $prezime = $row['prezime'];
                if ($status === NULL) {
                    $status = "Niste još odlučili";
                } else if ($status === '0') {
                    $status = "Odbijeno";
                } else {
                    $status = "Prihvaćeno";
                }
                $html .= '<div class="odvjetnik-card">
        <div class="odvjetnik-card__imeprezime">' . $zahtjev_id . ' - ' . $ime . ' ' . $prezime . '</div>
        <div class="odvjetnik-card__korime">' . $argument_obrane . '</div>
        <div class="odvjetnik-card__korime">' . $status . '</div>';
                if ($status === "Niste još odlučili") {
                    $html .= '<button onclick="prihvati(' . $zahtjev_id . ')" class="odvjetnik-card__pitanja">Prihvati postupak</button>
            <button onclick="odbij(' . $zahtjev_id . ')" class="odvjetnik-card__pitanja">Odbij postupak</button>';
                }
                $html .= '</div>';
            }
            break;
        }
    case 'filtrirajZahtjevStranke': {
            $id = $_POST['id'];
            $odvjetnik_id = $_POST['odvjetnik'];

            if ($id === '0') {
                $select = "SELECT z.zahtjev_id, z.status, z.argument_obrane, k.ime, k.prezime FROM zahtjev AS z JOIN sudski AS s ON s.sudski_id=z.sudski_id JOIN korisnik AS k ON k.korisnik_id=z.stranka_id WHERE z.odvjetnik_id=" . $odvjetnik_id . " AND s.tuzitelj_id!=" . $odvjetnik_id . " ORDER BY z.status DESC";
            } else {
                $select = "SELECT z.zahtjev_id, z.status, z.argument_obrane, k.ime, k.prezime FROM zahtjev AS z JOIN sudski AS s ON s.sudski_id=z.sudski_id JOIN korisnik AS k ON k.korisnik_id=z.stranka_id WHERE z.odvjetnik_id=" . $odvjetnik_id . " AND s.tuzitelj_id!=" . $odvjetnik_id . " AND z.zahtjev_id=" . $id . " ORDER BY z.status ASC";
            }

            $result = $bazaObj->standardUpit($select);

            $html = "";
            while ($row = mysqli_fetch_array($result)) {
                $zahtjev_id = $row['zahtjev_id'];
                $status = $row['status'];
                $argument_obrane = $row['argument_obrane'];
                $ime = $row['ime'];
                $prezime = $row['prezime'];
                if ($status === NULL) {
                    $status = "Niste još odlučili";
                } else if ($status === '0') {
                    $status = "Odbijeno";
                } else {
                    $status = "Prihvaćeno";
                }
                $html .= '<div class="odvjetnik-card">
        <div class="odvjetnik-card__imeprezime">' . $zahtjev_id . ' - ' . $ime . ' ' . $prezime . '</div>
        <div class="odvjetnik-card__korime">' . $argument_obrane . '</div>
        <div class="odvjetnik-card__korime">' . $status . '</div>';
                if ($status === "Niste još odlučili") {
                    $html .= '<button onclick="prihvati(' . $zahtjev_id . ')" class="odvjetnik-card__pitanja">Prihvati postupak</button>
            <button onclick="odbij(' . $zahtjev_id . ')" class="odvjetnik-card__pitanja">Odbij postupak</button>';
                }
                $html .= '</div>';
            }
            break;
        }
    case 'filtrirajPrihvaceneZahtjeve': {
            $id = $_POST['id'];
            $odvjetnik_id = $_POST['odvjetnik'];

            if ($id === '0') {
                $select = "SELECT z.zahtjev_id, z.status, z.argument_obrane, k.ime, k.prezime, s.status_id, s.datum_pocetak, s.datum_kraj, stat.naziv_statusa FROM zahtjev AS z JOIN sudski AS s ON s.sudski_id=z.sudski_id JOIN status AS stat ON stat.status_id=s.status_id JOIN korisnik AS k ON k.korisnik_id=z.stranka_id WHERE z.odvjetnik_id=" . $odvjetnik_id . " AND s.tuzitelj_id!=" . $odvjetnik_id . " AND z.status=1 ORDER BY z.status ASC";
            } else {
                $select = "SELECT z.zahtjev_id, z.status, z.argument_obrane, k.ime, k.prezime, s.status_id, s.datum_pocetak, s.datum_kraj, stat.naziv_statusa FROM zahtjev AS z JOIN sudski AS s ON s.sudski_id=z.sudski_id JOIN status AS stat ON stat.status_id=s.status_id JOIN korisnik AS k ON k.korisnik_id=z.stranka_id WHERE z.odvjetnik_id=" . $odvjetnik_id . " AND s.tuzitelj_id!=" . $odvjetnik_id . " AND z.status=1 AND z.zahtjev_id=" . $id . " ORDER BY z.status ASC";
            }

            $result = $bazaObj->standardUpit($select);

            $html = "";
            while ($row = mysqli_fetch_array($result)) {
                $zahtjev_id = $row['zahtjev_id'];
                $argument_obrane = $row['argument_obrane'];
                $ime = $row['ime'];
                $prezime = $row['prezime'];
                $status = "Prihvaćeno";
                $datum1 = $row['datum_pocetak'];
                $datum2 = $row['datum_kraj'];
                $status_sudski = $row['status_id'];
                $rjesenje = $row['naziv_statusa'];

                $html .= '<div class="odvjetnik-card">
        <div class="odvjetnik-card__imeprezime">' . $zahtjev_id . ' - ' . $ime . ' ' . $prezime . '</div>
        <div class="odvjetnik-card__korime">' . $argument_obrane . '</div>
        <div class="odvjetnik-card__korime">' . $status . '</div>';
                if ($status_sudski === '2') {
                    $html .= '<textarea id="' . $zahtjev_id . '" name="' . $zahtjev_id . '" placeholder="Unesite/ažurirajte argumente obrane" rows="4" cols="40" maxlength="250"></textarea>
        <button onclick="azuriraj(' . $zahtjev_id . ')" class="odvjetnik-card__pitanja">Unesi/ažuriraj obranu</button>';
                    $html .= '<label for="vrijeme">Vrijeme kraja: </label>
        <input type="datetime-local" id="vrijeme' . $zahtjev_id . '" name="vrijeme' . $zahtjev_id . '" placeholder="Vrijeme početka" required>
        <button onclick="zakljucak(' . $zahtjev_id . ',3)" class="odvjetnik-card__pitanja">Kriv</button>
        <button onclick="zakljucak(' . $zahtjev_id . ',4)" class="odvjetnik-card__pitanja">Nije kriv</button>';
                } else if ($status_sudski !== '2') {
                    $html .= '<div class="odvjetnik-card__korime">' . $datum1 . ' - ' . $datum2 . '</div>
        <div class="odvjetnik-card__korime">' . $rjesenje . '</div>';
                }

                $html .= '</div>';
            }
            break;
        }
    case 'azurirajZahtjev': {
            $id = $_POST['id'];
            $odvjetnik_id = $_POST['odvjetnik'];
            $argument = $_POST['argument'];

            $update = "UPDATE zahtjev SET argument_obrane='" . $argument . "' WHERE zahtjev_id =" . $id . " ";
            $bazaObj->standardUpit($update);

            $select = "SELECT z.zahtjev_id, z.status, z.argument_obrane, k.ime, k.prezime, s.status_id, s.datum_pocetak, s.datum_kraj, stat.naziv_statusa FROM zahtjev AS z JOIN sudski AS s ON s.sudski_id=z.sudski_id JOIN status AS stat ON stat.status_id=s.status_id JOIN korisnik AS k ON k.korisnik_id=z.stranka_id WHERE z.odvjetnik_id=" . $odvjetnik_id . " AND s.tuzitelj_id!=" . $odvjetnik_id . " AND z.status=1 ORDER BY z.status ASC";
            $result = $bazaObj->standardUpit($select);

            $html = '';
            while ($row = mysqli_fetch_array($result)) {
                $zahtjev_id = $row['zahtjev_id'];
                $argument_obrane = $row['argument_obrane'];
                $ime = $row['ime'];
                $prezime = $row['prezime'];
                $status = "Prihvaćeno";
                $datum1 = $row['datum_pocetak'];
                $datum2 = $row['datum_kraj'];
                $status_sudski = $row['status_id'];
                $rjesenje = $row['naziv_statusa'];

                $html .= '<div class="odvjetnik-card">
        <div class="odvjetnik-card__imeprezime">' . $zahtjev_id . ' - ' . $ime . ' ' . $prezime . '</div>
        <div class="odvjetnik-card__korime">' . $argument_obrane . '</div>
        <div class="odvjetnik-card__korime">' . $status . '</div>';
                if ($status_sudski === '2') {
                    $html .= '<textarea id="' . $zahtjev_id . '" name="' . $zahtjev_id . '" placeholder="Unesite/ažurirajte argumente obrane" rows="4" cols="40" maxlength="250"></textarea>
        <button onclick="azuriraj(' . $zahtjev_id . ')" class="odvjetnik-card__pitanja">Unesi/ažuriraj obranu</button>';
                    $html .= '<label for="vrijeme">Vrijeme kraja: </label>
        <input type="datetime-local" id="vrijeme' . $zahtjev_id . '" name="vrijeme' . $zahtjev_id . '" placeholder="Vrijeme početka" required>
        <button onclick="zakljucak(' . $zahtjev_id . ',3)" class="odvjetnik-card__pitanja">Kriv</button>
        <button onclick="zakljucak(' . $zahtjev_id . ',4)" class="odvjetnik-card__pitanja">Nije kriv</button>';
                } else if ($status_sudski !== '2') {
                    $html .= '<div class="odvjetnik-card__korime">' . $datum1 . ' - ' . $datum2 . '</div>
        <div class="odvjetnik-card__korime">' . $rjesenje . '</div>';
                }

                $html .= '</div>';
            }
            break;
        }
    case 'zakljucajZahtjev': {
            $id = $_POST['id'];
            $odvjetnik_id = $_POST['odvjetnik'];
            $vrijeme = $_POST['vrijeme'];
            $zakljucak = $_POST['kraj'];

            $html = '';
            $nadiSudski = $bazaObj->standardUpit("SELECT z.sudski_id, DATEDIFF('" . $vrijeme . "', s.datum_pocetak) AS vrijeme FROM zahtjev AS z JOIN sudski AS s ON s.sudski_id=z.sudski_id WHERE zahtjev_id=" . $id . " ");
            while ($row = mysqli_fetch_array($nadiSudski)) {
                $sudski = $row['sudski_id'];
                $razlika = $row['vrijeme'];
            }
            if ($razlika < 7) {
                $nije = 1;
            } else {
                $nije = 0;
                $update = "UPDATE sudski SET status_id=" . $zakljucak . ", datum_kraj='" . $vrijeme . "' WHERE sudski_id=" . $sudski . " ";
                $bazaObj->standardUpit($update);
            }

            $bazaObj = new Baza();
            $rezultat = $bazaObj->standardUpit("SELECT z.zahtjev_id, z.status, z.argument_obrane, k.ime, k.prezime, s.status_id, s.datum_pocetak, s.datum_kraj, stat.naziv_statusa FROM zahtjev AS z JOIN sudski AS s ON s.sudski_id=z.sudski_id JOIN status AS stat ON stat.status_id=s.status_id JOIN korisnik AS k ON k.korisnik_id=z.stranka_id WHERE z.odvjetnik_id=" . $odvjetnik_id . " AND s.tuzitelj_id!=" . $odvjetnik_id . " AND z.status=1 ORDER BY z.status ASC");
            while ($row = mysqli_fetch_array($rezultat)) {
                $zahtjev_id = $row['zahtjev_id'];
                $argument_obrane = $row['argument_obrane'];
                $ime = $row['ime'];
                $prezime = $row['prezime'];
                $status = "Prihvaćeno";
                $datum1 = $row['datum_pocetak'];
                $datum2 = $row['datum_kraj'];
                $status_sudski = $row['status_id'];
                $rjesenje = $row['naziv_statusa'];

                $html .= '<div class="odvjetnik-card">
        <div class="odvjetnik-card__imeprezime">' . $zahtjev_id . ' - ' . $ime . ' ' . $prezime . '</div>
        <div class="odvjetnik-card__korime">' . $argument_obrane . '</div>
        <div class="odvjetnik-card__korime">' . $status . '</div>';
                if ($status_sudski === '2') {
                    $html .= '<textarea id="' . $zahtjev_id . '" name="' . $zahtjev_id . '" placeholder="Unesite/ažurirajte argumente obrane" rows="4" cols="40" maxlength="250"></textarea>
        <button onclick="azuriraj(' . $zahtjev_id . ')" class="odvjetnik-card__pitanja">Unesi/ažuriraj obranu</button>';
                    if ($nije === 1) {
                        $html .= '<p style="text-align:center">Nije prošlo 7 dana od početka</p>';
                    }
                    $html .= '<label for="vrijeme">Vrijeme kraja: </label>
        <input type="datetime-local" id="vrijeme' . $zahtjev_id . '" name="vrijeme' . $zahtjev_id . '" placeholder="Vrijeme početka" required>
        <button onclick="zakljucak(' . $zahtjev_id . ',3)" class="odvjetnik-card__pitanja">Kriv</button>
        <button onclick="zakljucak(' . $zahtjev_id . ',4)" class="odvjetnik-card__pitanja">Nije kriv</button>';
                } else if ($status_sudski !== '2') {
                    $html .= '<div class="odvjetnik-card__korime">' . $datum1 . ' - ' . $datum2 . '</div>
        <div class="odvjetnik-card__korime">' . $rjesenje . '</div>';
                }

                $html .= '</div>';
            }
            break;
        }
    case 'dnevnikstranica': {
            $columnName = $_POST['columnName'];
            $sort = $_POST['sort'];

            $select_query = "SELECT * FROM dnevnik AS d JOIN radnja AS r ON d.radnja_id=r.radnja_id ORDER BY d." . $columnName . " " . $sort . " ";

            $result = $bazaObj->standardUpit($select_query);

            $html = '';
            while ($row = mysqli_fetch_array($result)) {
                $id = $row['dnevnik_id'];
                $korisnik_id = $row['korisnik_id'];
                $vrijeme = $row['vrijeme'];
                $radnja = $row['radnja'];

                $html .= "<tr>
    <td>" . $id . "</td>
    <td>" . $korisnik_id . "</td>
    <td>" . $vrijeme . "</td>
    <td>" . $radnja . "</td>
  </tr>";
            }
            break;
        }
}



echo $html;
