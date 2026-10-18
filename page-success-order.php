<?php
/**
 * Template Name:  Страница успешного оформления заказа
 * Страница успешного оформления заказа
 */

get_header();

$order_id = isset($_GET['order_id']) ? absint($_GET['order_id']) : 0;
$order = $order_id ? wc_get_order($order_id) : false;

$label = get_field('hero_label', $page) ?? 'Заказ успешно оформлен';
$title = get_field('hero_title', $page) ?? 'Спасибо!<br>Ваш заказ принят';
$descr = get_field('hero_descr', $page) ?? 'Мы получили ваш заказ и передали его в обработку. В ближайшее время вы получите подтверждение на e-mail или с вами свяжется менеджер.';
$image = get_field('hero_image', $page) ?? null;

if (!$order) {
	wp_redirect(home_url('/shop/'));
	exit;
}
?>

<section class="section success-order-page" id="success-order-page">
	<?php if (!empty($image)): ?>
		<div class="success-order-page__image image-box jarallax">
			<?php echo wp_get_attachment_image(
				$image['ID'],
				'full',
				false,
				array(
					'class' => 'img jarallax-img',
					'alt' => $image['alt'] ?: ''
				)
			); ?>
		</div>
	<?php endif; ?>
	<div class="container success-order-page__container">

		<div class="success-order-page__layout">

			<!-- ЛЕВАЯ КОЛОНКА -->
			<div class="success-order-page__content" data-aos="fade-up">

				<div class="success-order-page__header">
					<!-- Breadcrumbs -->
					<div class="success-order-page__breadcrumbs page-breadcrumbs">
						<?php if (function_exists('bcn_display')) {
							bcn_display();
						} ?>
					</div>
					<span class="success-order-page__subtitle"><?php echo esc_html($label); ?></span>
					<h1 class="success-order-page__title title-1 descr"><?php echo wp_kses_post($title); ?></h1>
					<div class="success-order-page__description descr">
						<?php echo wp_kses_post($descr) ?>
					</div>
				</div>
				<div class="success-order-page__decor-icon">
					<svg width="112" height="112" viewBox="0 0 112 112" fill="none" xmlns="http://www.w3.org/2000/svg">
						<rect x="0.5" y="0.5" width="111" height="111" rx="55.5" stroke="#C79F70" />
						<path d="M77 42L47.6 73.5L35 61.6875" stroke="url(#paint0_linear_46_3366)" stroke-width="4"
							stroke-linejoin="round" />
						<defs>
							<linearGradient id="paint0_linear_46_3366" x1="54.2591" y1="42" x2="54.2591" y2="73.5"
								gradientUnits="userSpaceOnUse">
								<stop stop-color="#D3B28B" />
								<stop offset="1" stop-color="#C79F6F" />
							</linearGradient>
						</defs>
					</svg>
				</div>
				<div class="success-order-page__info">
					<div class="success-order-info__item icon icon--document">
						<div class="success-order-info__content">
							<span class="success-order-info__label">Номер заказа:</span>
							<span class="success-order-info__value">TM-<?php echo $order->get_id(); ?></span>
						</div>
					</div>

					<div class="success-order-info__item  icon icon--email-stroke">
						<div class="success-order-info__content">
							<span class="success-order-info__label">Подтверждение отправлено на e-mail:</span>
							<span class="success-order-info__value"><?php echo esc_html($order->get_billing_email()); ?></span>
						</div>
					</div>
				</div>
			</div>

			<!-- ПРАВАЯ КОЛОНКА -->
			<div class="success-order-page__sidebar" data-aos="fade-up">
				<div class="success-order-summary checkout-order-summary" id="success-order-summary">
					<h2 class="checkout-order-summary__title">Ваш заказ</h2>

					<div class="checkout-order-summary__items">
						<?php foreach ($order->get_items() as $item_id => $item):
							$product = $item->get_product();
							$product_name = $item->get_name();
							$product_image = $product ? wp_get_attachment_image_src($product->get_image_id(), 'thumbnail') : null;
							?>
							<div class="checkout-order-summary__item">
								<div class="checkout-order-summary__item-image">
									<?php if ($product_image): ?>
										<img src="<?php echo esc_url($product_image[0]); ?>"
											alt="<?php echo esc_attr($product_name); ?>">
									<?php endif; ?>
								</div>
								<div class="checkout-order-summary__item-content">
									<div class="checkout-order-summary__item-info">
										<h3 class="checkout-order-summary__item-title"><?php echo esc_html($product_name); ?></h3>

									</div>
									<div class="checkout-order-summary__item-price">
										<span class="checkout-order-summary__item-qty">x <?php echo $item->get_quantity(); ?></span>
										<?php echo wc_price($item->get_total()); ?>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>

					<div class="checkout-order-summary__totals">
						<div class="checkout-order-summary__total-row checkout-order-summary__total-row--total-info">
							<span class="checkout-order-summary__total-label">
								<?php echo $order->get_item_count(); ?>
								<?php echo declension_items($order->get_item_count()); ?>
							</span>
						</div>
						<div class="checkout-order-summary__total-row">
							<span class="checkout-order-summary__total-label">Подытог</span>
							<span class="checkout-order-summary__total-value">
								<?php echo wc_price($order->get_subtotal()); ?>
							</span>
						</div>

						<?php foreach ($order->get_shipping_methods() as $shipping_method): ?>
							<div class="checkout-order-summary__total-row">
								<span class="checkout-order-summary__total-label">Доставка</span>
								<span class="checkout-order-summary__total-value">
									<?php echo wc_price($shipping_method->get_total()); ?>
								</span>
							</div>
						<?php endforeach; ?>

						<div class="checkout-order-summary__total-row checkout-order-summary__total-row--final">
							<span class="checkout-order-summary__total-label">Итого</span>
							<span class="checkout-order-summary__total-value checkout-order-summary__total-value--final">
								<?php echo $order->get_formatted_order_total(); ?>
							</span>
						</div>
					</div>
				</div>
			</div>

		</div>

	</div>

</section>

<?php 
get_template_part('partials/section-whats-next');
get_footer(); ?>