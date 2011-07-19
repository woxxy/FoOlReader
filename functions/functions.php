<?php

/***

This file contains only base functions that run FoOlReader. 
Most of them are just value returns to avoid using globals.
The first part is dedicated to fetching the comics, chapters and pages.
The second part is about theme connectors.
***/





// we don't want this file to be opened as stand-alone. This will kill the execution on open.
IF(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
    exit(1);

/*******
Arraycontains checks if the value is present in the Array
*******/
function arraycontains($array, $check){
		foreach($array as $key=>$value){
			if($value==$check) return true;
		}
		return false;
	}

/*******
This reads the comics available in the folder and returns an array with the names of the folders.
The names of the folders are always the name of the comic.
*******/
function fr_fetch_comics(){
		global $fr_contentdir;
		$fr_dirhandler = opendir($fr_contentdir);
			$fr_comiclist = array();
			$fr_comiclength = 0;
			while ($fr_file = readdir($fr_dirhandler)) 
				{
   					if (preg_match("/^[^\.]/",$fr_file)){
					$fr_comiclist[$fr_comiclength] = $fr_file;
					$fr_comiclength++;
				}
		}
		sort($fr_comiclist);
		return $fr_comiclist;
	}
	
/*******
This reads the chapters available in the comic folder and returns an array with the available chapters.
The name of the folder is always the name of the chapter.
*******/
function fr_fetch_chapters($fr_manga){
		global $fr_contentdir;
		if (is_dir($fr_contentdir."/".$fr_manga)) $fr_dirhandler = opendir($fr_contentdir."/".$fr_manga);
		$fr_chapterlist = array();
		$fr_chapterlength = 0;
		while ($fr_file = readdir($fr_dirhandler)) 
			{
		   		if ($fr_file != "description.txt" && !preg_match("/thumb\.(jpg|png)/i",$fr_file) && preg_match("/^[^\.]/",$fr_file)){
				$fr_chapterlist[$fr_chapterlength] = $fr_file;
				$fr_chapterlength++;
			}
		}
		rsort($fr_chapterlist);
		return $fr_chapterlist;
	}
	
/*******
This gets the description contained in the comic's folder, called description.txt
*******/
function fr_get_comic_description(){
	global $fr_contentdir;
		if(file_exists($fr_contentdir."/".fr_selected_comic()."/description.txt")) return file_get_contents($fr_contentdir."/".fr_selected_comic()."/description.txt");
		return "";
	}

/*******
This gets the URL for the thumbnail image contained in the comic's folder, called either thumb.png or thumb.jpg.
If both exist, it will return the .png version. In case the thumb file is not present, it will show the first page of the latest chapter.
If either the comic's folder is empty or the latest chapter is empty, and no thumb is present, it will show a "No preview available" image.
*******/
function fr_get_comic_thumb(){
	global $fr_contentdir, $fr_selected_chapter, $fr_selected_page;
		if (file_exists('./themes/'.fr_selected_theme().'/images/no-preview-available.png')) $nopreview = 'themes/'.fr_selected_theme().'/images/no-preview-available.png';
			else $nopreview = "themes/default/images/no-preview-available.png";
		if(file_exists($fr_contentdir."/".fr_selected_comic()."/thumb.png")) return (rawurlencode($fr_contentdir)."/".rawurlencode(fr_selected_comic())."/thumb.png");
		else if (file_exists($fr_contentdir."/".fr_selected_comic()."/thumb.jpg")) return (rawurlencode($fr_contentdir)."/".rawurlencode(fr_selected_comic())."/thumb.jpg");
		else {
			$temp = fr_get_chapters();
			if(!empty($temp)) 
				{
					$fr_thechapter = max(fr_get_chapters());
					$temp2 = fr_fetch_pages(fr_selected_comic(), $fr_thechapter);
					if (empty($temp2)) return $nopreview;
					$fr_thepage = min($temp2);
					return (rawurlencode($fr_contentdir)."/".rawurlencode(fr_selected_comic())."/".rawurlencode($fr_thechapter)."/".rawurlencode($fr_thepage));
				}
			else return $nopreview;
	}
}

/*******
This reads the pages available in the chapter folder and returns an array with the available pages.
*******/
function fr_fetch_pages($fr_manga, $fr_chapter){
		global $fr_contentdir;
		$fr_dirhandler = opendir($fr_contentdir."/".$fr_manga."/".$fr_chapter);
		$fr_pagelist = array();
		$fr_pagelength = 0;
		while ($fr_file = readdir($fr_dirhandler)) 
			{
   				if (preg_match("/([\w]|[\W])+\.(jpg|png)/i",$fr_file)){
				$fr_pagelist[$fr_pagelength] = $fr_file;
				$fr_pagelength++;
			}
		}
		sort($fr_pagelist);
		return $fr_pagelist;
	}
	


// returns the currently selected comic as a string
function fr_selected_comic()
{
	global $fr_selected_comic;
	return $fr_selected_comic;
}
// returns the currently selected chapter as a string
function fr_selected_chapter()
{
	global $fr_selected_chapter;
	return $fr_selected_chapter;
}

// returns the currently selected page as a string (always a number)
function fr_selected_page()
{
	global $fr_selected_page;
	return $fr_selected_page;
}

// returns the currently available comics as an array of strings
function fr_available_comics()
{
	global $fr_available_comics;
	return $fr_available_comics;
}

// returns the currently available chapters for the selected manga as an array of strings
function fr_available_chapters()
{
	global $fr_available_chapters;
	return $fr_available_chapters;
}

// returns the currently available pages for the selected chapter as an array of strings (always numbers)
function fr_available_pages()
{
	global $fr_available_pages;
	return $fr_available_pages;
}

	
	
// looks into the "content" folder and returns all the available manga as an array of strings
// it also caches it in the variable that you can call with fr_available_comics()
function fr_get_comics()
{
	global $fr_available_comics, $fr_next_comic;
	$fr_next_comic = 0;
	return $fr_available_comics = fr_fetch_comics();
}

// looks into the folder of the currently selected manga and returns all the available chapters as an array of strings
// it also caches it in the variable that you can call with fr_available_chapters()
function fr_get_chapters()
{
	global $fr_available_chapters, $fr_next_chapter;
	$fr_next_chapter = 0;
	return $fr_available_chapters = fr_fetch_chapters(fr_selected_comic());
}

// looks into the folder of the currently selected chapter and returns all the available pages as an array of strings (always numbers)
// it also caches it in the variable that you can call with fr_available_pages()
function fr_get_pages()
{
	global $fr_available_pages, $fr_next_page;	
	$fr_next_page = 0;
	return $fr_available_pages = fr_fetch_pages(fr_selected_comic(), fr_selected_chapter());
}

	
	
// creates the href for the links in the reader. It works both for normal GET urls as for the prettyurls
// currently prettyurls (url rewrite) are not yet implemented because it needs code both for nginx and apache servers
function fr_get_href($fr_comic, $fr_chapter = null, $fr_page = null, $fr_image = null)
{
	global $fr_settings_prettyurls;
	$fr_output = "";
	
	if ($fr_settings_prettyurls)
	{
		$fr_output = $fr_output.$fr_comic.'/';
		if ($fr_chapter != null)
		{
			$fr_output = $fr_output.$fr_chapter . '/';
			if ($fr_page != null)
			{
				$fr_output = $fr_output.$fr_page . '/';
			}
				
		}
	}
	else
	{
		$fr_output = '?manga='.urlencode($fr_comic);
		if ($fr_chapter != null)
		{
			$fr_output = $fr_output.'&chapter='.urlencode($fr_chapter);
			if ($fr_page != null)
			{
				$fr_output = $fr_output.'&page='.urlencode($fr_page);
			}
				
		}
	}
	return $fr_output;
}	
	
// creates the src link for any page. $fr_page must be an actual filename.
function fr_get_image_href($fr_comic, $fr_chapter, $fr_page){
	global $fr_contentdir;
	$fr_output = $fr_contentdir.'/';
	$fr_output = $fr_output.rawurlencode($fr_comic).'/';
		if ($fr_chapter != null)
		{
			$fr_output = $fr_output.rawurlencode($fr_chapter).'/';
			if ($fr_page != null)
			{
				$fr_output = $fr_output.rawurlencode($fr_page);
			}
				
		}

	return $fr_output;
}

	
// gives the base URL of the manga reader
function fr_get_url(){
	global $fr_baseurl;
	return 'http://'.$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"];
	}

// returns the name (folder) of the selected theme as a string
function fr_selected_theme()
{
	global $fr_selected_theme;
	return $fr_selected_theme;
}
	
// decides which file to include, when the non-default child theme doesn't have one of the files
function fr_theme_fallback($file)
{
	if (file_exists('./themes/'.fr_selected_theme().'/'.$file)) include('./themes/'.fr_selected_theme().'/'.$file);
	else include('./themes/default/'.$file);
}

// includes functions.php, wheter default or child theme
// this one contains all the theme functions that build up the reader
// differently from following functions, this isn't to be used by the theme itself, as it's called my init.php by the reader itself
function fr_get_functions()
{
	fr_theme_fallback("functions.php");
}

// includes header.php, wheter default or child theme
// this one is full of fr_html(...) functions, make sure you keep the search engine optimization alright!
function fr_get_header()
{
	fr_theme_fallback("header.php");
}

// includes comicSelect.php, wheter default or child them
// this page contains the thumbnails and the descriptions of each available comic
function fr_get_comicSelect()
{
	fr_theme_fallback("comicSelect.php");
}

// includes chapterSelect.php, wheter default or child theme
// this page contains the thumbnail and the descriptions of each selected comic

function fr_get_chapterSelect()
{
	fr_theme_fallback("chapterSelect.php");
}

// includes reader.php, wheter default or child theme
// this is the manga reader itself, where you browse pages
function fr_get_reader()
{
	fr_theme_fallback("reader.php");
}

// includes footer.php, wheter default or child theme.
// contains the very necessary credits.
function fr_get_footer()
{
	fr_theme_fallback("footer.php");
}


//spawns the error page, which is nothing but a div displaying text
function fr_get_error($error)
{
	global $fr_theme_error;
	switch($error)
	{
		case "missing_content_folder":
			$fr_theme_error = '"content" folder not found. Create a folder named "content" in the root of the reader.';
			break;
		case "no_comic_available":
			$fr_theme_error = 'There are no manga hosted at the moment.';
			break;			
	}
	fr_theme_fallback("error.php");
}

// includes js.php, wheter default or child theme
// always insert this in the <head>, else there will be no javascript effects and functions
function fr_html_js()
{
	fr_theme_fallback("js.php");
}

//selects the right style.css
function fr_html_style(){
	global $fr_baseurl, $fr_selected_theme;
	return "themes/".$fr_selected_theme."/style.css";
}

// function to return the title variable from settings.php
function fr_html_title(){
	global $fr_html_title;
	return $fr_html_title;
}

// function to return the description variable from settings.php
function fr_html_description(){
	global $fr_html_description;
	return $fr_html_description;
}

// function to return the keywords variable from settings.php
function fr_html_keywords(){
	global $fr_html_keywords;
	return $fr_html_keywords;
}	
	
?>