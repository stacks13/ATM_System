<?php
$details = explode("|", base64_decode($_COOKIE['details']));
if($details == '') die();
?>

<!DOCTYPE html>
<html>
<head>
	<title>successful</title>
	<link rel="stylesheet" type="text/css" href="css/page2.css">
</head>
<body>
	<div class = "box">
		<h1 id="status">Processing Transaction</h1>
		<marquee id="m2" behavior="scroll" direction="down" scrollamount="10" >$ $ $ $</marquee>
		<input id="btnCollected" type="submit" name="" value="Collected" style="visibility: hidden">
	</div>
    <form action="enter_amount.php" method="post">
        <input type="hidden" value="<?php echo $details[3];?>" name="amount">
        <input type="hidden" name="enter_amount" value="ENTER">
        <input type="hidden" name="unsuccessful" value="ab">
    </form>
    <script>
        function post(path, params, method='post') {

            // The rest of this code assumes you are not using a library.
            // It can be made less wordy if you use one.
            const form = document.createElement('form');
            form.method = method;
            form.action = path;

            for (const key in params) {
                if (params.hasOwnProperty(key)) {
                    const hiddenField = document.createElement('input');
                    hiddenField.type = 'hidden';
                    hiddenField.name = key;
                    hiddenField.value = params[key];

                    form.appendChild(hiddenField);
                }
            }

            document.body.appendChild(form);
            form.submit();
        }

        const status = document.getElementById("status");
        var countdown = 10000;
        setTimeout(function () {
            status.textContent = "Please collect your cash in 10 seconds";

            var timer = setInterval(function () {
                countdown -= 1000;
                status.textContent = "Please collect your cash in " + (countdown/1000).toString() + " seconds";
                if (countdown <= 0) {
                    clearInterval(timer);
                    document.forms[0].submit();
                }
            }, 1000);
            document.getElementById('btnCollected').style.visibility = 'visible';
            document.getElementById('btnCollected').onclick = function () {
                clearInterval(timer);

                status.textContent = "Cash Collected";
                document.getElementById('btnCollected').style.visibility = "invisible";
                setTimeout(function () {
                    location.href = 'index.php';
                }, 2000);


                post("download_notes.php", {amount: <?php echo $details[3];?>});

            };
        }, 2000);
    </script>
</body>
</html>