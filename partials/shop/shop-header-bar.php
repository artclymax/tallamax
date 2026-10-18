<?php
$exclude_term = get_term_by('slug', 'misc', 'product_cat');
$exclude_ids = $exclude_term ? [$exclude_term->term_id] : [];

$categories = get_terms([
	'taxonomy' => 'product_cat',
	'hide_empty' => false,
	'orderby' => 'menu_order',
	'order' => 'ASC',
	'parent' => 0,
	'exclude' => $exclude_ids,
]);

// Определяем текущий объект (категория или страница магазина)
$current_term_id = is_tax('product_cat') ? get_queried_object_id() : 0;
$is_shop_page = is_shop() || is_post_type_archive('product');

// Считаем количество товаров (учитывает примененные фильтры)
global $wp_query;
$found_products = isset($wp_query->found_posts) ? (int) $wp_query->found_posts : 0;
?>

<div class="shop-header-bar">
	<!-- Категории -->
	<div class="shop-header-bar__categories" data-aos="fade-up" data-aos-delay="100">
		<ul class="section-products__btn-list">
			<!-- Кнопка "Все средства" -->
			<li class="section-products__btn-item">
				<a class="section-products__btn link <?php echo $is_shop_page ? 'active' : ''; ?>"
					href="<?php echo esc_url(home_url('/shop/')); ?>">
					Все средства
				</a>
			</li>

			<!-- Категории -->
			<?php if (!empty($categories) && !is_wp_error($categories)): ?>
				<?php foreach ($categories as $cat): ?>
					<?php $is_active = ($current_term_id === (int) $cat->term_id); ?>
					<li class="section-products__btn-item">
						<a class="section-products__btn link <?php echo $is_active ? 'active' : ''; ?>"
							href="<?php echo esc_url(get_term_link($cat)); ?>">
							<?php echo esc_html($cat->name); ?>
						</a>
					</li>
				<?php endforeach; ?>
			<?php endif; ?>
		</ul>
	</div>

	<!-- Фильтр -->
	<div class="shop-header-bar__filter filter-box" data-aos="fade-up">
		<div class="filter-box__filter">
			<?php echo do_shortcode('[fe_widget]'); ?>
		</div>
		<a class="filter-box__btn" href="<?php echo esc_url(home_url('/shop/')); ?>">
			Сбросить фильтры
		</a>
	</div>

	<!-- Счетчик товаров -->
	<div class="shop-header-bar__counter eyebrow" data-aos="fade-up" data-aos-delay="100">
		Найдено: <?php echo esc_html($found_products); ?> <?php echo declension_products($found_products); ?>
	</div>
</div>