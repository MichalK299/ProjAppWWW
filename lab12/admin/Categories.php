<?php
include "../CategoryManager.php"; // Plik z klasą CategoryManager
include "../cfg.php"; // Połączenie z bazą danych

// Połączenie z bazą danych
$db = new mysqli($dbhost, $dbuser, $dbpass, $baza);
if ($db->connect_error) {
    die("Błąd połączenia: " . $db->connect_error);
}

// Inicjalizacja klasy CategoryManager
$categoryManager = new CategoryManager($db);

// Obsługa akcji w formularzu
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        // Dodaj kategorię
        $categoryManager->DodajKategorie($_POST['name'], $_POST['parent_id']);
    } elseif (isset($_POST['edit'])) {
        // Edytuj kategorię
        $categoryManager->EdytujKategorie($_POST['id'], $_POST['name']);
    } elseif (isset($_POST['delete'])) {
        // Usuń kategorię
        $categoryManager->UsunKategorie($_POST['id']);
    }
}

// Wyświetlenie zarządzania kategoriami
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zarządzanie kategoriami</title>
    <style>
        form {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <h1>Zarządzanie kategoriami</h1>

    <h2>Dodaj kategorię</h2>
    <form method="post">
        <label for="name">Nazwa:</label>
        <input type="text" id="name" name="name" required>
        <label for="parent_id">Rodzic:</label>
        <select id="parent_id" name="parent_id">
            <option value="0">Brak (kategoria główna)</option>
            <?php
            // Pobierz wszystkie główne kategorie (parent_id = 0)
            $stmt = $db->query("SELECT id, name FROM categories WHERE parent_id = 0");
            while ($row = $stmt->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['name']}</option>";
            }
            ?>
        </select>
        <input type="submit" name="add" value="Dodaj kategorię">
    </form>

    <h2>Edytuj kategorię</h2>
    <form method="post">
        <label for="id">ID kategorii:</label>
        <input type="number" id="id" name="id" required>
        <label for="name">Nowa nazwa:</label>
        <input type="text" id="name" name="name" required>
        <input type="submit" name="edit" value="Edytuj kategorię">
    </form>

    <h2>Usuń kategorię</h2>
    <form method="post">
        <label for="id">ID kategorii:</label>
        <input type="number" id="id" name="id" required>
        <input type="submit" name="delete" value="Usuń kategorię">
    </form>

    <h2>Drzewo kategorii</h2>
    <?php
    // Wyświetl drzewo kategorii
    $categoryManager->PokazKategorie();
    ?>

</body>
</html>
