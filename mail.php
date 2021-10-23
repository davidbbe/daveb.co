<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // access
        $secretKey = '';
        $captcha = $_POST['g-recaptcha-response'];

        if(!$captcha){
          echo 'No captcha. Please check the captcha form.';
          exit;
        }

        $mail_to = "david123beauchamp@gmail.com";
        
        # Sender Data
        $name = str_replace(array("\r","\n"),array(" "," ") , strip_tags(trim($_POST["name"])));
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $message = trim($_POST["message"]);
        $subject = 'Message from daveb.co site visitor ' . $name;
        
        if ( empty($name) OR !filter_var($email, FILTER_VALIDATE_EMAIL) OR empty($subject) OR empty($message)) {
            # Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo 'Please complete the form and try again.';
            exit;
        }

        $ip = $_SERVER['REMOTE_ADDR'];
        $response= file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
        $responseKeys = json_decode($response,true);

        if(intval($responseKeys["success"]) !== 1) {
          echo 'No captcha response. Please check the captcha form.';
        } else {
            # Mail Content
            $content = "Name: $name\n";
            $content .= "Email: $email\n\n";
            $content .= "Message:\n$message\n";

            # email headers.
            $headers = "From: $name <$email>";

            # Send the email.
            $success = mail($mail_to, $subject, $content, $headers);
            if ($success) {
                # Set a 200 (okay) response code.
                http_response_code(200);
                echo 'Thank You! Your message has been sent.';
            } else {
                # Set a 500 (internal server error) response code.
                http_response_code(500);
                echo 'Oops! Something went wrong, we couldnt send your message.';
            }
        }

    } else {
        # Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo 'There was a problem with your submission, please try again.';
    }
    exit;
?>
