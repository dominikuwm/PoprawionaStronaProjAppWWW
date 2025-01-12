<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="Content-Language" content="pl">
    <meta name="Author" content="Dominik Gutowski">
    <title>Japońskie samochody</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="/js/timedate.js" type="text/javascript"></script>
    <script src="/js/kolortlo.js" type="text/javascript"></script>
</head>
<body>
    <!-- Obrazek -->
    

    <!-- Nawigacja po stronie -->
    <nav>
        <ul>
            <li><a href="index.php?id=glowna">Strona Główna</a></li>
            <li><a href="index.php?id=kontakt">Kontakt</a></li>
            <li><a href="index.php?id=historia">Historia japońskich samochodów</a></li>
            <li><a href="index.php?id=popmar">Najpopularniejsze marki</a></li>
            <li><a href="index.php?id=motorsport">Motorsport i tuning</a></li>
            <li><a href="index.php?id=samelek">Samochody elektryczne i hybrydowe</a></li>
            <li><a href="index.php?id=lab3">Lab 3</a></li>
        </ul>
    </nav>

    <!-- Główna treść strony -->
    <div class="content">
        <?php
        // Wyświetlanie błędów dla debugowania
        error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

        // Strona domyślna
        $strona = 'html/glowna.html';

        // Obsługa dynamicznego wyboru podstron
        if (isset($_GET['id'])) {
            switch ($_GET['id']) {
                case 'glowna':
                    $strona = 'html/glowna.html';
                    break;
                case 'kontakt':
                    $strona = 'html/kontakt.html';
                    break;
                case 'historia':
                    $strona = 'html/historia.html';
                    break;
                case 'popmar':
                    $strona = 'html/popmar.html';
                    break;
                case 'motorsport':
                    $strona = 'html/motorsport.html';
                    break;
                case 'samelek':
                    $strona = 'html/samelek.html';
                    break;
                case 'lab3':
                    $strona = 'html/lab3.html';
                    break;
                default:
                    echo "<h3>Nie znaleziono podstrony. Przekierowanie do strony głównej...</h3>";
                    $strona = '/html/glowna.html';
                    break;
            }
        }

        // Sprawdzenie, czy plik istnieje i wczytanie zawartości
        if (file_exists($strona)) {
            include($strona);
        } else {
            echo "<h3>Błąd: Plik nie istnieje!</h3>";
        }
        ?>
    </div>

    <!-- Stopka -->
    <footer>
        <?php
        $nr_indeksu = '1234567';
        $nrGrupy = 'X';
        echo 'Autor: Jan Kowalski, nr indeksu: ' . $nr_indeksu . ', grupa: ' . $nrGrupy . '<br>';
        ?>
    </footer>
</body>
</html>

