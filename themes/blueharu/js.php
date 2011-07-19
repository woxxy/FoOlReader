
<script type="text/javascript">
var justloaded = true;
var current = <?php if (isset($_GET['page'])){ echo $_GET['page'];} else {echo '1';} ?>;

jQuery(document).ready(function() {

		jQuery(document).scroll(function(){
			//jQuery("html").stop(true,false);
		});
		
		jQuery(document).keyup(function(e){
			if(e.keyCode==37) 
				if (!isSpread) prevImage();
				else 
					{
						if(e.timeStamp - timeStamp37 < 400) prevImage();
						timeStamp37 = e.timeStamp;
					}
			if(e.keyCode==39) 
				if (!isSpread) nextImage();
				else 
					{
						if(e.timeStamp - timeStamp39 < 400) nextImage();
						timeStamp39 = e.timeStamp;
					}
		});

		timeStamp37 = 0;
		timeStamp39 = 0;
		isSpread = false;
		loadImage(current);
		justloaded = false;
		jQuery.cacheImage("themes/default/images/ajax-loader.gif");
		
		
		
		var currentPage = current;
		
		jQuery(window).bind( 'hashchange', function(e) {
					var hashpage = jQuery.bbq.getState('page');
					if (hashpage != current){
						loadImage(hashpage);
						currentPage = hashpage;
						}
					});
		
		
		});





imageArray = new Array();
heightArray = new Array();
widthArray = new Array();
<?php
	global $fr_contentdir, $fr_baseurl;
		foreach(fr_available_pages() as $key=>$value){
			list($fr_img_width, $fr_img_height, $fr_img_type, $fr_img_attr) = getimagesize($fr_contentdir."/".addslashes(fr_selected_comic())."/".addslashes(fr_selected_chapter())."/".addslashes($value));
			echo "imageArray[$key]='".$fr_contentdir."/".addslashes(fr_selected_comic())."/".addslashes(fr_selected_chapter())."/".addslashes($value)."';\n";
			echo "heightArray[$key]='".$fr_img_height."';\n";
			echo "widthArray[$key]='".$fr_img_width."';\n";
		}
		?>
		

function loadImage(num){
	if (num < 1) return;
	if (num > imageArray.length) {<?php
				
                    foreach(fr_available_chapters() as $key=>$value){
                        if ($value == fr_selected_chapter()){
                        	$thekey = $key;
                                } }
                                if ($thekey > 0){
                                	$fr_available_chapters_temp = fr_available_chapters();
                                	echo "location.href = \"".$fr_baseurl.fr_get_href(fr_selected_comic(),$fr_available_chapters_temp[$thekey-1])."\"";
                                }
                                else echo 'location.href = "'.fr_get_href(fr_selected_comic()).'&last"';

                	?>};
	if (num <= imageArray.length) current = num;
	if (widthArray[num-1] > 900 && widthArray[num-1]/heightArray[num-1] > 1.2) {
			jQuery("#thePic").css("width", widthArray[num-1]);
			jQuery("#theManga").css("width",widthArray[num-1]);
			isSpread = true;
			}
		else{
			  jQuery("#thePic").attr('style', '');
			  jQuery("#theManga").attr('style','');
			  isSpread = false;
		}
	var pageState = {};
	pageState['page'] = num;
	jQuery.bbq.pushState({page : num});
	infoSpread(isSpread);
	jQuery("#thePic img").remove();
	jQuery("#thePic a").html("<img src='themes/default/images/ajax-loader.gif' />")
	jQuery("#thePic img").attr("src", imageArray[num-1]);
	jQuery("#ad1 .iframead").attr("src","ads/adtop.html");
	jQuery("#ad2 .iframead").attr("src","ads/adtop2.html");
	jQuery("#ad3 .iframead").attr("src","ads/adbottom.html");
	jQuery(".loadblue").removeClass("loadblue");
	jQuery(".loaded"+num).parent().addClass("loadblue");
	theCurrent = parseInt(current) + 1;
	jQuery("#thePicLink").attr("onClick","loadImage(" + (theCurrent) + "); return false;");
	jQuery("html, body").stop(true,true);
	if (!justloaded) jQuery.scrollTo("#loadingbar",300, {offset:{top: 0, left:1000000000}});
	cacheTheImage(num);
	}

function cacheTheImage(num, stop){
nums = new Array();

jj = 0;

<?php global $fr_settings_preload_backwards, $fr_settings_preload_forward; 
	$fr_settings_preload_forward_half = $fr_settings_preload_forward/2;
?>

for (j = -<?php echo $fr_settings_preload_backwards; ?>; j < <?php echo $fr_settings_preload_forward_half; ?>; j++) {
	nums[jj++] = num + j;
	}

	jQuery.each(nums, function(idx, val)
		{						
		if (val>-1 && (val<((imageArray.length)+1))){
			jQuery.cacheImage(imageArray[val-1], {
						load: function(){
						jQuery(".loaded" + val).parent().addClass("loadgreen");
						if (idx == <?php echo $fr_settings_preload_forward_half; ?> && !stop) {
							cacheTheImage(num + <?php echo $fr_settings_preload_forward_half; ?>, true);
						}
						}
										});
										}
	});
}
			

	
function prevImage(){
	current--;
		loadImage(current);
}
		
function nextImage(){
	current++;
		loadImage(current);
}
		
function hideShareBox(){
	jQuery('#sharebox').hide();
}

function infoSpread(status){
	if(status)
	jQuery('#infoSpread').slideDown();
	if(!status)
	jQuery('#infoSpread').slideUp();
}
</script>

