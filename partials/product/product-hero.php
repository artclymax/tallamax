<?php
/**
 * Шаблон Product Hero - первый экран товара WooCommerce
 */

// Надёжное получение объекта товара
$product_obj = null;

if (is_singular('product') || is_product()) {
	$product_id = get_the_ID();
	$product_obj = wc_get_product($product_id);
}

// Если объект не получен — прерываем рендер
if (!$product_obj || !is_a($product_obj, 'WC_Product')) {
	return;
}

$product_id = $product_obj->get_id();

// ACF-поля товара
$subtitle = get_field('product_subtitle', $product_id) ?? '';
$hero_descr = get_field('product_hero_descr', $product_id) ?? get_the_excerpt() ?? '';
$features = get_field('product_features', $product_id) ?? [];
$specs = get_field('product_specs', $product_id) ?? [];

// Данные товара WooCommerce
$product_name = $product_obj->get_name() ?? '';
$product_price = $product_obj->get_price_html() ?? '';
$product_url = $product_obj->get_permalink() ?? '';
$is_purchasable = $product_obj->is_purchasable();
$is_in_stock = $product_obj->is_in_stock();
$product_type = $product_obj->get_type();

// Галерея товара
$main_image_id = $product_obj->get_image_id();
$attachment_ids = $product_obj->get_gallery_image_ids();
$all_images = array_filter(array_merge([$main_image_id], $attachment_ids));

// Labels (Ритуал + Категория товара)
$ritual_name = '';
$ritual_link = '';

// Получаем выбранный термин ритуала из ACF
$ritual_term = get_field('product_ritual_term', $product_id) ?: get_the_terms($product_id, 'product_cat')[0];

if ($ritual_term && !is_wp_error($ritual_term)) {
	$ritual_name = get_field('product_ritual_name', $product_id) ?? $ritual_term->name;
	$ritual_link = get_term_link($ritual_term);
}

// Категория товара (берем первую привязанную категорию)
$product_cat_name = '';
$product_cat_link = '';
$terms = get_the_terms($product_id, 'product_cat');

if ($terms && !is_wp_error($terms)) {
	$term = reset($terms);
	$product_cat_name = $term->name;
	$product_cat_link = get_term_link($term);
}
// Атрибут "Объем"
$obem_value = '';
$obem_attrs = $product_obj->get_attribute('pa_obem');
if ($obem_attrs) {
	$obem_value = $obem_attrs;
}

// Защитная обёртка
if ($product_name):
	?>
	<section class="section product-hero" id="product-hero">
		<div class="container product-hero__container" data-aos="fade-up" data-aos-delay="100"><!-- Breadcrumbs -->
			<div class="product-hero__breadcrumbs page-breadcrumbs">
				<?php if (function_exists('bcn_display')) {
					bcn_display();
				} ?>
			</div>
			<div class="product-hero__wrapper">


				<!-- Галерея -->
				<?php if (!empty($all_images)): ?>
					<div class="product-hero__gallery" data-aos="fade-up">
						<!-- Основной Swiper -->
						<div class="swiper product-hero__main-swiper">
							<div class="swiper-wrapper">
								<?php foreach ($all_images as $image_id): ?>
									<div class="swiper-slide product-hero__slide">
										<div class="product-hero__image image-box">
											<?php echo wp_get_attachment_image(
												$image_id,
												'large',
												false,
												[
													'class' => 'img',
													'alt' => get_post_meta($image_id, '_wp_attachment_image_alt', true) ?: $product_name,
													'loading' => 'eager'
												]
											); ?>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</div>

						<!-- Thumbs Swiper (миниатюры) -->
						<?php if (count($all_images) > 1): ?>
							<div class="swiper product-hero__thumbs-swiper">
								<div class="swiper-wrapper">
									<?php foreach ($all_images as $image_id): ?>
										<div class="swiper-slide product-hero__thumb">
											<div class="product-hero__thumb-image image-box">
												<?php echo wp_get_attachment_image(
													$image_id,
													'medium',
													false,
													[
														'class' => 'img',
														'alt' => ''
													]
												); ?>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<!-- Контент -->
				<div class="product-hero__content" data-aos="fade-up" data-aos-delay="100">

					<!-- Labels -->
					<?php if ($ritual_name || $product_cat_name): ?>
						<div class="product-hero__labels labels-box">
							<?php if ($ritual_link && $ritual_name): ?>
								<a class="labels-box__link" href="<?php echo esc_url($ritual_link); ?>">
									<?php echo esc_html($ritual_name); ?>
								</a>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<h1 class="product-hero__title title-1">
						<?php echo esc_html($product_name); ?>
					</h1>

					<?php if ($subtitle): ?>
						<div class="product-hero__subtitle ">
							<?php echo esc_html($subtitle); ?>
						</div>
					<?php endif; ?>

					<?php if ($hero_descr): ?>
						<div class="product-hero__descr descr">
							<?php echo wp_kses_post($hero_descr); ?>
						</div>
					<?php endif; ?>

					<!-- Объем -->
					<?php if ($obem_value): ?>
						<div class="product-hero__attr">
							<?php echo esc_html($obem_value); ?>
						</div>
					<?php endif; ?>

					<!-- Цена -->
					<?php if ($product_price): ?>
						<div class="product-hero__price price">
							<?php echo wp_kses_post($product_price); ?>
						</div>
					<?php endif; ?>

					<!-- Форма добавления в корзину -->
					<!-- Форма добавления в корзину -->
					<?php if ($is_purchasable && $is_in_stock): ?>
						<?php if ($product_type === 'simple'): ?>
							<?php
							// Подготовка данных для кнопки (чтобы модалка работала)
							$image_id = $product_obj->get_image_id();
							$image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
							$clean_price = strip_tags(wc_price($product_obj->get_price()));
							?>

							<form class="product-hero__cart-form cart" action="<?php echo esc_url($product_obj->add_to_cart_url()); ?>"
								method="post" enctype="multipart/form-data">
								<div class="product-hero__cart-actions">
									<!-- Количество -->
									<div class="product-hero__quantity quantity-box">
										<button type="button" class="quantity-box__btn quantity-box__btn--minus"
											aria-label="Уменьшить">−</button>
										<input type="number" class="quantity-box__input" name="quantity" value="1" min="1" step="1"
											inputmode="numeric" aria-label="Количество">
										<button type="button" class="quantity-box__btn quantity-box__btn--plus"
											aria-label="Увеличить">+</button>
									</div>

									<!-- Кнопка добавления (с AJAX и data-атрибутами для модалки) -->
									<button type="submit" class="product-hero__add-btn btn add_to_cart_button ajax_add_to_cart"
										name="add-to-cart" value="<?php echo esc_attr($product_id); ?>"
										data-product_id="<?php echo esc_attr($product_id); ?>" data-quantity="1"
										data-product-image="<?php echo esc_url($image_url); ?>"
										data-product-name="<?php echo esc_attr($product_name); ?>"
										data-product-price="<?php echo esc_attr($clean_price); ?>"
										data-success_message="<?php echo esc_attr(sprintf(__('%s добавлен в вашу корзину', 'woocommerce'), $product_name)); ?>">
										<span class="product-hero__add-btn-text">
											Добавить в корзину
										</span>
									</button>
								</div>

								<?php wp_nonce_field('woocommerce_add_to_cart'); ?>
								<input type="hidden" name="product_id" value="<?php echo esc_attr($product_id); ?>">
							</form>
						<?php else: ?>
							<a class="product-hero__add-btn btn" href="<?php echo esc_url($product_url); ?>">
								<?php esc_html_e('Выбрать варианты', 'woocommerce'); ?>
							</a>
						<?php endif; ?>
					<?php elseif (!$is_in_stock): ?>
						<div class="product-hero__out-of-stock btn btn--disabled">
							<?php esc_html_e('Нет в наличии', 'woocommerce'); ?>
						</div>
					<?php endif; ?>

					<!-- Преимущества -->
					<?php if (!empty($features)): ?>
						<ul class="product-hero__features features-list grid">
							<?php foreach ($features as $index => $feature):
								$feat_icon = $feature['icon'] ?? null;
								$feat_title = $feature['title'] ?? '';
								$feat_descr = $feature['descr'] ?? '';
								if (!$feat_title && !$feat_descr)
									continue;
								?>
								<li class="features-list__item" data-aos="fade-up" data-aos-delay="<?= $index * 100; ?>">
									<?php if ($feat_icon && is_array($feat_icon) && !empty($feat_icon['ID'])): ?>
										<div class="features-list__icon">
											<?php echo wp_get_attachment_image(
												$feat_icon['ID'],
												'medium',
												false,
												[
													'class' => 'img',
													'alt' => $feat_icon['alt'] ?: $feat_title,
													'loading' => 'lazy'
												]
											); ?>
										</div>
									<?php endif; ?>
									<div class="features-list__content">
										<?php if ($feat_title): ?>
											<h3 class="features-list__title title-4">
												<?php echo esc_html($feat_title); ?>
											</h3>
										<?php endif; ?>
										<?php if ($feat_descr): ?>
											<div class="features-list__descr descr">
												<?php echo wp_kses_post($feat_descr); ?>
											</div>
										<?php endif; ?>
									</div>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

					<!-- Свойства (иконка + текст) -->
					<?php if (!empty($specs)): ?>
						<ul class="product-hero__specs specs-list">
							<?php foreach ($specs as $spec):
								$spec_icon = $spec['icon'] ?? null;
								$spec_text = $spec['text'] ?? '';
								if (!$spec_text)
									continue;
								?>
								<li class="specs-list__item">
									<?php if ($spec_icon && is_array($spec_icon) && !empty($spec_icon['ID'])): ?>
										<div class="specs-list__icon">
											<?php echo wp_get_attachment_image(
												$spec_icon['ID'],
												'medium',
												false,
												[
													'class' => 'img',
													'alt' => $spec_icon['alt'] ?: $spec_text,
													'loading' => 'lazy'
												]
											); ?>
										</div>
									<?php endif; ?>
									<span class="specs-list__text">
										<?php echo esc_html($spec_text); ?>
									</span>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

				</div>
			</div>
		</div>
	</section>
<?php endif; ?>