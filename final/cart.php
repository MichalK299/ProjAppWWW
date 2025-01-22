<?php
session_start();

// Funkcja dodawania produktu do koszyka
function addToCart($product_id, $quantity, $size, $price, $vat) {
    // Inicjalizacja koszyka
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Obliczenie ceny brutto
    $gross_price = $price * (1 + $vat / 100);

    // Dodanie produktu do koszyka
    $_SESSION['cart'][] = [
        'product_id' => $product_id,
        'quantity' => $quantity,
        'size' => $size,
        'price' => $price,
        'vat' => $vat,
        'gross_price' => $gross_price
    ];
}

// Funkcja wyświetlania koszyka
function showCart() {
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        echo '<p>Twój koszyk jest pusty.</p>';
        return;
    }

    echo '<h2>Zawartość koszyka:</h2>';
    echo '<table border="1">';
    echo '<tr><th>ID Produktu</th><th>Ilość</th><th>Rozmiar</th><th>Cena netto</th><th>VAT</th><th>Cena brutto</th></tr>';

    $total = 0;

    foreach ($_SESSION['cart'] as $item) {
        echo '<tr>';
        echo '<td>' . $item['product_id'] . '</td>';
        echo '<td>' . $item['quantity'] . '</td>';
        echo '<td>' . $item['size'] . '</td>';
        echo '<td>' . number_format($item['price'], 2) . ' PLN</td>';
        echo '<td>' . $item['vat'] . '%</td>';
        echo '<td>' . number_format($item['gross_price'] * $item['quantity'], 2) . ' PLN</td>';
        echo '</tr>';

        $total += $item['gross_price'] * $item['quantity'];
    }

    echo '</table>';
    echo '<h3>Łączna wartość koszyka: ' . number_format($total, 2) . ' PLN</h3>';
}

// Funkcja usuwania koszyka
function clearCart() {
    unset($_SESSION['cart']);
}
?>
