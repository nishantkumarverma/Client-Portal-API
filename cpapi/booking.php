<?php 
$app->get('/booking/getbyid/:id', function ($id) {
 
    $app = \Slim\Slim::getInstance();
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("SELECT * 
            FROM nkvbooking
            WHERE BookingID = :id");
 
        $sth->bindParam(':id', $id);
        $sth->execute();
 
        $booking = $sth->fetchAll(PDO::FETCH_OBJ);
 
        if($booking) {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($booking);
            $db = null;
        } else {
            throw new PDOException('No records found.');
        }
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/booking/getbycustomer/:id', function ($id) {
 
    $app = \Slim\Slim::getInstance();
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("SELECT * 
            FROM bookingview
            WHERE CustomerID = :id order by BookedDate desc");
 
        $sth->bindParam(':id', $id);
        $sth->execute();
 
        $booking = $sth->fetchAll(PDO::FETCH_OBJ);
 
        if($booking) {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($booking);
            $db = null;
        } else {
            throw new PDOException('No records found.');
        }
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->get('/booking/get(/)', function () {
 
    $app = \Slim\Slim::getInstance();
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("SELECT * 
            FROM bookingview order by BookedDate desc
            ");
 
        $sth->execute();
 
        $booking = $sth->fetchAll(PDO::FETCH_OBJ);
 
        if($booking) {
            $app->response->setStatus(200);
            $app->response()->headers->set('Content-Type', 'application/json');
            echo json_encode($booking);
            $db = null;
        } else {
            throw new PDOException('No records found.');
        }
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
});

$app->post('/booking/add(/)', function() use($app) {
 
    $allPostVars = $app->request->post();
    $CustomerID = $allPostVars['CustomerID'];
	$LocationID = $allPostVars['LocationID'];
	$TotalPrice = $allPostVars['TotalPrice'];
	$TotalSeconds = $allPostVars['TotalSeconds'];
	$CouponCodeID = $allPostVars['CouponCodeID'];
	$TaxID = $allPostVars['TaxID'];
	$SubTotal=$allPostVars['SubTotal'];
	$IsPaid=$allPostVars['IsPaid'];
	$IsApproved=0;//$allPostVars['IsApproved'];
	$PaymentMethodID=$allPostVars['PaymentMethodID'];
	$ContentType= $allPostVars['ContentType'];
	$UploadedContentURL=$allPostVars['UploadedContentURL'];
	$BookingCode=$allPostVars['BookingCode'];
	$PublicKey=md5(GUID());
	$Comments=$allPostVars['Comments'];
	$TimeSlotID=$allPostVars['TimeSlotID'];
	$PriceID=$allPostVars['PriceID'];
    
	try 
    {
        $db = getDB();
 
        $sth = $db->prepare("INSERT INTO nkvbooking (CustomerID,SubTotal,TimeSlotID,PriceID,LocationID,TotalPrice,TotalSeconds,CouponCodeID,TaxID,IsPaid,
		IsApproved,PaymentMethodID,UploadedContentURL,BookingCode,Comments,ContentType,PublicKey)
            VALUES (:CustomerID,:SubTotal,:TimeSlotID,:PriceID,:LocationID,:TotalPrice,:TotalSeconds,:CouponCodeID,:TaxID,:IsPaid,
		:IsApproved,:PaymentMethodID,:UploadedContentURL,:BookingCode,:Comments,:ContentType,:PublicKey)");
 
        $sth->bindParam(':CustomerID', $CustomerID);
		$sth->bindParam(':SubTotal', $SubTotal);
		$sth->bindParam(':TimeSlotID', $TimeSlotID);
		$sth->bindParam(':PriceID', $PriceID);
		$sth->bindParam(':LocationID', $LocationID);
		$sth->bindParam(':TotalPrice', $TotalPrice);
		$sth->bindParam(':TotalSeconds', $TotalSeconds);
		$sth->bindParam(':CouponCodeID', $CouponCodeID);
		$sth->bindParam(':TaxID', $TaxID);
		$sth->bindParam(':IsPaid', $IsPaid);
		$sth->bindParam(':IsApproved', $IsApproved);
		$sth->bindParam(':PaymentMethodID', $PaymentMethodID);
		$sth->bindParam(':UploadedContentURL', $UploadedContentURL);
		$sth->bindParam(':BookingCode', $BookingCode);
        $sth->bindParam(':Comments', $Comments);
		$sth->bindParam(':ContentType', $ContentType);
		$sth->bindParam(':PublicKey', $PublicKey);
		
		$sth->execute();
		$lastInsertId = $db->lastInsertId();
        $app->response->setStatus(200);
        $app->response()->headers->set('Content-Type', 'application/json');
        echo json_encode(array("status" => "success", "code" => 1,"id"=>$lastInsertId));
        $db = null;
 
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
 
});

$app->post('/booking/update(/)', function() use($app) {
 
    $allPostVars = $app->request->post();
	$BookingID=$allPostVars['BookingID'];
	$CustomerID = $allPostVars['CustomerID'];
	$LocationID = $allPostVars['LocationID'];
	$TotalPrice = $allPostVars['TotalPrice'];
	$TotalSeconds = $allPostVars['TotalSeconds'];
	$CouponCodeID = $allPostVars['bookingCouponCodeID'];
	$TaxID = $allPostVars['TaxID'];
	$BookedDate=$allPostVars['BookedDate'];
	$IsPaid=$allPostVars['IsPaid'];
	$IsApproved=$allPostVars['IsApproved'];
	$PaymentMethodID=$allPostVars['PaymentMethodID'];
	$UploadedContentURL=$allPostVars['UploadedContentURL'];
	$BookingCode=$allPostVars['BookingCode'];
	$PublicKey=$allPostVars['PublicKey'];
	$Comments=$allPostVars['Comments'];
	
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("UPDATE nkvbooking 
            SET CustomerID=:CustomerID, LocationID=:LocationID, TotalPrice=:TotalPrice, TotalSeconds=:TotalSeconds, 
			bookingCouponCodeID=:bookingCouponCodeID, TaxID=:TaxID, BookedDate=:BookedDate, IsPaid=:IsPaid, IsApproved=:IsApproved, 
			PaymentMethodID=:PaymentMethodID, UploadedContentURL=:UploadedContentURL, BookingCode=:BookingCode, PublicKey=:PublicKey, Comments=:Comments
            WHERE BookingID = :BookingID");
 
        $sth->bindParam(':BookingID', $BookingID);
		$sth->bindParam(':CustomerID', $CustomerID);
		$sth->bindParam(':LocationID', $LocationID);
		$sth->bindParam(':TotalPrice', $TotalPrice);
		$sth->bindParam(':TotalSeconds', $TotalSeconds);
		$sth->bindParam(':bookingCouponCodeID', $CouponCodeID);
		$sth->bindParam(':TaxID', $TaxID);
		$sth->bindParam(':BookedDate', $BookedDate);
		$sth->bindParam(':IsPaid', $IsPaid);
		$sth->bindParam(':IsApproved', $IsApproved);
		$sth->bindParam(':PaymentMethodID', $PaymentMethodID);
		$sth->bindParam(':UploadedContentURL', $UploadedContentURL);
		$sth->bindParam(':BookingCode', $BookingCode);
		$sth->bindParam(':PublicKey', $PublicKey);
        $sth->bindParam(':Comments', $Comments);
		
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

$app->post('/booking/delete(/)', function() use($app) {
 
    $allPostVars = $app->request->post();
	$BookingID=$allPostVars['BookingID'];
 
    try 
    {
        $db = getDB();
 
        $sth = $db->prepare("Delete From nkvbooking 
            WHERE BookingID = :BookingID");
 
        $sth->bindParam(':BookingID', $BookingID);
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

$app->post('/booking/images/upload(/)', function () {
 
  try 
    {
	$app = \Slim\Slim::getInstance();
	 $db = getDB();
	$allPostVars = $app->request->post();
	$BookingID = $allPostVars['BookingID'];
	$output_dir = "public/images/";
	if (!is_dir($output_dir)) {
	mkdir($output_dir, 0777, true);       
	}
	$firstImage="";
	 if (isset($_FILES['iPhoto'])) {
	 $imgDesc1 = $allPostVars['iPhoto'];
	$ImageName= str_replace(' ','-',strtolower($_FILES["iPhoto"]['name']));        
    $ImageExt= substr($ImageName, strrpos($ImageName, '.'));
    $ImageExt= str_replace('.','',$ImageExt);
	$name = md5('img-'.mt_rand_str(3, 'TUVWXYZ256ABCDEFGH34IJKLMN789OPQR01S').date('Ymd').'').'.'.$ImageExt ;
	 if (move_uploaded_file($_FILES["iPhoto"]["tmp_name"], $output_dir .$name) === true) {
	$firstImage= $output_dir .$name;
	$spl = $db->prepare("Update nkvbooking set UploadedContentURL=:UploadedContentURL Where BookingID=:BookingID");
	$spl->bindParam(':UploadedContentURL', $firstImage);
    $spl->bindParam(':BookingID', $BookingID);
	$spl->execute();
	 $app->response->setStatus(200);
        $app->response()->headers->set('Content-Type', 'application/json');
        echo json_encode(array("status" => "success",  "bid" => $BookingID, "url" => $output_dir . $name));
        $db = null;
    }
	}
    } catch(PDOException $e) {
        $app->response()->setStatus(404);
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
	
});
function GUID()
{
    if (function_exists('com_create_guid') === true)
    {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}

?>