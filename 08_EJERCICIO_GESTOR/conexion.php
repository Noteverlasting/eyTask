<?php

//PARA CONECTARSE (POR EJEMPLO) A UNA DB EN MYSQL, CAMBIAMOS PUERTO Y CONTRASEÑA -EN ESTE CASO-

$host = 'sql313.byethost5.com';
$database = 'b5_39082256_tareas_omar';
$port = 3306;
$user = 'b5_39082256'; // este user no se debe utilizar, es mejor definir un usuario que no sea el raiz.
$password = 'tralalerotralala9999';
$charset = 'utf8mb4';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $conn = new PDO ("mysql:host=$host;port=$port;dbname=$database;charset=$charset;", $user, $password, $options);
    // echo "¡Conectado a $database! <br>";

    foreach ($conn -> query('SELECT * FROM tareas') as $fila) {
        // print_r($fila);
        // echo $fila['titulo'];
        // echo "<br>";

    }

} catch (PDOException $error){
    //SI FALLA, NOS INDICARÁ EL ERROR
    echo "Error $error";
}