<?php
@session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cleup Captcha</title>
    <style>
        html,
        body {
            font-family: Helvetica, sans-serif;
            background-color: #ccf2ff;
            height: 100%;
            width: 100%;
            padding: 0;
            margin: 0;
        }

        .success {
            color: #fff;
            background-color: darkcyan;
        }

        .error {
            color: #fff;
            background-color: brown
        }

        .message {
            display: none;
            padding: 16px;
            font-size: 16px;
            font-weight: 600;
            max-width: 300px;
            border-radius: 8px;
            margin-top: 12px;
        }

        .container {
            width: 300px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100%;
        }

        input {
            border: 0;
            background-color: #ebebeb;
            border-radius: 8px;
            padding: 6px 12px;
            width: 90px;
            height: 24px;
            width: 100%;
        }

        #send {
            width: 100px;
            padding: 10px;
            color: #fff;
            background-color: #0066ff;
            border-radius: 8px;
            border: 0
        }

        .box {
            margin-top: 12px;
            display: flex;
            gap: 12px
        }
    </style>
</head>

<body>
    <div class="container">
        <img src="image.php?<?= rand(1, 100); ?>" alt="Captcha"/>
        <div class="form">
            <div class="message" id="message"></div>
            <div class="box" id="box">
                <input type="text" name="code" id="code" placeholder="Enter the code" />
                <button id="send">Send</button>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('send').addEventListener('click', function(e) {
            const code = document.getElementById('code').value;
            fetch('verify.php', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    code: code
                })
            }).then((response) => {
                return response.json();
            }).then((response) => {
                const msg = document.getElementById('message');
                msg.classList.remove('success');
                msg.classList.remove('error');
                msg.innerHTML = response.message;
                msg.style.display = 'block';
                msg.classList.add(response.success ? 'success' : 'error');

                if (response.success)
                    document.getElementById('box').style.display = 'none'
            })
        })
    </script>
</body>

</html>