<!doctype html>
<html lang=ru>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Лабиринт</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            width: 100%;
            background-color: #99a0bd;
            height: 35px;
            margin-top:280px;
            margin-left:600px;
        }
        table {
            width: 300px;
            border-collapse: separate;
        }
        td {
            border: solid 3px;
        }
        th {
            border: solid 3px;
        }
    </style>
</head>
<body>
    <?php
    session_start();
//    error_reporting(E_ERROR|E_WARNING);
    $height = $_POST['height'];
    $width = $_POST['width'];
    $counter = 0;

    if($height == 0){
        echo 'Длина лабиринта не может равняться нулю';
        die();
    } elseif ($width == 0){
        echo 'Ширина лабиринта не может равняться нулю';
        die();
    } elseif ($height < 0){
        echo 'Длина лабиринта не может иметь отрицательное значение';
        die();
    } elseif ($width < 0) {
        echo 'Ширина лабиринта не может иметь отрицательное значение';
        die();
    }

    //Записывает длину и ширину в ассоциативный массив текущего сеанса
    $_SESSION['height'] = $height;
    $_SESSION['width'] = $width;

    echo '<form method="post" action="solver.php">';
    echo '<table  ><tbody>';

    //Заполняем клетки лабиринта
    for($i = 0; $i < $_POST['height']; $i++){
        echo '<tr>';
        for($j = 0; $j <$_POST['width']; $j++){
                echo "<td><input type='text' id='$counter' name='$counter' value='0'></td>"; //У каждой клетки будет уникальное id и название согласно счётчику
                $counter++;
        }
        echo '</tr>';
    }
    echo '</tbody></table>';
    echo '<br>
        <p>Вход в лабиринт находится в клетке номер: <input type="text" name="start"/></p>
        <p>Выход из лабиринта находится в клетке: <input type="text" name="finish"/></p>';
    echo '<p><input type="submit" value="Найти кратчайший путь" class="btn btn-secondary"/></p>';
    echo '</form>';
    ?>
</body>
</html>