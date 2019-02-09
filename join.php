<?php
ini_set('date.timezone','Africa/Lagos');
$res = ['status'=>500, 'message'=>'UNKWOWN_ERROR'];
$idx = md5(uniqid());
$when = date('Y-m-d H:i:s');
$email = isset($_POST['email']) ? trim($_POST['email']) : 'a@b.com';
$names = isset($_POST['names']) ? trim($_POST['names']) : 'New Member';
$msgtxt = "To verify your place in the program please visit this url: https://codeeva.xyz/v.php?w=$idx";
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
   '</div>'.   
'</div>'. 
'<div id="footer" style="width: 80%;height: 40px;margin: 0 auto;text-align: center;padding: 10px;font-family: Verdena,Arial,sans-serif;background-color: #E2E2E2;">'. 
   'All rights reserved &copy; ' . date('Y') . ' Codeeva' . 
'</div>'. 
'</body>';

$db = new SQLite3('codeeva.db');
if($stmt = $db->prepare('INSERT INTO girls (email,names,verified,key,applied) VALUES (?,?,0,?,?)')) {
  
  $stmt->bindValue(1, $email);
  $stmt->bindValue(2, $names);
  $stmt->bindValue(3, $idx);
  $stmt->bindValue(4, $when);
  $stmt->execute();

  require_once('assets/php/class.phpmailer.php');
  $mail = new PHPMailer(true);
  $sender = 'hi@codeeva.xyz';
  $sender_name = 'From Codeeva';
  $mail->IsSMTP();

  try {
    $mail->Host       = '';
    $mail->SMTPDebug  = 0;                     
    $mail->SMTPAuth   = true;  
    $mail->SMTPSecure = 'tls';                 
    $mail->Port       = 587;                    
    $mail->Username   = $sender;
    $mail->Password   = '';
    $mail->AddReplyTo($sender, $sender_name);
    $mail->AddAddress($email, $names);
    $mail->SetFrom($sender, $sender_name);
    $mail->Subject = 'Welcome to Codeeva';
    $mail->IsHTML(true);
    $mail->AltBody = $msghead.$msgtxt;
    $mail->MsgHTML($message);
    $mail->AddAttachment('images/codeeva-bg.png');
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
