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

$servername = "localhost";
$username = "test";
$password = "test";
$dbname = "test";

// Instantiate the app
    $settings = require __DIR__ . '/../src/settings.php';
    $app = new \Slim\App($settings);

    $app->get('/menu/f', function ($request, $response, $args) {

        global $servername, $username, $password, $dbname;
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

    $app->get('/menu/dr', function ($request, $response, $args) {
        
        global $servername, $username, $password, $dbname;
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Create connection

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = "SELECT * FROM `DRINKS`";
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

     $app->get('/menu/dess', function ($request, $response, $args) {
        
        global $servername, $username, $password, $dbname;
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Create connection

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 

        $sql = "SELECT * FROM `DESS`";
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

    $app->get("/reserve", function ($request, $response, $args) {
        
        global $servername, $username, $password, $dbname;
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Create connection

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $fName = $request->getAttribute('fname');
        //$fName = $app->request->get('fname');
        //$response->getBody()->write($fName);

        //return $response;
        
        $lName = $request->getAttribute('lname');
        $time = $request->getAttribute('time');
        $LD = $request->getAttribute('ld');
        $NoG = $request->getAttribute('nog');
        $date = $request->getAttribute('date');

        $sql = "INSERT INTO Reservations (FName, LName, T, LD, NoG, D)
                VALUES ($fName, $lName, $time, $LD, $NoG, $date)";
        
        if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
        } 
        else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        
        $conn->close();
    });

$app->run();













