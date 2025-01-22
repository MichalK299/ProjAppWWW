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

    // Dodaj kategorię
    public function DodajKategorie($name, $parent_id = 0) {
        $stmt = $this->db->prepare("INSERT INTO categories (name, parent_id) VALUES (?, ?)");
        if (!$stmt) {
            die("Błąd w zapytaniu SQL: " . $this->db->error);
        }
        $stmt->bind_param("si", $name, $parent_id);
        $stmt->execute();
        echo "Dodano kategorię: $name<br>";
    }

    // Edytuj kategorię
    public function EdytujKategorie($id, $new_name) {
        $stmt = $this->db->prepare("UPDATE categories SET name = ? WHERE id = ?");
        if (!$stmt) {
            die("Błąd w zapytaniu SQL: " . $this->db->error);
        }
        $stmt->bind_param("si", $new_name, $id);
        $stmt->execute();
        echo "Zaktualizowano kategorię o ID: $id<br>";
    }

    // Usuń kategorię i jej podkategorie
    public function UsunKategorie($id) {
        // Usuń podkategorie
        $stmt = $this->db->prepare("DELETE FROM categories WHERE parent_id = ?");
        if (!$stmt) {
            die("Błąd w zapytaniu SQL: " . $this->db->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // Usuń kategorię główną
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
        if (!$stmt) {
            die("Błąd w zapytaniu SQL: " . $this->db->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        echo "Usunięto kategorię o ID: $id<br>";
    }

    // Pokaż kategorie w tabeli
    public function PokazKategorie() {
        $query = "SELECT * FROM categories ORDER BY parent_id, id";
        $result = $this->db->query($query);

        if (!$result) {
            die("Błąd w zapytaniu SQL: " . $this->db->error);
        }

        echo '<h2>Lista kategorii:</h2>';
        echo '<table border="1">
            <tr>
                <th>ID</th>
                <th>Nazwa</th>
                <th>ID Kategorii Nadrzędnej</th>
                <th>Akcje</th>
            </tr>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . htmlspecialchars($row['name']) . '</td>';
            echo '<td>' . $row['parent_id'] . '</td>';
            echo '<td>
                <a href="admin.php?action=edit_category&id=' . $row['id'] . '">Edytuj</a> | 
                <a href="admin.php?action=delete_category&id=' . $row['id'] . '">Usuń</a>
            </td>';
            echo '</tr>';
        }

        echo '</table>';
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
        
        // Wyświetlanie obrazu z BLOB jako Base64
        if (!empty($row['image'])) {
            $imageData = base64_encode($row['image']);
            echo '<td><img src="data:image/jpeg;base64,' . $imageData . '" alt="Zdjęcie produktu" width="100"></td>';
        } else {
            echo '<td>Brak zdjęcia</td>';
        }

        echo '<td>
            <a href="admin.php?action=edit_product&id=' . $row['id'] . '">Edytuj</a> | 
            <a href="admin.php?action=delete_product&id=' . $row['id'] . '">Usuń</a>
        </td>';
        echo '</tr>';
    }

    echo '</table>';
}
	
	public function UsunProdukt($id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        if (!$stmt) {
            die("Błąd w zapytaniu SQL: " . $this->db->error);
        }
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Produkt o ID $id został usunięty.<br>";
        } else {
            echo "Błąd podczas usuwania produktu: " . $stmt->error;
        }

        $stmt->close();
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

function FormularzEdycjiKategorii($id, $current_name) {
    echo '<h2>Edytuj kategorię:</h2>';
    echo '<form method="post" action="admin.php?action=edit_category&id=' . $id . '">
        <label for="category_name">Nazwa kategorii:</label><br>
        <input type="text" id="category_name" name="new_name" value="' . htmlspecialchars($current_name) . '" required><br><br>
        <input type="submit" name="edit_category_submit" value="Zapisz zmiany">
    </form>';
}

function FormularzEdycjiProduktu($id, $product) {
    echo '<h2>Edytuj produkt:</h2>';
    echo '<form method="post" action="admin.php?action=edit_product&id=' . $id . '" enctype="multipart/form-data">
        <label for="title">Tytuł:</label><br>
        <input type="text" id="title" name="title" value="' . htmlspecialchars($product['title']) . '" required><br><br>

        <label for="description">Opis:</label><br>
        <textarea id="description" name="description" required>' . htmlspecialchars($product['description']) . '</textarea><br><br>

        <label for="creation_date">Data utworzenia:</label><br>
        <input type="date" id="creation_date" name="creation_date" value="' . htmlspecialchars($product['creation_date']) . '" required><br><br>

        <label for="modification_date">Data modyfikacji:</label><br>
        <input type="date" id="modification_date" name="modification_date" value="' . htmlspecialchars($product['modification_date']) . '"><br><br>

        <label for="expiration_date">Data wygaśnięcia:</label><br>
        <input type="date" id="expiration_date" name="expiration_date" value="' . htmlspecialchars($product['expiration_date']) . '"><br><br>

        <label for="net_price">Cena netto:</label><br>
        <input type="number" step="0.01" id="net_price" name="net_price" value="' . htmlspecialchars($product['net_price']) . '" required><br><br>

        <label for="vat">Podatek VAT (%):</label><br>
        <input type="number" step="0.01" id="vat" name="vat" value="' . htmlspecialchars($product['vat']) . '" required><br><br>

        <label for="stock">Stan magazynowy:</label><br>
        <input type="number" id="stock" name="stock" value="' . htmlspecialchars($product['stock']) . '" required><br><br>

        <label for="availability">Dostępność:</label><br>
        <select id="availability" name="availability">
            <option value="1"' . ($product['availability'] ? ' selected' : '') . '>Dostępny</option>
            <option value="0"' . (!$product['availability'] ? ' selected' : '') . '>Niedostępny</option>
        </select><br><br>

        <label for="category_id">ID kategorii:</label><br>
        <input type="number" id="category_id" name="category_id" value="' . htmlspecialchars($product['category_id']) . '" required><br><br>

        <label for="size">Gabaryt:</label><br>
        <input type="text" id="size" name="size" value="' . htmlspecialchars($product['size']) . '" required><br><br>

        <label for="image">Zdjęcie:</label><br>
        <input type="file" id="image" name="image"><br><br>';

    // Wyświetlenie aktualnego zdjęcia, jeśli istnieje
    if (!empty($product['image'])) {
        echo '<img src="data:image/jpeg;base64,' . base64_encode($product['image']) . '" alt="Aktualne zdjęcie" width="100"><br><br>';
    }

    echo '<input type="submit" name="edit_product_submit" value="Zapisz zmiany">
    </form>';
}

function FormularzDodawaniaProduktu() {
    echo '<h2>Dodaj nowy produkt:</h2>';
    echo '<form method="post" action="admin.php?action=add_product" enctype="multipart/form-data">
        <label for="title">Tytuł:</label><br>
        <input type="text" id="title" name="title" placeholder="Tytuł produktu" required><br><br>

        <label for="description">Opis:</label><br>
        <textarea id="description" name="description" placeholder="Opis produktu" required></textarea><br><br>

        <label for="creation_date">Data utworzenia:</label><br>
        <input type="date" id="creation_date" name="creation_date" required><br><br>

        <label for="modification_date">Data modyfikacji:</label><br>
        <input type="date" id="modification_date" name="modification_date"><br><br>

        <label for="expiration_date">Data wygaśnięcia:</label><br>
        <input type="date" id="expiration_date" name="expiration_date"><br><br>

        <label for="net_price">Cena netto:</label><br>
        <input type="number" step="0.01" id="net_price" name="net_price" placeholder="Cena netto" required><br><br>

        <label for="vat">Podatek VAT (%):</label><br>
        <input type="number" step="0.01" id="vat" name="vat" placeholder="Podatek VAT" required><br><br>

        <label for="stock">Stan magazynowy:</label><br>
        <input type="number" id="stock" name="stock" placeholder="Stan magazynowy" required><br><br>

        <label for="availability">Dostępność:</label><br>
        <select id="availability" name="availability">
            <option value="1">Dostępny</option>
            <option value="0">Niedostępny</option>
        </select><br><br>

        <label for="category_id">ID kategorii:</label><br>
        <input type="number" id="category_id" name="category_id" placeholder="ID kategorii" required><br><br>

        <label for="size">Gabaryt:</label><br>
        <input type="text" id="size" name="size" placeholder="Gabaryt produktu" required><br><br>

        <label for="image">Zdjęcie:</label><br>
        <input type="file" id="image" name="image" required><br><br>

        <input type="submit" name="add_product_submit" value="Dodaj produkt">
    </form>';
}

function FormularzEdycjiPodstrony($id, $current_title, $current_content, $current_status) {
    echo '<h2>Edytuj podstronę:</h2>';
    echo '<form method="post" action="admin.php?action=edit_page&id=' . $id . '">
        <label for="title">Tytuł:</label><br>
        <input type="text" id="title" name="title" value="' . htmlspecialchars($current_title) . '" required><br><br>
        
        <label for="content">Treść:</label><br>
        <textarea id="content" name="content" rows="10" cols="50" required>' . htmlspecialchars($current_content) . '</textarea><br><br>
        
        <label for="status">Status:</label><br>
        <input type="checkbox" id="status" name="status" value="1" ' . ($current_status ? 'checked' : '') . '><br><br>
        
        <input type="submit" name="edit_page_submit" value="Zapisz zmiany">
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

    if (isset($_POST['add_product_submit'])) {
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

        // Obsługa przesyłania obrazu
        $image = null;
        if (!empty($_FILES['image']['tmp_name'])) {
            $image = file_get_contents($_FILES['image']['tmp_name']);
        }

        // Przygotowanie zapytania SQL
        $stmt = $conn->prepare("INSERT INTO products (title, description, creation_date, modification_date, expiration_date, net_price, vat, stock, availability, category_id, size, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            die("Błąd w zapytaniu SQL: " . $conn->error);
        }

        // Bindowanie parametrów
        $stmt->bind_param("sssssdiiissb", $title, $description, $creation_date, $modification_date, $expiration_date, $net_price, $vat, $stock, $availability, $category_id, $size, $image);

        // Przesyłanie danych obrazu jako BLOB
        if ($image !== null) {
            $stmt->send_long_data(11, $image); // Kolumna `image` to 12. parametr
        }

        // Wykonanie zapytania
        if ($stmt->execute()) {
            echo "Produkt został dodany: $title<br>";
        } else {
            echo "Błąd podczas dodawania produktu: " . $stmt->error;
        }

        $stmt->close();
    }
    break;



        case 'show_products':
            $productManager->PokazProdukty();
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

        case 'edit_category':
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                $query = "SELECT name FROM categories WHERE id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($row = $result->fetch_assoc()) {
                    FormularzEdycjiKategorii($id, $row['name']);
                    if (isset($_POST['edit_category_submit'])) {
                        $new_name = $_POST['new_name'];
                        $categoryManager->EdytujKategorie($id, $new_name);
                    }
                } else {
                    echo "Nie znaleziono kategorii o ID: $id";
                }
            }
            break;

        case 'delete_category':
            if (isset($_GET['id'])) {
                $id = intval($_GET['id']);
                $categoryManager->UsunKategorie($id);
            }
            break;	
			
		case 'add_product':
    FormularzDodawaniaProduktu();

    if (isset($_POST['add_product_submit'])) {
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

        // Obsługa przesyłania obrazu
        if (!empty($_FILES['image']['tmp_name'])) {
            $image = file_get_contents($_FILES['image']['tmp_name']);
        } else {
            $image = null;
        }

        // Dodanie produktu do bazy danych
        $stmt = $conn->prepare("INSERT INTO products (title, description, creation_date, modification_date, expiration_date, net_price, vat, stock, availability, category_id, size, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            die("Błąd w zapytaniu SQL: " . $conn->error);
        }

        $stmt->bind_param("sssssdiiissb", $title, $description, $creation_date, $modification_date, $expiration_date, $net_price, $vat, $stock, $availability, $category_id, $size, $image);

        if ($stmt->execute()) {
            echo "Produkt został dodany: $title<br>";
        } else {
            echo "Błąd podczas dodawania produktu: " . $stmt->error;
        }
    }
    break;
			
		case 'edit_product':
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);

        // Pobierz szczegóły produktu z bazy danych
        $query = "SELECT * FROM products WHERE id = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die("Błąd w zapytaniu SQL: " . $conn->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            // Wyświetl formularz edycji
            FormularzEdycjiProduktu($id, $row);

            // Przetwarzanie zmian po przesłaniu formularza
            if (isset($_POST['edit_product_submit'])) {
                $title = $_POST['title'];
                $description = $_POST['description'];
                $creation_date = $_POST['creation_date'];
                $modification_date = $_POST['modification_date'];
                $expiration_date = $_POST['expiration_date'];
                $net_price = floatval($_POST['net_price']);
                $vat = floatval($_POST['vat']);
                $stock = intval($_POST['stock']);
                $availability = intval($_POST['availability']);
                $category_id = intval($_POST['category_id']);
                $size = $_POST['size'];
                $image = null;

                // Obsługa przesyłania nowego zdjęcia
                if (!empty($_FILES['image']['tmp_name'])) {
                    $image = file_get_contents($_FILES['image']['tmp_name']);
                }

                // Zaktualizuj produkt w bazie danych
                $update_query = "UPDATE products SET title = ?, description = ?, creation_date = ?, modification_date = ?, expiration_date = ?, net_price = ?, vat = ?, stock = ?, availability = ?, category_id = ?, size = ?" . ($image ? ", image = ?" : "") . " WHERE id = ?";
                $update_stmt = $conn->prepare($update_query);

                if (!$update_stmt) {
                    die("Błąd w zapytaniu SQL: " . $conn->error);
                }

                if ($image) {
                    $update_stmt->bind_param("sssssdiiissbi", $title, $description, $creation_date, $modification_date, $expiration_date, $net_price, $vat, $stock, $availability, $category_id, $size, $image, $id);
                } else {
                    $update_stmt->bind_param("sssssdiiissi", $title, $description, $creation_date, $modification_date, $expiration_date, $net_price, $vat, $stock, $availability, $category_id, $size, $id);
                }

                if ($update_stmt->execute()) {
                    echo "Produkt został zaktualizowany.";
                } else {
                    echo "Błąd podczas aktualizacji: " . $update_stmt->error;
                }
            }
        } else {
            echo "Nie znaleziono produktu o ID: $id";
        }
    }
    break;
	
	case 'delete_product':
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $productManager->UsunProdukt($id);
    } else {
        echo "Nie podano ID produktu do usunięcia.";
    }
    break;
	
	case 'edit_page':
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $query = "SELECT page_title, page_content, status FROM page_list WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            FormularzEdycjiPodstrony($id, $row['page_title'], $row['page_content'], $row['status']);
            if (isset($_POST['edit_page_submit'])) {
                $title = $_POST['title'];
                $content = $_POST['content'];
                $status = isset($_POST['status']) ? 1 : 0;

                $update = "UPDATE page_list SET page_title = ?, page_content = ?, status = ? WHERE id = ?";
                $stmt = $conn->prepare($update);
                $stmt->bind_param("ssii", $title, $content, $status, $id);
                $stmt->execute();

                echo "Podstrona została zaktualizowana.<br>";
            }
        } else {
            echo "Nie znaleziono podstrony o ID: $id.<br>";
        }
    }
    break;
	
	case 'delete_page':
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $delete = "DELETE FROM page_list WHERE id = ?";
        $stmt = $conn->prepare($delete);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Podstrona została usunięta.<br>";
        } else {
            echo "Nie udało się usunąć podstrony. Sprawdź, czy ID jest poprawne.<br>";
        }
    }
    break;



        default:
            echo 'Nieznana akcja.';
			
		
    }
}

// Lista podstron
function ListaPodstron($db) {
    $wynik = '<h2>Lista podstron:</h2>';
    $wynik .= '<table border="1">
        <tr>
            <th>ID</th>
            <th>Tytuł</th>
            <th>Akcje</th>
        </tr>';

    $query = "SELECT id, page_title FROM page_list LIMIT 100";
    $result = $db->query($query);

    while ($row = $result->fetch_assoc()) {
        $wynik .= '<tr>';
        $wynik .= '<td>' . $row['id'] . '</td>';
        $wynik .= '<td>' . $row['page_title'] . '</td>';
        $wynik .= '<td>
            <a href="admin.php?action=edit_page&id=' . $row['id'] . '">Edytuj</a> | 
            <a href="admin.php?action=delete_page&id=' . $row['id'] . '" onclick="return confirm(\'Czy na pewno chcesz usunąć tę podstronę?\')">Usuń</a>
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












