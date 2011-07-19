<?php fr_show_ads(3); ?>
<?php
global $fr_html_groupname, $fr_html_startyear;
$currentYear = date("Y");

if ($currentYear != $fr_html_startyear) $currentYear = $fr_html_startyear."-".$currentYear;

?>
<br />
<div id="theFooter">
<div id="" style="clear: both;"></div><br />
<div style="background: none repeat scroll #43c8f0; padding: 5px 5px 9px; margin: 5px 0pt 0pt;"></div>
<div style="background: #FFF; background: none repeat scroll 0% 0% rgba(255, 255, 255, 0.8); padding: 5px 5px 9px; margin: 0px 0pt 0pt;">
<div style="font-size: 10px; font-family: Arial; margin: 0pt 10px 0px; color:#333; line-height: 13px; width: 900px; text-align: left;" id="theverylastcredits"><small><? echo $fr_html_groupname." ".$currentYear; ?> 
<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/" style="color: rgb(170, 170, 170);"><img alt="Creative Commons License" style="border-width: 0pt; position: relative; top: 2px;" src="http://i.creativecommons.org/l/by-nc-sa/3.0/80x15.png"></a> This work is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/3.0/" style="color: rgb(170, 170, 170);">Creative Commons Attribution-NonCommercial-ShareAlike 3.0 Unported License</a>.

<br>
All the manga featured in this website are property of their publishers. The translations are fanmade and meant to be a preview of material unavailable for western countries. Do not try to profit from this material. If you liked any of the manga you obtained here, consider buying the Japanese versions, or the local translation, where available. Thanks for your support.
<br>
<div style=" text-align:left; font-size:11px;">Proudly <a title="Download or update your FoOlReader, made by FoOlRulez team"  style="color:#43c8f0" href="http://foolrulez.org/blog/foolreader">Powered by FoOlReader</a> | <a style="color:#43c8f0" title="FoOlRulez.org website" href="http://foolrulez.org">FoOlRulez.org</a> - Theme: <a style="color:#43c8f0" href="http://haru-ka.net/" target="_blank">BlueHaru</a> by <a style="color:#43c8f0" href="http://haru-ka.net/andrei" target="_blank">dHEKU</a>. Works best in a modern browser.</div>
</small></div>
</div>
</div>

</body></html>