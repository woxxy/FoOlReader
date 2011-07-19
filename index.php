<?php

/***

Copyright (C) 2011 by Woxxy (woxxy@foolrulez.org) and FoOlRulez

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

***/

session_start();

// sets UTF-8 on browser via headers. It's not always enough
header ('Content-type: text/html; charset=utf-8'); 
// checks if multibyte encoding is supported and enables UTF-8 in multybyte. Absolutely needed for Japanese characters.
if(function_exists("mb_internal_encoding")) mb_internal_encoding("UTF-8"); 
setlocale(LC_ALL, 'en_US.UTF8');

// sets magic quotes off (all inputs must be sanitized manually from now on).
ini_set('magic_quotes_runtime', 0);

// let's get a variable to know the absolute patch of the reader
$fr_base_path = dirname(__FILE__);

	// settings.php in the root folder contains very basical setup for the reader
	include('settings.php');
	
	// functions/init.php checks the URL query to select which page to show.
	// it also starts up some variables
	include('functions/init.php');

?>