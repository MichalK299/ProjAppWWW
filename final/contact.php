<?php

function PokazKontakt() {
    echo '
    <form action="contact.php" method="post" class="formularz-kontaktowy">
        <label for="temat">Temat:</label>
        <input type="text" id="temat" name="temat" required><br><br>
        <label for="tresc">Treść:</label>
        <textarea id="tresc" name="tresc" required></textarea><br><br>
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required><br><br>
        <input type="submit" name="submit" value="Wyślij">
    </form>';
}

function WyslijMailKontakt($odbiorca) {
    if (empty($_POST['temat']) || empty($_POST['tresc']) || empty($_POST['email'])) {
        echo "Nie wypełniłeś pola!";
        PokazKontakt(); // Ponowne wywołanie formularza, jeżeli pola są puste
    } else {
        $mail['subject'] = htmlspecialchars($_POST['temat'], ENT_QUOTES, 'UTF-8');
        $mail['body'] = htmlspecialchars($_POST['tresc'], ENT_QUOTES, 'UTF-8');
        $mail['sender'] = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');

        if (!filter_var($mail['sender'], FILTER_VALIDATE_EMAIL)) {
            echo "Podano nieprawidłowy adres e-mail!";
            PokazKontakt();
            return;
        }

        $header = "From: Formularz kontaktowy <" . $mail['sender'] . ">\n";
        $header .= "MIME-Version: 1.0\nContent-Type: text/plain; charset=utf-8\nContent-Transfer-Encoding: 8bit\n";
        $header .= "X-Sender: " . $mail['sender'] . "\n";
        $header .= "X-Mailer: PHP/" . phpversion() . "\n";
        $header .= "X-Priority: 3\n";
        $header .= "Return-Path: " . $mail['sender'] . "\n";

        if (mail($odbiorca, $mail['subject'], $mail['body'], $header)) {
            echo "Wiadomość wysłana!";
        } else {
            echo "Wystąpił błąd podczas wysyłania wiadomości.";
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    WyslijMailKontakt('odbiorca@example.com'); // Podaj adres odbiorcy
} else {
    PokazKontakt();
}
?>

<style>
.formularz-kontaktowy {
    width: 400px;
    margin: 0 auto;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
}

.formularz-kontaktowy input[type="text"],
.formularz-kontaktowy input[type="email"],
.formularz-kontaktowy textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}
</style>

