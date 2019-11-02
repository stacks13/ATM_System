<?php
if(!isset($_COOKIE['details'])){
    header('HTTP/1.0 403 Forbidden');
    die();
}else {
    include_once "include/DB.php";
    $details = explode("|", base64_decode($_COOKIE['details']), 3);
    print_r($details);
    $success = -1;
    if (isset($_POST['action'])) {
        if($_POST['action'] == 'change_pin'){
            $pin = $_POST['pin'];
            $update = "UPDATE card_details SET pin=$pin WHERE card_no = $details[0]";
            $stmt = $conn->prepare($update);
            if($stmt->execute()){
                header("Location: pin_changed_successfully.php");
            }else{
                $success = -2;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>change pin</title>
	<link rel="stylesheet" type="text/css" href="css/page2.css">
</head>
<body>

	<div class = "box">
		<h1>Change pin</h1>	
		<h2 style="color: #face20">X X X X</h2>
        <form method="POST">
		<input type="password" pattern="[0-9]{4}" name="pin">

        <?php
            if ($success==-2){
                echo "<p>Error changing your pin</p>";
            }
        ?>

		<input type="submit" name="action" value="change_pin">
        </form>
	</div>

</body>
</html>