<?php
$yinyuetai_url = $_REQUEST['yinyuetai_url'];
$keyword = $_REQUEST['keyword'];
$page = intval($_REQUEST['page']);
$search_page = $page ? ceil($page/2) : 1;
$perpage = 8;
if($_REQUEST['tab'] == 'tab2'){
	$url = 'http://www.yinyuetai.com/search/playlist?page=' . $search_page . '&keyword=' . urlencode($keyword);
	$result = '';
	$content = file_get_contents($url);
	$num_reg = "/(找到)([\s]*)(\<em[^\>]*\>)([0-9]+\+?)(\<\/em\>)/";
	preg_match($num_reg, $content, $num);
	if($num[4]){
		$sesult_num = '<div class="result_summary">找到' . $num[4] . '条符合搜索条件“' . $keyword . '”的内容。</div>';
		$result .= $sesult_num;
		$list_reg = "/(\<li\>)([\s]*)(\<div class=\"thumb thumb_playlist\"\>)([\s\S]*?)(\<\/li\>)/";
		$result_list = '<ul class="result_list" class="cl">';
		preg_match_all($list_reg, $content, $list_match);
		$list_rep_reg[] = "/((\<li\>)([\s]*))((\<div class=\"thumb thumb_playlist\"\>)([\s]*)(\<a target=\"_blank\" href=\"\/playlist\/)([0-9]+)(\"))/";
		$list_rep_tar[] = "\$1<input class=\"id_list\" name=\"id_list[]\" type=\"checkbox\" value=\"\$8\" />\$4";
		$list_rep_reg[] = "/src=\"\//";
		$list_rep_tar[] = "src=\"$yinyuetai_url/thumb.php?w=120&h=67&src=http://www.yinyuetai.com/";
		$list_rep_reg[] = "/((src=\")([^\"]*))(\?t\=)([0-9]+)/";
		$list_rep_tar[] = "\$1";
		$list_rep_reg[] = "/href=\"\//";
		$list_rep_tar[] = "href=\"http://www.yinyuetai.com/";
		foreach($list_match[0] as $key=>$list){
			if($page%2 && $key<8 || !($page%2) && $key>=8){
				$list = preg_replace($list_rep_reg, $list_rep_tar, $list);
				$result_list .= $list;
			}
		}
		$result .= $result_list . '</ul>';
		$result .= multi($num[4], $perpage, $page, 'tab2');
	} else {
		$sesult_num = '<div class="result_summary">没有找到符合搜索条件“' . $keyword . '”的内容。</div>';
		$result .= $sesult_num;
	}
	echo $result;
} else {
	$url = 'http://www.yinyuetai.com/search?page=' . $search_page . '&keyword=' . urlencode($keyword);
	$result = '';
	$content = file_get_contents($url);
	$num_reg = "/(找到)([\s]*)(\<em[^\>]*\>)([0-9]+\+?)(\<\/em\>)/";
	preg_match($num_reg, $content, $num);
	if($num[4]){
		$sesult_num = '<div class="result_summary">找到' . $num[4] . '条符合搜索条件“' . $keyword . '”的内容。</div>';
		$result .= $sesult_num;
		$list_reg = "/(\<li id=\"parent_per_[0-9]+\"\>)([\s\S]*?)(\<\/li\>)/";
		$result_list = '<ul class="result_list" class="cl">';
		preg_match_all($list_reg, $content, $list_match);
		$list_rep_reg[] = "/(\<li id=\"parent_per_([0-9]+)\"\>)/";
		$list_rep_tar[] = "\$1<input class=\"id_list\" name=\"id_list[]\" type=\"checkbox\" value=\"\$2\" />";
		$list_rep_reg[] = "/src=\"\//";
		$list_rep_tar[] = "src=\"$yinyuetai_url/thumb.php?w=120&h=67&src=http://www.yinyuetai.com/";
		$list_rep_reg[] = "/((src=\")([^\"]*))(\?t\=)([0-9]+)/";
		$list_rep_tar[] = "\$1";
		$list_rep_reg[] = "/href=\"\//";
		$list_rep_tar[] = "href=\"http://www.yinyuetai.com/";
		foreach($list_match[0] as $key=>$list){
			if($page%2 && $key<8 || !($page%2) && $key>=8){
				$list = preg_replace($list_rep_reg, $list_rep_tar, $list);
				$result_list .= $list;
			}
		}
		$result .= $result_list . '</ul>';
		$result .= multi($num[4], $perpage, $page, 'tab1');
	} else {
		$sesult_num = '<div class="result_summary">没有找到符合搜索条件“' . $keyword . '”的内容。</div>';
		$result .= $sesult_num;
	}
	echo $result;
}
function multi($num, $perpage, $curpage, $tab, $page = 10) {
	$lang['prev'] = '上页';
	$lang['next'] = '下页';
	$dot = '...';
	$multipage = '';
	$realpages = 1;
	$page -= strlen($curpage) - 1;
	if($page <= 0) {
		$page = 1;
	}
	if($num > $perpage) {

		$offset = floor($page * 0.5);

		$realpages = @ceil($num / $perpage);
		$pages = $realpages;

		if($page > $pages) {
			$from = 1;
			$to = $pages;
		} else {
			$from = $curpage - $offset;
			$to = $from + $page - 1;
			if($from < 1) {
				$to = $curpage + 1 - $from;
				$from = 1;
				if($to - $from < $page) {
					$to = $page;
				}
			} elseif($to > $pages) {
				$from = $pages - $page + 1;
				$to = $pages;
			}
		}
		$multipage = ($curpage - $offset > 1 && $pages > $page ? '<a href="javascript:;" onclick="search_submit(\''.$tab.'\',1);" class="first">1 '.$dot.'</a>' : '').
		($curpage > 1 ? '<a href="javascript:;" onclick="search_submit(\''.$tab.'\','.($curpage-1).');" class="prev">'.$lang['prev'].'</a>' : '');
		for($i = $from; $i <= $to; $i++) {
			$multipage .= $i == $curpage ? '<strong>'.$i.'</strong>' :
			'<a href="javascript:;" onclick="search_submit(\''.$tab.'\','.$i.');">'.$i.'</a>';
		}
		$multipage .= ($to < $pages ? '<a href="javascript:;" onclick="search_submit(\''.$tab.'\','.$pages.');" class="last">'.$dot.' '.$realpages.'</a>' : '').
		($curpage < $pages && !$simple ? '<a href="javascript:;" onclick="search_submit(\''.$tab.'\','.($curpage+1).');" class="nxt">'.$lang['next'].'</a>' : '');

		$multipage = $multipage ? '<div class="pg_wrapper cl"><div class="pg">'.$multipage.'</div></div>' : '';
	}
	return $multipage;
}
?>
