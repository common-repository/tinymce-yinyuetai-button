<?php
	require_once('../../../wp-load.php');
	$yinyuetai_url = WP_PLUGIN_URL . '/' . plugin_basename(dirname(__FILE__));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"  dir="ltr" lang="zh-CN">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>插入音悦台MV或悦单</title>
</head>
<body>
	<link rel="stylesheet" href="<?php echo $yinyuetai_url; ?>/search.css?t=2011110210" type="text/css" media="all" />
	<script type="text/javascript" src="<?php echo $yinyuetai_url; ?>/search.js?t=2011100413"></script>
	<script type="text/javascript">
		var yinyuetai_url = '<?php echo $yinyuetai_url; ?>';
		var site_url = '<?php bloginfo('url'); ?>';
	</script>
	<div class="search_box">
		<div class="box_title cl">
			<h2><span class='active' id="span1" onclick="show_tab(1,1,3);" >插入MV</span><span id="span2" onclick="show_tab(2,1,3);" >插入悦单</span></h2>
		</div>
		<div class="box_content" id="tab1">
			<div class="search_form_wrapper">
				<label>请输入关键字：</label><input type="text" name="keyword" class="text search_text" onkeypress="search_press('tab1',event)" /><input type="submit" value="搜索" class="button" id="search_submit" onclick="search_submit('tab1',1);" />
			</div>
			<div class="search_result_wrapper cl">
				<div class="search_result">
				</div>
				<p class="search_result_blank">MV</p>
			</div>
			<div class="submit_wrapper cl">
				<span class="submit_options tumblog_option">
					<label>插入到：</label>
					<select class="tumblog_select" name="tumblog" type="select" onchange="toggle_shortcode('tab1')">
						<option value="0">Tumblog&nbsp;</option>
						<option value="1">正文中</option>
					</select>
				</span>
				<span class="submit_options auto_option">
					<input name="auto" type="checkbox" /> <label>自动播放</label>
				</span>
				<span class="submit_options shortcode_option">
					<input name="shortcode" type="checkbox" /> <label>使用缩略代码</label>
				</span>
				<input class="submit_button button-primary" type="button" value="确定" onclick="insert_code('tab1')" />
			</div>
		</div>
		<div class="box_content none" id="tab2">
			<div class="search_form_wrapper">
				<label>请输入关键字：</label><input type="text" name="keyword" class="text search_text" onkeypress="search_press('tab2',event)" /><input type="submit" value="搜索" class="button" id="search_submit" onclick="search_submit('tab2',1);" />
			</div>
			<div class="search_result_wrapper cl">
				<div class="search_result">
				</div>
				<p class="search_result_blank">悦单</p>
			</div>
			<div class="submit_wrapper cl">
				<span class="submit_options tumblog_option">
					<label>插入到：</label>
					<select class="tumblog_select" name="tumblog" type="select" onchange="toggle_shortcode('tab2')">
						<option value="0">Tumblog&nbsp;</option>
						<option value="1">正文中</option>
					</select>
				</span>
				<span class="submit_options auto_option">
					<input name="auto" type="checkbox" /> <label>自动播放</label>
				</span>
				<span class="submit_options shortcode_option">
					<input name="shortcode" type="checkbox" /> <label>使用缩略代码</label>
				</span>
				<input class="submit_button button-primary" type="button" value="确定" onclick="insert_code('tab2')" />
			</div>
		</div>
	</div>
			
</body>

