<?php
$nr_indeksu = "163085";
$nrGrupy = "4";
echo "Michal Kaczmarczyk " . $nr_indeksu . ' grupa ' . $nrGrupy . '<br /><br />';
echo 'Zastosowanie metody include() <br />';

echo "<h2>a) Metoda include(), require_once()</h2>";
include 'header.php';
echo "Plik nagłówka został załączony.<br /><br />";

echo "<h2>b) Warunki if, else, elseif, switch</h2>";
$number = 10;

if ($number > 10) {
    echo "Liczba jest większa niż 10.<br />";
} elseif ($number < 10) {
    echo "Liczba jest mniejsza niż 10.<br />";
} else {
    echo "Liczba jest równa 10.<br />";
}

switch ($number) {
    case 10:
        echo "Liczba wynosi 10.<br />";
        break;
    case 20:
        echo "Liczba wynosi 20.<br />";
        break;
    default:
        echo "Liczba jest inna.<br />";
}

echo "<h2>c) Pętla while() i for()</h2>";
$i = 0;
echo "Pętla while:<br />";
while ($i < 5) {
    echo "Liczba: $i<br />";
    $i++;
}

echo "Pętla for:<br />";
for ($j = 0; $j < 5; $j++) {
    echo "Liczba: $j<br />";
}

echo "<h2>d) Typy zmiennych \$_GET, \$_POST, \$_SESSION</h2>";

session_start();
$_SESSION['user'] = 'Michal Kaczmarczyk';

echo "Zmienna sesyjna: " . $_SESSION['user'] . "<br />";

if (isset($_GET['name'])) {
    echo "Wartość zmiennej GET: " . htmlspecialchars($_GET['name']) . "<br />";
} else {
    echo "Nie podano zmiennej GET.<br />";
}

if (isset($_POST['age'])) {
    echo "Wartość zmiennej POST: " . htmlspecialchars($_POST['age']) . "<br />";
} else {
    echo "Nie podano zmiennej POST.<br />";
}
?>