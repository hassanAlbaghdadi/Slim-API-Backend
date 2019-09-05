<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

//endpoint to get all players resources
$app->get('/api/players', function(Request $request, Response $response){
    
    //SQL query
    $sql= "SELECT * FROM players";
    
    try{
        //get db object
        $db= new db();
        // connect db
        $db = $db->connect();

        //prepared stmt
        $stmt = $db->query($sql);
        //fetching the resources
        $players = $stmt->fetchAll(PDO::FETCH_OBJ);
        //close connection
        $db=null;
        
        //echoing in json 
        $json= json_encode($players);
        //return the response object
        $response->getBody()->write($json);
        return $response;
    } catch(PDOException $e){
        //error report
        echo '{"error":{"text": '.$e->getMessage().'}';
    } 
});

//endpoint to get a specific player resources using id
$app->get('/api/player/{id}', function(Request $request, Response $response){
    //getting the id from the request
    $id= $request->getAttribute('id');
    //SQL query
    $sql= "SELECT * FROM players WHERE id = $id";
    
    try{
        //get db object
        $db= new db();
        // connect db
        $db = $db->connect();

        //prepared stmt
        $stmt = $db->query($sql);
        //fetching the resources
        $player = $stmt->fetch(PDO::FETCH_OBJ);
        //close connection
        $db=null;
        
        //echoing in json 
        $json= json_encode($player);
        //return the response object
        $response->getBody()->write($json);
        return $response;
    } catch(PDOException $e){
        //error report
        echo '{"error":{"text": '.$e->getMessage().'}';
    } 
});

//endpoint to which a player can be uploaded using a .json file
$app->post('/api/player/add', function(Request $request, Response $response){
    //getting the paramters
    $name= $request->getParam('_name');
    $age= $request->getParam('age');
    $city= $request->getParam('city');
    $province= $request->getParam('province');
    $country= $request->getParam('country');

    //SQL query
    $sql= "INSERT * INTO players (_name,age,city,province,country) VALUES (:_name,age,:city,:province,:country)";
    
    try{
        //get db object
        $db= new db();
        // connect db
        $db = $db->connect();

        //prepared stmt
        $stmt = $db->prepare($sql);
        //binding the parameters
        $stmt->bindParam(':name',$name);
        $stmt->bindParam(':age',$age);
        $stmt->bindParam(':city',$city);
        $stmt->bindParam(':province',$province);
        $stmt->bindParam(':country',$country);
        //execute the stmt
        $stmt->execute();
        
        //close connection
        $db=null;
        
        //echoing success
        $text='{"message":"Player Added"';
        //return the response object
        $response->getBody()->write($text);
        return $response;
    } catch(PDOException $e){
        //error report
        echo '{"error":{"text": '.$e->getMessage().'}';
    } 
});

//endpoint to delete a specific player resources using id
$app->delete('/api/player/delete/{id}', function(Request $request, Response $response){
    //getting the id from the request
    $id= $request->getAttribute('id');
    //SQL query
    $sql= "DELETE FROM players WHERE id = $id";
    
    try{
        //get db object
        $db= new db();
        // connect db
        $db = $db->connect();

        //prepared stmt
        $stmt = $db->prepare($sql);
        $stmt = execute();
        //close connection
        $db=null;
        
        //echoing success
        $text='{"message":"Player deleted"';
        //return the response object
        $response->getBody()->write($text);
        return $response;
    } catch(PDOException $e){
        //error report
        echo '{"error":{"text": '.$e->getMessage().'}';
    } 
});

