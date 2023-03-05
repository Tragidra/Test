<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Решение</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
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
        body {
            width: 100%;
            background-color: #99a0bd;
            height: 35px;
            margin-top:280px;
            margin-left:600px;
        }
    </style>
</head>
<body>
    <?php
    include 'Graph.php';
    error_reporting(E_ERROR | E_PARSE);
    session_start();

    $a = array();
    $array_with_values = array();
    $columns = $_SESSION['width'];
    $rows = $_SESSION['height'];
    $start = $_POST['start'] - 1;
    $end = $_POST['finish'] - 1;

    for($i = 0; $i < $rows; $i++){
        for($j = 0; $j < $columns; $j++){
            if(!is_numeric($_POST[$i * $columns + $j])){
                echo 'Вы ввели нечисловое значение!';
                exit();
            }
            $array_with_values[$i][] = $_POST[$i * $columns + $j];
        }
    }

    $j = 0;
    $graph_array = array();
    for($i = 0; $i < sizeof($array_with_values) * sizeof($array_with_values[0]); $i++){
        $y = intdiv($i , $columns);
        $x = $i % $columns;

        if($array_with_values[$y][$x + 1] != 0 && $array_with_values[$y][$x] != 0 && !in_array([$i, $i + 1], $graph_array)){
            $graph_array[$j++] = [$i, $i + 1];
            $graph_array[$j++] = [$i + 1, $i];
        }
        if($array_with_values[$y][$x - 1] != 0 && $array_with_values[$y][$x] != 0 && !in_array([$i, $i - 1], $graph_array)){
            $graph_array[$j++] = [$i, $i - 1];
            $graph_array[$j++] = [$i - 1, $i];
        }
        if($array_with_values[$y + 1][$x] != 0 && $array_with_values[$y][$x] != 0 && !in_array([$i + $columns, $i], $graph_array)){
            $graph_array[$j++] = [$i + $columns, $i];
            $graph_array[$j++] = [$i, $i + $columns];
        }
        if($array_with_values[$y - 1][$x] != 0 && $array_with_values[$y][$x] != 0 && !in_array([$i - $columns, $i], $graph_array)){
            $graph_array[$j++] = [$i, $i - $columns];
            $graph_array[$j++] = [$i - $columns, $i];
        }
    }

    $pathInfo = Graph::neighboring($graph_array);

    $path = Graph::count($pathInfo, $start, $end);

    $min_s = 1000000;
    $min_ind = -1;
    $s = 0;
    for($i = 0; $i < sizeof($path); $i++){
        for($j = 0; $j < sizeof($path[$i]); $j++){
            $y = intdiv($path[$i][$j], $columns);
            $x = $path[$i][$j] % $columns;
            $s += $array_with_values[$y][$x];
        }
        if($s < $min_s){
            $min_s = $s;
            $min_ind = $i;
        }
        $s = 0;
    }
    $incr_path = $path[$min_ind];
    try {
        for($i = 0; $i < sizeof($incr_path); $i++){
            $incr_path[$i]++;
        }
    }catch (TypeError $ex){
        echo 'У лабиринта нет решения';
        die();
    }

    try {
        echo 'Кратчайший путь к выходу проходит через поля лабиринта с номерами: ' . implode(', ', $incr_path) . '<br>';
        echo 'Длина пути составит ' . $min_s .' единиц.';
    }catch (TypeError $ex){
        echo 'У лабиринта нет решения';
        exit();
    }


    $q = 0;
    echo '<table><tbody>';
    for($i = 0; $i < $rows; $i++){
        echo '<tr>';
        for($j = 0; $j <$columns; $j++){
            if(in_array($q, $path[$min_ind])){
                echo '<td>';
            }else {
                echo '<td style="display:none;">';
            }
            echo $array_with_values[$i][$j];
            $q++;
            echo '</td>';
        }
        echo '</tr>';
    }
    echo '</tbody></table>';
    ?>
</body>
</html>
