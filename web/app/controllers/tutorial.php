<?php
requirePHPLib('form');

if (!validateUInt($_GET['id']) || !($problem = queryProblemBrief($_GET['id']))) {
    become404Page();
}

if (!isProblemVisibleToUser($problem, $myUser)) {
    become403Page();
}

function echoBlogCell($blog) {
    echo '<tr>';
    echo '<td>' . getBlogLink($blog['id']) . '</td>';
    echo '<td>' . getUserLink($blog['poster']) . '</td>';
    echo '<td>' . $blog['post_time'] . '</td>';
    echo '</tr>';
}

$header = <<<EOD
            <tr>
                    <th width="60%">标题</th>
                    <th width="20%">发表者</th>
                    <th width="20%">发表日期</th>
            </tr>
EOD;
$config = array();
$config['table_classes'] = array('table', 'table-hover');

$config['data'] = array();
$problem_blogs = DB::selectAll("select blog_id from blogs_tags where tag = {$problem['id']}");
foreach ($problem_blogs as $problem_blog) {
    $tutorial_cnt = DB::selectCount("select count(*) from blogs_tags where blog_id = {$problem_blog['blog_id']} and tag = 'tutorial'");
    if ($tutorial_cnt > 0) {
	$is_hidden = DB::selectFirst("select is_hidden from blogs where id = {$problem_blog['blog_id']}");
	if ($is_hidden['is_hidden'] == 0) {
            $tutorial_blog = DB::selectFirst("select id, poster, title, post_time, zan from blogs where id = {$problem_blog['blog_id']}");
    	    $config['data'][] = $tutorial_blog;
	}
    }
}
?>
<?php echoUOJPageHeader(HTML::stripTags($problem['title']) . ' - ' . UOJLocale::get('problems::tutorial')) ?>
<?php if (Auth::check()): ?>
<div class="float-right">
    <div class="btn-group">
        <a href="<?= HTML::blog_url(Auth::id(), '/') ?>" class="btn btn-secondary btn-sm">我的博客首页</a>
        <a href="<?= HTML::blog_url(Auth::id(), '/post/new/write')?>" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit"></span> 写新博客</a>
    </div>
</div>
<?php endif ?>
<h3><?= '<a href="/problem/' . $_GET['id'] . '">#' . $_GET['id'] . '. ' . HTML::stripTags($problem['title']) . '</a> ' . UOJLocale::get('problems::tutorial') ?></h3>
<?php if (count($config['data']) == 0): ?>
<p>还没有人写题解呢..要不你来写一篇？<br>在博客中加上 <code>tutorial</code> 以及 <code>题号</code> 两个标签就可以啦！</p>
<?php else: ?>
<?php echoLongTableData($header, 'echoBlogCell', $config); ?>
<?php endif ?>
<?php echoUOJPageFooter() ?>
