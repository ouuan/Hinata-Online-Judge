<?php
requirePHPLib('uploaded-file');

$type = $_GET['type'];

switch ($type) {
	case 'user':
		$domain = $_GET['username'];
		break;
	case 'problem':
		$domain = $_GET['id'];
		break;
	default:
		become404Page();
}

$config = array();

$dir = (new UploadedFile($type, $domain))->filePath();

$files = array_values(array_filter(
	scandir($dir),
	function ($x) use ($dir) {
		return !strStartWith($x, '.') && is_file($dir . $x);
	}
));

$config['data'] = array();
foreach ($files as $name) {
	$file = new UploadedFile($type, $domain, $name);
	if ($file->hasReadPermission()) $config['data'][] = $file;
}
usort($config['data'], function (UploadedFile $x, UploadedFile $y) {
	return filemtime($y->filePath()) - filemtime($x->filePath());
});

function printRow(UploadedFile $file)
{
	echo '<tr>';
	echo '<td>' . $file->mtime() . '</td>';
	echo '<td><a href="' . $file->url() . '">' . $file->name . '</a></td>';
	echo '<td data-sort="' . filesize($file->filePath()) . '">' . $file->size() . '</td>';
	echo '<td>' . $file->operation() . '</td>';
	echo '<td>' . $file->deleteButton() . '</td>';
	echo '</tr>';
}

$header = <<<EOD
    <tr>
		<th>修改时间</th>
		<th>文件名</th>
		<th>大小</th>
		<th>操作</th>
		<th>删除</th>
    </tr>
EOD;

?>

<?php echoUOJPageHeader($type . "/" . $domain . " - 已上传文件列表"); ?>

<div class="float-right">
	<a href="<?= HTML::url('/file-upload?type=' . $type . '&domain=' . $domain) ?>" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-upload"></span> 上传新文件</a>
</div>

<h2>/upload/<?= $type ?>/<?= $domain ?> 的文件列表</h2>

<?php echoLongTableData($header, 'printRow', $config); ?>

<?php echoUOJPageFooter(); ?>
