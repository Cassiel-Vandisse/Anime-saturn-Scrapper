<?php
// Parametri di connessione al database
$servername = "localhost";
$username = "estrapolatore";
$password = "password";  // Sostituisci con la tua password
$dbname = "anime";


// Creazione connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Controllo connessione
if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}

// Gestione dell'inserimento di un nuovo URL
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["url"])) {
    $url = $conn->real_escape_string(trim($_POST["url"]));

    // Inserisci l'URL nella tabella Url_iniziali
    $sql_insert = "INSERT INTO Url_iniziali (url) VALUES ('$url')";
    if ($conn->query($sql_insert) === TRUE) {
        $success_message = "URL aggiunto con successo!";
    } else {
        $error_message = "Errore durante l'inserimento: " . $conn->error;
    }
}

// Gestione eliminazione URL
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_id"])) {
    $id_to_delete = intval($_POST["delete_id"]);
    $delete_query = "DELETE FROM Url_iniziali WHERE id = $id_to_delete";
    if ($conn->query($delete_query) === TRUE) {
        $success_message = "URL eliminato con successo!";
    } else {
        $error_message = "Errore durante l'eliminazione: " . $conn->error;
    }
}

// Query per selezionare gli URL iniziali
$sql = "SELECT id, url FROM Url_iniziali";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestione URL Iniziali</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            text-align: center;
        }
        .header a {
            color: white;
            margin: 0 10px;
            text-decoration: none;
            font-weight: bold;
        }
        .header a:hover {
            text-decoration: underline;
        }
        .container {
            flex: 1; /* Espande il contenuto per occupare lo spazio disponibile */
            width: 80%;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            margin-bottom: 20px;
            text-align: center;
        }
        input[type="text"] {
            width: 70%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            background-color: #4CAF50;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #d32f2f;
        }
        .message {
            text-align: center;
            margin-bottom: 20px;
            color: green;
        }
        .error {
            color: red;
        }
        .footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: auto; /* Spinge il footer verso il fondo */
        }
        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="index.php">Home</a>
        <a href="aggiungi.php">Aggiungi</a>
    </div>

    <div class="container">
        <h2>Gestione URL Iniziali</h2>

        <!-- Messaggi di successo o errore -->
        <?php if (!empty($success_message)) echo "<p class='message'>$success_message</p>"; ?>
        <?php if (!empty($error_message)) echo "<p class='message error'>$error_message</p>"; ?>

        <!-- Modulo di inserimento -->
        <form method="POST" action="">
            <input type="text" name="url" placeholder="Inserisci un URL iniziale" required>
            <input type="submit" value="Aggiungi URL">
        </form>

        <!-- Tabella degli URL iniziali -->
        <table>
            <tr>
                <th>ID</th>
                <th>URL</th>
                <th>Azione</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row["id"] . "</td>
                            <td>" . htmlspecialchars($row["url"]) . "</td>
                            <td>
                                <form method='POST' action='' style='display:inline;'>
                                    <input type='hidden' name='delete_id' value='" . $row["id"] . "'>
                                    <button type='submit'>Elimina</button>
                                </form>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Nessun URL in attesa</td></tr>";
            }
            ?>
        </table>
    </div>

    <div class="footer">
        <p>© 2025 <a href="https://github.com/Cassiel-Vandisse/Anime-saturn-Scrapper" target="_blank">Cassiel-Vandisse</a>. Licenza MIT.</p>
    </div>
</body>
</html>

<?php
// Chiudi la connessione al database
$conn->close();
?>