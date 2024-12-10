<?php
// Projekt: System Zarządzania Kategoriami do Sklepu Internetowego

class CategoryManagement {
    private $pdo;

    public function __construct($host, $dbname, $username, $password) {
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Błąd połączenia z bazą danych: " . $e->getMessage());
        }
    }

    public function DodajKategorie($nazwa, $matka = 0) {
        $stmt = $this->pdo->prepare("INSERT INTO kategorie (matka, nazwa) VALUES (:matka, :nazwa)");
        $stmt->execute(['matka' => $matka, 'nazwa' => $nazwa]);
        echo "Kategoria '$nazwa' została dodana pomyślnie.";
    }

    public function UsunKategorie($id) {
        $stmt = $this->pdo->prepare("DELETE FROM kategorie WHERE id = :id OR matka = :id");
        $stmt->execute(['id' => $id]);
        echo "Kategoria o ID $id oraz jej podkategorie zostały usunięte.";
    }

    public function EdytujKategorie($id, $nowaNazwa) {
        $stmt = $this->pdo->prepare("UPDATE kategorie SET nazwa = :nazwa WHERE id = :id");
        $stmt->execute(['nazwa' => $nowaNazwa, 'id' => $id]);
        echo "Kategoria o ID $id została zaktualizowana.";
    }

    public function PokazKategorie() {
        $stmt = $this->pdo->query("SELECT * FROM kategorie ORDER BY matka, id");
        $kategorie = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $drzewo = $this->GenerujDrzewo($kategorie);
        $this->WyswietlDrzewo($drzewo);
    }

    private function GenerujDrzewo($kategorie, $matka = 0) {
        $drzewo = [];
        foreach ($kategorie as $kategoria) {
            if ($kategoria['matka'] == $matka) {
                $dzieci = $this->GenerujDrzewo($kategorie, $kategoria['id']);
                if ($dzieci) {
                    $kategoria['dzieci'] = $dzieci;
                }
                $drzewo[] = $kategoria;
            }
        }
        return $drzewo;
    }

    private function WyswietlDrzewo($drzewo, $poziom = 0) {
        foreach ($drzewo as $kategoria) {
            echo str_repeat("-", $poziom) . " " . $kategoria['nazwa'] . "<br>";
            if (isset($kategoria['dzieci'])) {
                $this->WyswietlDrzewo($kategoria['dzieci'], $poziom + 1);
            }
        }
    }
}