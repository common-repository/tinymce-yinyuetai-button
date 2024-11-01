<?php
/*
Plugin Name: TinyMCE Yinyuetai Button
Description: Add a button to TinyMCE Editor to search and insert videos into post from yinyuetai. 在TinyMCE编辑器中添加一个按钮，可搜索并插入音悦台的MV或悦单至文章中。
Version: 1.1
Author: 扯蛋
Plugin URI: http://www.chedan.in/yinyuetai.html
Author URI: http://www.chedan.in/
License: GPLv2 or later
*/

/*
This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, write to the Free Software Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/

function yinyuetai_shortcode($atts, $content = NULL ){
	$atts_init = array( 'id' => '', 'playlist' => '', 'auto' => '' );
	extract(shortcode_atts($atts_init, $atts));
	if($id){
		return '<embed src="http://www.yinyuetai.com/video/player/' . $id . '/' . ($auto ? 'a_0' : 'v_0') . '.swf" quality="high" width="560" height="380" align="middle"  allowScriptAccess="sameDomain" type="application/x-shockwave-flash"></embed>' . $content . '<br />';
	}elseif($playlist){
		return '<embed height="380" allowscriptaccess="always" style="visibility: visible;" pluginspage="http://get.adobe.com/cn/flashplayer/" flashvars="playMovie=true&amp;auto=1&amp;adss=0" width="560" allowfullscreen="true" quality="hight" src="http://www.yinyuetai.com/playlist/swf/' . $playlist . '/1/' . ($auto ? 'a' : 'v_0') . '.swf" type="application/x-shockwave-flash" wmode="transparent"' . ($auto ? '' : ' onclick="this.src=\'http://www.yinyuetai.com/playlist/swf/' . $playlist . '/1/a.swf\';this.onclick=function(){}"') . '></embed>' . $content . '<br />';
	}
}
add_shortcode('yinyuetai', 'yinyuetai_shortcode');

function yinyuetai_button(){
	$yinyuetai_url = WP_PLUGIN_URL . '/' . plugin_basename(dirname(__FILE__));
	echo '<a href="' . $yinyuetai_url . '/search.php?width=640&height=550" class="thickbox" title="插入音悦台MV或悦单" ><img src="' . $yinyuetai_url . '/yinyuetai.png" alt="插入音悦台MV或悦单" /></a>';
}
add_action('media_buttons', 'yinyuetai_button', 20);

?>
