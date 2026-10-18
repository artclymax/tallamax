<?php
defined('ABSPATH') || exit;

global $product;

if (!is_a($product, WC_Product::class) || !$product->is_visible()) {
	return;
}
$product_id = $product->id;
$product_id = get_the_ID();
$product_title = get_the_title();
$product_link = get_permalink($product_id);
$product_excerpt = get_the_excerpt();

// Атрибут pa_ritual
$ritual_terms = get_the_terms($product_id, 'pa_ritual');
$ritual_name = '';
$ritual_link = '';
if ($ritual_terms && !is_wp_error($ritual_terms)) {
	$ritual_term = $ritual_terms[0];
	$ritual_name = $ritual_term->name;
	$ritual_link = get_term_link($ritual_term);
}

// Атрибут pa_obem
$obem_terms = get_the_terms($product_id, 'pa_obem');
$obem_value = '';
if ($obem_terms && !is_wp_error($obem_terms)) {
	$obem_value = $obem_terms[0]->name;
}

// Категория продукта
$product_cats = get_the_terms($product_id, 'product_cat');
$product_cat_name = '';
$product_cat_link = '';
if ($product_cats && !is_wp_error($product_cats)) {
	$product_cat = $product_cats[0];
	$product_cat_name = $product_cat->name;
	$product_cat_link = get_term_link($product_cat);
}
?>
<div <?php wc_product_class('product-card', $product); ?> data-aos="fade-up">
	<!-- Labels -->
	<?php if ($ritual_name || $product_cat_name): ?>
		<div class="product-card__labels labels-box">
			<?php if ($ritual_link && $ritual_name): ?>
				<a class="labels-box__link" href="<?php echo esc_url($ritual_link); ?>">
					<?php echo esc_html($ritual_name); ?>
				</a>
			<?php endif; ?>

			<?php if ($product_cat_link && $product_cat_name): ?>
				<a class="labels-box__link" href="<?php echo esc_url($product_cat_link); ?>">
					<?php echo esc_html($product_cat_name); ?>
				</a>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	<!-- Изображение -->
	<a class="product-card__image-link image-box" href="<?php echo esc_url($product_link); ?>">
		<?php if (has_post_thumbnail($product_id)): ?>
			<?php echo the_post_thumbnail(
				'woocommerce_thumbnail',
				[
					'class' => 'img',
					'alt' => $product_title,
					'loading' => 'lazy',
				]
			); ?>
		<?php else: ?>
			<?php echo wc_placeholder_img('woocommerce_thumbnail', [
				'class' => 'img',
				'alt' => $product_title,
			]); ?>
		<?php endif; ?>
	</a>

	<!-- Контент -->
	<div class="product-card__content">
		<h3 class="product-card__title title-3">
			<a class="product-card__title-link" href="<?php echo esc_url($product_link); ?>">
				<?php echo esc_html($product_title); ?>
			</a>
		</h3>

		<?php if ($product_excerpt): ?>
			<div class="product-card__descr descr">
				<?php echo wp_kses_post($product_excerpt); ?>
			</div>
		<?php endif; ?>

		<!-- Атрибут Объем -->
		<?php if ($obem_value): ?>
			<div class="product-card__attr">
				<?php echo esc_html($obem_value); ?>
			</div>
		<?php endif; ?>

		<!-- Цена и кнопка -->
		<div class="product-card__price-box">
			<div class="product-card__price">
				<?php echo $product->get_price_html(); ?>
			</div>

			<div class="product-card__btn-box">
				<?php woocommerce_template_loop_add_to_cart(); ?>
			</div>
		</div>
	</div>
</div>