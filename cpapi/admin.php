<?php 
$app->get('/admin/getbyid/:id', function ($id) {
 
    $app = \Slim\Slim::getInstance();
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("SELECT *,r.AdminRoleName
            FROM nkvadmin a, nkvadminrole r where r.AdminRoleID=a.RoleID and a.AdminID = :id");
 
        $sth->bindParam(':id', $id);
        $sth->execute();
 
        $admin = $sth->fetchAll(PDO::FETCH_OBJ);
 
        if($admin) {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($admin);
            $db = null;
        } else {
            throw new PDOException('No records found.');
        }
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/admin/get(/)', function () {
 
    $app = \Slim\Slim::getInstance();
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("SELECT *,r.AdminRoleName
            FROM nkvadmin a, nkvadminrole r where r.AdminRoleID=a.RoleID
            ");
 
        $sth->execute();
 
        $admin = $sth->fetchAll(PDO::FETCH_OBJ);
 
        if($admin) {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($admin);
            $db = null;
        } else {
            throw new PDOException('No records found.');
        }
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});
$app->post('/admin/validate(/)', function() use($app) {
 
    $allPostVars = $app->request->post();
	$AdminEmail = $allPostVars['AdminEmail'];
	$AdminPassword = $allPostVars['AdminPassword'];
	$AdminPassword = md5($AdminPassword );
    
	try 
    {
        $db = getDB();
 
        $sth = $db->prepare("select * from nkvadmin WHERE AdminEmail=:AdminEmail and AdminPassword=:AdminPassword");
 
		$sth->bindParam(':AdminEmail', $AdminEmail);
		$sth->bindParam(':AdminPassword', $AdminPassword);
        $sth->execute();
 
        $admin = $sth->fetchAll(PDO::FETCH_OBJ);
 
        if($admin) {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($admin);
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
$app->post('/admin/add(/)', function() use($app) {
 
    $allPostVars = $app->request->post();
    $AdminName = $allPostVars['AdminName'];
	$AdminEmail = $allPostVars['AdminEmail'];
	$AdminPassword = md5($allPostVars['AdminPassword']);
	$RoleID = $allPostVars['RoleID'];
	$AdminProfilePic = "";
    
	try 
    {
        $db = getDB();
		$sth = $db->prepare("select * from nkvadmin WHERE AdminEmail=:AdminEmail");
 
		$sth->bindParam(':AdminEmail', $AdminEmail);
		//$sth->bindParam(':AdminPassword', $AdminPassword);
        $sth->execute();
 
        $admin = $sth->fetchAll(PDO::FETCH_OBJ);
		if($admin) {
				echo json_encode("Email already register");
		}else{
        $sth = $db->prepare("INSERT INTO nkvadmin (AdminName,AdminEmail,AdminPassword,RoleID,AdminProfilePic)
            VALUES (:AdminName,:AdminEmail,:AdminPassword,:RoleID,:AdminProfilePic)");
 
        $sth->bindParam(':AdminName', $AdminName);
		$sth->bindParam(':AdminEmail', $AdminEmail);
		$sth->bindParam(':AdminPassword', $AdminPassword);
		$sth->bindParam(':RoleID', $RoleID);
		$sth->bindParam(':AdminProfilePic', $AdminProfilePic);
		
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

$app->post('/admin/update(/)', function() use($app) {
 
    $allPostVars = $app->request->post();
	$AdminID=$allPostVars['AdminID'];
	$AdminName = $allPostVars['AdminName'];
	$AdminEmail = $allPostVars['AdminEmail'];
	$AdminPassword = $allPostVars['AdminPassword'];
	$RoleID = $allPostVars['RoleID'];
	$AdminCreatedOn = $allPostVars['AdminCreatedOn'];
	$AdminProfilePic = $allPostVars['AdminProfilePic'];
	
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("UPDATE nkvadmin 
            SET AdminName=:AdminName, AdminEmail=:AdminEmail, AdminPasswordword=:AdminPasswordword, RoleID=:RoleID, AdminAdminCreatedOn=:AdminAdminCreatedOn, 
			AdminProfilePic=:AdminProfilePic
            WHERE AdminID = :AdminID");
 
        $sth->bindParam(':AdminID', $AdminID);
		$sth->bindParam(':AdminName', $AdminName);
		$sth->bindParam(':AdminEmail', $AdminEmail);
		$sth->bindParam(':AdminPassword', $AdminPassword);
		$sth->bindParam(':RoleID', $RoleID);
		$sth->bindParam(':AdminCreatedOn', $AdminCreatedOn);
		$sth->bindParam(':AdminProfilePic', $AdminProfilePic);
		
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

$app->post('/admin/delete(/)', function() use($app) {
 
    $allPostVars = $app->request->post();
	$AdminID=$allPostVars['AdminID'];
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("Delete From nkvadmin 
            WHERE AdminID = :AdminID");
 
        $sth->bindParam(':AdminID', $AdminID);
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