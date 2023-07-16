window.addEventListener("load", kreirajDogadaje);
/*document.addEventListener("readystatechange", () => {
 
 if(document.readyState !== "complete") return;
 
 });*/
function kreirajDogadaje() {

    var cookieuvjeti = (document.cookie.match(/uvjetikoristenja/) || [, null])[1];
    //console.log(cookieuvjeti);
    if (!(/uvjetikoristenja/.test(document.cookie))) {
        if (window.confirm("Ta korištenje ove stranice morate prihvatiti kolačiće uvjeta korištenja!")) {
            var istjece = (new Date(Date.now() + 180000 * 1000)).toUTCString();
            document.cookie = 'uvjetikoristenja=true;expires=' + istjece;
        } else {
            window.location.replace("https://www.google.com");
        }
    }

    switch (document.location.pathname) {
        case "/WebDiP/2021_projekti/WebDiP2021x066/registracija.php":
        {

            var problemi = [];

            var korime = document.getElementById("korime");
            var email = document.getElementById("email");
            var lozinka1 = document.getElementById("lozinka1");
            var lozinka2 = document.getElementById("lozinka2");
            var godina = document.getElementById("godina");

            function provjeriIspravnost(nazivElementa) {
                if (problemi[nazivElementa] === false) {
                    document.getElementById(nazivElementa).style.border = "3px lightgreen solid";
                    document.getElementById(`${nazivElementa}-problem`).innerHTML = "";
                } else {
                    document.getElementById(nazivElementa).style.border = "3px red solid";
                    document.getElementById(`${nazivElementa}-problem`).innerHTML = problemi[nazivElementa] + "<br>";
                }
            }

            async function korimeProvjera() {
                if (RegExp(/^.{3,45}$/).test(korime.value) === false) {
                    problemi["korime"] = "Korisničko ime nije valjano!";
                } else {

                    const odgovorJSON = await fetch(`./api/servisi.php?korime=${korime.value}`);
                    const odgovor = await odgovorJSON.json();

                    if (odgovor.podaci === 1) {
                        problemi["korime"] = odgovor.poruka;
                    } else {
                        problemi["korime"] = false;
                    }
                }
                provjeriIspravnost("korime");
            }
            function emailProvjera() {
                if (RegExp(/^\w+@\w+\.\w{2,4}$/).test(email.value) === false) {
                    problemi["email"] = "Unesite valjan email!";
                } else {
                    problemi["email"] = false;
                }
                provjeriIspravnost("email");
            }
            function lozinkaProvjera() {
                if (RegExp(/^(?=.*\d)(?=.*[a-zšđčćžŠĐČĆŽ])[\wšđčćžŠĐČĆŽ]{4,}$/).test(lozinka1.value) === false) {
                    problemi["lozinka1"] = "Lozinka treba sadržavati barem jedno slovo i broj te minimalne dužine od 4 znaka!";
                } else {
                    problemi["lozinka1"] = false;
                }
                if (lozinka2.value.length)
                    lozinkaPonovljenaProvjera();
                provjeriIspravnost("lozinka1");
            }
            function lozinkaPonovljenaProvjera() {
                if (lozinka2.value !== lozinka1.value || lozinka2.value.length === 0) {
                    problemi["lozinka2"] = "Lozinke se ne podudaraju!";
                } else {
                    problemi["lozinka2"] = false;
                }
                provjeriIspravnost("lozinka2");
            }
            function godinaProvjera() {
                if (godina.value > new Date().getFullYear()) {
                    problemi["godina"] = "Unesena godina je veća od trenutne godine!";
                } else {
                    problemi["godina"] = false;
                }
                provjeriIspravnost("godina");
            }

            korime.addEventListener("focusout", korimeProvjera);
            email.addEventListener("focusout", emailProvjera);
            lozinka1.addEventListener("focusout", lozinkaProvjera);
            lozinka2.addEventListener("focusout", lozinkaPonovljenaProvjera);
            godina.addEventListener("focusout", godinaProvjera);

            document.querySelector(".forme-podaci").addEventListener("submit", (event) => {

                korimeProvjera();
                emailProvjera();
                lozinkaProvjera();
                lozinkaPonovljenaProvjera();
                godinaProvjera();

                for (let index = 0; index < problemi.length; index++) {
                    if (problemi[index] !== false) {
                        event.preventDefault();
                    }
                }
            });

            break;
        }
        case "/WebDiP/2021_projekti/WebDiP2021x066/prijava.php":
        {
            zapamceniKorisnik();

            function zapamceniKorisnik() {
                var postavi = dohvatiCookie("korime");
                console.log(postavi);
                if (postavi) {
                    document.getElementById('korime').value = postavi;
                }
            }

            function dohvatiCookie(ime) {
                let name = ime + "=";
                let dekodiranicookie = decodeURIComponent(document.cookie);
                let cookiebroj = dekodiranicookie.split(';');
                for (let i = 0; i < cookiebroj.length; i++) {
                    let c = cookiebroj[i];
                    while (c.charAt(0) === ' ') {
                        c = c.substring(1);
                    }
                    if (c.indexOf(name) === 0) {
                        return c.substring(name.length, c.length);
                    }
                }
            }

            break;
        }
    }
}