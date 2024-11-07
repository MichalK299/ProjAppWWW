<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="pl" />
    <meta name="Author" content="Michał Kaczmarczyk" />
    <title>Największe budynki świata</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>

<?php
$nr_indeksu = "163085";
$nrGrupy = "4";
echo "Michał Kaczmarczyk " . $nr_indeksu . ' grupa ' . $nrGrupy . '<br /><br />';

error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

// Dynamiczne ładowanie stron
if ($_GET['idp'] == '') {
    $strona = 'html/glowna.html';
} else if ($_GET['idp'] == 'podstrona1') {
    $strona = 'html/BurdzChalifa.htm';
} else if ($_GET['idp'] == 'podstrona2') {
    $strona = 'html/merdeka.htm';
} else if ($_GET['idp'] == 'podstrona3') {
    $strona = 'html/shanghaitower.htm';
} else if ($_GET['idp'] == 'podstrona4') {
    $strona = 'html/abradzalbajt.htm';
} else if ($_GET['idp'] == 'podstrona5') {
    $strona = 'html/pinganfinancecenter.htm';
} else if ($_GET['idp'] == 'filmy') { // Dodaj obsługę dla strony z filmami
    $strona = 'html/filmy.html';
}

// Sprawdzenie, czy plik istnieje, w przeciwnym razie ustaw domyślną stronę główną
if (!file_exists($strona)) {
    $strona = 'html/glowna.html';
}
?>

<!-- Miejsce na załadowanie treści strony -->
<?php include($strona); ?>

<!-- Sekcja z obrazami tylko na stronie głównej -->
<?php if ($_GET['idp'] == ''): ?>
    <img src="img/burj2.jpg" alt="Burj Khalifa" class="img1">
    <img src="img/Shanghai_Tower.jpg" alt="Shanghai Tower" class="img2">
<?php endif; ?>

<h2><a href="index.php?idp=Kontakt">Kontakt</a></h2>
<h2><a href="index.php?idp=filmy">Filmy</a></h2> <!-- Dodaj link do podstrony Filmy -->

</body>
</html>


