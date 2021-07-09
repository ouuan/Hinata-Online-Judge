<?php
requirePHPLib('form');
requirePHPLib('judger');
requirePHPLib('data');

if (isSuperUser($myUser)) {
	$new_problem_form = new UOJForm('new_problem');
	$new_problem_form->handle = function () {
		DB::query("insert into problems (title, is_hidden, submission_requirement) values ('New Problem', 1, '{}')");
		$id = DB::insert_id();
		DB::query("insert into problems_contents (id, statement, statement_md) values ($id, '', '')");
		dataNewProblem($id);
	};
	$new_problem_form->submit_button_config['align'] = 'right';
	$new_problem_form->submit_button_config['class_str'] = 'btn btn-primary';
	$new_problem_form->submit_button_config['text'] = UOJLocale::get('problems::add new');
	$new_problem_form->submit_button_config['smart_confirm'] = '';

	$new_problem_form->runAtServer();
}

function echoProblem($problem)
{
	global $myUser;
	if (isProblemVisibleToUser($problem, $myUser)) {
		echo '<tr class="text-center">';
		$max_score = -1;
		$max_submission = -1;
		$submissions = DB::selectAll("select score, id from submissions where problem_id = {$problem['id']} and submitter = '{$myUser['username']}'");
		foreach ($submissions as $submission) {
			if ($submission['score'] > $max_score) {
				$max_score = $submission['score'];
				$max_submission = $submission['id'];
			}
		}
		if ($max_score >= 0) {
			echo '<td class="submitted" title=' . $max_score . '>';
			echo '<a href="/submission/' . $max_submission . '" title="' . UOJLocale::get('problems::best submission') . '">';
		} else {
			echo '<td>';
		}
		echo '#', $problem['id'];
		if ($max_score >= 0) {
			echo '</a>';
		}
		echo '</td>';
		echo '<td class="text-left">';
		if ($problem['is_hidden']) {
			echo ' <span class="text-danger">[隐藏]</span> ';
		}
		echo '<a href="/problem/', $problem['id'], '">', $problem['title'], '</a>';
		if (isset($_COOKIE['show_tags_mode'])) {
			foreach (queryProblemTags($problem['id']) as $tag) {
				echo '<a class="uoj-problem-tag">', '<span class="badge badge-pill badge-secondary">', HTML::escape($tag), '</span>', '</a>';
			}
		}
		echo '</td>';
		if (isset($_COOKIE['show_submit_mode'])) {
			$problem['ac_num'] = queryDistinctAC($problem['id']);
			echo <<<EOD
				<td><a href="/submissions?problem_id={$problem['id']}&min_score=100&max_score=100">&times;{$problem['ac_num']}</a></td>
				<td><a href="/submissions?problem_id={$problem['id']}">&times;{$problem['submit_num']}</a></td>
EOD;
			$rating = AVGACRating($problem['id']);
			if ($rating != -1) {
				echo '<td><span class="uoj-honor" data-rating="' . $rating . '">' . $rating . '</span></td>';
			} else {
				echo '<td>N/A</td>';
			}
		}
		echo '<td class="text-left">', getClickZanBlock('P', $problem['id'], $problem['zan']), '</td>';
		echo '</tr>';
	}
}

$cond = array();

$search_tag = null;

$cur_tab = isset($_GET['tab']) ? $_GET['tab'] : 'all';
if ($cur_tab == 'template') {
	$search_tag = "模板题";
} else if ($cur_tab == 'original') {
	$search_tag = "原创题";
} else if ($cur_tab == 'nohack') {
	$cond[] = "hackable = 0";
	$cond[] = "'" . DB::escape('提交答案题') . "' not in (select tag from problems_tags where problems_tags.problem_id = problems.id)";
} else if ($cur_tab == 'nostatement') {
	$cond[] = "(SELECT LENGTH(statement_md) FROM problems_contents WHERE id = problems.id) < 100";
}
if (isset($_GET['tag'])) {
	$search_tag = $_GET['tag'];
}
if ($search_tag) {
	$cond[] = "'" . DB::escape($search_tag) . "' in (select tag from problems_tags where problems_tags.problem_id = problems.id)";
}
if (isset($_GET["search"])) {
	$cond[] = "title like '%" . DB::escape($_GET["search"]) . "%' or id like '%" . DB::escape($_GET["search"]) . "%'";
}
if (isset($_COOKIE['show_unaccepted_mode'])) {
	$cond[] = "best_ac_submissions.submission_id is null";
}

if ($cond) {
	$cond = join($cond, ' and ');
} else {
	$cond = '1';
}

$header = '<tr>';
$header .= '<th class="text-center" style="width:5em;">ID</th>';
$header .= '<th>' . UOJLocale::get('problems::problem') . '</th>';
if (isset($_COOKIE['show_submit_mode'])) {
	$header .= '<th class="text-center" style="width:5em;" title="除 std 外 AC 人数">' . UOJLocale::get('problems::ac') . '</th>';
	$header .= '<th class="text-center" style="width:5em;" title="总提交次数">' . UOJLocale::get('problems::submit') . '</th>';
	$header .= '<th class="text-center" style="width:5em;" title="' . UOJLocale::get('problems::ac rating') . '">' . UOJLocale::get('rating') . '</th>';
}
$header .= '<th class="text-center" style="width:180px;">' . UOJLocale::get('appraisal') . '</th>';
$header .= '</tr>';

$tabs_info = array(
	'all' => array(
		'name' => UOJLocale::get('problems::all problems'),
		'url' => "/problems"
	),
	'template' => array(
		'name' => UOJLocale::get('problems::template problems'),
		'url' => "/problems/template"
	),
	'original' => array(
		'name' => UOJLocale::get('problems::original problems'),
		'url' => "/problems/original"
	),
	'nohack' => array(
		'name' => UOJLocale::get('problems::nohack problems'),
		'url' => "/problems/nohack"
	),
	'nostatement' => array(
		'name' => UOJLocale::get('problems::nostatement problems'),
		'url' => "/problems/nostatement"
	),
);

/*
	<?php
	echoLongTable(array('*'),
		"problems left join best_ac_submissions on best_ac_submissions.submitter = '{$myUser['username']}' and problems.id = best_ac_submissions.problem_id", $cond, 'order by id asc',
		$header,
		'echoProblem',
		array('page_len' => 3,
			'table_classes' => array('table', 'table-bordered', 'table-hover', 'table-striped'),
			'print_after_table' => function() {
				global $myUser;
				if (isSuperUser($myUser)) {
					global $new_problem_form;
					$new_problem_form->printHTML();
				}
			},
			'head_pagination' => true
		)
	);
?>*/

$pag_config = array('page_len' => 100);
$pag_config['col_names'] = array('*');
$pag_config['table_name'] = "problems left join best_ac_submissions on best_ac_submissions.submitter = '{$myUser['username']}' and problems.id = best_ac_submissions.problem_id";
$pag_config['cond'] = $cond;
$pag_config['tail'] = "order by id asc";
$pag = new Paginator($pag_config);

$div_classes = array('table-responsive');
$table_classes = array('table', 'table-bordered', 'table-hover', 'table-striped');
?>
<?php echoUOJPageHeader(UOJLocale::get('problems')) ?>
<div class="row">
	<div class="col-sm-5">
		<?= HTML::tablist($tabs_info, $cur_tab, 'nav-pills') ?>
	</div>
	<div class="col-sm-4 order-sm-9 checkbox text-right">
		<label class="checkbox-inline" for="input-show_tags_mode"><input type="checkbox" id="input-show_tags_mode" <?= isset($_COOKIE['show_tags_mode']) ? 'checked="checked" ' : '' ?> /> <?= UOJLocale::get('problems::show tags') ?></label>&nbsp;
		<label class="checkbox-inline" for="input-show_submit_mode"><input type="checkbox" id="input-show_submit_mode" <?= isset($_COOKIE['show_submit_mode']) ? 'checked="checked" ' : '' ?> /> <?= UOJLocale::get('problems::show statistics') ?></label>&nbsp;
		<label class="checkbox-inline" for="input-show_unaccepted"><input type="checkbox" id="input-show_unaccepted" <?= isset($_COOKIE['show_unaccepted_mode']) ? 'checked="checked" ' : '' ?> /> <?= UOJLocale::get('problems::show unaccepted only') ?></label>&nbsp;
	</div>
	<div class="col-sm-3 order-sm-5">
		<?php echo $pag->pagination(); ?>
	</div>
</div>
<div class="top-buffer-sm"></div>
<script type="text/javascript">
	$('#input-show_tags_mode').click(function() {
		if (this.checked) {
			$.cookie('show_tags_mode', '', {
				path: '/problems'
			});
		} else {
			$.removeCookie('show_tags_mode', {
				path: '/problems'
			});
		}
		location.reload();
	});
	$('#input-show_submit_mode').click(function() {
		if (this.checked) {
			$.cookie('show_submit_mode', '', {
				path: '/problems'
			});
		} else {
			$.removeCookie('show_submit_mode', {
				path: '/problems'
			});
		}
		location.reload();
	});
	$('#input-show_unaccepted').click(function() {
		if (this.checked) {
			$.cookie('show_unaccepted_mode', '', {
				path: '/problems'
			});
		} else {
			$.removeCookie('show_unaccepted_mode', {
				path: '/problems'
			});
		}
		location.reload();
	});
</script>
<?php
echo '<div class="', join($div_classes, ' '), '">';
echo '<table class="', join($table_classes, ' '), '">';
echo '<thead>';
echo $header;
echo '</thead>';
echo '<tbody>';

foreach ($pag->get() as $idx => $row) {
	echoProblem($row);
	echo "\n";
}
if ($pag->isEmpty()) {
	echo '<tr><td class="text-center" colspan="233">' . UOJLocale::get('none') . '</td></tr>';
}

echo '</tbody>';
echo '</table>';
echo '</div>';

if (isSuperUser($myUser)) {
	$new_problem_form->printHTML();
}

echo $pag->pagination();
?>
<?php echoUOJPageFooter() ?>
