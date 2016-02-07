<?php
ini_set('date.timezone','Africa/Lagos');
$when = date('Y-m-d H:i:s');
$key = isset($_GET['w']) ? trim($_GET['w']) : false;
$done = false;
if($key !== false) {
  $db = new SQLite3('codeeva.db');
  if($stmt = $db->prepare('UPDATE girls SET verified=:v WHERE key=:key')) {
    $stmt->bindParam(':key', $key, SQLITE3_TEXT);
    $stmt->bindParam(':v', $when, SQLITE3_TEXT);
    $rest = $stmt->execute();
  }
  if($stmt = $db->prepare('SELECT email, names, verified FROM girls WHERE key=:key')) {
    $stmt->bindParam(':key', $key, SQLITE3_TEXT);
    $rest = $stmt->execute();
    $data = $rest->fetchArray(SQLITE3_ASSOC);
    $mesg = "Welcome back <strong>{$data['names']}</strong>, your email address <strong>{$data['email']}</strong> has been sucessfully verified. Thank you.";
    $done = true;
  }
}
?>
<!DOCTYPE HTML>
<html>
  <head>
    <title>Codeeva Verification</title>
    <?php include("inc/header.html"); ?>
  </head>
  <body>

    <!-- Header -->
    <header id="header">
      <h1 style="line-height:1.25em;"><img src="images/codeeva.png" alt="Codeeva" style="height:1.25em; max-width:100%;"/>\verification</h1>
      <p><?php echo $done ? $mesg : 'There was an error verifying your key. Please try again or contact us at hi@codeeva.xyz for assistance'; ?></p>
      <?php include("inc/nav.html"); ?>
    </header>
    <?php include("inc/footer.html"); ?>

  </body>
</html>