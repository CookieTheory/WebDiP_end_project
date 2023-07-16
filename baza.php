<?php

class Baza {

    private $veza;

    public function __construct() {
        $this->veza = new mysqli("localhost", "WebDiP2021x066", "admin_TfrZ", "WebDiP2021x066");
        if ($this->veza->connect_errno) {
            throw new Exception("Neuspješno spajanje na bazu");
        }
    }

    public function __destruct() {
        $this->veza->close();
    }

    public function izvrsiUpit(string $upit, string $vrsteArgumenata = "", array $argumenti = [], bool $naredba = false) {
        mysqli_set_charset($this->veza,"utf8");
        $pripremljenUpit = $this->veza->prepare($upit);

        if ($pripremljenUpit == false) {
            throw new Exception("Problem s bazom (" . __LINE__ . ")");
        }

        if (!empty($vrsteArgumenata)) {
            if ($pripremljenUpit->bind_param($vrsteArgumenata, ...$argumenti) == false) {
                throw new Exception("Problem s bazom (" . __LINE__ . ")");
            }
        }

        if ($pripremljenUpit->execute() == false) {
            throw new Exception("Problem s bazom (" . __LINE__ . ")");
        }

        if ($naredba == false) {
            return $pripremljenUpit->get_result()->fetch_all(MYSQLI_ASSOC);
        } else {
            return $this->veza->insert_id;
        }
    }
    
    public function standardUpit($upit) {
        mysqli_set_charset($this->veza,"utf8");
        $rezultat = $this->veza->query($upit);
        if ($this->veza->connect_errno) {
            echo "Greška kod upita: {$upit} - " . $this->veza->connect_errno . ", " .
            $this->veza->connect_error;
            $this->greska = $this->veza->connect_error;
        }
        if (!$rezultat) {
            $rezultat = null;
        }
        return $rezultat;
    }

    public function provjeriKorisnika(string $korime) {
        return $this->izvrsiUpit("SELECT EXISTS (SELECT * FROM korisnik WHERE korime = ?) as postoji", "s",
                        [$korime])[0]["postoji"];
    }
    
    public function provjeriID(int $id) {
        return $this->izvrsiUpit("SELECT EXISTS (SELECT * FROM korisnik WHERE korisnik_id = ?) as postoji", "i",
                        [$id])[0]["postoji"];
    }
    
    public function provjeriKategoriju(int $id) {
        return $this->izvrsiUpit("SELECT EXISTS (SELECT * FROM kategorija WHERE kategorija_id = ?) as postoji", "i",
                        [$id])[0]["postoji"];
    }
    
    public function provjeriModeratora(string $korime) {
        return $this->izvrsiUpit("SELECT EXISTS (SELECT * FROM korisnik WHERE korime = ? AND uloga_uloga_id ='2') as postoji", "s",
                        [$korime])[0]["postoji"];
    }
    
    public function provjeriModeratoraKategorije(int $id) {
        return $this->izvrsiUpit("SELECT EXISTS (SELECT * FROM moderator_kategorije WHERE modkategorija_id = ?) as postoji", "i",
                        [$id])[0]["postoji"];
    }
    
    public function provjeriSudski(int $id) {
        return $this->izvrsiUpit("SELECT EXISTS (SELECT * FROM sudski WHERE sudski_id = ?) as postoji", "i",
                        [$id])[0]["postoji"];
    }
    
    public function provjeriSudskiITuzitelja(int $id, int $tuzitelj) {
        return $this->izvrsiUpit("SELECT EXISTS (SELECT * FROM sudski WHERE sudski_id = ? AND tuzitelj_id != ? AND datum_pocetak>CURRENT_TIMESTAMP) as postoji", "ii",
                        [$id, $tuzitelj])[0]["postoji"];
    }
    
    public function provjeriZahtjev(int $id, int $stranka) {
        return $this->izvrsiUpit("SELECT EXISTS (SELECT * FROM zahtjev WHERE zahtjev_id = ? AND stranka_id = ?) as postoji", "ii",
                        [$id, $stranka])[0]["postoji"];
    }

}

?>