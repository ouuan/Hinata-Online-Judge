<?php

class UploadedFile
{
	public $type;
	public $domain;
	public $name;

	public function __construct($type, $domain, $name = '')
	{
		$this->type = $type;
		$this->domain = $domain;
		$this->name = $name;
	}

	private function relPath()
	{
		return '/upload/' . $this->type . '/' . $this->domain . '/' . $this->name;
	}

	public function filePath()
	{
		return UOJContext::storagePath() . $this->relPath();
	}

	public function url()
	{
		return HTML::url($this->relPath());
	}

	public function hasWritePermission()
	{
		if (isSuperUser(Auth::user())) return true;
		if ($this->type === 'user') {
			return Auth::id() === $this->domain;
		}
		if ($this->type === 'problem') {
			return hasProblemPermission(Auth::user(), array("id" => $this->domain));
		}
		return false;
	}

	public function hasReadPermission()
	{
		if ($this->type === 'user') return true;
		if ($this->type === 'problem') {
			return isProblemOrContestProblemVisibleToUser(queryProblemBrief($this->domain), Auth::user());
		}
		return false;
	}

	public function delete()
	{
		if ($this->hasWritePermission())
			return unlink($this->filePath());
		return false;
	}

	public function size()
	{
		return humanFilesize(filesize($this->filePath()));
	}

	public function mtime()
	{
		return date("Y-m-d H:i:s", filemtime($this->filePath()));
	}

	public function markdownButton()
	{
		if (strStartWith(mime_content_type($this->filePath()), 'image/')) {
			$name = "图片";
			$prefix = "!";
		} else {
			$name = "文件链接";
			$prefix = "";
		}
		return <<<EOD
<button title="复制{$name}的 Markdown 代码" class="btn btn-primary" onclick="copyTextToClipboard('{$prefix}[{$this->name}]({$this->relPath()})')">复制 Markdown</button>
EOD;
	}

	public function deleteButton()
	{
		return <<<EOD
<button class="btn btn-danger delete-uploaded-file-btn" data-type="{$this->type}" data-domain="{$this->domain}" data-name="{$this->name}">
	<span class="glyphicon glyphicon-remove"></span>
	删除
</button>
EOD;
	}

	public function exists()
	{
		return file_exists($this->filePath());
	}
};
