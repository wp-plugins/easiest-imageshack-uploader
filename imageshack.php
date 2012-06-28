<?php
/*
 Info for WordPress:
 ==============================================================================
 Plugin Name: Easiest Imageshack Uploader
 Plugin URI: http://anthony.strangebutfunny.net/my-plugins/imageshack-uploader/
 Description: Allows you to upload images to ImageShack.com directly from your posting screen.
 Version: 3.0
 Author: Alex and Anthony Zbierajewski
 Author URI: http://www.strangebutfunny.net/
*/
function alex_imageshack_uploader(){
echo '		<h3 class="media-title">Upload stuff to ImageShack!</h3><b>Note:</b> If you are logged into Imageshack, this image will be added to your pictures. This will work with pictures and videos.<br />
			<script src="http://imageshack.us/scripts/syndicate/widget.js" type="text/javascript" charset="utf-8"></script><script type="text/javascript">new ImageShackSyndicateWidget({width: "300",height: "110",theme: {shell: {buttonColor: "#1775a1",color: "#000000",backgroundColor: "#ffffff",backgroundImage: "",text: "Select photos and videos to upload."}}}).render();</script>
	<br />This opens in a new window, just copy the direct link to the image/video, and close this dialog<br />Please visit my site <a href="http://www.strangebutfunny.net/">http://www.strangebutfunny.net/</a>';
}
add_action('post-upload-ui', 'alex_imageshack_uploader');
?>
