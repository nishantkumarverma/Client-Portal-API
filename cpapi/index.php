<?php
require_once 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();


function getDB()
{
    $dbhost = "localhost";
    $dbuser = "thinkles_cpdb";
    $dbpass = "L.El+N2{afGx";
    $dbname = "thinkles_cpdb";
 
    $mysql_conn_string = "mysql:host=$dbhost;dbname=$dbname";
    $dbConnection = new PDO($mysql_conn_string, $dbuser, $dbpass); 
    $dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbConnection;
}
 
 
 

$app->get('/', function() use($app) {
    $app->response->setStatus(200);
    echo "Welcome to Slim 3.0 based API";
}); 
$app->get('/admin', function() use($app) {
    $app->response->setStatus(200);
    echo "Welcome to Slim 3.0 based API - admin";
}); 

$app->get('/adminrole', function() use($app) {
    $app->response->setStatus(200);
    echo "Welcome to Slim 3.0 based API - adminrole";
}); 
$app->get('/booking', function() use($app) {
    $app->response->setStatus(200);
    echo "Welcome to Slim 3.0 based API - booking";
}); 
$app->get('/coupon', function() use($app) {
    $app->response->setStatus(200);
    echo "Welcome to Slim 3.0 based API - coupon";
}); 
$app->get('/customer', function() use($app) {
    $app->response->setStatus(200);
    echo "Welcome to Slim 3.0 based API - customer";
}); 
$app->get('/customercompany', function() use($app) {
    $app->response->setStatus(200);
    echo "Welcome to Slim 3.0 based API - customercompany";
}); 
$app->get('/customerrole', function() use($app) {
    $app->response->setStatus(200);
    echo "Welcome to Slim 3.0 based API - customerrole";
}); 
$app->get('/location', function() use($app) {
    $app->response->setStatus(200);
    echo "Welcome to Slim 3.0 based API - location";
}); 
$app->get('/locationcategory', function() use($app) {
    $app->response->setStatus(200);
    echo "Welcome to Slim 3.0 based API - locationcategory";
}); 
$app->get('/pricingtable', function() use($app) {
    $app->response->setStatus(200);
    echo "Welcome to Slim 3.0 based API - pricingtable";
}); 
$app->get('/timeslot', function() use($app) {
    $app->response->setStatus(200);
    echo "Welcome to Slim 3.0 based API - timeslot";
}); 

include_once("admin.php");
include_once("adminrole.php");
include_once("booking.php");
include_once("coupon.php");
include_once("customer.php");
include_once("customercompany.php");
include_once("customerrole.php");
include_once("location.php");
include_once("locationcategory.php");
include_once("pricingtable.php");
include_once("timeslot.php");
include_once("tax.php");
include_once("paymentmethod.php");

$app->run();

?>