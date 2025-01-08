<?php
session_start();

// Dane do logowania
$login = 'admin';
$pass = '12345';

// Połączenie z bazą danych
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$baza = 'moja_strona';

$conn = new mysqli($dbhost, $dbuser, $dbpass, $baza);

if ($conn->connect_error) {
    die("Błąd połączenia z bazą danych: " . $conn->connect_error);
}

// Klasa CategoryManager
class CategoryManager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function DodajKategorie($name, $parent_id = 0) {
        $stmt = $this->db->prepare("INSERT INTO categories (name, parent_id) VALUES (?, ?)");
        $stmt->bind_param("si", $name, $parent_id);
        $stmt->execute();
        echo "Dodano kategorię: $name<br>";
    }

    public function PokazKategorie($parent_id = 0, $level = 0) {
        $stmt = $this->db->prepare("SELECT id, name FROM categories WHERE parent_id = ? ORDER BY id");
        $stmt->bind_param("i", $parent_id);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            echo str_repeat("&nbsp;&nbsp;&nbsp;", $level) . "- " . htmlspecialchars($row['name']) . "<br>";
            $this->PokazKategorie($row['id'], $level + 1);
        }
    }
}

// Klasa ProductManager
class ProductManager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function DodajProdukt($title, $description, $creation_date, $modification_date, $expiration_date, $net_price, $vat, $stock, $availability, $category_id, $size, $image_url) {
        $stmt = $this->db->prepare("INSERT INTO products (title, description, creation_date, modification_date, expiration_date, net_price, vat, stock, availability, category_id, size, image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        if (!$stmt) {
            die("Błąd w zapytaniu SQL: " . $this->db->error);
        }

        $stmt->bind_param("sssssdiiisss", $title, $description, $creation_date, $modification_date, $expiration_date, $net_price, $vat, $stock, $availability, $category_id, $size, $image_url);

        if (!$stmt->execute()) {
            die("Błąd podczas wykonywania zapytania: " . $stmt->error);
        }

        echo "Produkt został dodany: $title<br>";
    }

    public function PokazProdukty() {
        $query = "SELECT * FROM products";
        $result = $this->db->query($query);

        echo '<h2>Lista produktów:</h2>';
        echo '<table border="1">
            <tr>
                <th>ID</th>
                <th>Tytuł</th>
                <th>Opis</th>
                <th>Data utworzenia</th>
                <th>Data modyfikacji</th>
                <th>Data wygaśnięcia</th>
                <th>Cena netto</th>
                <th>Podatek VAT</th>
                <th>Stan magazynowy</th>
                <th>Dostępność</th>
                <th>Kategoria</th>
                <th>Gabaryt</th>
                <th>Zdjęcie</th>
                <th>Akcje</th>
            </tr>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . htmlspecialchars($row['title']) . '</td>';
            echo '<td>' . htmlspecialchars($row['description']) . '</td>';
            echo '<td>' . $row['creation_date'] . '</td>';
            echo '<td>' . $row['modification_date'] . '</td>';
            echo '<td>' . $row['expiration_date'] . '</td>';
            echo '<td>' . number_format($row['net_price'], 2) . ' PLN</td>';
            echo '<td>' . $row['vat'] . '%</td>';
            echo '<td>' . $row['stock'] . '</td>';
            echo '<td>' . ($row['availability'] ? 'Dostępny' : 'Niedostępny') . '</td>';
            echo '<td>' . $row['category_id'] . '</td>';
            echo '<td>' . htmlspecialchars($row['size']) . '</td>';
            echo '<td><img src="' . htmlspecialchars($row['image_url']) . '" alt="Zdjęcie produktu" width="100"></td>';
            echo '<td>
                <a href="admin.php?action=edit_product&id=' . $row['id'] . '">Edytuj</a> | 
                <a href="admin.php?action=delete_product&id=' . $row['id'] . '">Usuń</a>
            </td>';
            echo '</tr>';
        }

        echo '</table>';
    }
}

// Formularze
function FormularzDodawaniaPodstrony() {
    echo '<h2>Dodaj nową podstronę:</h2>';
    echo '<form method="post">
        <input type="text" name="title" placeholder="Tytuł podstrony" required><br>
        <textarea name="content" placeholder="Treść podstrony" required></textarea><br>
        <input type="checkbox" name="status" value="1"> Aktywna<br>
        <input type="submit" name="add_page" value="Dodaj podstronę">
    </form>';
}

function FormularzDodawaniaKategorii() {
    echo '<h2>Dodaj kategorię:</h2>';
    echo '<form method="post">
        <input type="text" name="category_name" placeholder="Nazwa kategorii" required><br>
        <input type="number" name="parent_id" placeholder="ID kategorii nadrzędnej (0 dla głównej)" required><br>
        <input type="submit" name="add_category" value="Dodaj kategorię">
    </form>';
}

// Obsługa akcji
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    $categoryManager = new CategoryManager($conn);
    $productManager = new ProductManager($conn);

    switch ($action) {
        case 'add_page':
            FormularzDodawaniaPodstrony();
            if (isset($_POST['add_page'])) {
                $title = $_POST['title'];
                $content = $_POST['content'];
                $status = isset($_POST['status']) ? 1 : 0;

                $stmt = $conn->prepare("INSERT INTO page_list (page_title, page_content, status) VALUES (?, ?, ?)");
                $stmt->bind_param("ssi", $title, $content, $status);
                $stmt->execute();
                echo "Podstrona została dodana: $title<br>";
            }
            break;

        case 'add_category':
            FormularzDodawaniaKategorii();
            if (isset($_POST['add_category'])) {
                $name = $_POST['category_name'];
                $parent_id = intval($_POST['parent_id']);
                $categoryManager->DodajKategorie($name, $parent_id);
            }
            break;

        case 'show_categories':
            $categoryManager->PokazKategorie();
            break;

        case 'add_product':
            FormularzDodawaniaProduktu();
            if (isset($_POST['add_product'])) {
                $title = $_POST['title'];
                $description = $_POST['description'];
                $creation_date = $_POST['creation_date'];
                $modification_date = $_POST['modification_date'] ?? null;
                $expiration_date = $_POST['expiration_date'] ?? null;
                $net_price = floatval($_POST['net_price']);
                $vat = floatval($_POST['vat']);
                $stock = intval($_POST['stock']);
                $availability = intval($_POST['availability']);
                $category_id = intval($_POST['category_id']);
                $size = $_POST['size'];
                $image_url = $_POST['image_url'];

                $productManager->DodajProdukt($title, $description, $creation_date, $modification_date, $expiration_date, $net_price, $vat, $stock, $availability, $category_id, $size, $image_url);
            }
            break;

        case 'show_products':
            $productManager->PokazProdukty();
            break;

        default:
            echo 'Nieznana akcja.';
    }
}

// Lista podstron
function ListaPodstron($db) {
    $wynik = '<h2>Lista podstron:</h2>';
    $wynik .= '<table border="1"><tr><th>ID</th><th>Tytuł</th><th>Akcje</th></tr>';

    $query = "SELECT id, page_title FROM page_list LIMIT 100";
    $result = $db->query($query);

    while ($row = $result->fetch_assoc()) {
        $wynik .= '<tr>';
        $wynik .= '<td>' . $row['id'] . '</td>';
        $wynik .= '<td>' . $row['page_title'] . '</td>';
        $wynik .= '<td>
            <a href="admin.php?action=edit_page&id=' . $row['id'] . '">Edytuj</a> | 
            <a href="admin.php?action=delete_page&id=' . $row['id'] . '">Usuń</a>
        </td>';
        $wynik .= '</tr>';
    }

    $wynik .= '</table>';
    return $wynik;
}

// Sprawdzenie zalogowania
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo 'Zaloguj się!';
    exit;
}

// Panel administracyjny
echo '<h1>Panel administracyjny</h1>';
echo '<a href="admin.php?action=add_page">Dodaj nową podstronę</a><br>';
echo '<a href="admin.php?action=add_category">Dodaj kategorię</a><br>';
echo '<a href="admin.php?action=show_categories">Pokaż kategorie</a><br>';
echo '<a href="admin.php?action=add_product">Dodaj produkt</a><br>';
echo '<a href="admin.php?action=show_products">Pokaż produkty</a><br>';

// Wyświetlenie listy podstron
echo ListaPodstron($conn);
?>












