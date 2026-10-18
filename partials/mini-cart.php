<?php
/**
 * Mini Cart Template
 * 
 * @var array $args
 */

// Получаем товары из корзины
$cart_items = WC()->cart->get_cart();
$cart_count = WC()->cart->get_cart_contents_count();
$cart_total = WC()->cart->get_cart_total();
$cart_subtotal = WC()->cart->get_cart_subtotal();
?>

<div class="mini-cart" id="mini-cart" aria-hidden="true">
	<div class="mini-cart__overlay" data-mini-cart-close></div>

	<div class="mini-cart__container">
		<div class="mini-cart__header">
			<h2 class="mini-cart__title">Корзина</h2>
			<button class="mini-cart__close" type="button" data-mini-cart-close aria-label="Закрыть корзину">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none">
					<path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
				</svg>
			</button>
		</div>

		<div class="mini-cart__body">
			<?php if (!empty($cart_items) && $cart_count > 0): ?>
				<ul class="mini-cart__list">
					<?php foreach ($cart_items as $cart_item_key => $cart_item):
						$product = $cart_item['data'];
						$quantity = $cart_item['quantity'];
						$product_id = $cart_item['product_id'];
						$variation_id = $cart_item['variation_id'];
						$product_name = $product->get_name();
						$product_price = WC()->cart->get_product_price($product);
						$product_subtotal = WC()->cart->get_product_subtotal($product, $quantity);

						// Получаем URL товара
						$product_url = $product->get_permalink();

						// Получаем изображение
						$thumbnail_id = $variation_id ? $variation_id : $product_id;
						$thumbnail = wp_get_attachment_image(
							get_post_thumbnail_id($thumbnail_id),
							'thumbnail',
							false,
							['class' => 'mini-cart__item-image']
						);

						// Получаем атрибуты для вариаций
						$item_meta = wc_get_formatted_variation($product, true, true, false);
						?>
						<li class="mini-cart__item" data-cart-item-key="<?php echo esc_attr($cart_item_key); ?>">
							<div class="mini-cart__item-wrapper">
								<div class="mini-cart__item-image-wrapper image-box">
									<?php if ($thumbnail): ?>
										<a href="<?php echo esc_url($product_url); ?>" class="mini-cart__item-link"
											title="<?php echo esc_attr($product_name); ?>">
											<?php echo $thumbnail; ?>
										</a>
									<?php else: ?>
										<a href="<?php echo esc_url($product_url); ?>"
											class="mini-cart__item-link mini-cart__item-link--no-image"
											title="<?php echo esc_attr($product_name); ?>">
											<div class="mini-cart__item-image-placeholder"></div>
										</a>
									<?php endif; ?>
								</div>

								<div class="mini-cart__item-content">
									<a href="<?php echo esc_url($product_url); ?>"
										class="mini-cart__item-link mini-cart__item-title-link"
										title="<?php echo esc_attr($product_name); ?>">
										<h3 class="mini-cart__item-title"><?php echo esc_html($product_name); ?></h3>
									</a>

									<?php if ($item_meta): ?>
										<div class="mini-cart__item-meta">
											<?php echo wp_kses_post($item_meta); ?>
										</div>
									<?php endif; ?>

									<div class="mini-cart__item-price">
										<span class="price"><?php echo wp_kses_post($product_price); ?></span>
										<span class="quantity">× <?php echo esc_html($quantity); ?></span>
									</div>
									<?php if (!empty($quantity > 1)): ?>
										<div class="mini-cart__item-subtotal">
											<?php echo wp_kses_post($product_subtotal); ?>
										</div>
									<?php endif; ?>

								</div>
								<button class="mini-cart__item-remove" type="button"
									data-cart-item-key="<?php echo esc_attr($cart_item_key); ?>"
									onclick="if(window.miniCart) window.miniCart.removeItem('<?php echo esc_attr($cart_item_key); ?>')"
									aria-label="Удалить <?php echo esc_attr($product_name); ?>">
									<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path
											d="M9.99957 10.0001L17.2218 17.2223M9.99957 10.0001L2.77734 2.77783M9.99957 10.0001L2.77734 17.2223M9.99957 10.0001L17.2218 2.77783"
											stroke="#C79F70" stroke-linecap="round" />
									</svg>
								</button>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php else: ?>
				<div class="mini-cart__empty">
					<p class="mini-cart__empty-text">Ваша корзина пуста</p>
					<a class="mini-cart__empty-btn btn" href="<?php echo esc_url(home_url('/shop/')); ?>">
						Перейти в каталог
					</a>
				</div>
			<?php endif; ?>
		</div>

		<?php if (!empty($cart_items) && $cart_count > 0): ?>
			<div class="mini-cart__footer">
				<div class="mini-cart__totals">
					<span class="mini-cart__totals-label">Итого</span>
					<span class="mini-cart__totals-value">
						<?php echo wp_kses_post($cart_total); ?>
					</span>
				</div>

				<a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="mini-cart__btn btn">
					Перейти в корзину
				</a>
			</div>
		<?php endif; ?>
	</div>
</div>