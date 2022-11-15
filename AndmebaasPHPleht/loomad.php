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
//kustutamine
if(isset($_REQUEST['Kustuta']))
{
    $paring = $yhendus->prepare("DELETE FROM loomad where id=?");
    $paring->bind_param('i', $_REQUEST['Kustuta']);
    $paring->execute();
}
//tabeli sisu näitamine
$paring = $yhendus->prepare("SELECT id, loomanimi, vanus, pilt, silmadvarv FROM loomad");
$paring->bind_result($id, $nimi, $vanus, $pilt, $silmadvarv);
$paring->execute();

?>
<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Loomad</title>
</head>
<body>
<h1>Loomade tabel</h1>
<table>
    <tr>
        <th>
            id
        </th>
        <th>
            Loomanimi
        </th>
        <th>
            Vanus
        </th>
        <th>
            Pilt
        </th>
        <th>
            Kustuta
        </th>
    </tr>
    <?php
    while($paring->fetch())
    {
        echo "<tr>";
        echo "<td>".htmlspecialchars($id)."</td>";
        //htmlspecialchars($id) - <käsk> - käsk null nurksulugudes mis ei loetakse
        echo "<td style='color: $silmadvarv'>".htmlspecialchars($nimi)."</td>";
        echo "<td>".htmlspecialchars($vanus)."</td>";
        echo "<td><img src='$pilt' alt='pilt' width='150px' height='120px'></td>";
        echo "<td><a href='?Kustuta=$id'>Kustuta</a></td>";
        echo "</tr>";
    }
    ?>
</table>
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
</body>
<?php
$yhendus->close();
//lisa tabelisse veerg silmadeVarv ja täida värvidega inglise keel
//veebilehel kõik Nimed(tekst) värvida silmadeVärviga
?>
</html>