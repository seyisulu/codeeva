<?php
$db = new SQLite3('codeeva.db');
$res = $db->query('SELECT email, names, applied, verified FROM girls');
$data = [];
while ($dat = $res->fetchArray(SQLITE3_ASSOC)) {
  $data[] = $dat;
}
?>
<!DOCTYPE HTML>
<html>
  <head>
    <title>Codeeva Registrations</title>
    <?php include("inc/header.html"); ?>
  </head>
  <body>

    <!-- Header -->
    <header id="header">
      <h1 style="line-height:1.25em;"><img src="images/codeeva.png" alt="Codeeva" style="height:1.25em; max-width:100%;"/>\registrations</h1>
      <p></p>
      
      <table class="flat-table flat-table-3">
        <thead>
          <th>Names</th>
          <th>Emails</th>
          <th>Applied</th>
          <th>Verified</th>
        </thead>
        <tbody>
          <?php foreach($data as $info): ?>
          <tr>
            <td><?php echo $info['names']; ?></td>
            <td><?php echo $info['email']; ?></td>
            <td><?php echo $info['applied']; ?></td>
            <td><?php echo $info['verified']; ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      
      <?php include("inc/nav.html"); ?>
    </header>
    <?php include("inc/footer.html"); ?>

  </body>
</html>