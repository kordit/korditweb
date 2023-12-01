<?php
/* Inicjacja widżetów */

function et_widgets_init()
{
	register_sidebar(array(
		'name' => esc_html__('Sidebar 1', 'Ergotree'),
		'id' => 'sidebar-1',
		'description' => esc_html__('Sidebar widget 1', 'Ergotree'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
	));

	register_sidebar(array(
		'name' => esc_html__('Sidebar 2', 'Ergotree'),
		'id' => 'sidebar-2',
		'description' => esc_html__('Sidebar widget 2', 'Ergotree'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
	));

	register_sidebar(array(
		'name' => esc_html__('Sidebar 3', 'Ergotree'),
		'id' => 'sidebar-3',
		'description' => esc_html__('Sidebar widget 3', 'Ergotree'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
	));
	register_sidebar(array(
		'name' => esc_html__('Sidebar 4', 'Ergotree'),
		'id' => 'sidebar-4',
		'description' => esc_html__('Sidebar widget 4', 'Ergotree'),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
	));
}

add_action('widgets_init', 'et_widgets_init');
