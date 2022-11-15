<?php
require_once ('connect.php');
global  $yhendus;

if(isset($_REQUEST['lisamisvorm']) && !empty($_REQUEST['nimi']))
{
    $paring = $yhendus->prepare("INSERT INTO arvuti(arvutiNimi, hind, pilt) VALUES (?,?,?)");
    $paring->bind_param('siss', $_REQUEST['nimi'],$_REQUEST['hind'],$_REQUEST['pilttext']);
    $paring->execute();
    header("Location: $_SERVER[PHP_SELF]");
}
if(isset($_REQUEST['Kustuta']))
{
    $paring = $yhendus->prepare("DELETE FROM arvuti where id=?");
    $paring->bind_param('i', $_REQUEST['Kustuta']);
    $paring->execute();
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>ArvutiPood</title>
</head>
<body>
<h1>Arvutite baas</h1>
<div id="meny">
    <ul>
        <?php
        //näitab loomade loetelu tabelist loomad
        $paring = $yhendus->prepare("SELECT arvutiID, arvutiNimi FROM arvuti");
        $paring->bind_result( $id,$nimi);
        $paring->execute();

        while($paring->fetch()) {
            echo "<li><a href='?id=$id'>$nimi</a></li>";
        }
        echo "</ul>";
        echo "<a href='?lisaArvuti=OK'>Lisa arvuti</a>";
        ?>
</div>
<div id="sisu">
    <?php
    if(isset($_REQUEST["id"])){
        $paring = $yhendus->prepare("SELECT arvutiNimi, hind, pilt FROM arvuti WHERE id=?");
        $paring->bind_param('i', $_REQUEST['id']);
        // ? küsimärki asemel aadressiribalt tuleb id
        $paring->bind_result( $nimi, $hind, $pilt);
        $paring->execute();
        if($paring->fetch()){
            echo "<div><strong>".htmlspecialchars($nimi)."</strong>, hind ";
            echo htmlspecialchars($hind)." €";
            echo "<br><img src='$pilt' alt='pilt'>";
            echo "<br><bu><a href='?Kustuta=$id'>Kustuta</a></bu>";
            echo "</div>";
        }
    }
    else if(isset($_REQUEST['lisaArvuti'])){
        ?>
        <h2>Uue arvuti lisamine</h2>
        <form name="uusArvuti" method="post" action="?">
            <input type="hidden" name="lisamisvorm">
            <input type="text" name="nimi" placeholder="Arvuti nimi">
            <input type="number" name="hind" placeholder="Arvuti hind" max="9999.99">
            <br>
            <textarea name="pilttext" placeholder="Siia lisa pildi aadress"></textarea>
            <br>
            <input type="submit" value="OK">
        </form>
        <?php
    }
    else{
        echo "<h3>Siia tuleb arvuti info...</h3>";
    }
    ?>
</div>
</body>
</html>