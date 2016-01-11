<?php 
$app->get('/customercompany/getbyid/:id', function ($id) {
 
    $app = \Slim\Slim::getInstance();
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("SELECT * 
            FROM nkvcustomercompany
            WHERE CompanyID = :id");
 
        $sth->bindParam(':id', $id);
        $sth->execute();
 
        $customercompany = $sth->fetch(PDO::FETCH_OBJ);
 
        if($customercompany) {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($customercompany);
            $db = null;
        } else {
            throw new PDOException('No records found.');
        }
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/customercompany/get/', function () {
 
    $app = \Slim\Slim::getInstance();
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("SELECT * 
            FROM nkvcustomercompany
            ");
 
        $sth->execute();
 
        $customercompany = $sth->fetch(PDO::FETCH_OBJ);
 
        if($customercompany) {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($customercompany);
            $db = null;
        } else {
            throw new PDOException('No records found.');
        }
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->post('/customercompany/add/', function() use($app) {
 
    $allPostVars = $app->request->post();
   
   $CompanyName = $allPostVars['CompanyName'];
	$CompanyDescription = $allPostVars['CompanyDescription'];
	$CompanyCreatedOn = $allPostVars['CompanyCreatedOn'];
	$CompanyActiveFrom = $allPostVars['CompanyActiveFrom'];
	$CompanyActiveTill = $allPostVars['customercompanyCompanyActiveTill'];
	$CompanyIsActive = $allPostVars['CompanyIsActive'];
    
	try 
    {
        $db = getDB();
 
        $sth = $db->prepare("INSERT INTO nkvcustomercompany (CompanyName,CompanyDescription,CompanyCreatedOnword,CompanyActiveFrom,customercompanyCompanyActiveTill,CompanyIsActive)
            VALUES (:CompanyName,:CompanyDescription,:CompanyCreatedOn,:CompanyActiveFrom,:CompanyActiveTill,:CompanyIsActive)");
 
        $sth->bindParam(':CompanyName', $CompanyName);
		$sth->bindParam(':CompanyDescription', $CompanyDescription);
		$sth->bindParam(':CompanyCreatedOnword', $CompanyCreatedOn);
		$sth->bindParam(':CompanyActiveFrom', $CompanyActiveFrom);
		$sth->bindParam(':customercompanyCompanyActiveTill', $CompanyActiveTill);
		$sth->bindParam(':CompanyIsActive', $CompanyIsActive);
		
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

$app->post('/customercompany/update/', function() use($app) {
 
    $allPostVars = $app->request->post();
	
	$CompanyID=$allPostVars['CompanyID'];
	$CompanyName = $allPostVars['CompanyName'];
	$CompanyDescription = $allPostVars['CompanyDescription'];
	$CompanyCreatedOn = $allPostVars['CompanyCreatedOnword'];
	$CompanyActiveFrom = $allPostVars['CompanyActiveFrom'];
	$CompanyActiveTill = $allPostVars['customercompanyCompanyActiveTill'];
	$CompanyIsActive = $allPostVars['CompanyIsActive'];
	
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("UPDATE nkvcustomercompany 
            SET CompanyName=:CompanyName, CompanyDescription=:CompanyDescription, CompanyCreatedOnword=:CompanyCreatedOnword, CompanyActiveFrom=:CompanyActiveFrom, customercompanyCompanyActiveTill=:customercompanyCompanyActiveTill, 
			CompanyIsActive=:CompanyIsActive
            WHERE CompanyID = :CompanyID");
 
        $sth->bindParam(':CompanyID', $CompanyID);
		$sth->bindParam(':CompanyName', $CompanyName);
		$sth->bindParam(':CompanyDescription', $CompanyDescription);
		$sth->bindParam(':CompanyCreatedOnword', $CompanyCreatedOn);
		$sth->bindParam(':CompanyActiveFrom', $CompanyActiveFrom);
		$sth->bindParam(':customercompanyCompanyActiveTill', $CompanyActiveTill);
		$sth->bindParam(':CompanyIsActive', $CompanyIsActive);
		
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

$app->post('/customercompany/delete/', function() use($app) {
 
    $allPostVars = $app->request->post();
	$CompanyID=$allPostVars['CompanyID'];
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("Delete From nkvcustomercompany 
            WHERE CompanyID = :CompanyID");
 
        $sth->bindParam(':CompanyID', $CompanyID);
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