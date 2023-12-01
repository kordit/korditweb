<?php
if (get_the_post_thumbnail()) {
	if (!is_search()) {
		$bgimage = get_the_post_thumbnail_url();
	} else {
		$bgimage = get_the_post_thumbnail_url();
	}
} else {
	$bgimage = wp_get_attachment_image_url(get_field('background_image', 'options'), "full");
}
$bgcolor = get_field('background_color', 'options');
$fontcolor = get_field('font_color', 'options');
$fonttransform = get_field('font_transform', 'options');
if (!$bgimage) {
	$bgimage = 'none';
} else {
	$bgimage = 'url(' . $bgimage . ')';
}
if (!$bgcolor) {
	$bgcolor = 'transparent';
}
if (!$fontcolor) {
	$fontcolor = '#fff';
}
if (!$fonttransform) {
	$fonttransform = 'capitalize';
}
$post = get_post();
?>
.bg-header {
position: relative;
}
.bg-header .bg-image {
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 100%;
background-size: cover;
background-repeat: no-repeat;
z-index: 1;
background-image: <?= $bgimage; ?>;
}
.bg-header .bg-overlay {
position: absolute;
top: 0;
left: 0;
width: 100%;
height: 100%;
z-index: 2;
background-color: <?= $bgcolor; ?>;
}
.bg-header .my-container {
position: relative;
z-index: 3;
}
.bg-header .bg-title {
color: <?= $fontcolor; ?>;
text-transform: <?= $fonttransform; ?>;
}
.bg-header .bg-taxonomy-description {
color: <?= $fontcolor; ?>;
}