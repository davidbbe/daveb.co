<?php
$field_name = trim($_POST['name']);
$field_email = trim($_POST['email']);
$field_phone = trim($_POST['tel']);
$field_message = trim($_POST['message']);
 
$mail_to = 'david123beauchamp@gmail.com, streethouse4@gmail.com';
$subject = 'Message from daveb.co site visitor '.$field_name;
 
$body_message = 'From: '.$field_name."\n";
$body_message .= 'E-mail: '.$field_email."\n";
$body_message .= 'Phone: '.$field_phone."\n";
$body_message .= 'Message: '.$field_message;
 
$headers = 'From: '.$field_name."\r\n";
$headers .= 'Reply-To: '.$field_email."\r\n";
 
$mail_status = mail($mail_to, $subject, $body_message, $headers);
 
if ($mail_status) { ?>
   <script language="javascript" type="text/javascript">
      alert('Your message was sent. I will get back to as soon as possible.');
      window.location = 'index.html';
   </script>
<?php
}
else { ?>
   <script language="javascript" type="text/javascript">
      alert('Message failed. Please, send an email to david123beauchamp@gmail.com');
      window.location = 'index.html';
   </script>
<?php
}
?>