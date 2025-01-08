<?php

class ProductManager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Dodaj produkt
    public function DodajProdukt($title, $description, $net_price, $vat, $stock, $availability_status, $category_id, $size, $image_url) {
        $stmt = $this->db->prepare("
            INSERT INTO products (title, description, creation_date, net_price, vat, stock, availability_status, category_id, size, image_url)
            VALUES (?, ?, NOW(), ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param("ssdiiiss", $title, $description, $net_price, $vat, $stock, $availability_status, $category_id, $size, $image_url);
        $stmt->execute();
        echo "Dodano produkt: $title<br>";
    }

    // Usuń produkt
    public function UsunProdukt($id) {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        echo "Usunięto produkt o ID: $id<br>";
    }

    // Edytuj produkt
    public function EdytujProdukt($id, $title, $description, $net_price, $vat, $stock, $availability_status, $category_id, $size, $image_url) {
        $stmt = $this->db->prepare("
            UPDATE products SET
            title = ?, description = ?, modification_date = NOW(), net_price = ?, vat = ?, stock = ?, availability_status = ?, category_id = ?, size = ?, image_url = ?
            WHERE id = ?
        ");
        $stmt->bind_param("ssdiiisssi", $title, $description, $net_price, $vat, $stock, $availability_status, $category_id, $size, $image_url, $id);
        $stmt->execute();
        echo "Zaktualizowano produkt o ID: $id<br>";
    }

    // Pokaż wszystkie produkty
    public function PokazProdukty() {
        $result = $this->db->query("
            SELECT p.*, c.name AS category_name
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
        ");

        echo "<h1>Lista produktów:</h1>";
        echo "<table border='1' cellpadding='5' cellspacing='0'>";
        echo "<tr>
                <th>ID</th>
                <th>Tytuł</th>
                <th>Opis</th>
                <th>Cena netto</th>
                <th>Podatek VAT</th>
                <th>Cena brutto</th>
                <th>Magazyn</th>
                <th>Status</th>
                <th>Kategoria</th>
                <th>Gabaryt</th>
                <th>Zdjęcie</th>
              </tr>";

        while ($row = $result->fetch_assoc()) {
            $brutto = $row['net_price'] * (1 + $row['vat']);
            $status = $row['availability_status'] ? "Dostępny" : "Niedostępny";

            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['title']}</td>
                    <td>{$row['description']}</td>
                    <td>{$row['net_price']} zł</td>
                    <td>{$row['vat'] * 100}%</td>
                    <td>{$brutto} zł</td>
                    <td>{$row['stock']}</td>
                    <td>{$status}</td>
                    <td>{$row['category_name']}</td>
                    <td>{$row['size']}</td>
                    <td><img src='{$row['image_url']}' alt='{$row['title']}' width='100'></td>
                  </tr>";
        }

        echo "</table>";
    }
}

?>
