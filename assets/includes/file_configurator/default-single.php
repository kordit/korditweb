<?php
if (!isset($srctemplate)) {
	$srctemplate = '';
}
$singletemplate = '<?php include("config.php"); ?>' . PHP_EOL;
$singletemplate .= '<h1>' . $single_name_cpt . '</h1>' . PHP_EOL . 'Plik można edytować w <b>"' . $srctemplate . '/assets/template.php"</b>' . PHP_EOL . PHP_EOL;
$singletemplateconfig = '';

foreach ($stack_cpt[$single_name_cpt] as $single) {
	if ($single != 'post_format') {
		$my_name_term = str_replace('-', '_', $single);
		$singletemplateconfig .= '<?php ' . PHP_EOL;
		$singletemplateconfig .= '//Wyświetla wszystkie termy (' . $my_name_term . ')' . PHP_EOL;
		$singletemplateconfig .= '$all_terms_' . $my_name_term . ' = get_terms( array( ' . PHP_EOL;
		$singletemplateconfig .= '"taxonomy" => "' . $single . '", "hide_empty" => false) );';
		$singletemplateconfig .= PHP_EOL . PHP_EOL . '//Wyświetla aktualnie przypisanego terma (' . $my_name_term . ')' . PHP_EOL;
		$singletemplateconfig .= '$current_terms_' . $my_name_term . ' = get_the_terms( get_the_ID(), "' . $single . '" );' . PHP_EOL;

		$singletemplateconfig .= ' ?>' . PHP_EOL . PHP_EOL;
	}
}
$singletemplate .= '<?php the_post_thumbnail(); ?>' . PHP_EOL;
$singletemplate .= '<?php the_title(); ?>' . PHP_EOL;
$singletemplate .= '<?php the_content(); ?>' . PHP_EOL;
$singletemplate .= '<?= get_the_date(); ?>' . PHP_EOL;
$singletemplate .= '<?php $author = get_the_author_meta(); ?>' . PHP_EOL;
foreach ($stack_cpt[$single_name_cpt] as $single) {
	$my_name_term = str_replace('-', '_', $single);
	if ($single != 'post_format') {
		$singletemplate .= '<?php if($current_terms_' . $my_name_term . ') : ?>' . PHP_EOL;
		$singletemplate .= '<?php echo "<h2>" . get_taxonomy($current_terms_' . $my_name_term . '[0]->taxonomy)->label . ": </h2>"; ?>' . PHP_EOL;
		$singletemplate .= '<?php foreach ($current_terms_' . $my_name_term . ' as $single) {' . PHP_EOL . 'echo "<span>" . $single->name . "</span>";' . PHP_EOL . '}; ?>' . PHP_EOL;
		$singletemplate .= '<?php endif; ?>' . PHP_EOL;
		$singletemplate .= '<?php et_the_list_term($all_terms_' . $my_name_term . ',$current_terms_' . $my_name_term . '); ?>' . PHP_EOL;
	}
}
