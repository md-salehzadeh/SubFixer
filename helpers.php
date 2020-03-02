<?php

function filter($content) {
	$content = iconv(mb_detect_encoding($content, mb_detect_order(), true), "UTF-8", $content);
	
	$content = str_replace('ي', 'ی', $content);
	$content = str_replace('ك', 'ک', $content);

	return $content;
}

function dd($input, $print_type = false, $pre = true) {
	$tag = ( $pre ) ? 'pre' : 'div';

	if ( $print_type == 'echo' || $print_type == 'print' ) {
		echo '<'.$tag.' class="devPrint">';
			echo($input);
		echo '</'.$tag.'>';
	} elseif ( $print_type == 'var_dump' ) {
		echo '<'.$tag.' class="devPrint">';
			var_dump($input);
		echo '</'.$tag.'>';
	} else {
		echo '<'.$tag.' class="devPrint">';
			print_r($input);
		echo '</'.$tag.'>';
	}

	echo '
		<style>
			.devPrint {
				padding: 10px;
				background: #eee;
				border: 1px solid #ccc;
				border-radius: 2px;
				font-family: iranSans, yekan, arial, Helvetica;
				direction: ltr;
				margin: 20px auto;
				max-height: 400px;
				max-width: 1100px;
				overflow: auto;
			}
		</style>
	';

	die;
}

function make_zip($files) {
	$zip = new ZipArchive();

	$zip_filename = "SubFixer-".time().".zip";

	$zip->open('archives/'.$zip_filename, ZIPARCHIVE::CREATE);

	foreach ( $files as $file ) {
		$zip->addFile('export/'.$file, $file);
	}

	$zip->close();

	return $zip_filename;
}

function empty_directories() {
	$directories = ['export', 'import'];

	foreach ( $directories as $directory ) {
		foreach ( scandir($directory) as $file ) {
			if ( in_array($file, ['.', '..']) ) continue;
		
			unlink($directory.'/'.$file);
		}
	}
}