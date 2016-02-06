<?php
$key = isset($_GET['w']) ? trim($_GET['w']) : false;
$done = false;
if($key !== false) {
  $db = new SQLite3('codeeva.db');
  if($stmt = $db->prepare('UPDATE girls SET verified=1 WHERE key=:key')) {
    $stmt->bindParam(':key', $key, SQLITE3_TEXT);
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
    <meta charset="utf-8" />
    <meta name="description" content="Codeeva: female focused modern software development training in Nigeria, West Africa.">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <!--[if lte IE 8]><script src="assets/js/ie/html5shiv.js"></script><![endif]-->
    <link rel="stylesheet" href="assets/css/main.css" />
    <!--[if lte IE 8]><link rel="stylesheet" href="assets/css/ie8.css" /><![endif]-->
    <!--[if lte IE 9]><link rel="stylesheet" href="assets/css/ie9.css" /><![endif]-->
  </head>
  <body>

    <!-- Header -->
      <header id="header">
        <h1 style="line-height:1.25em;"><img src="images/codeeva.png" alt="Codeeva" style="height:1.25em; max-width:100%;"/>\verification</h1>
        <p><?php echo $done ? $mesg : 'There was an error verifying your key. Please try again or contact us at hi@codeeva.xyz for assistance'; ?></p>
        <nav class="cd-stretchy-nav">
          <a class="cd-nav-trigger" href="#0">
            <span aria-hidden="true"></span>
          </a>

          <ul>
            <li><a href="index.html" class="active"><span>Home</span></a></li>
            <li><a href="about.html"><span>About</span></a></li>
            <li><a href="partners.html"><span>Partners</span></a></li>
            <li><a href="contact.html"><span>Contact</span></a></li>
          </ul>

          <span aria-hidden="true" class="stretchy-nav-bg"></span>
        </nav>
      </header>
<?php include("inc/footer.html"); ?>