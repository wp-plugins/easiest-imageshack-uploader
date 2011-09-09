<?php

/*
 Info for WordPress:
 ==============================================================================
 Plugin Name: Easiest Imageshack Uploader
 Plugin URI: http://anthony.strangebutfunny.net/my-plugins/imageshack-uploader/
 Description: Allows you to upload images to ImageShack.com directly from your posting screen.
 Version: 1.0
 Author: Alex and Anthony Zbierajewski
 Author URI: http://www.strangebutfunny.net/

*/

class ImageShack {
	
	var $mode = "wp25";
	
	function ImageShack() {
		
		global $wp_version;
		
		if(version_compare($wp_version,"3.1",">=")) {
			$this->mode = "wp25";
		} else {
			$this->mode = "wp21";
		}
		if($this->mode == "wp25") {
			add_filter("media_upload_tabs",array(&$GLOBALS["is_instance"],"HtmlAddTab"));
			add_action('media_upload_imageshack',array(&$GLOBALS["is_instance"],"HtmlGetTab"));
		} else {
			add_filter("wp_upload_tabs",array(&$GLOBALS["is_instance"],"HtmlAddTab"));
		}
		
	}
	
	function Enable() {
		if(!isset($GLOBALS["is_instance"])) {
			
			$GLOBALS["is_instance"]=new ImageShack();
			
		}
	}

	
	function HtmlAddTab($tabs) {
		if($this->mode=="wp25") {
			$tabs['imageshack'] = __("ImageShack","imageshack");
		} else {
			//0 => tab display name, 1 => required cap, 2 => function that produces tab content, 3 => total number objects OR array(total, objects per page), 4 => add_query_args
			$tabs["imageshack"]=array(__("ImageShack","imageshack"),"edit_posts",array($this,"HtmlPrintTab"),0);
		}
		
		return $tabs;
	}
	
	function HtmlGetTab() {
		return wp_iframe( array(&$this,'HtmlPrintTab'),'image', array() );
	}
	
	function HtmlPrintTab($type = 'image', $errors = null, $id = null) {
		if($this->mode=="wp25") {
			//media_admin_css();
			media_upload_header();
		
			$post_id = intval($_REQUEST['post_id']);

			$form_action_url = get_option('siteurl') . "/wp-admin/media-upload.php?type=$type&tab=imageshack&post_id=$post_id";
		} else {
			$form_action_url = get_option('siteurl') . "/wp-admin/upload.php?style=inline&amp;tab=imageshack";
		}
	
		?>
		<script type="text/javascript">
			function imageshack_insert(img,link) {
			

			
				if(!img) return;
				h = '';
				if(link) {
					h+='<a href="' + link + '">';
				}
				h+='<img src="' + img + '" border="0" alt="ImageShack" />';
				if(link) {
					h+='</a>';
				}
				<?php if($this->mode=="wp25"): ?>
				
				top.send_to_editor(h);
				top.tb_remove();
				return;
				
				<?php else: ?>
				
				var win = window.opener ? window.opener : window.dialogArguments;
				if ( !win )
					win = top;
				tinyMCE = win.tinyMCE;
				if ( typeof tinyMCE != 'undefined' && tinyMCE.getInstanceById('content') ) {
					tinyMCE.selectedInstance.getWin().focus();
					tinyMCE.execCommand('mceInsertContent', false, h);
				} else
					win.edInsertContent(win.edCanvas, h);
				<?php endif; ?>
			}
		</script>
		<div style="padding:10px;">
		<b>Note:</b> If you are logged into Imageshack, this image will be added to your pictures. This will work with pictures and videos.<br />
			<script src="http://imageshack.us/scripts/syndicate/widget.js" type="text/javascript" charset="utf-8"></script><script type="text/javascript">new ImageShackSyndicateWidget({width: "300",height: "110",theme: {shell: {buttonColor: "#1775a1",color: "#000000",backgroundColor: "#ffffff",backgroundImage: "",text: "Select photos and videos to upload."}}}).render();</script>
	<br />This opens in a new window, just copy the direct link to the image/video, and close this dialog
		</div>
		<?php
	}
	
}

ImageShack::Enable();

?>