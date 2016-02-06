<?php
ini_set('date.timezone','Africa/Lagos');
$res = ['status'=>500, 'message'=>'UNKWOWN_ERROR'];
$when = date('Y-m-d H:i:s');
$dates = date("D M j G:i:s T Y");
$email = isset($_POST['email']) ? trim($_POST['email']) : 'a@b.com';
$names = isset($_POST['names']) ? trim($_POST['names']) : 'Another Bagger';
$messg = isset($_POST['messg']) ? trim($_POST['messg']) : 'Fake Message';
$msgtxt = "Thank you for your message. We will get back to you shortly.";
$msghead = "Hello $names, ";
header('Content-type: application/json');

$message = '<!DOCTYPE HTML>'. 
'<head>'. 
'<meta http-equiv="content-type" content="text/html">'. 
'<title>From Codeeva</title>'. 
'</head>'. 
'<body>'. 
'<div id="header" style="width: 80%;height: 60px;margin: 0 auto;padding: 10px;color: #fff;text-align: center;background-color: #E0E0E0;font-family: Open Sans,Arial,sans-serif;">'. 
   '<img height="63" width="400" style="border-width:0" src="https://codeeva.xyz/images/codeeva-lite.png" alt="Codeeva Logo" title="Codeeva Logo">'. 
'</div>'. 

'<div id="outer" style="width: 80%;margin: 0 auto;margin-top: 10px;">'.  
   '<div id="inner" style="width: 78%;margin: 0 auto;background-color: #fff;font-family: Open Sans,Arial,sans-serif;font-size: 13px;font-weight: normal;line-height: 1.4em;color: #444;margin-top: 10px;">'. 
       '<p><strong>'.$msghead.'</strong></p>'. 
       '<p>'.$msgtxt.'</p>'.
       "<p>On $dates from $email you wrote:</p>".
       '<pre>'.$messg.'</pre>'.
   '</div>'.   
'</div>'. 
'<div id="footer" style="width: 80%;height: 40px;margin: 0 auto;text-align: center;padding: 10px;font-family: Verdena,Arial,sans-serif;background-color: #E2E2E2;">'. 
   'All rights reserved &copy; ' . date('Y') . ' Codeeva' . 
'</div>'. 
'</body>';

$db = new SQLite3('codeeva.db');
if($stmt = $db->prepare('INSERT INTO talks (email,names,message,sent) VALUES (:email,:names,:message,:when)')) {
  
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':names', $names);
  $stmt->bindParam(':message', $messg);
  $stmt->bindParam(':when', $when);
  $stmt->execute();

  require_once('assets/php/class.phpmailer.php');
  $mail = new PHPMailer(true);
  $sender = 'hi@codeeva.xyz';
  $sender_name = 'From Codeeva';
  $mail->IsSMTP();

  try {
    $mail->Host       = 'smtp.yandex.com';
    $mail->SMTPDebug  = 0;                     
    $mail->SMTPAuth   = true;  
    $mail->SMTPSecure = 'tls';                 
    $mail->Port       = 587;                    
    $mail->Username   = $sender;
    $mail->Password   = 'chocolate';
    $mail->AddReplyTo($sender, $sender_name);
    $mail->AddAddress($email, $names);
    $mail->SetFrom($sender, $sender_name);
    $mail->AddBCC($sender);
    $mail->Subject = 'Codeeva: Thanks for Getting in Touch';
    $mail->IsHTML(true);
    $mail->AltBody = $msghead.$msgtxt;
    $mail->MsgHTML($message);
    $mail->Send();

    $res['status'] = 200;
    $res['message'] = 'GIRL_WELCOME';
    echo json_encode($res);
    exit();

  } catch (phpmailerException $e) {
    $res['debug'] = $e->errorMessage();
  } catch (Exception $e) {
    $res['debug'] = $e->getMessage();
  }
}
echo json_encode($res);
exit();
?>