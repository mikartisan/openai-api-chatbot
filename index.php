<?php
    $completion = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Your OpenAI API key
        $apiKey = 'OPENAI_API_KEY';

        // The message you want to send to OpenAI
        $message = $_POST['message'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "model": "gpt-3.5-turbo",
            "messages": [
                {
                "role": "user",
                "content": "'.$message.'"
                }
            ]
            }',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$apiKey,
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        // Process the response from the OpenAI API
        $json = json_decode($response);
        $completion = $json->choices[0]->message->content;
        // echo $response;
        // echo $completion;
    }
?>
<html lang="en">
<head>
    <!-- Meta Properties -->
    <meta charset="UTF-8">
    <title>Chatbot</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <!-- CSS -->
    <link rel="stylesheet" href="css/main.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>
<body>
    <div id="chatWrapper">
        <form method="POST">
            <div id="chatBox">
                <img id="logo" src="wizard.png" alt="">
                <p>Wizard Chatbot</p>
                <?php
                    if ($completion) {
                        echo '<ul id="response">' . $message . '</ul>';
                        echo '<ul id="response">' . $completion . '</ul>';
                    }else{
                        echo '<ul id="greet">Hello, Im an AI Chatbot. You can ask me everything!</ul>';
                    }
                ?>
                <input type="text" tabindex="0" autofocus placeholder="Send a message" name="message" class="chatInput" autocomplete="off"/>
                <button type="submit" id="send"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send</button>
            </div>
        </form>
    </div>
</body>
</html>
