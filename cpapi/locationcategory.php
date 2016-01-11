<?php 
$app->get('/locationcategory/getbyid/:id', function ($id) {
 
    $app = \Slim\Slim::getInstance();
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("SELECT * 
            FROM nkvlocationcategory
            WHERE LocationCategoryID = :id");
 
        $sth->bindParam(':id', $id);
        $sth->execute();
 
        $locationcategory = $sth->fetchAll(PDO::FETCH_OBJ);
 
        if($locationcategory) {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($locationcategory);
            $db = null;
        } else {
            throw new PDOException('No records found.');
        }
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/locationcategory/get(/)', function () {
 
    $app = \Slim\Slim::getInstance();
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("SELECT * 
            FROM nkvlocationcategory
            ");
 
        $sth->execute();
 
        $locationcategory = $sth->fetchAll(PDO::FETCH_OBJ);
 
        if($locationcategory) {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($locationcategory);
            $db = null;
        } else {
            throw new PDOException('No records found.');
        }
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->post('/locationcategory/add(/)', function() use($app) {
 
    $allPostVars = $app->request->post();
	
    $LocationCategoryDesc = $allPostVars['LocationCategoryDesc'];
    $LocationCategoryName = $allPostVars['LocationCategoryName'];
	$CategoryIsActive = $allPostVars['CategoryIsActive'];
	
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("INSERT INTO nkvlocationcategory (LocationCategoryName,LocationCategoryDesc,CategoryIsActive)
            VALUES (:LocationCategoryName,:LocationCategoryDesc,:CategoryIsActive)");
 
        $sth->bindParam(':LocationCategoryDesc', $LocationCategoryDesc);
        $sth->bindParam(':LocationCategoryName', $LocationCategoryName);
		$sth->bindParam(':CategoryIsActive', $CategoryIsActive);
       
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

$app->post('/locationcategory/update(/)', function() use($app) {
 
    $allPostVars = $app->request->post();
    $LocationCategoryDesc = $allPostVars['LocationCategoryDesc'];
    $LocationCategoryName = $allPostVars['LocationCategoryName'];
	$LocationCategoryID=$allPostVars['LocationCategoryID'];
	$CategoryIsActive = $allPostVars['CategoryIsActive'];
    
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("UPDATE nkvlocationcategory 
            SET LocationCategoryDesc = :LocationCategoryDesc, LocationCategoryName=:LocationCategoryName, CategoryIsActive=:CategoryIsActive
            WHERE LocationCategoryID = :LocationCategoryID");
 
        $sth->bindParam(':LocationCategoryDesc', $LocationCategoryDesc);
		$sth->bindParam(':LocationCategoryName', $LocationCategoryName);
        $sth->bindParam(':LocationCategoryID', $LocationCategoryID);
		$sth->bindParam(':CategoryIsActive', $CategoryIsActive);
		
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

$app->post('/locationcategory/delete(/)', function() use($app) {
 
    $allPostVars = $app->request->post();
	$LocationCategoryID=$allPostVars['LocationCategoryID'];
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("Delete From nkvlocationcategory 
            WHERE LocationCategoryID = :LocationCategoryID");
 
        $sth->bindParam(':LocationCategoryID', $LocationCategoryID);
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