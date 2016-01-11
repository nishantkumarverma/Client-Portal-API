<?php 
$app->get('/tax/get(/)', function () {
 
    $app = \Slim\Slim::getInstance();
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("SELECT * 
            FROM nkvtaxapplied where TaxIsActive=1
            ");
 
        $sth->execute();
 
        $timeslot = $sth->fetchAll(PDO::FETCH_OBJ);
 
        if($timeslot) {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($timeslot);
            $db = null;
        } else {
            throw new PDOException('No records found.');
        }
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});



?>