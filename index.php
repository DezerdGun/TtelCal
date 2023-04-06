<?php


use Kreait\Firebase\Factory;

require __DIR__.'/vendor/autoload.php';
session_start();

$factory = (new Factory)
    ->withServiceAccount('turon-fde91-firebase-adminsdk-2c0ld-893ea9db91.json')
    ->withDatabaseUri('https://turon-fde91-default-rtdb.firebaseio.com/');
$database = $factory->createDatabase();
$reference = $database->getReference('firebase');
echo $reference->getValue();
//$con = mysqli_connect("localhost","root","","cal");
//
//if(!$con){
//    echo "No Connection";
//}
//AIzaSyBfksgEB9T3QNRmYOxe_NzTsW5Lg7kJjOA
if(isset($_POST['firebase'])) {
    $stored = $_POST['stored'];
//    $reg = mysqli_query($con, "INSERT INTO `cal` (`stored`) VALUES ('$stored')");
    $postData = [
            'stored' => $stored,
    ];
    $ref_table = 'firebase';
    $postRef = $database->getReference($ref_table)->push($postData);

    if($postData){
        $_SESSION['status'] = "Turon your calculate is saved";
    }else{
        $_SESSION['status'] = "Turon your calculate isn't saved";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    <title>Calculate for Turon Telecom test</title>
</head>
<body>
<?php

$buttons = [1, 2, 3, '+', 4, 5, 6, '-', 7, 8, 9, '*', 'C', 0, '.', '/', '='];
$pressed = '';
if (isset($_POST['pressed']) && in_array($_POST['pressed'], $buttons)) {
    $pressed = $_POST['pressed'];
}
$stored = '';
if (isset($_POST['stored']) && preg_match('~^(?:[\d.]+[*/+-]?)+$~', $_POST['stored'], $out)) {
    $stored = $out[0];
}
$display = $stored . $pressed;
if ($pressed == 'C') {
    $display = '';
} elseif ($pressed == '=' && preg_match('~^\d*\.?\d+(?:[*/+-]\d*\.?\d+)*$~', $stored)) {
    $display .= eval("return $stored;");
}

echo "<form action=\"\" method=\"POST\">";
echo "<table style=\"width:300px;border:solid thick black;\">";
echo "<tr>";
echo "<td colspan=\"4\">$display</td>";
echo "</tr>";
foreach (array_chunk($buttons, 4) as $chunk) {
    echo "<tr>";
    foreach ($chunk as $button) {
        echo "<td", (count($chunk) != 4 ? " colspan=\"4\"" : ""), ">
<button name=\"pressed\" value=\"$button\">$button</button>
</td>";
    }
    echo "</tr>";
}
echo "</table>";
echo "<input type=\"hidden\" name=\"stored\" value=\"$display\">";
echo "<input type=\"hidden\" name=\"stored\" value=\"$display\">";
echo "<input type=\"submit\" name=\"firebase\" value='Save into Firebase All' >";
echo "</form>";
?>
</body>
</html>