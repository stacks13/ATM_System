<?php
include_once "include/DB.php";
if(!isset($_COOKIE['details'])){
    header("Location: index.php");
}
if(isset($_POST['submit'])){
    $details = explode("|", base64_decode($_COOKIE['details']));
    $atm_no = 1;
    $amount = $_POST['amount'];
    if($details[2]=='Withdraw') {
        $stmt = $conn->prepare("CALL withdraw($amount, $details[1], $atm_no, $details[0], @status);");
        if($stmt->execute()){
            $result = $conn->query('SELECT @status');
            $status = $result->fetch_assoc()['@status'];
//            die("Status" . $status);
            if($status == 0) {
                header("Location: withdrawal_successful.php");
            }
        }else{
            die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>put amt</title>
	<link rel="stylesheet" type="text/css" href="css/page2.css">
</head>
<body>
	<div class = "box">
		<h1>enter amount ₹₹₹</h1>
		<div id="succ1">
            <form method="post">
                <input type="number" name="amount" value="₹">
                <input type="submit" name="submit" value="ENTER">
            </form>
		</div>
	</div>
</body>
</html>