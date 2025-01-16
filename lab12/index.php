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
include 'cart.php';

// Dane autora
$nr_indeksu = "163085";
$nrGrupy = "4";
echo "Michał Kaczmarczyk " . $nr_indeksu . ' grupa ' . $nrGrupy . '<br /><br />';

// Dane logowania
$login = 'admin';
$pass = '12345';

// Połączenie z bazą danych
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$baza = 'moja_strona';

$conn = new mysqli($dbhost, $dbuser, $dbpass, $baza);

if ($conn->connect_error) {
    die("Błąd połączenia: " . $conn->connect_error);
}

// Sprawdzenie statusu logowania
$is_logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// Obsługa wylogowania
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

// Obsługa logowania
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login_email'], $_POST['login_pass'])) {
    if ($_POST['login_email'] === $login && $_POST['login_pass'] === $pass) {
        $_SESSION['logged_in'] = true;
        header("Location: index.php");
        exit;
    } else {
        $login_error = 'Nieprawidłowy login lub hasło.';
    }
}
?>

<div class="header">
    <div>
        <a href="index.php?id=0">Strona główna</a>
        <a href="contact.php">Kontakt</a>
        <a href="html/lab2.html">Lab2</a>
        <a href="html/filmy.html">Filmy</a>
		<a href="index.php?id=products">Produkty</a>
		<a href="index.php?id=cart">Koszyk</a>
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
            <a href="admin/admin.php">Panel administracyjny</a>
        <?php endif; ?>
    </div>
    <div>
        <?php if ($is_logged_in): ?>
            <a href="index.php?logout=true">Wyloguj się</a>
        <?php else: ?>
            <a href="index.php?login=true">Zaloguj się</a>
        <?php endif; ?>
    </div>
</div>


<div class="content">
<?php
if (isset($_GET['login']) && !$is_logged_in) {
    echo '
    <div class="logowanie">
        <h1>Logowanie</h1>
        <form method="post" action="index.php">
            <table>
                <tr>
                    <td>Email:</td>
                    <td><input type="text" name="login_email" required></td>
                </tr>
                <tr>
                    <td>Hasło:</td>
                    <td><input type="password" name="login_pass" required></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" value="Zaloguj się">
                    </td>
                </tr>
            </table>
        </form>';
    if (isset($login_error)) {
        echo "<p style='color: red;'>$login_error</p>";
    }
    echo '</div>';
} else {
    $idp = $_GET['id'] ?? 0;

    if ($idp == 0) {
        echo '<h1 class="center-title">Lista największych budynków świata</h1>';
        echo '<div class="main-content">';

        // Zdjęcia po bokach
        echo '<div class="images-left">';
        echo '<img src="img/Burj_Khalifa.jpg" alt="Burj Khalifa" class="image">';
        echo '</div>';

        // Tabela na środku
        echo '<div class="table-section">';
        $sql = "SELECT id, page_title, height FROM page_list WHERE status = 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Budynek</th><th>Wysokość</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td><a href='index.php?id=" . $row['id'] . "'>" . $row['page_title'] . "</a></td>";
                echo "<td>" . $row['height'] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>Brak danych w tabeli.</p>";
        }
        echo '</div>'; // Zamknięcie sekcji tabeli

        // Drugie zdjęcie po prawej stronie
        echo '<div class="images-right">';
        echo '<img src="img/ST.jpg" alt="Shanghai Tower" class="image">';
        echo '</div>';

        echo '</div>'; // Zamknięcie kontenera głównego
    } elseif ($idp == 1) { // Burj Khalifa
    $sql = "SELECT page_content FROM page_list WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $content = str_replace("../img/", "img/", $row['page_content']);

        echo "<div class='burj-khalifa'>";
        echo $content;

        echo "<div class='next-button'>";
        echo "<a href='index.php?id=2' class='button'>Przejdź do następnej strony</a>";
        echo "</div>";

        echo "</div>";
    } else {
        echo "<h1>Nie znaleziono strony!</h1>";
    }
}elseif ($idp == 2) { // Merdeka
    $sql = "SELECT page_content FROM page_list WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $content = str_replace("../css/budynki.css", "../css/styles.css", $row['page_content']);
        $content = str_replace("../img/", "img/", $content);

        echo "<div class='merdeka'>";
        echo $content; // Wyświetlamy treść z bazy danych

        echo "<div class='next-button'>";
        echo "<a href='index.php?id=3' class='button'>Przejdź do następnej strony</a>"; // Zmień `id=3` na następną podstronę
        echo "</div>";

        echo "</div>";
    } else {
        echo "<h1>Nie znaleziono strony!</h1>";
    }
}elseif ($idp == 3) { // Shanghai Tower
    $sql = "SELECT page_content FROM page_list WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $content = str_replace("../css/budynki.css", "../css/styles.css", $row['page_content']);
        $content = str_replace("../img/", "img/", $content);

        echo "<div class='shanghai-tower'>";
        echo $content;

        echo "<div class='next-button'>";
        echo "<a href='index.php?id=4' class='button'>Przejdź do następnej strony</a>";
        echo "</div>";

        echo "</div>";
    } else {
        echo "<h1>Nie znaleziono strony!</h1>";
    }
}elseif ($idp == 4) { // Abradż al-Bajt
    $sql = "SELECT page_content FROM page_list WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $content = str_replace("../css/budynki.css", "../css/styles.css", $row['page_content']);
        $content = str_replace("../img/", "img/", $content);

        echo "<div class='abradz-al-bajt'>";
        echo $content;

        echo "<div class='next-button'>";
        echo "<a href='index.php?id=5' class='button'>Przejdź do następnej strony</a>"; // Zmień `id=5` na następną podstronę
        echo "</div>";

        echo "</div>";
    } else {
        echo "<h1>Nie znaleziono strony!</h1>";
    }
}elseif ($idp == 5) { // Ping An Finance Center
    $sql = "SELECT page_content FROM page_list WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $idp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $content = str_replace("../css/budynki.css", "../css/styles.css", $row['page_content']);
        $content = str_replace("../img/", "img/", $content);

        echo "<div class='ping-an-finance-center'>";
        echo $content;


        echo "<div class='next-button'>";
        echo "<a href='index.php?id=0' class='button'>Powrót na stronę główną</a>";
        echo "</div>";

        echo "</div>";
    } else {
        echo "<h1>Nie znaleziono strony!</h1>";
    }
}elseif ($idp === 'products') {
    $query = "SELECT * FROM products";
    $result = $conn->query($query);

    echo '<h1>Produkty</h1>';
    echo '<div class="products-container">';

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="product-card">';
            echo '<img src="' . htmlspecialchars($row['image_url']) . '" alt="' . htmlspecialchars($row['title']) . '" width="150">';
            echo '<h3>' . htmlspecialchars($row['title']) . '</h3>';
            echo '<p>' . htmlspecialchars($row['description']) . '</p>';
            echo '<p>Cena netto: ' . number_format($row['net_price'], 2) . ' PLN</p>';
            echo '<p>VAT: ' . $row['vat'] . '%</p>';
            echo '<p>Cena brutto: ' . number_format($row['net_price'] * (1 + $row['vat'] / 100), 2) . ' PLN</p>';
            echo '<p>Stan magazynowy: ' . $row['stock'] . '</p>';
            echo '<a href="index.php?action=add_to_cart&product_id=' . $row['id'] . '&quantity=1&size=' . urlencode($row['size']) . '&price=' . $row['net_price'] . '&vat=' . $row['vat'] . '">Dodaj do koszyka</a>';
            echo '</div>';
        }
    } else {
        echo '<p>Brak produktów w ofercie.</p>';
    }

    echo '</div>';
}elseif ($idp === 'cart') {
    echo '<h1>Koszyk</h1>';
    showCart();
    echo '<a href="?action=clear_cart">Wyczyść koszyk</a>';
}


if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'add_to_cart':
            $product_id = intval($_GET['product_id']);
            $quantity = intval($_GET['quantity']);
            $size = $_GET['size'];
            $price = floatval($_GET['price']);
            $vat = floatval($_GET['vat']);

            addToCart($product_id, $quantity, $size, $price, $vat);
            header('Location: index.php?id=products');
            exit;

        case 'clear_cart':
            clearCart();
            header('Location: index.php?id=cart');
            exit;
    }
}




}
$conn->close();
?>
</div>
</body>
</html>



















