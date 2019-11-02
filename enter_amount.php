<?php
include_once "include/DB.php";
if(!isset($_COOKIE['details'])){
    header("Location: index.php");
}
if(isset($_POST['enter_amount'])){
    $details = explode("|", base64_decode($_COOKIE['details']));
    $amount = $_POST['amount'];
    if(isset($_POST['unsuccessful'])){
        $details[2] = 'Deposit';
    }
    if($details[2]=='Withdraw') {
        $stmt = $conn->prepare("CALL withdraw($amount, $details[1], $atm_no, $details[0], @status, 'ATM-WITHDRAWAL');");
        if($stmt->execute()){
            $result = $conn->query('SELECT @status');
            $status = $result->fetch_assoc()['@status'];
            if($status == 0) {
                header("Location: withdrawal_successful.php");

                setcookie("details", base64_encode("$details[0]|$details[1]|$details[2]|$amount"), time() + 100, "/");
            }else if($status == -2){
                header("Location: balance_insufficient.php");
            }else if($status == -3){
                header("Location: withdrawal_limit.php");
            }else if($status == -4){
                header("Location: cash_insufficient.php");
            }else{
                die($status);
            }
        }else{
            die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }
    }else if($details[2]=='Deposit'){
        $stmt = $conn->prepare("CALL deposit($details[0], $details[1], $amount, $atm_no, @status, 'ATM-DEPOSIT');");
        if($stmt->execute()){
            $result = $conn->query('SELECT @status');
            $status = $result->fetch_assoc()['@status'];
            if(isset($_POST['unsuccessful'])){
                header("Location: transaction_unsuccessful.php");
            }else if($status == 0) {
                header("Location: deposit_successful.php");
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
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
	<div class = "box">
		<h1>enter amount ₹₹₹</h1>
		<div id="succ1">
            <form method="post">

                <script>
                    function check() {
                        var frm = document.forms[0];

                        frm.amount.value = frm.amount.value.replace(/[e\+\-]/gi, "");
                        console.log(frm.amount.value);
                        if(parseInt(frm.amount.value) % 100 == 0){
                            frm.enter_amount.disabled = false;
                            // frm.submit();
                        }else{
                            // alert("INVALID AMOUNT");
                            // frm.reset();
                            frm.enter_amount.disabled = true;
                        }
                    }


                </script>
                <input type="number" name="amount" onkeyup="check()" pattern="[1-9][0-9]*00" placeholder="₹">
<!--                <input type="submit" name="submit" value="ENTER" onclick="check()">-->
                <input type="submit" name="enter_amount" disabled value="ENTER">
                <p style='color: red' id="errormsg">Amount should be a multiple of ₹100/-</p>
            </form>
		</div>
	</div>
</body>
</html>