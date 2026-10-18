<?php
/**
 * Шаблон страницы корзины WooCommerce
 * 
 * Переопределяет стандартный шаблон WooCommerce
 * Путь: your-theme/woocommerce/cart/cart.php
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart');
?>

<section class="section cart-page" id="cart-page">
	<div class="container cart-page__container" data-aos="fade-up">

		

		<?php if (WC()->cart->is_empty()): ?>
			<div class="cart-page__empty" >
				<h2 class="cart-page__empty-title title-2"><?php esc_html_e('Ваша корзина пуста', 'woocommerce'); ?></h2>
				<p class="cart-page__empty-descr">
					<?php esc_html_e('Добавьте товары из каталога, чтобы оформить заказ', 'woocommerce'); ?>
				</p>
				<a class="cart-page__empty-btn btn" href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>">
					<?php esc_html_e('Перейти в каталог', 'woocommerce'); ?>
				</a>
			</div>
		<?php else: ?>

			<form class="cart-page__form cart" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">

				<!-- Левая колонка: Список товаров -->
				<ul class="cart-page__list">
					<?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item):
						$_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
						$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

						if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)):
							$product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
							$product_name = $_product->get_name();
							$product_price = $_product->get_price();
							$product_regular_price = $_product->get_regular_price();
							$product_sale_price = $_product->get_sale_price();
							$quantity = $cart_item['quantity'];
							$line_subtotal = WC()->cart->get_product_subtotal($_product, $quantity);

							// Получаем объем (атрибут pa_obem)
							$obem = $_product->get_attribute('pa_obem');
							?>
							<li class="cart-page__item cart-item" data-cart-item-key="<?php echo esc_attr($cart_item_key); ?>">

								<!-- Изображение -->
								<div class="cart-item__image image-box">
									<?php
									$thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
									if ($product_permalink):
										echo '<a href="' . esc_url($product_permalink) . '">' . $thumbnail . '</a>';
									else:
										echo $thumbnail;
									endif;
									?>
								</div>

								<!-- Контент -->
								<div class="cart-item__content">
									<!-- Кнопка удаления -->
									<button type="button" class="cart-item__remove"
										data-cart-item-key="<?php echo esc_attr($cart_item_key); ?>"
										aria-label="<?php echo esc_attr__('Удалить товар', 'woocommerce'); ?>">
										<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path
												d="M9.99957 9.99999L17.2218 17.2222M9.99957 9.99999L2.77734 2.77777M9.99957 9.99999L2.77734 17.2222M9.99957 9.99999L17.2218 2.77777"
												stroke="currentColor" stroke-linecap="round" />
										</svg>
									</button>
									<!-- Название -->
									<?php if ($product_permalink): ?>
										<a class="cart-item__title title-3" href="<?php echo esc_url($product_permalink); ?>">
											<?php echo esc_html($product_name); ?>
										</a>
									<?php else: ?>
										<h3 class="cart-item__title title-3">
											<?php echo esc_html($product_name); ?>
										</h3>
									<?php endif; ?>

									<!-- Описание (краткое) -->
									<?php
									$short_description = $_product->get_short_description();
									if ($short_description):
										?>
										<div class="cart-item__descr descr">
											<?php echo wp_kses_post($short_description); ?>
										</div>
									<?php endif; ?>

									<!-- Объем -->
									<?php if ($obem): ?>
										<div class="cart-item__attr">
											<?php echo esc_html($obem); ?>
										</div>
									<?php endif; ?>

									<!-- Цена и количество -->
									<div class="cart-item__bottom">
										<div class="cart-item__price" data-cart-item-key="<?php echo esc_attr($cart_item_key); ?>">
											<?php if ($product_regular_price && $product_sale_price && $product_regular_price !== $product_sale_price): ?>
												<span class="price-regular"><?php echo wc_price($product_regular_price); ?></span>
											<?php endif; ?>
											<span class="price-current"><?php echo wc_price($product_price); ?></span>
										</div>

										<!-- Счетчик количества -->
										<div class="cart-item__quantity quantity-box">
											<button type="button" class="quantity-box__btn quantity-box__btn--minus"
												data-cart-item-key="<?php echo esc_attr($cart_item_key); ?>"
												aria-label="<?php esc_attr_e('Уменьшить', 'woocommerce'); ?>">−</button>
											<input type="number" class="quantity-box__input"
												data-cart-item-key="<?php echo esc_attr($cart_item_key); ?>"
												value="<?php echo esc_attr($quantity); ?>" min="0" max="" step="1" inputmode="numeric"
												aria-label="<?php esc_attr_e('Количество', 'woocommerce'); ?>">
											<button type="button" class="quantity-box__btn quantity-box__btn--plus"
												data-cart-item-key="<?php echo esc_attr($cart_item_key); ?>"
												aria-label="<?php esc_attr_e('Увеличить', 'woocommerce'); ?>">+</button>
										</div>
									</div>
								</div>
							</li>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>

				<!-- Правая колонка: Ваш заказ -->
				<div class="cart-page__sidebar">
					<div class="cart-page__totals cart-totals" id="cart-totals-block">
						<h2 class="cart-totals__title title-3"><?php esc_html_e('Ваш заказ', 'woocommerce'); ?></h2>

						<div class="cart-totals__info">
							<?php
							$cart_count = WC()->cart->get_cart_contents_count();
							$items_text = $cart_count . ' ' . declension_items($cart_count);
							?>
							<span class="cart-totals__count"><?php echo esc_html($items_text); ?></span>
						</div>
					
						<table class="cart-totals__table">
							<tbody>
								<tr class="cart-subtotal">
									<th><?php esc_html_e('Подытог', 'woocommerce'); ?></th>
									<td data-title="<?php esc_attr_e('Подытог', 'woocommerce'); ?>">
										<?php wc_cart_totals_subtotal_html(); ?>
									</td>
								</tr>


								<tr class="shipping">
									<th><?php esc_html_e('Доставка', 'woocommerce'); ?></th>
									<td data-title="<?php esc_attr_e('Доставка', 'woocommerce'); ?>">
										<p class="shipping-calculator-message">Рассчитается после выбора способа доставки</p>
									</td>
								</tr>

								<?php do_action('woocommerce_cart_totals_before_order_total'); ?>

								<tr class="order-total">
									<th><?php esc_html_e('Итого', 'woocommerce'); ?></th>
									<td data-title="<?php esc_attr_e('Итого', 'woocommerce'); ?>">
										<?php wc_cart_totals_order_total_html(); ?>
									</td>
								</tr>

								<?php do_action('woocommerce_cart_totals_after_order_total'); ?>
							</tbody>
						</table>

						<div class="cart-totals__checkout">
							<a class="cart-totals__checkout-btn btn" href="<?php echo esc_url(wc_get_checkout_url()); ?>">
								<?php esc_html_e('Перейти к оформлению', 'woocommerce'); ?>
							</a>
						</div>
					</div>
				</div>

			</form>
			<!-- Ссылка "Продолжить покупки" -->
			<a class="cart-page__back-link link-arrow link-arrow--reverse" href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>">
				<?php esc_html_e('Продолжить покупки', 'woocommerce'); ?>
			</a>
		<?php endif; ?>
	</div>
</section>

<?php do_action('woocommerce_after_cart'); ?>