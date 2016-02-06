<?php
header('Content-type: application/json');
$db = new SQLite3('..'.DIRECTORY_SEPARATOR.'codeeva.db');
$res = $db->query('SELECT email, names, verified FROM girls');
$data = [];
while ($dat = $res->fetchArray(SQLITE3_ASSOC)) {
  $data[] = $dat;
}
echo json_encode([ 'status'=>200,'result'=>$data ]);
?>