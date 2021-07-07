<?php

if (!Auth::check()) {
	redirectToLogin();
}

requirePHPLib('uploaded-file');

$parts = explode("/", $_GET['uploaded_file_path']);

if (count($parts) !== 3) {
	become404Page();
}

$file = new UploadedFile($parts[0], $parts[1], urldecode($parts[2]));

if (!$file->hasReadPermission()) {
	become403Page();
}

$content = file_get_contents($file->filePath());

if ($content === false) {
	become404Page();
}

header("Content-type: " . mime_content_type($file->filePath()));
echo $content;
