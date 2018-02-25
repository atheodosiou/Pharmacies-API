<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../src/config.php';

$app = new \Slim\App;

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

//get all pharmacies with locations
$app->get('/api/pharmacies', function(Request $request, Response $response){
   $sql = "SELECT * FROM pharmacy, location WHERE pharmacy.id = location.pharmacy_id"; 
    
    try{
        $db = new db();
        $db = $db->connect();
        $stm = $db->query($sql);
        $pharmacies = $stm->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        
        echo json_encode($pharmacies);
    }catch(PDOException $ex){
        echo $ex->getMessage();
    }
});

//get single pharmact with location
$app->get('/api/pharmacy/{id}', function(Request $request, Response $response){
    $id = $request->getAttribute('id');
    
    $sql = "SELECT * FROM pharmacy, location WHERE pharmacy.id = $id AND location.pharmacy_id = $id"; 
    
    try{
        $db = new db();
        $db = $db->connect();
        $stm = $db->query($sql);
        $pharmacies = $stm->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        
        echo json_encode($pharmacies);
    }catch(PDOException $ex){
        echo $ex->getMessage();
    }
});

//create new pharmacy
$app->post('/api/pharmacy/add', function(Request $request, Response $response){
    $name = $request->getParam('name');
    $phone = $request->getParam('phone');
    $working_hours = $request->getParam('working_hours');
    
    $sql = "INSERT INTO pharmacy (name, phone, working_hours) VALUES (:name, :phone, :working_hours)";
    
    
        try{
            $db = new db();
            $db = $db->connect();
            $stm = $db->prepare($sql);

            $stm->bindParam(':name', $name);
            $stm->bindParam(':phone', $phone);
            $stm->bindParam(':working_hours', $working_hours);

            $stm->execute();
            $db = null;

            echo '{"notice": {"text": "Pharmacy added"}';
        }catch(PDOException $ex){
            echo 'Error text: '.$ex->getMessage();
        }
});

//add location on existing pharmacy
$app->post('/api/location/add', function(Request $request, Response $response){    
    $county = $request->getParam('county');
    $city = $request->getParam('city');
    $street_address = $request->getParam('street_address');
    $post_code = $request->getParam('post_code');
    $latitude = $request->getParam('latitude');
    $longitude = $request->getParam('longitude');
    $accuracy = $request->getParam('accuracy');
    $pharmacy_id = $request->getParam('pharmacy_id');
    
    $sql = "INSERT INTO location (county, city, street_address, post_code, latitude, longitude, accuracy, pharmacy_id) 
            VALUES (:county, :city, :street_address, :post_code, :latitude, :longitude, :accuracy, :pharmacy_id)";
    
    
        try{
            $db = new db();
            $db = $db->connect();
            $stm = $db->prepare($sql);

            $stm->bindParam(':county', $county);
            $stm->bindParam(':city', $city);
            $stm->bindParam(':street_address', $street_address);
            $stm->bindParam(':post_code', $post_code);
            $stm->bindParam(':latitude', $latitude);
            $stm->bindParam(':longitude', $longitude);
            $stm->bindParam(':accuracy', $accuracy);
            $stm->bindParam(':pharmacy_id', $pharmacy_id);

            $stm->execute();
            $db = null;

            echo '{"notice": {"text": "Location added"}';
        }catch(PDOException $ex){
            echo 'Error text: '.$ex->getMessage();
        }
});
$app->run();

