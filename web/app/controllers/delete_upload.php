<?php

requirePHPLib('uploaded-file');

$file = new UploadedFile($_POST['type'], $_POST['domain'], $_POST['name']);

if ($file->delete()) {
	echo "<p class='text-success'>已成功删除</p>";
} else {
	echo "<p class='text-danger'>删除失败，可能没有权限</p>";
}
