<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">


<head>
	<title><?php echo fr_html_title(); ?> | <?php echo fr_selected_manga_title(); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="description" content="<?php echo fr_selected_manga_title(); echo fr_html_description(); ?>, Powered by FoOlReader." />
	<meta name="keywords" content="FoOlReader, <?php echo fr_selected_manga_title(); echo fr_html_keywords(); ?>" />
	<meta name="generator" content="FoOlReader 1.0" />
	<link rel="canonical" href="<?php global $fr_baseurl; echo $fr_baseurl;?>" />
	<link href="<?php echo fr_html_style(); ?>" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="js/jquery.js"></script>
	
<script type="text/javascript">
function toggleMenu(that)
{
	jQuery(".options").not(jQuery(that).find(".options")).hide();
	jQuery(".selector").not(that).removeClass("selector-active");
	jQuery(".options").not(jQuery(that).find(".options")).removeClass("options-active");
	jQuery(that).find(".options").toggle();
	jQuery(that).toggleClass("selector-active");
	jQuery(that).find(".options").toggleClass("options-active");
}

jQuery(document).ready(function(){

	jQuery(".selector").each(function(){
		if (jQuery.browser.msie) {
   			this.onselectstart = function () { return false; };
		} else
		{
    		this.onmousedown = function(e){e.preventDefault()}
    	}
	});
	
	jQuery('body').click(function() {
		jQuery(".options").hide();
		jQuery(".selector").removeClass("selector-active");
		jQuery(".options").removeClass("options-active");
	});

 	jQuery('.selector').click(function(event){
  	   event.stopPropagation();
 	});
});
</script>
</head>


<body>

<div id="navig">
	<a href="<?php echo $fr_baseurl;?>"><h1 id="title"><?php echo fr_html_title(); ?></h1></a> 
		<?php global $fr_html_back; if($fr_html_back != "") echo'<div style="float:left; margin:2px 5px 0; padding-top:6px; font-size:11px;"><a href="'.$fr_html_back.'">Go back to site &crarr;</a></div>'; ?>
	
			<?php fr_dropdown_comics(); ?>
			<?php fr_dropdown_chapters(); ?>			
	<div class="clearer"></div>	
</div>



<?php fr_show_ads(1); ?>



