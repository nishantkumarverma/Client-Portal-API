<?php 
$app->get('/timeslot/getbyid/:id', function ($id) {
 
    $app = \Slim\Slim::getInstance();
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("SELECT * 
            FROM nkvtimeslot
            WHERE TimeSlotID = :id");
 
        $sth->bindParam(':id', $id);
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

$app->get('/timeslot/get(/)', function () {
 
    $app = \Slim\Slim::getInstance();
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("SELECT * 
            FROM nkvtimeslot
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

$app->post('/timeslot/add(/)', function() use($app) {
 
    $allPostVars = $app->request->post();
	
    $TimeSlotName = $allPostVars['TimeSlotName'];
	$SlotStartTime = $allPostVars['SlotStartTime'];
	$SlotEndTime = $allPostVars['SlotEndTime'];
	$TimeSlotCreatedBy = $allPostVars['TimeSlotCreatedBy'];
	$TimeSlotDescription = $allPostVars['TimeSlotDescription'];
	$IsAllowedSunday=$allPostVars['IsAllowedSunday'];
	$IsTimeslotActive=$allPostVars['IsTimeslotActive'];
	$IsAllowedSaturday=$allPostVars['IsAllowedSaturday'];
	$IsAllowedMonday=$allPostVars['IsAllowedMonday'];
	$IsAllowedTuesday=$allPostVars['IsAllowedTuesday'];
	$IsAllowedWednesday=$allPostVars['IsAllowedWednesday'];
	$IsAllowedThursday=$allPostVars['IsAllowedThursday'];
	$IsAllowedFriday=$allPostVars['IsAllowedFriday'];
	$DurationInSec=$allPostVars['DurationInSec'];
    
	try 
    {
        $db = getDB();
 
        $sth = $db->prepare("INSERT INTO nkvtimeslot (TimeSlotName,SlotStartTime,SlotEndTime,DurationInSec,TimeSlotCreatedBy,TimeSlotDescription,IsAllowedSunday,IsTimeslotActive,
		IsAllowedSaturday,IsAllowedMonday,IsAllowedTuesday,IsAllowedWednesday,IsAllowedThursday,IsAllowedFriday)
            VALUES (:TimeSlotName,:SlotStartTime,:SlotEndTime,:DurationInSec,:TimeSlotCreatedBy,:TimeSlotDescription,:IsAllowedSunday,:IsTimeslotActive,
		:IsAllowedSaturday,:IsAllowedMonday,:IsAllowedTuesday,:IsAllowedWednesday,:IsAllowedThursday,:IsAllowedFriday)");
 
        $sth->bindParam(':TimeSlotName', $TimeSlotName);
		$sth->bindParam(':SlotStartTime', $SlotStartTime);
		$sth->bindParam(':SlotEndTime', $SlotEndTime);
		$sth->bindParam(':TimeSlotCreatedBy', $TimeSlotCreatedBy);
		$sth->bindParam(':TimeSlotDescription', $TimeSlotDescription);
		$sth->bindParam(':IsAllowedSunday', $IsAllowedSunday);
		$sth->bindParam(':IsTimeslotActive', $IsTimeslotActive);
		$sth->bindParam(':IsAllowedSaturday', $IsAllowedSaturday);
		$sth->bindParam(':IsAllowedMonday', $IsAllowedMonday);
		$sth->bindParam(':IsAllowedTuesday', $IsAllowedTuesday);
		$sth->bindParam(':IsAllowedWednesday', $IsAllowedWednesday);
		$sth->bindParam(':IsAllowedThursday', $IsAllowedThursday);
        $sth->bindParam(':IsAllowedFriday', $IsAllowedFriday);
		$sth->bindParam(':DurationInSec', $DurationInSec);
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

$app->post('/timeslot/update(/)', function() use($app) {
 
    $allPostVars = $app->request->post();
	$TimeSlotID=$allPostVars['TimeSlotID'];
	$TimeSlotName = $allPostVars['TimeSlotName'];
	$SlotStartTime = $allPostVars['SlotStartTime'];
	$SlotEndTime = $allPostVars['SlotEndTime'];
	$TimeSlotCreatedBy = $allPostVars['TimeSlotCreatedBy'];
	$TimeSlotDescription = $allPostVars['TimeSlotDescription'];
	$IsAllowedSunday=$allPostVars['IsAllowedSunday'];
	$IsTimeslotActive=$allPostVars['IsTimeslotActive'];
	$IsAllowedSaturday=$allPostVars['IsAllowedSaturday'];
	$IsAllowedMonday=$allPostVars['IsAllowedMonday'];
	$IsAllowedTuesday=$allPostVars['IsAllowedTuesday'];
	$IsAllowedWednesday=$allPostVars['IsAllowedWednesday'];
	$IsAllowedThursday=$allPostVars['IsAllowedThursday'];
	$IsAllowedFriday=$allPostVars['IsAllowedFriday'];
	$DurationInSec=$allPostVars['DurationInSec'];
	
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("UPDATE nkvtimeslot 
            SET DurationInSec:DurationInSec, TimeSlotName=:TimeSlotName, SlotStartTime=:SlotStartTime, SlotEndTime=:SlotEndTime, 
			TimeSlotCreatedBy=:TimeSlotCreatedBy, TimeSlotDescription=:TimeSlotDescription, IsAllowedSunday=:IsAllowedSunday, IsTimeslotActive=:IsTimeslotActive, IsAllowedSaturday=:IsAllowedSaturday, 
			IsAllowedMonday=:IsAllowedMonday, IsAllowedTuesday=:IsAllowedTuesday, IsAllowedWednesday=:IsAllowedWednesday, IsAllowedThursday=:IsAllowedThursday, IsAllowedFriday=:IsAllowedFriday
            WHERE TimeSlotID = :TimeSlotID");
 
        $sth->bindParam(':TimeSlotID', $TimeSlotID);
		$sth->bindParam(':DurationInSec', $DurationInSec);
		$sth->bindParam(':TimeSlotName', $TimeSlotName);
		$sth->bindParam(':SlotStartTime', $SlotStartTime);
		$sth->bindParam(':SlotEndTime', $SlotEndTime);
		$sth->bindParam(':TimeSlotCreatedBy', $TimeSlotCreatedBy);
		$sth->bindParam(':TimeSlotDescription', $TimeSlotDescription);
		$sth->bindParam(':IsAllowedSunday', $IsAllowedSunday);
		$sth->bindParam(':IsTimeslotActive', $IsTimeslotActive);
		$sth->bindParam(':IsAllowedSaturday', $IsAllowedSaturday);
		$sth->bindParam(':IsAllowedMonday', $IsAllowedMonday);
		$sth->bindParam(':IsAllowedTuesday', $IsAllowedTuesday);
		$sth->bindParam(':IsAllowedWednesday', $IsAllowedWednesday);
		$sth->bindParam(':IsAllowedThursday', $IsAllowedThursday);
        $sth->bindParam(':IsAllowedFriday', $IsAllowedFriday);
		
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

$app->post('/timeslot/delete(/)', function() use($app) {
 
    $allPostVars = $app->request->post();
	$TimeSlotID=$allPostVars['TimeSlotID'];
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("Delete From nkvtimeslot 
            WHERE TimeSlotID = :TimeSlotID");
 
        $sth->bindParam(':TimeSlotID', $TimeSlotID);
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