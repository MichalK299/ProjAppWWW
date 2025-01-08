<?php
include "../ProductManager.php";
include "../cfg.php";

$db = new mysqli($dbhost, $dbuser, $dbpass, $baza);
if ($db->connect_error) {
    die("Błąd połączenia: " . $db->connect_error);
}

$productManager = new ProductManager($db);

// Obsługa formularzy
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $productManager->DodajProdukt($_POST['title'], $_POST['description'], $_POST['net_price'], $_POST['vat'], $_POST['stock'], $_POST['availability_status'], $_POST['category_id'], $_POST['size'], $_POST['image_url']);
    } elseif (isset($_POST['edit'])) {
        $productManager->EdytujProdukt($_POST['id'], $_POST['title'], $_POST['description'], $_POST['net_price'], $_POST['vat'], $_POST['stock'], $_POST['availability_status'], $_POST['category_id'], $_POST['size'], $_POST['image_url']);
    } elseif (isset($_POST['delete'])) {
        $productManager->UsunProdukt($_POST['id']);
    }
}

// Wyświetlanie produktów
$productManager->PokazProdukty();
?>
