<?php
// Dane do połączenia z bazą danych
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$baza = 'moja_strona';

// Dane logowania
$login = 'admin';
$pass = '12345';

// Połączenie z bazą danych
$link = mysqli_connect($dbhost, $dbuser, $dbpass, $baza);
if (!$link) {
    die('<b>Przerwane połączenie: </b>' . mysqli_connect_error());
}
?>