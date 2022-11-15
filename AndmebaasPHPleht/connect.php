<?php
//$kasutaja = 'd113370_ednever';
$kasutaja='neverovskiTARpv21';
//$server = 'd113370.mysql.zonevs.eu';
$server ='localhost';
//$andmebaas = 'd113370_baasedn';
$andmebaas = 'neverovskiTARpv21';
//$salasyna = '';
$salasyna = 'mby9wD@ICFVuOQn2';
//teeme käsk mis ühendab andmebaasiga
$yhendus = new mysqli($server, $kasutaja, $salasyna, $andmebaas);
$yhendus->set_charset('UTF8');
/*
create table loomad(
    id int primary key AUTO_INCREMENT,
    loomanimi varchar(15),
    vanus int,
    pilt text,
    silmadvarv varchar(20))
*/
?>

