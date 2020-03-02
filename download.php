<?php

require_once('helpers.php');

$path = 'archives/';
$filename = $path.trim($_GET['filename']);

$size = filesize($filename);

header('Content-Description: File Transfer');
header('Content-Type: image/png');
header('Content-Disposition: attachment; filename="'.$filename.'"');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . $size);
readfile($filename);