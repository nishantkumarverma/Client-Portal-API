<?php 
$app->get('/location/getbyid/:id', function ($id) {
 
    $app = \Slim\Slim::getInstance();
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("SELECT l.*,c.LocationCategoryName,c.LocationCategoryDesc 
            FROM nkvlocation l, nkvlocationcategory c 
            WHERE c.LocationCategoryID=l.LocationCategoryID and l.LocationID = :id");
 
        $sth->bindParam(':id', $id);
        $sth->execute();
 
        $location = $sth->fetchAll(PDO::FETCH_OBJ);
 
        if($location) {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($location);
            $db = null;
        } else {
            throw new PDOException('No records found.');
        }
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/location/get(/)', function () {
 
    $app = \Slim\Slim::getInstance();
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("SELECT l.*,c.LocationCategoryName,c.LocationCategoryDesc 
            FROM nkvlocation l, nkvlocationcategory c 
            WHERE c.LocationCategoryID=l.LocationCategoryID
            ");
 
        $sth->execute();
 
        $location = $sth->fetchAll(PDO::FETCH_OBJ);
 
        if($location) {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($location);
            $db = null;
        } else {
            throw new PDOException('No records found.');
        }
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->post('/location/add(/)', function() use($app) {
 
    $allPostVars = $app->request->post();
    
	$LocationName = $allPostVars['LocationName'];
	$ScreenHeight = $allPostVars['ScreenHeight'];
	$ScreenWidth = $allPostVars['ScreenWidth'];
	$ScreenResolution = $allPostVars['ScreenResolution'];
	$LocationCategoryID = $allPostVars['LocationCategoryID'];
	$Latitude = $allPostVars['Latitude'];
	$Longitude=$allPostVars['Longitude'];
	$CompleteAddress=$allPostVars['CompleteAddress'];
	$LocationIsActive=$allPostVars['LocationIsActive'];
	$Pincode=$allPostVars['Pincode'];
    
	try 
    {
        $db = getDB();
 
        $sth = $db->prepare("INSERT INTO nkvlocation (LocationName,ScreenHeight,ScreenWidth,ScreenResolution,LocationCategoryID,Latitude,Longitude,CompleteAddress,
		LocationIsActive,Pincode)
            VALUES (:LocationName,:ScreenHeight,:ScreenWidth,:ScreenResolution,:LocationCategoryID,:Latitude,:Longitude,:CompleteAddress,
		:LocationIsActive,:Pincode)");
 
        $sth->bindParam(':LocationName', $LocationName);
		$sth->bindParam(':ScreenHeight', $ScreenHeight);
		$sth->bindParam(':ScreenWidth', $ScreenWidth);
		$sth->bindParam(':ScreenResolution', $ScreenResolution);
		$sth->bindParam(':LocationCategoryID', $LocationCategoryID);
		$sth->bindParam(':Latitude', $Latitude);
		$sth->bindParam(':Longitude', $Longitude);
		$sth->bindParam(':CompleteAddress', $CompleteAddress);
		$sth->bindParam(':LocationIsActive', $LocationIsActive);
		$sth->bindParam(':Pincode', $Pincode);
		
		
		
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

$app->post('/location/update(/)', function() use($app) {
 
    $allPostVars = $app->request->post();
	$ScreenHeight=$allPostVars['ScreenHeight'];
	$LocationName = $allPostVars['LocationName'];
	$ScreenHeight = $allPostVars['ScreenHeight'];
	$ScreenWidth = $allPostVars['ScreenWidthword'];
	$ScreenResolution = $allPostVars['ScreenResolution'];
	$LocationCategoryID = $allPostVars['LocationCategoryID'];
	$Latitude = $allPostVars['Latitude'];
	$Longitude=$allPostVars['Longitude'];
	$CompleteAddress=$allPostVars['CompleteAddress'];
	$LocationIsActive=$allPostVars['LocationIsActive'];
	$Pincode=$allPostVars['Pincode'];
	$LocationCreatedOn=$allPostVars['LocationCreatedOn'];
	
	
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("UPDATE nkvlocation 
            SET LocationName=:LocationName, ScreenHeight=:ScreenHeight, ScreenWidthword=:ScreenWidthword, ScreenResolution=:ScreenResolution, 
			LocationCategoryID=:LocationCategoryID, Latitude=:Latitude, Longitude=:Longitude, CompleteAddress=:CompleteAddress, LocationIsActive=:LocationIsActive, 
			Pincode=:Pincode, LocationCreatedOn=:LocationCreatedOn
            WHERE ScreenHeight = :ScreenHeight");
 
        $sth->bindParam(':ScreenHeight', $ScreenHeight);
		$sth->bindParam(':LocationName', $LocationName);
		$sth->bindParam(':ScreenHeight', $ScreenHeight);
		$sth->bindParam(':ScreenWidthword', $ScreenWidth);
		$sth->bindParam(':ScreenResolution', $ScreenResolution);
		$sth->bindParam(':LocationCategoryID', $LocationCategoryID);
		$sth->bindParam(':Latitude', $Latitude);
		$sth->bindParam(':Longitude', $Longitude);
		$sth->bindParam(':CompleteAddress', $CompleteAddress);
		$sth->bindParam(':LocationIsActive', $LocationIsActive);
		$sth->bindParam(':Pincode', $Pincode);
		$sth->bindParam(':LocationCreatedOn', $LocationCreatedOn);
		
		
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

$app->post('/location/delete(/)', function() use($app) {
 
    $allPostVars = $app->request->post();
	$ScreenHeight=$allPostVars['ScreenHeight'];
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("Delete From nkvlocation 
            WHERE ScreenHeight = :ScreenHeight");
 
        $sth->bindParam(':ScreenHeight', $ScreenHeight);
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