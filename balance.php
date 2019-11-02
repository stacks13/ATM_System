<?php
    include_once "include/DB.php";
    $amount = 0;
    $details = explode("|", base64_decode($_COOKIE['details']));
    if($details[2]=='Check Balance') {
        $result = $conn->query("SELECT * FROM accounts WHERE account_no=$details[1]");
        $data = $result->fetch_assoc();
        $amount = $data['balance'];
    }else if($details[2]=='Deposit'){

    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>balance</title>
	<link rel="stylesheet" type="text/css" href="css/page2.css">
</head>
<body>
	<div class = "box">
		<h1>current balance</h1>	
		<marquee id="m2" behavior="scroll" direction="down" scrollamount="10" >$ $ $ $</marquee>
        <h1> ₹<?php echo $amount;?>/- </h1>
		<marquee id="m2" behavior="scroll" direction="up" scrollamount="10" >$ $ $ $</marquee>
		<input type="submit" name="" value="Exit">
	</div>

    <script>
        setTimeout(function () {
            location.href = 'index.php';
        }, 3000);
    </script>

</body>
</html>