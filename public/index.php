<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $file = __DIR__ . $_SERVER['REQUEST_URI'];
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . '/../vendor/autoload.php';

session_start();


// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

    $app->get('/hello/[{name}]', function ($request, $response, $args) {
        $name = $request->getAttribute('name');
        $response->getBody()->write("Hello, $name");

        return $response;
    });

    $app->get('/menu/f', function ($request, $response, $args) {
        $servername = "localhost";
        $username = "root";
        $password = "root";
        $dbname = "Menu";
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Create connection

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = "SELECT * FROM `FOOD`";
        $result = $conn->query($sql);
        $rows = array();
        if ($result->num_rows > 0) {
            // output data of each row
            while($r = $result->fetch_assoc()) {
                $rows[] = $r;
                
            }
        } 
        else {
            echo "0 results";
        }
        

        echo json_encode($rows);
        $conn->close();
    });

    $app->get('/{id}', function ($request, $response, $args) {
    $id = $request->getAttribute('id');

    return $response->withJSON(
        ['id' => $id]
    );
    });

$app->run();





