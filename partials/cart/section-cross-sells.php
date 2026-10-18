<!-- Кросс-сейлы или случайные товары (слайдер) -->
<?php
$cross_sells = WC()->cart->get_cross_sells();
$cross_sell_ids = is_array($cross_sells) ? array_map('absint', $cross_sells) : [];

// Исключаем категорию misc
$exclude_term = get_term_by('slug', 'misc', 'product_cat');
$exclude_ids = $exclude_term ? [$exclude_term->term_id] : [];

// Получаем ID товаров в корзине, чтобы исключить их из случайной выборки
$cart_items = WC()->cart->get_cart();
$cart_product_ids = array_map(function ($item) {
	return $item['product_id']; }, $cart_items);

// Формируем запрос
if (count($cross_sell_ids) > 0) {
	// Кросс-сейлы из настроек товаров
	$products_args = [
		'post_type' => 'product',
		'post_status' => 'publish',
		'posts_per_page' => 4,
		'post__in' => $cross_sell_ids,
		'orderby' => 'post__in',
	];
	$section_title = __('С этим заказом сочетается', 'woocommerce');
} else {
	// Fallback: 8 случайных товаров, исключая товары из корзины и misc
	$products_args = [
		'post_type' => 'product',
		'post_status' => 'publish',
		'posts_per_page' => 8,
		'orderby' => 'rand',
		'post__not_in' => array_merge($cart_product_ids, $exclude_ids),
		'tax_query' => [
			[
				'taxonomy' => 'product_cat',
				'field' => 'term_id',
				'terms' => $exclude_ids,
				'operator' => 'NOT IN',
			],
		],
	];
	$section_title = __('С этим заказом сочетается', 'woocommerce');
}

$cross_sells_query = new WP_Query($products_args);
?>

<?php if ($cross_sells_query->have_posts()): ?>
	<section class="section section-products section-cross-sells" id="section-cross-sells">
		<div class="container section-products__container section-gap">

			<div class="section-products__header" data-aos="zoom-in-up">
				<h2 class="section-products__title title-2 descr">
					<?php echo esc_html($section_title); ?>
				</h2>
			</div>

			<div class="section-products__slider swiper-slider" data-aos="zoom-in-up">
				<div class="swiper products-swiper products-swiper--cross-sells"
					data-swiper='{ "slidesPerView": 2, "spaceBetween": 8, "rewind": true, "breakpoints": { "640": { "slidesPerView": 2.2, "spaceBetween": 16 }, "1024": { "slidesPerView": 3.5, "spaceBetween": 16 }, "1280": { "slidesPerView": 4, "spaceBetween": 24 } } }'>
					<div class="swiper-wrapper products-swiper__wrapper">
						<?php while ($cross_sells_query->have_posts()):
							$cross_sells_query->the_post(); ?>
							<div class="swiper-slide products-slide">
								<?php get_template_part('woocommerce/content-product'); ?>
							</div>
						<?php endwhile;
						wp_reset_postdata(); ?>
					</div>
				</div>
				<div class="swiper-pagination swiper-slider__pagination visible-mobile"
					data-swiper-pagination=".products-swiper--cross-sells"></div>
			</div>

		</div>
	</section>
<?php endif; ?>