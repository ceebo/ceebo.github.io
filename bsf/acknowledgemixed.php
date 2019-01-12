
<?php
$HRT = $ART = 0;

for ($i = 1; $i <= 12; $i++) {
    $HRT += $_POST['H'.$i];
    $ART += $_POST['A'.$i];
}

if (isset($_POST['submit'])){
	$to = 'roy.caswell1@ntlworld.com';
	$subject = 'Mixed Match Card Results';
	$message .= 'Division: '.$_POST['Division'];
	$message .= 'Week: '.$_POST['Week'];
	$message = 'Home team: '.$_POST['HT'];
	$message .= '  Away team: '.$_POST['AT']."\r\n\r\n";
	$message .= 'Home Players: '.$_POST['HF1'];
	$message .= ', '.$_POST['HM1'];
	$message .= ', '.$_POST['HF2'];
	$message .= ', '.$_POST['HM2'];
	$message .= ', '.$_POST['HF3'];
	$message .= ', '.$_POST['HM3'];
	$message .= ', '.$_POST['HF4'];
	$message .= ', '.$_POST['HM4']."\r\n\r\n";
	$message .= 'Away Players: '.$_POST['AL1'];
	$message .= ', '.$_POST['AM1'];
	$message .= ', '.$_POST['AF2'];
	$message .= ', '.$_POST['AM2'];
	$message .= ', '.$_POST['AF3'];
	$message .= ', '.$_POST['AM3'];
	$message .= ', '.$_POST['AF4'];
	$message .= ', '.$_POST['AM4']."\r\n\r\n";
	$message .= 'Home Total: '.$_POST['HRT'];
	$message .= '  Away Total: '.$_POST['ART']."\r\n\r\n";
	$message .= 'Remarks: '.$_POST['remarks']."\r\n\r\n";
	$message .= 'Completed by '.$_POST['Name']."\r\n\r\n";
	$message .= 'Tel. '.$_POST['Tel']."\r\n\r\n";
	
	$success = mail($to, $subject,$message, $headers);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>acknowledemixed</title>
</head>

<body
<?php if (isset($success) && $success){ ?>
<h1>Thank You</h1>
<p>Your results have been submitted</p>
<?php }else{ ?>
<h1>Oops!</h1>
<p>There was a problem sending the form results</p>
<?php  } ?>

<?php
include("config.php");

// Create connection
try {
    $conn = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

$values= [$_POST['Division'],
          $_POST['Week'],
          $_POST['HT'],
          $_POST['AT'],
          $_POST['HF1'],
          $_POST['HM1'],
          $_POST['HF2'],
          $_POST['HM2'],
          $_POST['HF3'],
          $_POST['HM3'],
          $_POST['HF4'],
          $_POST['HM4'],
          $_POST['AF1'],
          $_POST['AM1'],
          $_POST['AF2'],
          $_POST['AM2'],
          $_POST['AF3'],
          $_POST['AM3'],
          $_POST['AF4'],
          $_POST['AM4'],
          $_POST['HFC'],
          $_POST['HMC'],
          $_POST['AFC'],
          $_POST['AMC'],
          $_POST['H1'],
          $_POST['A1'],
          $_POST['H2'],
          $_POST['A2'],
          $_POST['H3'],
          $_POST['A3'],
          $_POST['H4'],
          $_POST['A4'],
          $_POST['H5'],
          $_POST['A5'],
          $_POST['H6'],
          $_POST['A6'],
          $_POST['H7'],
          $_POST['A7'],
          $_POST['H8'],
          $_POST['A8'],
          $_POST['H9'],
          $_POST['A9'],
          $_POST['H10'],
          $_POST['A10'],
          $_POST['H11'],
          $_POST['A11'],
          $_POST['H12'],
          $_POST['A12'],
          $HRT, $ART];
		 
$sql = "INSERT INTO MixedMatchCard2 (Division, Week, HT, AT, HF1, HM1, HF2, HM2, HF3, HM3, HF4, HM4, AF1, AM1, AF2, AM2, AF3, AM3, AF4, AM4, HFC, HMC, AFC, AMC, H1, A1, H2, A2, H3, A3, H4, A4, H5, A5, H6, A6, H7, A7, H8, A8, H9, A9, H10, A10, H11, A11, H12, A12, HRT, ART)
VALUES (?" . str_repeat(",?", count($values)-1) . ")";

if ($conn->prepare($sql)->execute($values)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . print_r($values) . "<br>" . print_r($conn->errorInfo());
}

// Close connection by destroying PDO object
$conn = null;
?> 
</body>
</html>
