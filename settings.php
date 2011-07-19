<?php

// select the theme
// available themes at fresh install: default, foolrulez, blueharu
// you can find PSDs of blueharu's banner in its image folder
// make sure you try all the themes to check which fits you best!
$fr_selected_theme = "default";

// your group's name.
$fr_html_groupname = "Generic group scans";

// the year your group was created. This goes in the credits of some themes.
$fr_html_startyear = "2010";

// website's name at the top of the screen
$fr_html_title = "manga reader";

// URL for "Go back to site ↵" link. Write it with full URL, in example: http://foolrulez.org/blog/
// if you don't write anything, the link simply won't appear.
$fr_html_back = "";

// website's description for search engines
$fr_html_description = "Manga reader";

// keywords for search engines (separate by a comma)
$fr_html_keywords = "manga, manga reader";

// pages to preload backwards
$fr_settings_preload_backwards = "2";

// pages to preload forward (prioritizes first half) (and don't be stingy)
$fr_settings_preload_forward = "6";




/*    This is a theme changer that can be used by adding ?theme=nameoftheme in the URL. Uncomment this section to use it.
if (isset($_GET['theme'])) 
{
	setcookie('theme', $_GET['theme'], time()+3600);
	$fr_selected_theme = $_GET['theme'];
}
else if (isset($_COOKIE['theme'])) $fr_selected_theme = $_REQUEST['theme'];
*/
?>