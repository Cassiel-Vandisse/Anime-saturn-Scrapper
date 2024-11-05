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
$sql = "SELECT Url, titolo FROM estrapolazioni";
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
        h2 {
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>
    <h2>Dati Estratti</h2>
    <table>
        <tr>
            <th>URL</th>
            <th>Titolo</th>
        </tr>
        
        <?php
        // Controllo se ci sono risultati e visualizzazione
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr><td><a href='" . $row["Url"] . "' target='_blank'>" . $row["Url"] . "</a></td><td>" . htmlspecialchars($row["titolo"]) . "</td></tr>";
            }
        } else {
            echo "<tr><td colspan='2'>Nessun dato disponibile</td></tr>";
        }
        ?>

    </table>
</body>
</html>

<?php
// Chiudi la connessione al database
$conn->close();
?>
