<?php
include_once "include/DB.php";
if(!isset($_COOKIE['admin'])){
    header("Location: index.php");
}else{
    $cash = 0;
    $result = $conn->query("SELECT * FROM atms WHERE atm_no=$atm_no");
    $data = $result->fetch_assoc();
    $cash = $data['current_cash'];
}
if(isset($_POST['enter_amount'])){
//    $details = explode("|", base64_decode($_COOKIE['details']));

    $amount = $_POST['amount'];
    $admin_id = base64_decode($_COOKIE['admin']);


    $stmt = $conn->prepare("UPDATE atms SET current_cash=current_cash+$amount WHERE atm_no=$atm_no");
    if($stmt->execute()){
        $stmt = $conn->prepare("INSERT INTO atm_log VALUES (now(), 'CASH_ADD', $amount, null, '$admin_id')");
        if($stmt->execute()) {
            header("Location: deposit_successful.php");
        }else{
        die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }
    }else{
        die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
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
        <h1>Current cash in ATM<br>
            ₹<?php echo $cash;?>/-</h1>
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