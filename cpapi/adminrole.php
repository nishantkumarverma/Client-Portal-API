<?php 
$app->get('/adminrole/getbyid/:id', function ($id) {
 
    $app = \Slim\Slim::getInstance();
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("SELECT * 
            FROM nkvadminrole
            WHERE AdminRoleID = :id");
 
        $sth->bindParam(':id', $id);
        $sth->execute();
 
        $adminrole = $sth->fetchAll(PDO::FETCH_OBJ);
 
        if($adminrole) {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($adminrole);
            $db = null;
        } else {
            throw new PDOException('No records found.');
        }
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/adminrole/get(/)', function () {
 
    $app = \Slim\Slim::getInstance();
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("SELECT * 
            FROM nkvadminrole Where AdminRoleIsActive=1
            ");
 
        $sth->execute();
 
        $adminrole = $sth->fetchAll(PDO::FETCH_OBJ);
 
        if($adminrole) {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($adminrole);
            $db = null;
        } else {
            throw new PDOException('No records found.');
        }
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->post('/adminrole/add(/)', function() use($app) {
 
    $allPostVars = $app->request->post();
    $AdminRoleIsActive = $allPostVars['AdminRoleIsActive'];
    $AdminRoleName = $allPostVars['AdminRoleName'];
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("INSERT INTO nkvadminrole (AdminRoleName,AdminRoleIsActive)
            VALUES (:AdminRoleName,:AdminRoleIsActive)");
 
        $sth->bindParam(':AdminRoleIsActive', $AdminRoleIsActive);
        $sth->bindParam(':AdminRoleName', $AdminRoleName);
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

$app->post('/adminrole/update(/)', function() use($app) {
 
    $allPostVars = $app->request->post();
      $AdminRoleIsActive = $allPostVars['AdminRoleIsActive'];
    $AdminRoleName = $allPostVars['AdminRoleName'];
	$AdminRoleID=$allPostVars['AdminRoleID'];
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("UPDATE nkvadminrole 
            SET AdminRoleIsActive = :AdminRoleIsActive, AdminRoleName=:AdminRoleName
            WHERE AdminRoleID = :AdminRoleID");
 
        $sth->bindParam(':AdminRoleIsActive', $AdminRoleIsActive);
		$sth->bindParam(':AdminRoleName', $AdminRoleName);
        $sth->bindParam(':AdminRoleID', $AdminRoleID);
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

$app->post('/adminrole/delete(/)', function() use($app) {
 
    $allPostVars = $app->request->post();
	$AdminRoleID=$allPostVars['AdminRoleID'];
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("Delete From nkvadminrole 
            WHERE AdminRoleID = :AdminRoleID");
 
        $sth->bindParam(':AdminRoleID', $AdminRoleID);
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