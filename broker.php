<?php


class Broker{

    private $rezultat;
    private $mysqli;
    private static $broker;
    public function getRezultat(){
        return $this->rezultat;
    }
    public function getMysqli(){
        return $this->mysqli;
    }
    private function __construct(){
        $this->mysqli = new mysqli("localhost", "root", "", "baza_rentacar");
        $this->mysqli->set_charset("utf8");
    }

    public static function getBroker(){
        if(!isset($broker)){
            $broker=new Broker();
        }
        return $broker;
    }
    private function izvrsiUpit($upit){
        $this->rezultat=$this->mysqli->query($upit);
    }
    public function vratiSveAute(){
        $this->izvrsiUpit("select k.*, kat.naziv as 'kategorija', kat.id as 'kat_id' from auto k inner join kategorija_auto kat on (kat.id=k.kategorija)");
    }

    public function vratiSveAuteIzSalona($salon){
        $this->izvrsiUpit("select k.*, kat.naziv as 'kategorija', kat.id as 'kat_id', bk.broj_primeraka as 'brojPrimeraka' from auto k inner join kategorija_auto kat on (kat.id=k.kategorija) inner join salon_auto bk on (bk.auto=k.id) where bk.salon=".$salon);
    }
    public function vratiSveKategorije(){
        $this->izvrsiUpit("select * from kategorija_auto");
    }
    public function dodajAuto($naziv,$kat,$brojS){
        $this->izvrsiUpit("insert into auto (naziv,kategorija,broj_auta) values ('".$naziv."',".$kat.", ".$brojS.")");
    }
    public function obrisiAuto($id){
        $this->izvrsiUpit("delete from auto where id=".$id);
    }
    public function izmeniAuto($id,$naziv,$kat,$brojS){
        $this->izvrsiUpit("update auto set naziv='".$naziv."', kategorija=".$kat.", broj_auta=".$brojS." where id=".$id);
    }
    public function vratiSalone(){
        $this->izvrsiUpit("select * from salon");
    }
    public function dodajSalon($naziv,$adresa){
        $this->izvrsiUpit("insert into salon(naziv,adresa) values ('".$naziv."','".$adresa."')");
    }
    public function obrisiSalon($id){
        $this->izvrsiUpit("delete from salon where id=".$id);
    }
    public function dodajVezu($b,$k,$bp){
        $this->izvrsiUpit("insert into salon_auto values (".$b.",".$k.",".$bp.")");
    }
    public function obrisiVezu($b,$k){
        $this->izvrsiUpit("delete from salon_auto where salon=".$b." and auto=".$k);
    }
    public function izmeniSalon($id,$n,$a){
        $this->izvrsiUpit("update salon set naziv='".$n."', adresa='".$a."' where id=".$id);
    }
}
