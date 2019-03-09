<?php

function won_set($a, $b) {
    return ($a == 6 && $b <= 4) || ($a == 7 && ($b == 5 || $b == 6));
}

$HT = array(0, 0, 0, 0);
$AT = array(0, 0, 0, 0);
$HRT = $ART = 0;

for ($i = 1; $i <= 3; $i++) {
    for ($j = 1; $j <= 3; $j++) {
        $H = $_POST['H'.(3*$i+$j-3)];
        $A = $_POST['A'.(3*$i+$j-3)];
        $HS = won_set($H, $A);
        $AS = won_set($A, $H);
        $HT[$i] += $HS;
        $AT[$j] += $AS;
        $HRT += $HS;
        $ART += $AS;
    }
}

if (isset($_POST['submit'])){
	$to = 'roy.caswell1@ntlworld.com';
	$subject = 'Mens Match Card Results';
	$message = 'Home team: '.$_POST['HT'];
	$message .= '  Away team: '.$_POST['AT']."\r\n\r\n";
	$message .= 'Home Players: '.$_POST['HP1'];
	$message .= ', '.$_POST['HP2'];
	$message .= ', '.$_POST['HP3'];
	$message .= ', '.$_POST['HP4'];
	$message .= ', '.$_POST['HP5'];
	$message .= ', '.$_POST['HP6']."\r\n\r\n";
	$message .= 'Away Players: '.$_POST['AP1'];
	$message .= ', '.$_POST['AP2'];
	$message .= ', '.$_POST['AP3'];
	$message .= ', '.$_POST['AP4'];
	$message .= ', '.$_POST['AP5'];
	$message .= ', '.$_POST['AP6']."\r\n\r\n";
	$message .= 'Home and Away Sub Totals 1:  '.$HT[1].' '.$AT[1]."\r\n\r\n";
	$message .= 'Home and Away Sub Totals 2:  '.$HT[2].' '.$AT[2]."\r\n\r\n";
	$message .= 'Home and away Sub Totals 3:  '.$HT[3].' '.$AT[3]."\r\n\r\n";
	$message .= 'Home Total: '.$HRT.'  Away Total: '.$ART."\r\n\r\n";
	$message .= 'Remarks: '.$_POST['remarks']."\r\n\r\n";
	$message .= 'Completed by '.$_POST['Name']."\r\n\r\n";
	$message .= 'Tel. '.$_POST['Tel']."\r\n\r\n";
	
	$success = mail($to, $subject, $message, $headers);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>acknowlede</title>
</head>

<body>
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

$values = [$_POST['HT'],
           $_POST['AT'],
           $_POST['Week'],
           $_POST['Division'],
           $_POST['HP1'],
           $_POST['HP2'],
           $_POST['HP3'],
           $_POST['HP4'],
           $_POST['HP5'],
           $_POST['HP6'],
           $_POST['AP1'],
           $_POST['AP2'],
           $_POST['AP3'],
           $_POST['AP4'],
           $_POST['AP5'],
           $_POST['AP6'],
           $_POST['H1'],
           $_POST['H2'],
           $_POST['H3'],
           $_POST['H4'],
           $_POST['H5'],
           $_POST['H6'],
           $_POST['H7'],
           $_POST['H8'],
           $_POST['H9'],
           $_POST['A1'],
           $_POST['A2'],
           $_POST['A3'],
           $_POST['A4'],
           $_POST['A5'],
           $_POST['A6'],
           $_POST['A7'],
           $_POST['A8'],
           $_POST['A9'],
           $HT[1], $HT[2], $HT[3],
           $AT[1], $AT[2], $AT[3],
           $HRT, $ART,
           $_POST['Name'],
           $_POST['Tel']];

$sql = "INSERT INTO MensMatchCard2 (HT, AT, Week, Division, HP1, HP2, HP3, HP4, HP5, HP6, AP1, AP2, AP3, AP4, AP5, AP6, H1, H2, H3, H4, H5, H6, H7, H8, H9, A1, A2, A3, A4, A5, A6, A7, A8, A9, HT1, HT2, HT3, AT1, AT2, AT3, HRT, ART, Name, Tel)
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
