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
        echo PokazKontakt(); // Ponowne wywołanie formularza, jeżeli pola są puste
    } else {
        $mail['subject'] = $_POST['temat'];
        $mail['body'] = $_POST['tresc'];
        $mail['sender'] = $_POST['email'];

        $header = "From: Formularz kontaktowy <" . $mail['sender'] . ">\n";
        $header .= "MIME-Version: 1.0\nContent-Type: text/plain; charset=utf-8\nContent-Transfer-Encoding: 8bit\n";
        $header .= "X-Sender: " . $mail['sender'] . "\n";
        $header .= "X-Mailer: PHP/" . phpversion() . "\n";
        $header .= "X-Priority: 3\n";
        $header .= "Return-Path: " . $mail['sender'] . "\n";

        mail($odbiorca, $mail['subject'], $mail['body'], $header);
        echo "Wiadomość wysłana!";
    }
}

function PrzypomnijHaslo($odbiorca, $haslo) {
    $mail['subject'] = "Przypomnienie hasła";
    $mail['body'] = "Twoje hasło do panelu admina to: " . $haslo;
    $mail['sender'] = "admin@example.com"; // Nadawca wiadomości

    $header = "From: Administrator <" . $mail['sender'] . ">\n";
    $header .= "MIME-Version: 1.0\nContent-Type: text/plain; charset=utf-8\nContent-Transfer-Encoding: 8bit\n";
    $header .= "X-Sender: " . $mail['sender'] . "\n";
    $header .= "X-Mailer: PHP/" . phpversion() . "\n";
    $header .= "X-Priority: 3\n";
    $header .= "Return-Path: " . $mail['sender'] . "\n";

    mail($odbiorca, $mail['subject'], $mail['body'], $header);
    echo "Wiadomość z przypomnieniem hasła wysłana!";
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
