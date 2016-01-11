<?php 
$app->get('/customerrole/getbyid/:id', function ($id) {
 
    $app = \Slim\Slim::getInstance();
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("SELECT * 
            FROM nkvcustomerrole
            WHERE CustomerRoleID = :id");
 
        $sth->bindParam(':id', $id);
        $sth->execute();
 
        $customerrole = $sth->fetch(PDO::FETCH_OBJ);
 
        if($customerrole) {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($customerrole);
            $db = null;
        } else {
            throw new PDOException('No records found.');
        }
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/customerrole/get/', function () {
 
    $app = \Slim\Slim::getInstance();
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("SELECT * 
            FROM nkvcustomerrole
            ");
 
        $sth->execute();
 
        $customerrole = $sth->fetch(PDO::FETCH_OBJ);
 
        if($customerrole) {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($customerrole);
            $db = null;
        } else {
            throw new PDOException('No records found.');
        }
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->post('/customerrole/add/', function() use($app) {
 
    $allPostVars = $app->request->post();
    $CustomerRoleIsActive = $allPostVars['CustomerRoleIsActive'];
    $CustomerRoleName = $allPostVars['CustomerRoleName'];
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("INSERT INTO nkvcustomerrole (CustomerRoleName,CustomerRoleIsActive)
            VALUES (:CustomerRoleName,:CustomerRoleIsActive)");
 
        $sth->bindParam(':CustomerRoleIsActive', $CustomerRoleIsActive);
        $sth->bindParam(':CustomerRoleName', $CustomerRoleName);
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

$app->post('/customerrole/update/', function() use($app) {
 
    $allPostVars = $app->request->post();
      $CustomerRoleIsActive = $allPostVars['CustomerRoleIsActive'];
    $CustomerRoleName = $allPostVars['CustomerRoleName'];
	$CustomerRoleID=$allPostVars['CustomerRoleID'];
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("UPDATE nkvcustomerrole 
            SET CustomerRoleIsActive = :CustomerRoleIsActive, CustomerRoleName=:CustomerRoleName
            WHERE CustomerRoleID = :CustomerRoleID");
 
        $sth->bindParam(':CustomerRoleIsActive', $CustomerRoleIsActive);
		$sth->bindParam(':CustomerRoleName', $CustomerRoleName);
        $sth->bindParam(':CustomerRoleID', $CustomerRoleID);
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

$app->post('/customerrole/delete/', function() use($app) {
 
    $allPostVars = $app->request->post();
	$CustomerRoleID=$allPostVars['CustomerRoleID'];
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("Delete From nkvcustomerrole 
            WHERE CustomerRoleID = :CustomerRoleID");
 
        $sth->bindParam(':CustomerRoleID', $CustomerRoleID);
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