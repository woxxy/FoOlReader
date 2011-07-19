<?php

// function to return a string "comicname - chaptername"
function fr_selected_manga_title(){
	return fr_selected_comic()." – ".fr_selected_chapter();
}

// makes a link to the currently selected chapter
function fr_selected_manga_title_url(){
	return '<a href="'.fr_get_href(fr_selected_comic()).'">'.fr_selected_comic().'</a> – <a href="'.fr_get_href(fr_selected_comic(), fr_selected_chapter()).'">'.fr_selected_chapter().'</a>';
}

// shows a dropdown menu with a list of the comics currently present in the reader
function fr_dropdown_comics(){
			echo '<div class="selector2" onclick="toggleMenu(this)">manga: '.fr_selected_comic();
			echo '<div class="options">';
        	foreach(fr_available_comics() as $key=>$value){
        		echo "<a title='".$value."' href='".fr_get_href($value)."'><div class='option'>$value</div></a>";
        	}
        	echo '</div></div>';
	}

// shows a dropdown menu with a list of the chapters of the currently selected chapter
function fr_dropdown_chapters(){
			if (fr_selected_comic() == "") return;
			echo '<div class="selector" onclick="toggleMenu(this)">chapter: '.fr_selected_chapter();
			echo '<div class="options">';
			$temp = fr_available_chapters();
			sort($temp);
            foreach($temp as $key=>$value){
            	echo "<a title='".fr_selected_chapter()." - ".$value."' href='".fr_get_href(fr_selected_comic(), $value)."'><div class='option'>$value</div></a>";
            }
            echo '</div></div>';
	}
	
// this works for the chapters picker ON THE NAVI stay with white color, if you have another suggestion for how to do that, good luck.
function fr_dropdown_chapters_2(){
			if (fr_selected_comic() == "") return;
			echo '<div class="selector2" onclick="toggleMenu(this)">chapter: '.fr_selected_chapter();
			echo '<div class="options">';
			$temp = fr_available_chapters();
			sort($temp);
            foreach($temp as $key=>$value){
            	echo "<a title='".fr_selected_chapter()." - ".$value."' href='".fr_get_href(fr_selected_comic(), $value)."'><div class='option'>$value</div></a>";
            }
            echo '</div></div>';
	}
		
// shows a list of available comics, as seen in the index page
function fr_list_comics(){
	global $fr_contentdir, $fr_selected_comic;
	$temp = array();
	if ($fr_selected_comic == "") $temp = fr_available_comics();
	else  $temp[0] = $fr_selected_comic;
	echo '<div class="theList">';
		foreach($temp as $key=>$value){
			$fr_selected_comic = $value;
			fr_get_chapters();
			$temp_chapters = fr_available_chapters();
        		echo "<div class='listed'>";
        		if(!empty($temp_chapters)) fr_dropdown_chapters();
        		echo "<a href='".fr_get_href($value)."'><table class='thumb'><tr><td><img src='".fr_get_comic_thumb($value)."'/></td></tr></table></a>".
        		"<a href='".fr_get_href($value)."'><h3 class='title'>".$value."</h3></a>";
        		if(!empty($temp_chapters)) echo  "<a href='".fr_get_href($value, max(fr_available_chapters()))."'> <h5 class='ultimo'> Last release: ".max(fr_available_chapters())." »</h5></a>";
        		else echo "No chapters available.";
        		echo "<br/><div class='descrip'>".fr_get_comic_description($value)."</div>".
        		"</div>";
        	}
	echo '</div>';
}
	
	
// shows a list of chapters, and basically builds the page "?manga=manganame"
function fr_list_chapters(){
	fr_list_comics();
	echo '<div class="theList">';
	$temp = fr_available_chapters();
	if(!empty($temp))
	foreach($temp as $key=>$value){
		echo '<div class="chapter"><b>'.$value.'</b><div style="float:right; color:#43c8f0;"><a href="'.fr_get_href(fr_selected_comic(),$value).'">Read</a></div></div>';
	}
	else echo "No chapters available.";
	echo '</div>';
}

// shows the preloading bar just over the actual page
function fr_show_loading(){
	echo '<div id="loadingbar"><table><tr>';
	$fr_available_pages_number = sizeof(fr_available_pages());
	
	foreach(fr_available_pages() as $key=>$value){
		
		echo '<td class="';
				if ($key+1 == fr_selected_page()) echo 'loadblue';
		echo '"><a class="loaded'.($key+1).'" onclick="loadImage('.($key+1).'); return false;" href="'.fr_get_href(fr_selected_comic(), fr_selected_chapter(), $key+1).'">';
	
		if( ($key+1) < 10 && $fr_available_pages_number > 9 && $fr_available_pages_number < 100)
			echo '0'.($key+1);
		else if( ($key+1) < 10 && $fr_available_pages_number > 99)
			echo '00'.($key+1);
		else if( ($key+1) > 9 && ($key+1) < 100 && $fr_available_pages_number > 99)
			echo '0'.($key+1);
		else
			echo ($key+1);
			
		echo '</a></td>';
		}
	echo '</table></div>';
}

// displays the actual image of the page, usually found just under the preloading bar
function fr_show_page(){
	global $fr_contentdir;
	$temp_avail = fr_available_pages();
	if (empty($temp_avail)) 
		{
			echo '<div class="theList">This chapter has no pages available.</div>';
			return;
		}
	echo '<div id="theManga"><div id="thePic"><a href="';
	if ((fr_selected_page() != count($temp_avail))) echo fr_get_href(fr_selected_comic(), fr_selected_chapter(), fr_selected_page() + 1);
	else {
			$temp = fr_available_chapters();
			sort($temp);
			$key = array_search(fr_selected_chapter(), $temp);
			$key++;
			echo fr_get_href(fr_selected_comic(), $temp[$key], "1");
			if ($temp[$key] == null) echo "&last";
		}
	echo '" id="thePicLink"><img alt="'.fr_selected_manga_title().'" src="'.fr_get_image_href(fr_selected_comic(), fr_selected_chapter(), $temp_avail[fr_selected_page() - 1]).'"/></a></div></div>';
}

// shows a wide advertising box
function fr_show_ads($num)
{
if ($num==1) $source = "ads/adtop.html";
if ($num==2) $source = "ads/adtop2.html";
if ($num==3) $source = "ads/adbottom.html";
if (strlen(file_get_contents($source)) > 75)

echo'<div id="ad'.$num.'" class="ads">
		<div class="adinside">
			<iframe class="iframead" src='.$source.'></iframe>
		</div>
	</div>';
}

?>