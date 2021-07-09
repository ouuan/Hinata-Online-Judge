<?php
requirePHPLib('judger');
switch ($_GET['type']) {
	case 'problem':
		if (!validateUInt($_GET['id']) || !($problem = queryProblemBrief($_GET['id']))) {
			become404Page();
		}

		$all = isset($_GET['all']) && $_GET['all'] == 'true' ? true : false;
		$visible = isProblemVisibleToUser($problem, $myUser);
		if (!$visible && $myUser != null && !$all) {
			$result = DB::query("select contest_id from contests_problems where problem_id = {$_GET['id']}");
			while (list($contest_id) = DB::fetch($result, MYSQLI_NUM)) {
				$contest = queryContest($contest_id);
				genMoreContestInfo($contest);
				if ($contest['cur_progress'] == CONTEST_IN_PROGRESS && hasRegistered($myUser, $contest) && queryContestProblemRank($contest, $problem)) {
					$visible = true;
				}
			}
		}
		if (!$visible) {
			become403Page();
		}

		$id = $_GET['id'];

		if ($all) {
			$file_name = "/var/uoj_data/$id.zip";
			$download_name = "problem_all_$id.zip";
		} else {
			$file_name = "/var/uoj_data/$id/download.zip";
			$download_name = "problem_down_$id.zip";
		}
		break;
	case 'testlib.h':
		$file_name = "/opt/uoj/judger/uoj_judger/include/testlib.h";
		$download_name = "testlib.h";
		break;
	default:
		become404Page();
}

$finfo = finfo_open(FILEINFO_MIME);
$mimetype = finfo_file($finfo, $file_name);
if ($mimetype === false) {
	become404Page();
}
finfo_close($finfo);

header("X-Sendfile: $file_name");
header("Content-type: $mimetype");
header("Content-Disposition: attachment; filename=$download_name");
