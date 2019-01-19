<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-39169788-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-39169788-1');
</script>
<title>Afternoon League Match Cards</title>
<style type="text/css">
td {
    text-align: center; 
    background-color: #b3ffd9;
}
</style>
<body>
<?php

function get_mixed($row, $def) {
    for ($i = 1; $i <= 2; $i++)
        $pairs[] = $row[$def.'M'.$i] . ' & ' . $row[$def.'F'.$i];
    return $pairs;
}

function get_pair($row, $def) {
    return $row[$def.'1'] . ' & ' . $row[$def.'2'];
}

function write_row($HP, $HS, $AS, $AP) {

    echo "<tr>\n";
    echo "<td>$HP</td>\n";
    echo "<td colspan=\"2\">$HS</td>\n";
    echo "<td colspan=\"2\">$AS</td>\n";
    echo "<td colspan=\"2\">$AP</td>\n";
    echo "</tr>\n";
    
}

function write_card($row) {

    $HXP = get_mixed($row, 'H');
    $AXP = get_mixed($row, 'A');
    $HFP = get_pair($row, 'HF');
    $HMP = get_pair($row, 'HM');
    $AFP = get_pair($row, 'AF');
    $AMP = get_pair($row, 'AM');

    echo '<table width="720" border="2">'."\n";

    echo '<tr>'."\n";
    echo '<td width="300" style="text-align: left">&nbsp;Junior Card</td>'."\n";
    echo '<td width="30">Week:</td>'."\n";
    echo '<td width="30">'.$row['Week'].'</td>'."\n";
    echo '<td width="30">Div:</td>'."\n";
    echo '<td width="30">'.$row['Division'].'</td>'."\n";
    echo '<td width="150">Date:</td>'."\n";
    echo '<td width="150">NO DATE :(</td>'."\n";
    echo '</tr>'."\n";

    echo '<tr>'."\n";
    echo '<td>'.$row['HT'].'</td>'."\n";
    echo '<td colspan="4">v</td>'."\n";
    echo '<td colspan="2">'.$row['AT'].'</td>'."\n";
    echo '</tr>'."\n";

    // Mixed
    write_row($HXP[0], $row['H1'], $row['A1'], $AXP[0]);
    write_row($HXP[1], $row['H2'], $row['A2'], $AXP[1]);
    write_row($HXP[0], $row['H3'], $row['A3'], $AXP[1]);
    write_row($HXP[1], $row['H4'], $row['A4'], $AXP[0]);

    // Ladies
    write_row($HFP, $row['H5'], $row['A5'], $AFP);

    // Mens
    write_row($HMP, $row['H6'], $row['A6'], $AMP);

    // Total
    write_row('Total:', $row['HRT'], $row['ART'], '');

    echo "</table><br><br>\n";
}

require('config.php');

// Create connection
try {
    $conn = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

$sql = 'SELECT * FROM AfternoonMatchCard ORDER BY Week desc, Division';
$result = $conn->query($sql);

foreach ($result as $row)
    write_card($row);

?>
</body>
</html>
