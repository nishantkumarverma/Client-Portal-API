<?php 
$app->get('/coupon/getbyid/:id', function ($id) {
 
    $app = \Slim\Slim::getInstance();
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("SELECT * 
            FROM nkvcoupon
            WHERE CouponID = :id");
 
        $sth->bindParam(':id', $id);
        $sth->execute();
 
        $coupon = $sth->fetch(PDO::FETCH_OBJ);
 
        if($coupon) {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($coupon);
            $db = null;
        } else {
            throw new PDOException('No records found.');
        }
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/coupon/get/', function () {
 
    $app = \Slim\Slim::getInstance();
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("SELECT * 
            FROM nkvcoupon
            ");
 
        $sth->execute();
 
        $coupon = $sth->fetch(PDO::FETCH_OBJ);
 
        if($coupon) {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($coupon);
            $db = null;
        } else {
            throw new PDOException('No records found.');
        }
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->post('/coupon/add/', function() use($app) {
 
    $allPostVars = $app->request->post();
	
    $CouponPercentage = $allPostVars['CouponPercentage'];
    $CouponName = $allPostVars['CouponName'];
	$CustomerID = $allPostVars['CustomerID'];
    $LocationID = $allPostVars['LocationID'];
	
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("INSERT INTO nkvcoupon (CouponName,CouponPercentage,CustomerID,LocationID)
            VALUES (:CouponName,:CouponPercentage,:CustomerID,:LocationID)");
 
        $sth->bindParam(':CouponPercentage', $CouponPercentage);
        $sth->bindParam(':CouponName', $CouponName);
		$sth->bindParam(':CustomerID', $CustomerID);
        $sth->bindParam(':LocationID', $LocationID);
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

$app->post('/coupon/update/', function() use($app) {
 
    $allPostVars = $app->request->post();
    $CouponPercentage = $allPostVars['CouponPercentage'];
    $CouponName = $allPostVars['CouponName'];
	$CouponID=$allPostVars['CouponID'];
	$CustomerID = $allPostVars['CustomerID'];
    $LocationID = $allPostVars['LocationID'];
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("UPDATE nkvcoupon 
            SET CouponPercentage = :CouponPercentage, CouponName=:CouponName, CustomerID=:CustomerID, LocationID=:LocationID
            WHERE CouponID = :CouponID");
 
        $sth->bindParam(':CouponPercentage', $CouponPercentage);
		$sth->bindParam(':CouponName', $CouponName);
        $sth->bindParam(':CouponID', $CouponID);
		$sth->bindParam(':CustomerID', $CustomerID);
        $sth->bindParam(':LocationID', $LocationID);
		
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

$app->post('/coupon/delete/', function() use($app) {
 
    $allPostVars = $app->request->post();
	$CouponID=$allPostVars['CouponID'];
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("Delete From nkvcoupon 
            WHERE CouponID = :CouponID");
 
        $sth->bindParam(':CouponID', $CouponID);
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