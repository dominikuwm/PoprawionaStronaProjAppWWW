<?php
session_start();
include('cfg.php');  // Dołączenie konfiguracji z bazą danych

// Pobranie ID kategorii z parametru URL
$kategoria_id = isset($_GET['kategoria_id']) ? intval($_GET['kategoria_id']) : 0;
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep - Lista produktów</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
        }
        h1, h2 {
            text-align: center;
            color: #333;
        }
        a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        .categories {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .categories ul {
            list-style: none;
            padding: 0;
        }
        .categories li {
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }
        .categories li:last-child {
            border-bottom: none;
        }
        .categories li a {
            font-size: 18px;
        }
        .product-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
        }
        .product-table th, .product-table td {
            padding: 15px;
            text-align: center;
        }
        .product-table th {
            background-color: #4CAF50;
            color: white;
        }
        .product-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .product-table tr:hover {
            background-color: #f1f1f1;
        }
        .back-home {
            display: block;
            text-align: center;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
            width: fit-content;
        }
        .back-home:hover {
            background-color: #45a049;
        }
        .empty-message {
            text-align: center;
            font-size: 18px;
            color: #888;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Sklep - Lista produktów</h1>
    <a href="index.php" class="back-home">Wróć na stronę główną</a>

    <!-- Wyświetlenie kategorii -->
    <div class="categories">
        <h2>Kategorie</h2>
        <ul>
            <li><a href="sklep.php">Wszystkie produkty</a></li>
            <?php
            $query = "SELECT id, nazwa FROM kategorie ORDER BY nazwa";
            $result = $link->query($query);
            while ($row = $result->fetch_assoc()) {
                echo '<li><a href="sklep.php?kategoria_id=' . $row['id'] . '">' . htmlspecialchars($row['nazwa']) . '</a></li>';
            }
            ?>
        </ul>
    </div>

    <!-- Wyświetlenie listy produktów -->
    <h2>Lista produktów</h2>
    <?php
    $sql = "SELECT p.*, k.nazwa AS nazwa_kategorii FROM produkty p
            LEFT JOIN kategorie k ON p.kategoria = k.id";

    if ($kategoria_id > 0) {
        $sql .= " WHERE p.kategoria = ?";
    }

    $stmt = $link->prepare($sql);
    if ($kategoria_id > 0) {
        $stmt->bind_param('i', $kategoria_id);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<table class="product-table">';
        echo '<tr><th>ID</th><th>Tytuł</th><th>Opis</th><th>Cena netto</th><th>VAT</th><th>Kategoria</th><th>Ilość sztuk</th></tr>';
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . $row['id'] . '</td>';
            echo '<td>' . htmlspecialchars($row['tytul']) . '</td>';
            echo '<td>' . htmlspecialchars($row['opis']) . '</td>';
            echo '<td>' . htmlspecialchars($row['cena_netto']) . ' zł</td>';
            echo '<td>' . htmlspecialchars($row['podatek_vat']) . '%</td>';
            echo '<td>' . htmlspecialchars($row['nazwa_kategorii']) . '</td>';
            echo '<td>' . htmlspecialchars($row['ilosc_sztuk']) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<p class="empty-message">Brak produktów w tej kategorii.</p>';
    }

    $link->close();
    ?>
</body>
</html>
