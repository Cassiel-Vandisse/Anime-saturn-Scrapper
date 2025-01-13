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

// Query per selezionare i dati
$sql = "SELECT id, Url, titolo FROM estrapolazioni";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizza Estrazioni</title>
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
        h2 {
            text-align: center;
            color: #333;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #ffffff;
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
        form {
            display: inline;
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

    <h2>Dati Estratti</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>URL</th>
            <th>Titolo</th>
            <th>Azione</th>
        </tr>

        <?php
        // Controllo se ci sono risultati e visualizzazione
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["id"] . "</td>
                        <td><a href='" . $row["Url"] . "' target='_blank'>" . $row["Url"] . "</a></td>
                        <td>" . htmlspecialchars($row["titolo"]) . "</td>
                        <td>
                            <form method='POST' action=''>
                                <input type='hidden' name='delete_id' value='" . $row["id"] . "'>
                                <button type='submit'>Elimina</button>
                            </form>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Nessun dato disponibile</td></tr>";
        }
        ?>