<?php

include "broker.php";

$broker=Broker::getBroker();

if(isset($_GET["metoda"])){
    if($_GET["metoda"]=="vratiSve"){
        $broker->vratiSalone();
        posalji($broker);
    }
}
if(isset($_POST["metoda"])){
    if($_POST["metoda"]=="dodaj"){
        $naziv=$_POST["naziv"];
        $adresa=$_POST["adresa"];
    if(!validirajSalon($naziv,$adresa)){
        echo "salon nije validan";
    }else{
        $broker->dodajSalon($naziv,$adresa);
        if(!$broker->getRezultat()){
            echo "greska pri dodavanju";
        }else{
            echo "ok";
        }
    }
    }
    if($_POST["metoda"]=="izmeni"){
        $naziv=$_POST["naziv"];
        $adresa=$_POST["adresa"];
        $id=$_POST["id"];
        if(!validirajSalon($naziv,$adresa)){
            echo "salon nije validan";
        }else{
            $broker->izmeniSalon($id,$naziv,$adresa);
        if(!$broker->getRezultat()){
            echo "greska pri dodavanju";
        }else{
            echo "ok";
        }
        }
    }
    if($_POST["metoda"]=="obrisi"){
        $broker->obrisiSalon($_POST["id"]);
        if(!$broker->getRezultat()){
            echo "greska pri brisanju";
        }else{
            echo "ok";
        }
    }
    if($_POST["metoda"]=="dodajVezu"){
        if(!intval($_POST["brojPrimeraka"]) || intval($_POST["brojPrimeraka"])<1){
            echo "Broj primeraka mora biti pozitivan broj";
        }else{
            $broker->dodajVezu($_POST["salon"],$_POST["auto"],$_POST["brojPrimeraka"]);
            if(!$broker->getRezultat()){
                echo "greska pri dodavanju";
            }else{
                echo "ok";
            }
        }
    }
    if($_POST["metoda"]=="obrisiVezu"){
        $broker->obrisiVezu($_POST["salon"],$_POST["auto"]);
        if(!$broker->getRezultat()){
            echo "greska pri brisanju";
        }else{
            echo "ok";
        }
    }
}

function posalji($broker){
    $rezultat=$broker->getRezultat();
    $response=array();
    if(!$rezultat){
        $response["status"]="greska u bazi";
        
    }else{
        $response["status"]="ok";
        $response["data"]=array();
        while($red=$rezultat->fetch_object()){
            $response["data"][]=$red;
        }
    }
    echo json_encode($response);
}
function validirajSalon($naziv,$adresa){
    $naziv=trim($naziv);
    $adresa=trim($adresa);
    return strlen($naziv)>3 && strlen($naziv)<40 && strlen($adresa)<40 && preg_match("/^[A-Za-z][A-Za-z\s]*([1-9][0-9]*|bb)$/",$adresa);
}
?>