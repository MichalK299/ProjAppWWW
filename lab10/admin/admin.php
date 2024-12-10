<?php

function FormularzLogowania()
{
    $wynik = '
    <div class="logowanie">
     <h1 class="heading">Panel CMS:</h1>
      <div class="logowanie">
       <form method="post" name="LoginForm" enctype="multipart/form-data" action="' . $_SERVER['REQUEST_URI'] . '">
        <table class="logowanie">
         <tr><td class="log4_t">[email]</td><td><input type="text" name="login_email" class="logowanie" /></td></tr>
         <tr><td class="log4_t">[haslo]</td><td><input type="password" name="login_pass" class="logowanie" /></td></tr>
         <tr><td>&nbsp;</td><td><input type="submit" name="x1_submit" class="logowanie" value="zaloguj" /></td></tr>
        </table>
       </form>
      </div>
     </div>
    ';
    return $wynik;
}


function ListaPodstron($db)
{
    $wynik = '
    <div class="lista-podstron">
     <h2>Lista podstron</h2>
     <table border="1" cellpadding="5" cellspacing="0" class="tabela">
      <thead>
       <tr>
        <th>ID</th>
        <th>Tytuł</th>
        <th>Akcje</th>
       </tr>
      </thead>
      <tbody>
    ';

    $query = "SELECT id, page_title FROM page_list";
    $result = $db->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $wynik .= '
            <tr>
             <td>' . htmlspecialchars($row['id']) . '</td>
             <td>' . htmlspecialchars($row['page_title']) . '</td>
             <td>
              <a href="edytuj.php?id=' . urlencode($row['id']) . '">Edytuj</a> | 
              <a href="usun.php?id=' . urlencode($row['id']) . '" onclick="return confirm(\'Czy na pewno chcesz usunąć tę podstronę?\')">Usuń</a>
             </td>
            </tr>
            ';
        }
    } else {
        $wynik .= '<tr><td colspan="3">Brak podstron w bazie danych.</td></tr>';
    }

    $wynik .= '
      </tbody>
     </table>
    </div>
    ';

    return $wynik;
}

function EdytujPodstrone($db, $id)
{
    $id = intval($id);
    $query = "SELECT * FROM page_list WHERE id = $id";
    $result = $db->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        $wynik = '
        <div class="edytuj-podstrone">
         <h2>Edytuj podstronę</h2>
         <form method="post" action="">
          <table>
           <tr>
            <td>Tytuł:</td>
            <td><input type="text" name="page_title" value="' . htmlspecialchars($row['page_title']) . '" required /></td>
           </tr>
           <tr>
            <td>Treść:</td>
            <td><textarea name="page_content" required>' . htmlspecialchars($row['page_content']) . '</textarea></td>
           </tr>
           <tr>
            <td>Aktywna:</td>
            <td><input type="checkbox" name="page_status" value="1" ' . ($row['status'] == 1 ? 'checked' : '') . ' /></td>
           </tr>
           <tr>
            <td colspan="2">
             <input type="submit" name="update" value="Zapisz zmiany" />
            </td>
           </tr>
          </table>
         </form>
        </div>
        ';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
            $title = $db->real_escape_string($_POST['page_title']);
            $content = $db->real_escape_string($_POST['page_content']);
            $status = isset($_POST['page_status']) ? 1 : 0;

            $updateQuery = "UPDATE page_list SET page_title = '$title', page_content = '$content', status = $status WHERE id = $id";
            if ($db->query($updateQuery)) {
                $wynik .= '<p>Podstrona została zaktualizowana!</p>';
            } else {
                $wynik .= '<p>Błąd podczas aktualizacji: ' . $db->error . '</p>';
            }
        }
    } else {
        $wynik = '<p>Nie znaleziono podstrony o podanym ID.</p>';
    }

    return $wynik;
}

function DodajNowaPodstrone($db)
{
    $wynik = '
    <div class="dodaj-podstrone">
     <h2>Dodaj nową podstronę</h2>
     <form method="post" action="">
      <table>
       <tr>
        <td>Tytuł:</td>
        <td><input type="text" name="page_title" required /></td>
       </tr>
       <tr>
        <td>Treść:</td>
        <td><textarea name="page_content" required></textarea></td>
       </tr>
       <tr>
        <td>Aktywna:</td>
        <td><input type="checkbox" name="page_status" value="1" /></td>
       </tr>
       <tr>
        <td colspan="2">
         <input type="submit" name="add" value="Dodaj podstronę" />
        </td>
       </tr>
      </table>
     </form>
    </div>
    ';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
        $title = $db->real_escape_string($_POST['page_title']);
        $content = $db->real_escape_string($_POST['page_content']);
        $status = isset($_POST['page_status']) ? 1 : 0;

        $insertQuery = "INSERT INTO page_list (page_title, page_content, status) VALUES ('$title', '$content', $status)";
        if ($db->query($insertQuery)) {
            $wynik .= '<p>Nowa podstrona została dodana!</p>';
        } else {
            $wynik .= '<p>Błąd podczas dodawania: ' . $db->error . '</p>';
        }
    }

    return $wynik;
}

function UsunPodstrone($db, $id)
{
    $id = intval($id);
    $query = "DELETE FROM page_list WHERE id = $id";

    if ($db->query($query)) {
        return '<p>Podstrona została usunięta!</p>';
    } else {
        return '<p>Błąd podczas usuwania: ' . $db->error . '</p>';
    }
}
?>
