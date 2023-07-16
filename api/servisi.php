<?php

ob_clean();
header_remove();
header("Content-type: application/json; charset=UTF-8");

require_once '../baza.php';

function uspjeh($poruka, $podaci){
    die(json_encode(["uspjeh"=>true, "poruka"=>$poruka, "podaci"=>$podaci]));
}

function neuspjeh($poruka){
    http_response_code(500);
    die(json_encode(["uspjeh"=>true, "poruka"=>$poruka, "podaci"=>[]]));
}

if(isset($_GET["korime"])){
    
    $korime = filter_input(INPUT_GET, "korime");
    
    try{
        $bazaObj = new Baza();
        $rezultat = $bazaObj->provjeriKorisnika($korime);
        
        $poruka = $rezultat  ? "Korisničko ime zauzeto!" : "Korisničko ime slobodno.";
        
        uspjeh($poruka, $rezultat);
    } catch (Exception $ex) {
        neuspjeh($ex->getMessage());
    }
}