<?php
require_once ('connect.php');
global  $yhendus;
//andmete lisamine tabelisse
if(isset($_REQUEST['lisamisvorm']) && !empty($_REQUEST['nimi']))
{
    $paring = $yhendus->prepare("INSERT INTO loomad(loomanimi, vanus, pilt, silmadvarv) VALUES (?,?,?,?)");
    $paring->bind_param('siss', $_REQUEST['nimi'],$_REQUEST['vanus'],$_REQUEST['pilttext'],$_REQUEST['varv']);
    //s-string, d-double, i-int
    $paring->execute();
    header("Location: $_SERVER[PHP_SELF]");
}
if(isset($_REQUEST['Kustuta']))
{
    $paring = $yhendus->prepare("DELETE FROM loomad where id=?");
    $paring->bind_param('i', $_REQUEST['Kustuta']);
    $paring->execute();
}
?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Loomad</title>
</head>
<body>
<h1>Loomad</h1>
<div id="meny">
    <ul>
        <?php
        //näitab loomade loetelu tabelist loomad
        $paring = $yhendus->prepare("SELECT id, loomanimi FROM loomad");
        $paring->bind_result( $id,$nimi);
        $paring->execute();

        while($paring->fetch()) {
            echo "<li><a href='?id=$id'>$nimi</a></li>";
        }
        echo "</ul>";
        echo "<a href='?lisaloom=OK'>Lisa loom</a>";
        ?>
</div>
<div id="sisu">
    <?php
    if(isset($_REQUEST["id"])){
        $paring = $yhendus->prepare("SELECT loomanimi, vanus, pilt, silmadvarv FROM loomad WHERE id=?");
        $paring->bind_param('i', $_REQUEST['id']);
        // ? küsimärki asemel aadressiribalt tuleb id
        $paring->bind_result( $nimi, $vanus, $pilt, $silmadvarv);
        $paring->execute();
        if($paring->fetch()){
            echo "<div><strong style='color: $silmadvarv'>".htmlspecialchars($silmadvarv)." ".htmlspecialchars($nimi)."</strong>, vanus ";
            echo htmlspecialchars($vanus)." aastat";
            echo "<br><img src='$pilt' alt='pilt'>";
            echo "<br>Silmadevärv: ".htmlspecialchars($silmadvarv);
            echo "<br><bu><a href='?Kustuta=$id'>Kustuta</a></bu>";
            echo "</div>";
        }
    }
    else if(isset($_REQUEST['lisaloom'])){
        ?>
    <h2>Uue looma lisamine</h2>
    <form name="uusloom" method="post" action="?">
        <input type="hidden" name="lisamisvorm">
        <input type="text" name="nimi" placeholder="Looma nimi">
        <input type="number" name="vanus" placeholder="Looma vanus" max="60">
        <label for="varv">Silmade värv: </label>
        <input type="color" name="varv" id="varv" placeholder="Silmade värv">
        <br>
        <textarea name="pilttext" placeholder="Siia lisa pildi aadress"></textarea>
        <br>
        <input type="submit" value="OK">
    </form>
    <?php
    }
    else{
        echo "<h3>Siia tuleb loomade info...</h3>";
    }
    ?>
</div>
</body>
</html>