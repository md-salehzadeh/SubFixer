<?php

require_once('helpers.php');

$source_dir = 'import/';
$export_dir = 'export/';

$name_pattern = trim($_POST['name-pattern']);
$name = trim($_POST['name']);

$count = 0;
foreach ( $_FILES['subtitles']['name'] as $filename ) {
	$tmp = $_FILES['subtitles']['tmp_name'][$count];
	$final_name = $source_dir.basename($filename);
	move_uploaded_file($tmp, $final_name);

	$count++;
}

$subtitles = [];
foreach ( scandir($source_dir) as $file ) {
	if ( in_array($file, ['.', '..']) ) continue;

	$subtitle = file_get_contents($source_dir.$file);
	$subtitle = filter($subtitle);

	if ( $name && $name_pattern ) {
		$ext = pathinfo($file, PATHINFO_EXTENSION);

		preg_match('/'.$name_pattern.'/', $file, $matches);
		if ( isset($matches[1]) ) {
			$number = $matches[1];
			$file = str_replace('{#}', $number, $name).'.'.$ext;
		}
	}

	file_put_contents($export_dir.$file, $subtitle);

	$subtitles[] = $file;
}

$zip_filename = make_zip($subtitles);

empty_directories();

die($zip_filename);