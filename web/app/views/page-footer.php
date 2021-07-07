<?php
if (!isset($ShowPageFooter)) {
	$ShowPageFooter = true;
}
?>
</div>
<?php if ($ShowPageFooter) : ?>
	<div class="uoj-footer">
		<div class="btn-group dropright mb-3">
			<button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-toggle="dropdown">
				<span class="glyphicon glyphicon-globe"></span> <?= UOJLocale::get('_common_name') ?>
			</button>
			<div class="dropdown-menu">
				<a class="dropdown-item" href="<?= HTML::url(UOJContext::requestURI(), array('params' => array('locale' => 'zh-cn'))) ?>">中文</a>
				<a class="dropdown-item" href="<?= HTML::url(UOJContext::requestURI(), array('params' => array('locale' => 'en'))) ?>">English</a>
			</div>
		</div>

		<p><?= UOJConfig::$data['profile']['oj-name'] ?> | <a href="https://github.com/ouuan/Hinata-Online-Judge" target="_blank"><?= UOJLocale::get('opensource project') ?></a></p>
		<?php if (UOJConfig::$data['profile']['ICP-license'] != '' && preg_match_all('/(\d+\.?\d+)/', UOJConfig::$data['profile']['ICP-license'], $ICP_number)) : ?>
			<p><a target="_blank" href="http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=<?= $ICP_number[0][0] ?>" style="text-decoration:none;"><img src="http://uoj.ac/pictures/beian.png" /> <?= UOJConfig::$data['profile']['ICP-license'] ?></a></p>
		<?php endif ?>
		<p><?= UOJLocale::get('server time') ?>: <?= UOJTime::$time_now_str ?> | 服务器空间: <?= humanFilesize(disk_total_space('/') - disk_free_space('/')) ?>/<?= humanFilesize(disk_total_space('/')) ?></p>
	</div>
<?php endif ?>
</div>
<!-- /container -->
</body>

</html>
