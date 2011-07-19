<?php fr_get_header(); ?>

	<?php echo fr_html_js(); ?>

<div id="theHead">
	<h2><?php echo fr_selected_manga_title_url(); ?></h2>

	<?php fr_show_loading(); ?>
</div>

<div id="infoSpread"><div class="text">Move with arrow keys. To go to the next or previous page with keyboard, just tap twice on the arrow key.</div></div>

<?php fr_show_ads(2); ?>


<?php fr_show_page(); ?>

<?php fr_get_footer(); ?>