<?php
	$blogs = DB::selectAll("select blogs.id, title, poster, post_time from important_blogs, blogs where is_hidden = 0 and important_blogs.blog_id = blogs.id order by level desc, important_blogs.blog_id desc limit 5");
?>
<?php echoUOJPageHeader(UOJConfig::$data['profile']['oj-name-short']) ?>
<div class="card card-default">
	<div class="card-body">
		<div class="row">
			<div class="col-sm-12 col-md-9">
				<table class="table table-sm">
					<thead>
						<tr>
							<th style="width:60%"><?= UOJLocale::get('announcements') ?></th>
							<th style="width:20%"></th>
							<th style="width:20%"></th>
						</tr>
					</thead>
				  	<tbody>
					<?php $now_cnt = 0; ?>
					<?php foreach ($blogs as $blog): ?>
						<?php
							$now_cnt++;
							$new_tag = '';
							if ((time() - strtotime($blog['post_time'])) / 3600 / 24 <= 7) {
								$new_tag = '<sup style="color:red">&nbsp;new</sup>';
							}
						?>
						<tr>
							<td><a href="/blogs/<?= $blog['id'] ?>"><?= $blog['title'] ?></a><?= $new_tag ?></td>
							<td>by <?= getUserLink($blog['poster']) ?></td>
							<td><small><?= $blog['post_time'] ?></small></td>
						</tr>
					<?php endforeach ?>
					<?php for ($i = $now_cnt + 1; $i <= 5; $i++): ?>
						<tr><td colspan="233">&nbsp;</td></tr>
					<?php endfor ?>
						<tr><td class="text-right" colspan="233"><a href="/announcements"><?= UOJLocale::get('all the announcements') ?></a></td></tr>
					</tbody>
				</table>
			</div>
			<script type="text/javascript">
			  function hitokotoLike(x, y) {
				$.ajax({
				    url: "https://hitokoto.cn/Like",
				    type: "GET",
				    data: "ID=" + x,
				    dataType: "jsonp",
				    success: function(data) {
					alert(data.message);
					$(y).css('color', 'red');
				    },
				    error: function() {
					console.log('Hitokoto Like Request Error.');
					$(y).css('color', 'red');
				    }
				});
			  }
			  $.get('https://v1.hitokoto.cn/?c=a', function(data) {
				$('#hitokoto-content').css('display', '').text(data.hitokoto);
				$('#hitokoto-from').css('display', '').text('——' + data.from);
				$('#hitokoto-from').attr('title', '上传者: ' + data.creator);
				$('#hitokoto-link').attr('href', 'https://hitokoto.cn/?id=' + data.id);
				document.getElementById('hitokoto-like').onclick = function() { hitokotoLike(data.id, '#hitokoto-like'); }
			  });
			</script>
			<div class="col-xs-6 col-sm-4 col-md-3">
				<div>
					<div style="display: table-cell;vertical-align: top; color:#B2B7F2;font-size:30px;font-family:'Times New Roman',serif;font-weight:bold;text-align:left;">“</div>
					<div style="display: table-cell;text-align: left; vertical-align: middle; text-indent: 2em; padding: 0.8em 0.2em 1em 0.2em; font-size:1.1em"><b><span style="color:burlywood;"><span id="hitokoto-content"></span></span></b></div>
					<div style="display: table-cell; vertical-align: bottom; color:#B2B7F2;font-size:30px;font-family:'Times New Roman',serif;font-weight:bold;text-align:left;">”</div>
				</div>
				<div style="text-align: right; font-size: 0.9em; color: black;" id="hitokoto-from"></div>
				<div style="text-align: center; margin-top: 15px; font-size: 1em; color: black;">
					<a id="hitokoto-link" href="https://hitokoto.cn/" style="background-color: transparent;color: #555;text-decoration: none;outline: none;border-bottom: 1px solid #999;border-bottom-color: rgb(153, 153, 153);">Hitokoto</a>&nbsp;&nbsp;&nbsp;
					<button id="hitokoto-like" title="通过给句子点赞可以增加其出现概率，由于技术原因并不能显示赞数与点赞是否成功的信息（红心表示成功发送点赞请求，但如果同 IP 重复点赞就会失败），如需查看可以点击左边的“Hitokoto”链接。"><i class="menu-item-icon fa fa-fw fa-heart"></i></button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-12 mt-4">
		<h3><?= UOJLocale::get('top rated') ?></h3>
		<?php echoRanklist(array('echo_full' => '', 'top10' => '')) ?>
		<div class="text-center">
			<a href="/ranklist"><?= UOJLocale::get('view all') ?></a>
		</div>
	</div>
</div>
<?php echoUOJPageFooter() ?>
