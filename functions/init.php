<?php

IF(__FILE__ == $_SERVER['SCRIPT_FILENAME'])
    exit(1);

	//----------- configs
	global $fr_contentdir;
	
	// change this to point to another folder containing the comics
	$fr_contentdir = "content"; 

	// if a page is not defined, start from 1
	$fr_startpage = 1;
	
	
	//----------- variables
	
	// let's create a baseurl, in case it's needed. This will point to the reader's root URL.
	$fr_folder = substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], "/")+1);
	$fr_baseurl = 'http://'.$_SERVER['HTTP_HOST'].$fr_folder;
	
	// let's initialize the 3 arrays always keeping the list of available files
	$fr_available_comics = array();
	$fr_available_chapters = array();
	$fr_available_pages = array();
	
	// out of the three arrays up here, these keep which file in the array is selected
	// if these variables are kept empty, the reader will show a proper page to go further in selection
	$fr_selected_comic = ""; 
	$fr_selected_chapter = "";
	$fr_selected_page = "1";
	
	// this finally loads all the functions needed to read the folders and fill the variables
	include('functions.php');

	// loads the functions that are specific for the currently selected theme
	fr_get_functions();
	
	// stops the script if there's no content folder at all, and tells to create one
	if (!is_dir($fr_contentdir)) {
			fr_get_error("missing_content_folder");
			die(0);
		}
	


	// reads the content folder and loads up all the available comics
	fr_get_comics();
	
	// if no comics were found, show that there are no comics in this reader
	if (empty($fr_available_comics)) {
			fr_get_error("no_comic_available");
			die(0);
		}
		
		// look in the URL query if there's a selected comic. If there is, keep going. Else, show a comic selection list.
		// if there's no match with the comic name, show the comic list.
		if(isset($_GET['manga']) && arraycontains(fr_available_comics(), stripslashes($_GET['manga']))){
			$fr_selected_comic = stripslashes($_GET['manga']);
		} else { fr_get_comicSelect(); exit(1);}
		
	// reads the comic's folder and loads up all the available chapters
	fr_get_chapters();

		// look in the URL query if there's a selected chapter. If there is, keep going. Else, show a chapter selection list.
		// if there's no match with the chapter name, show the chapter list.
		if(isset($_GET['chapter']) && arraycontains(fr_available_chapters(), stripslashes($_GET['chapter']))){
			$fr_selected_chapter = stripslashes($_GET['chapter']);
		} else { fr_get_chapterSelect(); exit(1);}
	
	// read the chapter's folder and load up all the available pages
	fr_get_pages();	
	
		// prepares an URL for the next chapter, that will be needed once the user reaches the last page of the chapter.
		if (($fr_next_chapter = array_search(fr_selected_chapter(), fr_available_chapters())-1) >= 0){
			$fr_next_chapter = $fr_baseurl.fr_get_href($fr_selected_comic, $fr_available_chapters[$fr_next_chapter]);
		} else {
			$nextchapter = $endmanga;
		}

		// look in the URL query if there's a selected page. If there is, show the reader with that page loaded. Else, show the first page.
		// if the page number selected is higher than the available page number, it will just show the first page.
		if(isset($_GET['page']) && ($_GET['page'] >= 1) && ($_GET['page'] <= sizeof(fr_available_pages())) ) $fr_selected_page = $_GET['page'];	
	
	// finally, load the reader page.
	fr_get_reader();
?>