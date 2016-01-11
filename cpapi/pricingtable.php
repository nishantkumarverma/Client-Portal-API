<?php 
$app->get('/pricingtable/getbyid/:id', function ($id) {
 
    $app = \Slim\Slim::getInstance();
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("SELECT * 
            FROM pricingview
            WHERE PriceID = :id");
 
        $sth->bindParam(':id', $id);
        $sth->execute();
 
        $pricingtable = $sth->fetchAll(PDO::FETCH_OBJ);
 
        if($pricingtable) {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($pricingtable);
            $db = null;
        } else {
            throw new PDOException('No records found.');
        }
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/pricingtable/getbylocation/:id', function ($id) {
 
    $app = \Slim\Slim::getInstance();
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("SELECT * 
            FROM pricingview
            WHERE LocationID = :id");
 
        $sth->bindParam(':id', $id);
        $sth->execute();
 
        $pricingtable = $sth->fetchAll(PDO::FETCH_OBJ);
 
        if($pricingtable) {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($pricingtable);
            $db = null;
        } else {
            throw new PDOException('No records found.');
        }
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/pricingtable/getall(/)', function () {
 
    $app = \Slim\Slim::getInstance();
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("SELECT * 
            FROM pricingview
            ");
 
        $sth->execute();
 
        $pricingtable = $sth->fetchAll(PDO::FETCH_OBJ);
 
        if($pricingtable) {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($pricingtable);
            $db = null;
        } else {
            throw new PDOException('No records found.');
        }
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/pricingtable/getall(/)', function () {
 
    $app = \Slim\Slim::getInstance();
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("SELECT * 
            FROM pricingview where PriceIsActive=1
            ");
 
        $sth->execute();
 
        $pricingtable = $sth->fetchAll(PDO::FETCH_OBJ);
 
        if($pricingtable) {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($pricingtable);
            $db = null;
        } else {
            throw new PDOException('No records found.');
        }
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});


$app->post('/pricingtable/add(/)', function() use($app) {
 
    $allPostVars = $app->request->post();
	
    $TimeSlotID = $allPostVars['TimeSlotID'];
    $LocationID = $allPostVars['LocationID'];
	$PricePerSec = $allPostVars['PricePerSec'];
	$PriceDescription = $allPostVars['PriceDescription'];
	$PriceIsActive = $allPostVars['PriceIsActive'];
    $MinimumSecRequired = $allPostVars['MinimumSecRequired'];
	
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("INSERT INTO nkvpricingtable (TimeSlotID,LocationID,PricePerSec,MinimumSecRequired,PriceDescription,PriceIsActive)
            VALUES (:TimeSlotID,:LocationID,:PricePerSec,:MinimumSecRequired,:PriceDescription,:PriceIsActive)");
 
        $sth->bindParam(':TimeSlotID', $TimeSlotID);
        $sth->bindParam(':LocationID', $LocationID);
		$sth->bindParam(':PricePerSec', $PricePerSec);
        $sth->bindParam(':MinimumSecRequired', $MinimumSecRequired);
		$sth->bindParam(':PriceDescription', $PriceDescription);
		$sth->bindParam(':PriceIsActive', $PriceIsActive);
        $sth->execute();
 
        $app->response->setStatus(200);
        $app->response()->headers->set('Content-Type', 'application/json');
        echo json_encode(array("status" => "success", "code" => 1));
        $db = null;
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
 
});

$app->post('/pricingtable/update(/)', function() use($app) {
 
    $allPostVars = $app->request->post();
   
	$PriceID=$allPostVars['PriceID'];
	$TimeSlotID = $allPostVars['TimeSlotID'];
    $LocationID = $allPostVars['LocationID'];
	$PricePerSec = $allPostVars['PricePerSec'];
    $MinimumSecRequired = $allPostVars['MinimumSecRequired'];
    
	try 
    {
        $db = getDB();
 
        $sth = $db->prepare("UPDATE nkvpricingtable 
            SET TimeSlotID = :TimeSlotID, LocationID=:LocationID, PricePerSec=:PricePerSec, MinimumSecRequired=:MinimumSecRequired
            WHERE PriceID = :PriceID");
 
        $sth->bindParam(':PriceID', $PriceID);
		$sth->bindParam(':TimeSlotID', $TimeSlotID);
        $sth->bindParam(':LocationID', $LocationID);
		$sth->bindParam(':PricePerSec', $PricePerSec);
        $sth->bindParam(':MinimumSecRequired', $MinimumSecRequired);
		
        $sth->execute();
 
        $app->response->setStatus(200);
        $app->response()->headers->set('Content-Type', 'application/json');
        echo json_encode(array("status" => "success", "code" => 1));
        $db = null;
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
 
});

$app->post('/pricingtable/delete(/)', function() use($app) {
 
    $allPostVars = $app->request->post();
	$PriceID=$allPostVars['PriceID'];
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("Delete From nkvpricingtable 
            WHERE PriceID = :PriceID");
 
        $sth->bindParam(':PriceID', $PriceID);
        $sth->execute();
 
        $app->response->setStatus(200);
        $app->response()->headers->set('Content-Type', 'application/json');
        echo json_encode(array("status" => "success", "code" => 1));
        $db = null;
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
 
});
?>