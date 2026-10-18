<?php
/**
 * Шаблон секции "С этим средством сочетается" (Cross-sells / Up-sells)
 * 
 * @var object $product Текущий товар WooCommerce
 */

global $product;
// Надёжное получение объекта товара
$product_obj = null;

if (is_singular('product') || is_product()) {
	$product_id = get_the_ID();
	$product_obj = wc_get_product($product_id);
}
$current_product_id = $product_obj->get_id();

// 1. Получаем данные из ACF (ручной выбор)
$acf_products = get_field('pairing_custom_products', $current_product_id) ?? [];

// 2. Получаем встроенные связанные товары WooCommerce
$cross_sell_ids = $product_obj->get_cross_sell_ids() ?? [];
$upsell_ids = $product_obj->get_upsell_ids() ?? [];
//$wc_related_ids = array_unique(array_merge($cross_sell_ids, $upsell_ids));

// 3. Определяем итоговый массив ID товаров
if (!empty($acf_products)) {
	// Если ACF настроен на возврат ID (рекомендуется)
	$target_ids = $acf_products;
} elseif (!empty($wc_related_ids)) {
	$target_ids = $wc_related_ids;
} else {
	$target_ids = []; // Триггер для рандомных товаров
}

// Настройки запроса
$page_id = get_the_ID();
$section_title = get_field('pairing_section_title', $page_id) ?: 'С этим средством сочетается';
$products_per_page = get_field('pairing_products_per_page', $page_id) ?? 8;
$section_decor = get_field('products_section_decor', $page_id) ?? false; // Используем общее поле декора

$products_args = [
	'post_type' => 'product',
	'posts_per_page' => $products_per_page,
	'post_status' => 'publish',
];

// Логика формирования запроса
if (!empty($target_ids)) {
	$products_args['post__in'] = $target_ids;
	$products_args['orderby'] = 'post__in'; // Сохраняем порядок из ACF или WooCommerce
} else {
	// Fallback: 8 случайных товаров, исключая текущий
	$products_args['orderby'] = 'rand';
	$products_args['post__not_in'] = [$current_product_id];
}

$products_query = new WP_Query($products_args);
?>

<?php if ($products_query->have_posts()): ?>
	<section class="section-full section-products section-pairing" id="section-pairing">
		<?php if (!empty($section_decor) && is_array($section_decor) && !empty($section_decor['ID'])): ?>
			<div class="section-decor" aria-hidden="true">
				<?php echo wp_get_attachment_image(
					$section_decor['ID'],
					'large',
					false,
					[
						'class' => 'img',
						'alt' => $section_decor['alt'] ?: ''
					]
				); ?>
			</div>
		<?php endif; ?>

		<div class="container section-products__container section-gap">
			<div class="section-products__header" data-aos="fade-up" data-aos-delay="100">
				<?php if ($section_title): ?>
					<h2 class="section-products__title title-2 descr">
						<?php echo wp_kses_post($section_title); ?>
					</h2>
				<?php endif; ?>
			</div>

			<div class="section-products__slider swiper-slider" data-aos="fade-up" >
				<div class="swiper products-swiper products-swiper--pairing"
					data-swiper='{ "slidesPerView": 2, "spaceBetween": 8, "rewind": true, "breakpoints": { "640": { "slidesPerView": 2.2, "spaceBetween": 16 }, "1024": { "slidesPerView": 3.5, "spaceBetween": 16 }, "1280": { "slidesPerView": 4, "spaceBetween": 24 } } }'>

					<div class="swiper-wrapper products-swiper__wrapper">
						<?php while ($products_query->have_posts()):
							$products_query->the_post(); ?>
							<div class="swiper-slide products-slide">
								<?php get_template_part('woocommerce/content-product'); ?>
							</div>
						<?php endwhile; ?>
					</div>
				</div>
				<div class="swiper-pagination swiper-slider__pagination visible-mobile"
					data-swiper-pagination=".products-swiper"></div>

			</div>
		</div>
	</section>
	<?php
	wp_reset_postdata();
endif;
?>