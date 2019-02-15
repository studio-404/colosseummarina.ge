<?php 
if(isset($_POST['label']) && isset($_POST['value'])){
	//$recieverEmail = "v.apkhazava@gmail.com";
	$recieverEmail = "giorgigvazava87@gmail.com";
	$decodeLabel = json_decode($_POST['label'], true);
	$decodeValue = json_decode($_POST['value'], true);
	
	require_once "_plugins/PHPMailer/PHPMailerAutoload.php"; 
	$out = array();;	
	$mail = new PHPMailer;
	//$mail->SMTPDebug = 3; 
	$mail->isSMTP(); 
	$mail->CharSet = 'UTF-8';
	$mail->Host = "mail.colosseummarina.ge";
	$mail->SMTPAuth = true;
	$mail->Username = "book@colosseummarina.ge";
	$mail->Password = "LX9qK847FB";
	$mail->SMTPSecure = 'tls';
	$mail->Port = 587;
	
	$mail->setFrom("book@colosseummarina.ge", "Colosseummarina.Ge");
	$mail->addAddress($recieverEmail); 
	$mail->addReplyTo("book@colosseummarina.ge");
	// $mail->addCC('cc@example.com');
	// $mail->addBCC('bcc@example.com');
	// $mail->addAttachment('/var/tmp/file.tar.gz');         
	// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');   
	$mail->isHTML(true);                                  

	$mail->Subject = "Colosseummarina";
	$body = "";
	
	for($x=0; $x<=count($decodeLabel); $x++)
	{
		$body .= "<strong>".$decodeLabel[$x]."</strong>: ".$decodeValue[$x]."<br />";
		if($decodeLabel[$x]=="email address" && !filter_var($decodeValue[$x], FILTER_VALIDATE_EMAIL)){
			$out = array(
				"Error"=>"Email format is not right !",
				"Success"=>"0"
			);
			echo json_encode($out);
			exit();
		}
	}
	
	$mail->Body = $body;
	// $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
	if(!$mail->send()) {
	    $out = array(
			"Error"=>"Error !",
			"Success"=>"0"
		);
	} else {
	    $out = array(
			"Error"=>"0",
			"Success"=>"Sent !"
		);
	}
	echo json_encode($out);
}
?>