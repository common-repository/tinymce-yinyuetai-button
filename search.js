function show_tab(theA,small,main){
	for(var i=small;i< main;i++ ){
		jQuery('#tab'+i).hide();
		jQuery('#span'+i).removeClass('active');
	}
	jQuery('#tab'+theA).show();
	jQuery('#span'+theA).addClass('active');
}

function search_submit(tab, page) {
	var keyword = jQuery.trim(jQuery('#'+tab+' .search_text').attr('value'));
	if(!keyword){
		alert('请输入关键字');
	}else{
		jQuery('#search_submit').attr('disabled', 'disabled');
		jQuery('#'+tab+' .search_result').html('<div id="TB_load" style="display: block;"><img src="'+site_url+'/wp-includes/js/thickbox/loadingAnimation.gif"></div>');
		jQuery.ajax({
			url:yinyuetai_url+'/ajax.php',
			data:'yinyuetai_url='+encodeURIComponent(yinyuetai_url)+'&keyword='+encodeURIComponent(keyword)+'&page='+page+'&tab='+tab,
			type:'POST',
			success:function(data){
				jQuery('#'+tab+' .search_result').html(data);
				jQuery('#'+tab+' .submit_wrapper').show();
				jQuery('#search_submit').removeAttr('disabled');
			}
		});
	}
}

function search_press(tab, event){
	var key = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
	if(key == 13){
		search_submit(tab, 1);
	}
}

function insert_code(tab){
	var code='';
	var id='';
	var auto=false;
	var tumblog=true;
	var shortcode='';
	if(jQuery('#'+tab+' input[name="auto"]').attr('checked')){
		auto = true;
	}
	if(jQuery('#'+tab+' select[name="tumblog"]').attr('value') == '1'){
		tumblog = false;
	}
	if(jQuery('#'+tab+' input[name="shortcode"]').attr('checked')){
		shortcode = true;
	}
	if(tab == 'tab2'){
		jQuery('input[name="id_list[]"]').each(function(){
			if(jQuery(this).attr('checked')){
				id = jQuery(this).attr('value');
				if(shortcode){
					code += '[yinyuetai playlist="'+id+'"'+(auto?' auto="1"':'')+']'+'悦单：'+jQuery.trim(jQuery(this).siblings('.title').find('a').html())+'[/yinyuetai]\r\n';
				} else {
					code += '<embed height="380" allowscriptaccess="always" style="visibility: visible;" pluginspage="http://get.adobe.com/cn/flashplayer/" flashvars="playMovie=true&amp;auto=1&amp;adss=0" width="560" allowfullscreen="true" quality="hight" src="http://www.yinyuetai.com/playlist/swf/' + id + '/1/' + (auto ? 'a' : 'v_0') + '.swf" type="application/x-shockwave-flash" wmode="transparent"' + (auto ? '' : ' onclick="this.src=\'http://www.yinyuetai.com/playlist/swf/'+id+'/1/a.swf\';this.onclick=function(){}"') +'></embed>'+'悦单：'+jQuery.trim(jQuery(this).siblings('.title').find('a').html())+'\r\n\r\n';
				}
			}
		});
	} else {
		jQuery('input[name="id_list[]"]').each(function(){
			if(jQuery(this).attr('checked')){
				id = jQuery(this).attr('value');
				if(shortcode){
					code += '[yinyuetai id="'+id+'"'+(auto?' auto="1"':'')+']'+'MV：'+jQuery.trim(jQuery('#'+tab+' #parent_per_'+id+' .mv_title a').html())+' -- '+jQuery.trim(jQuery('#'+tab+' #parent_per_'+id+' .artist a').html())+'[/yinyuetai]\r\n';
				} else {
					code += '<embed src="http://www.yinyuetai.com/video/player/' + id + '/' + (auto ? 'a_0' : 'v_0') + '.swf" quality="high" width="560" height="380" align="middle"  allowScriptAccess="sameDomain" type="application/x-shockwave-flash"></embed>'+'MV：'+jQuery.trim(jQuery('#'+tab+' #parent_per_'+id+' .mv_title a').html())+' -- '+jQuery.trim(jQuery('#'+tab+' #parent_per_'+id+' .artist a').html())+'\r\n\r\n';
				}
			}
		});
	}
	if(tumblog && jQuery('#woothemes_video-embed').length){
		jQuery('#woothemes_video-embed').attr('value',jQuery('#woothemes_video-embed').attr('value')+code);
		if(jQuery('#woothemes-settings').length){
			jQuery('#woothemes-settings').attr('class', jQuery('#woothemes-settings').attr('class').replace('closed',''));
		}
		if(jQuery('#tumblogchecklist').length){
			jQuery('#tumblogchecklist').find('input').each(function(){
				if(jQuery(this).parent('label')){
					if(jQuery(this).parent('label').html().search(/video/i) != -1){
						jQuery(this).attr('checked', true);
					}
				}
			});
		}
		jQuery('#woothemes_video-embed').focus();
		tb_remove();
	} else {
		var parent_window = window.dialogArguments || opener || parent || top;
		parent_window.send_to_editor(code);
	}
}

function toggle_shortcode(tab){
	if(jQuery('#'+tab+' select[name="tumblog"]').attr('value') == '1'){
		jQuery('#'+tab+' .shortcode_option').show();
	}else{
		jQuery('#'+tab+' .shortcode_option').hide();
		jQuery('#'+tab+' input[name="shortcode"]').attr('checked', false);
	}
}

jQuery('.search_box').ready(function(){
	if(!jQuery('#woothemes_video-embed').length){
		jQuery('select[name="tumblog"] option[value="0"]').attr('disabled', true);
		jQuery('select[name="tumblog"] option[value="1"]').attr('selected', true);
		jQuery('.shortcode_option').css('display', 'inline');
	}
});
