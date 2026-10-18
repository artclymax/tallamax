<?php
/**
 * Регистрация Custom Post Type "Отзывы"
 */
add_action('init', 'register_review_post_type');

function register_review_post_type()
{
	$labels = array(
		'name' => 'Отзывы',
		'singular_name' => 'Отзыв',
		'menu_name' => 'Отзывы',
		'add_new' => 'Добавить отзыв',
		'add_new_item' => 'Добавить новый отзыв',
		'edit_item' => 'Редактировать отзыв',
		'new_item' => 'Новый отзыв',
		'view_item' => 'Посмотреть отзыв',
		'search_items' => 'Найти отзыв',
		'not_found' => 'Отзывы не найдены',
		'not_found_in_trash' => 'В корзине отзывов не найдено',
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'review'),
		'capability_type' => 'post',
		'has_archive' => false,
		'hierarchical' => false,
		'menu_position' => 15,
		'menu_icon' => 'dashicons-format-quote',
		'supports' => array('title', 'thumbnail'),
		'show_in_rest' => true,
	);

	register_post_type('review', $args);
}