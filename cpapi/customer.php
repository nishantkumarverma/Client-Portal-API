<?php 
$app->get('/customer/getbyid/:id', function ($id) {
 
    $app = \Slim\Slim::getInstance();
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("SELECT * 
            FROM nkvcustomer
            WHERE CustomerID = :id");
 
        $sth->bindParam(':id', $id);
        $sth->execute();
 
        $customer = $sth->fetchAll(PDO::FETCH_OBJ);
 
        if($customer) {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($customer);
            $db = null;
        } else {
            throw new PDOException('No records found.');
        }
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/customer/get(/)', function () {
 
    $app = \Slim\Slim::getInstance();
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("SELECT * 
            FROM customerview
            ");
 
        $sth->execute();
 
        $customer = $sth->fetchAll(PDO::FETCH_OBJ);
 
        if($customer) {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($customer);
            $db = null;
        } else {
            throw new PDOException('No records found.');
        }
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});
$app->post('/customer/validate(/)', function() use($app) {
 
    $allPostVars = $app->request->post();
	$CustomerEmail = $allPostVars['CustomerEmail'];
	$CustomerPassword = $allPostVars['CustomerPassword'];
	$CustomerPassword = md5($CustomerPassword );
    
	try 
    {
        $db = getDB();
 
        $sth = $db->prepare("select * from nkvcustomer WHERE CustomerEmail=:CustomerEmail and CustomerPassword=:CustomerPassword");
 
		$sth->bindParam(':CustomerEmail', $CustomerEmail);
		$sth->bindParam(':CustomerPassword', $CustomerPassword);
        $sth->execute();
 
        $customer = $sth->fetchAll(PDO::FETCH_OBJ);
 
        if($customer) {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($customer);
            $db = null;
        } else {
		 $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
			 echo json_encode('No user found.');
          //  throw new PDOException('No user found.');
        }
 
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
 
});
$app->post('/customer/add(/)', function() use($app) {
 
    $allPostVars = $app->request->post();
    $CompanyName = $allPostVars['CompanyName'];
	$CustomerName = $allPostVars['CustomerName'];
	$CustomerEmail = $allPostVars['CustomerEmail'];
	$CustomerPassword = $allPostVars['CustomerPassword'];
	$CustomerPassword = md5($CustomerPassword );
	//$CustomerCreatedOn = $allPostVars['CustomerCreatedOn'];
	//$CustomerLastLogin = $allPostVars['CustomerLastLogin'];
	$CustomerRoleID =1; //$allPostVars['CustomerRoleID'];
	$CustomerCompanyID =1; //$allPostVars['CustomerCompanyID'];
	$CustomerProfilePic =""; //$allPostVars['CustomerProfilePic'];
    
	try 
    {
        $db = getDB();
		$sth = $db->prepare("select * from nkvcustomer WHERE CustomerEmail=:CustomerEmail");
 
		$sth->bindParam(':CustomerEmail', $CustomerEmail);
		//$sth->bindParam(':AdminPassword', $AdminPassword);
        $sth->execute();
 
        $customer = $sth->fetchAll(PDO::FETCH_OBJ);
		if($customer) {echo json_encode("Email already register");
		}else{
		$sth = $db->prepare("INSERT INTO nkvcustomercompany (CompanyName) VALUES (:CompanyName)");
		$sth->bindParam(':CompanyName', $CompanyName);
		$sth->execute();
		$CustomerCompanyID = $db->lastInsertId();
		
        $sth = $db->prepare("INSERT INTO nkvcustomer (CustomerName,CustomerEmail,CustomerPassword,
		CustomerRoleID,CustomerCompanyID,CustomerProfilePic)
            VALUES (:CustomerName,:CustomerEmail,:CustomerPassword,:CustomerRoleID,:CustomerCompanyID,:CustomerProfilePic)");
 
        $sth->bindParam(':CustomerName', $CustomerName);
		$sth->bindParam(':CustomerEmail', $CustomerEmail);
		$sth->bindParam(':CustomerPassword', $CustomerPassword);
		$sth->bindParam(':CustomerRoleID', $CustomerRoleID);
		//$sth->bindParam(':CustomerCreatedOn', $CustomerCreatedOn);
		$sth->bindParam(':CustomerCompanyID', $CustomerCompanyID);
		//$sth->bindParam(':CustomerLastLogin', $CustomerLastLogin);
		$sth->bindParam(':CustomerProfilePic', $CustomerProfilePic);
		
        $sth->execute();
 
        $app->response->setStatus(200);
        $app->response()->headers->set('Content-Type', 'application/json');
        echo json_encode(array("status" => "success", "code" => 1));
		}
        $db = null;
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
 
});

$app->post('/customer/update(/)', function() use($app) {
 
    $allPostVars = $app->request->post();
	$CustomerID=$allPostVars['CustomerID'];
	$CustomerName = $allPostVars['CustomerName'];
	$CustomerEmail = $allPostVars['CustomerEmail'];
	$CustomerPassword = $allPostVars['CustomerPassword'];
	
	$CustomerRoleID = $allPostVars['CustomerRoleID'];
	$CustomerCompanyID = $allPostVars['CustomerCompanyID'];
	$CustomerProfilePic = $allPostVars['CustomerProfilePic'];
	
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("UPDATE nkvcustomer 
            SET CustomerName=:CustomerName, CustomerEmail=:CustomerEmail, CustomerPassword=:CustomerPassword, 
			CustomerRoleID=:CustomerRoleID, CustomerCompanyID=:CustomerCompanyID, CustomerProfilePic=:CustomerProfilePic
            WHERE CustomerID = :CustomerID");
 
        $sth->bindParam(':CustomerName', $CustomerName);
		$sth->bindParam(':CustomerEmail', $CustomerEmail);
		$sth->bindParam(':CustomerPassword', $CustomerPassword);
		$sth->bindParam(':CustomerRoleID', $CustomerRoleID);
		//$sth->bindParam(':CustomerCreatedOn', $CustomerCreatedOn);
		$sth->bindParam(':CustomerCompanyID', $CustomerCompanyID);
		//$sth->bindParam(':CustomerLastLogin', $CustomerLastLogin);
		$sth->bindParam(':CustomerProfilePic', $CustomerProfilePic);
		
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

$app->post('/customer/delete(/)', function() use($app) {
 
    $allPostVars = $app->request->post();
	$CustomerID=$allPostVars['CustomerID'];
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("Delete From nkvcustomer 
            WHERE CustomerID = :CustomerID");
 
        $sth->bindParam(':CustomerID', $CustomerID);
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