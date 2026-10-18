<?php
/**
 * Template Name: Checkout Page
 * Шаблон страницы оформления заказа
 */

get_header();
get_template_part('partials/components/hero-page');

// ============================================
// ПРОВЕРКА КОРЗИНЫ
// ============================================
if (!class_exists('WooCommerce') || !WC()->cart || WC()->cart->is_empty()) {
	wp_redirect(home_url('/shop/'));
	exit;
}

$cart = WC()->cart;
$cart_items = $cart->get_cart();
$cart_subtotal = $cart->get_subtotal();
$cart_total = $cart->get_cart_contents_total();

// ============================================
// ДИНАМИЧЕСКОЕ ПОЛУЧЕНИЕ ЗОН ДОСТАВКИ
// ============================================
$shipping_zones = WC_Shipping_Zones::get_zones();

$shipping_countries = [];

foreach ($shipping_zones as $zone) {
	$zone_id = $zone['id'];
	$zone_name = $zone['zone_name'] ?: 'Доставка';

	$zone_obj = new WC_Shipping_Zone($zone_id);
	$methods = $zone_obj->get_shipping_methods();

	$enabled_methods = [];
	foreach ($methods as $method_id => $method) {
		if (!$method->is_enabled())
			continue;

		$cost = 0;
		if (method_exists($method, 'get_option')) {
			$cost = floatval($method->get_option('cost', 0));
		}

		$enabled_methods[$method_id] = [
			'id' => $zone_id . ':' . $method_id,
			'method_id' => $method_id,
			'label' => $method->get_title(),
			'description' => get_custom_shipping_method_description($method),
			'cost' => $cost,
		];
	}

	if (!empty($enabled_methods)) {
		$shipping_countries[$zone_id] = [
			'label' => $zone_name,
			'methods' => $enabled_methods,
		];
	}
}

$first_zone_id = array_key_first($shipping_countries);

$default_cost = 0;
if ($first_zone_id && !empty($shipping_countries[$first_zone_id]['methods'])) {
	$first_method = reset($shipping_countries[$first_zone_id]['methods']);
	$default_cost = $first_method['cost'] ?? 0;
}

// ============================================
// МЕТОДЫ ОПЛАТЫ
// ============================================
$available_gateways = WC()->payment_gateways()->get_available_payment_gateways();
$first_gateway_id = array_key_first($available_gateways);

// ============================================
// ВАЛЮТА (для JS)
// ============================================
$currency_symbol = trim(get_woocommerce_currency_symbol());

// Получаем nonce для AJAX
$checkout_nonce = wp_create_nonce('custom_checkout_nonce');
?>

<section class="section-full checkout-page" id="checkout-page">
	<div class="container checkout-page__container section-gap" data-aos="fade-up">

		<div class="checkout-page__layout">

			<!-- ЛЕВАЯ КОЛОНКА: ФОРМА -->
			<div class="checkout-page__form">

				<form class="checkout-form" id="checkout-form">

					<!-- Скрытое поле страны (заполняется JS) -->
					<input type="hidden" name="shipping_country" id="shipping_country"
						value="<?php echo esc_attr($shipping_countries[$first_zone_id]['label'] ?? ''); ?>">

					<!-- БЛОК 1: КОНТАКТНЫЕ ДАННЫЕ -->
					<div class="checkout-block checkout-block--contact">
						<div class="checkout-block__header">
							<span class="checkout-block__number">1</span>
							<h2 class="checkout-block__title">Контактные данные</h2>
						</div>

						<div class="checkout-block__content">
							<div class="checkout-form__row">
								<div class="checkout-form__col">
									<label class="checkout-form__label">
										<span class="checkout-form__label-text">Имя*</span>
										<input type="text" class="checkout-form__input" name="billing_first_name"
											placeholder="Ваше имя" required>
									</label>
								</div>
								<div class="checkout-form__col">
									<label class="checkout-form__label">
										<span class="checkout-form__label-text">Телефон*</span>
										<div class="checkout-form__phone-input">
											<input type="tel" class="checkout-form__input" name="billing_phone"
												placeholder="+375 (__) ___-__-__" required>
										</div>
									</label>
								</div>
							</div>

							<div class="checkout-form__row">
								<div class="checkout-form__col">
									<label class="checkout-form__label">
										<span class="checkout-form__label-text">E-mail*</span>
										<input type="email" class="checkout-form__input" name="billing_email" placeholder="E-mail"
											required>
									</label>
								</div>
								<div class="checkout-form__col">
									<label class="checkout-form__label">
										<span class="checkout-form__label-text">Комментарий</span>
										<input type="text" class="checkout-form__input" name="order_comments"
											placeholder="Комментарий">
									</label>
								</div>
							</div>
						</div>
					</div>

					<!-- БЛОК 2: ДОСТАВКА -->
					<?php if (!empty($shipping_countries)): ?>
						<div class="checkout-block checkout-block--shipping">
							<div class="checkout-block__header">
								<span class="checkout-block__number">2</span>
								<h2 class="checkout-block__title">Доставка</h2>
							</div>

							<div class="checkout-block__content">
								<div class="checkout-shipping__countries">
									<?php foreach ($shipping_countries as $zone_id => $zone_data): ?>
										<button
											class="checkout-shipping__country-btn <?php echo $zone_id === $first_zone_id ? 'checkout-shipping__country-btn--active' : ''; ?>"
											data-zone="<?php echo esc_attr($zone_id); ?>" type="button">
											<?php echo esc_html($zone_data['label']); ?>
										</button>
									<?php endforeach; ?>
								</div>

								<?php foreach ($shipping_countries as $zone_id => $zone_data): ?>
									<div class="checkout-shipping__methods checkout-method-card-wrapper"
										id="shipping-methods-zone-<?php echo esc_attr($zone_id); ?>"
										style="display: <?php echo $zone_id === $first_zone_id ? 'flex' : 'none'; ?>;">
										<?php $first_method = true;
										foreach ($zone_data['methods'] as $method_id => $method): ?>
											<label class="checkout-shipping__method checkout-method-card">
												<input type="radio" class="checkout-method-card__input" name="shipping_method"
													value="<?php echo esc_attr($method['id']); ?>" data-cost="<?php echo $method['cost']; ?>"
													<?php checked($first_method && $zone_id === $first_zone_id); ?>>
												<div class="checkout-method-card__content">
													<span class="checkout-method-card__icon"></span>
													<div class="checkout-method-card__info">
														<h3 class="checkout-method-card__title"><?php echo esc_html($method['label']); ?>
														</h3>
														<?php if (!empty($method['description'])): ?>
															<p class="checkout-method-card__desc">
																<?php echo esc_html($method['description']); ?>
															</p>
														<?php endif; ?>
													</div>
													<div class="checkout-method-card__price">
														<?php echo $method['cost'] > 0 ? wc_price($method['cost']) : 'Бесплатно'; ?>
													</div>
												</div>
											</label>
											<?php $first_method = false; endforeach; ?>
									</div>
								<?php endforeach; ?>

								<div class="checkout-form__row">
									<div class="checkout-form__col">
										<label class="checkout-form__label">
											<span class="checkout-form__label-text">Город*</span>
											<input type="text" class="checkout-form__input" name="shipping_city"
												placeholder="Введите город" required>
										</label>
									</div>
									<div class="checkout-form__col">
										<label class="checkout-form__label">
											<span class="checkout-form__label-text">Адрес / пункт выдачи*</span>
											<input type="text" class="checkout-form__input" name="shipping_address_1"
												placeholder="Улица, дом, отделение, индекс" required>
										</label>
									</div>
								</div>

								<div class="checkout-form__row">
									<div class="checkout-form__col checkout-form__col--full">
										<label class="checkout-form__label">
											<span class="checkout-form__label-text">Комментарий к доставке</span>
											<input type="text" class="checkout-form__input" name="shipping_comments"
												placeholder="Комментарий">
										</label>
									</div>
								</div>

								<div class="checkout-shipping__info icon icon--info">
									<span class="checkout-shipping__info-text">
										Стоимость доставки: <strong
											id="shipping-cost-display"><?php echo $default_cost > 0 ? wc_price($default_cost) : 'Бесплатно'; ?></strong>
									</span>
								</div>
							</div>
						</div>
					<?php endif; ?>

					<!-- БЛОК 3: ОПЛАТА -->
					<?php if (!empty($available_gateways)): ?>
						<div class="checkout-block checkout-block--payment">
							<div class="checkout-block__header">
								<span class="checkout-block__number">3</span>
								<h2 class="checkout-block__title">Оплата</h2>
							</div>

							<div class="checkout-block__content">
								<div class="checkout-payment__methods checkout-method-card-wrapper">
									<?php foreach ($available_gateways as $gateway_id => $gateway): ?>
										<label class="checkout-payment__method checkout-method-card">
											<input type="radio" class="checkout-method-card__input" name="payment_method"
												value="<?php echo esc_attr($gateway_id); ?>" <?php checked($gateway_id, $first_gateway_id); ?>>
											<div class="checkout-method-card__content">
												<span class="checkout-method-card__icon"></span>
												<div class="checkout-method-card__info">
													<h3 class="checkout-method-card__title">
														<?php echo esc_html($gateway->get_title()); ?>
													</h3>
													<?php if ($gateway->get_description()): ?>
														<p class="checkout-method-card__desc">
															<?php echo esc_html($gateway->get_description()); ?>
														</p>
													<?php endif; ?>
												</div>
											</div>
										</label>
									<?php endforeach; ?>
								</div>
							</div>
						</div>
					<?php endif; ?>

					<!-- БЛОК 4: СОГЛАСИЕ И УСЛОВИЯ -->
					<div class="checkout-block checkout-block--terms">
						<div class="checkout-block__header">
							<span class="checkout-block__number">4</span>
							<h2 class="checkout-block__title">Согласие и условия</h2>
						</div>

						<div class="checkout-block__content">
							<div class="checkout-terms__checkboxes">
								<label class="checkout-terms__checkbox">
									<input type="checkbox" class="checkout-terms__checkbox-input" name="privacy_policy" checked
										required>
									<div class="checkout-terms__checkbox-icon"></div>
									<span class="checkout-terms__checkbox-text">
										Соглашаюсь с <a href="/privacy-policy/" target="_blank">политикой обработки персональных
											данных</a>
									</span>
								</label>

								<label class="checkout-terms__checkbox">
									<input type="checkbox" class="checkout-terms__checkbox-input" name="public_offer" checked
										required>
									<div class="checkout-terms__checkbox-icon"></div>
									<span class="checkout-terms__checkbox-text">
										Соглашаюсь с условиями <a href="/public-offer/" target="_blank">публичной оферты</a>
									</span>
								</label>
							</div>
						</div>
					</div>

				</form>

			</div>

			<!-- ПРАВАЯ КОЛОНКА: ВАШ ЗАКАЗ -->
			<div class="checkout-page__sidebar">
				<div class="checkout-order-summary" id="checkout-order-summary">
					<h2 class="checkout-order-summary__title">Ваш заказ</h2>

					<div class="checkout-order-summary__items">
						<?php foreach ($cart_items as $cart_item_key => $cart_item):
							$product = $cart_item['data'];
							$quantity = $cart_item['quantity'];
							$product_name = $product->get_name();
							$product_price = $product->get_price();
							$product_image = wp_get_attachment_image_src($product->get_image_id(), 'thumbnail');
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
										<span class="checkout-order-summary__item-qty">x <?php echo $quantity; ?></span>
										<?php echo wc_price($product_price * $quantity); ?>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>

					<div class="checkout-order-summary__totals">
						<div class="checkout-order-summary__total-row checkout-order-summary__total-row--total-info">
							<span class="checkout-order-summary__total-label">
								<?php echo WC()->cart->get_cart_contents_count(); ?>
								<?php echo declension_items(WC()->cart->get_cart_contents_count()); ?>
							</span>
						</div>

						<div class="checkout-order-summary__total-row">
							<span class="checkout-order-summary__total-label">Подытог</span>
							<span class="checkout-order-summary__total-value" id="cart-subtotal">
								<?php echo wc_price($cart_subtotal); ?>
							</span>
						</div>

						<div class="checkout-order-summary__total-row">
							<span class="checkout-order-summary__total-label">Доставка</span>
							<span class="checkout-order-summary__total-value" id="cart-shipping">
								<?php echo $default_cost > 0 ? wc_price($default_cost) : 'Бесплатно'; ?>
							</span>
						</div>

						<div class="checkout-order-summary__total-row checkout-order-summary__total-row--final">
							<span class="checkout-order-summary__total-label">Итого</span>
							<span class="checkout-order-summary__total-value checkout-order-summary__total-value--final"
								id="cart-total">
								<?php echo wc_price($cart_subtotal + $default_cost); ?>
							</span>
						</div>
					</div>
				</div>
			</div>
			<!-- КНОПКИ ДЕЙСТВИЯ -->
			<div class="checkout-page__actions">
				<a href="<?php echo esc_url(wc_get_cart_url()); ?>"
					class="checkout-page__back-link link-arrow link-arrow--reverse">
					Вернуться в корзину
				</a>

				<button type="button" class="checkout-page__submit-btn btn" id="checkout-submit-btn">
					Подтвердить заказ
				</button>
			</div>
		</div>



	</div>
</section>

<script>
	document.addEventListener('DOMContentLoaded', function () {

		console.log('✅ Checkout Page Initialized');

		const currencySymbol = '<?php echo esc_js($currency_symbol); ?>';
		const checkoutNonce = '<?php echo $checkout_nonce; ?>';

		const cartSubtotal = <?php echo $cart_subtotal; ?>;
		let currentShippingCost = <?php echo $default_cost; ?>;

		// ============================================
		// 1. ПЕРЕКЛЮЧЕНИЕ ТАБОВ ЗОН ДОСТАВКИ + СТРАНА
		// ============================================
		const countryBtns = document.querySelectorAll('.checkout-shipping__country-btn');
		const allShippingBlocks = document.querySelectorAll('[id^="shipping-methods-zone-"]');
		const shippingCountryInput = document.getElementById('shipping_country');

		countryBtns.forEach(btn => {
			btn.addEventListener('click', function () {
				countryBtns.forEach(b => b.classList.remove('checkout-shipping__country-btn--active'));
				this.classList.add('checkout-shipping__country-btn--active');

				const zoneId = this.dataset.zone;
				const countryName = this.textContent.trim();

				console.log('🌍 Zone changed to:', zoneId, 'Country:', countryName);

				if (shippingCountryInput) {
					shippingCountryInput.value = countryName;
				}

				allShippingBlocks.forEach(block => block.style.display = 'none');

				const targetBlock = document.getElementById('shipping-methods-zone-' + zoneId);
				if (targetBlock) {
					targetBlock.style.display = 'flex';

					const firstRadio = targetBlock.querySelector('input[type="radio"]');
					if (firstRadio) {
						firstRadio.checked = true;
						firstRadio.dispatchEvent(new Event('change'));
					}
				}
			});
		});

		// ============================================
		// 2. ВЫБОР МЕТОДА ДОСТАВКИ
		// ============================================
		const shippingMethodInputs = document.querySelectorAll('input[name="shipping_method"]');
		const shippingCostDisplay = document.getElementById('shipping-cost-display');
		const cartShipping = document.getElementById('cart-shipping');
		const cartTotal = document.getElementById('cart-total');

		shippingMethodInputs.forEach(input => {
			input.addEventListener('change', function () {
				const cost = parseFloat(this.dataset.cost) || 0;
				currentShippingCost = cost;

				const priceText = cost > 0 ? formatPrice(cost) : 'Бесплатно';
				shippingCostDisplay.textContent = priceText;
				cartShipping.textContent = priceText;

				recalculateTotal();
			});
		});

		function recalculateTotal() {
			const total = cartSubtotal + currentShippingCost;
			cartTotal.textContent = formatPrice(total);
		}

		function formatPrice(amount) {
			const rounded = Math.round(amount * 100) / 100;

			if (Number.isInteger(rounded)) {
				return rounded.toString() + ' ' + currencySymbol;
			}

			return rounded.toFixed(2) + ' ' + currencySymbol;
		}

		// ============================================
		// 3. ОТПРАВКА ФОРМЫ С ЗАГРУЗКОЙ И ОТЛАДКОЙ
		// ============================================
		const submitBtn = document.getElementById('checkout-submit-btn');
		const checkoutForm = document.getElementById('checkout-form');

		let errorContainer = document.getElementById('checkout-errors');
		if (!errorContainer) {
			errorContainer = document.createElement('div');
			errorContainer.id = 'checkout-errors';
			errorContainer.className = 'checkout-errors';
			errorContainer.style.display = 'none';
			errorContainer.style.color = '#ff4d4f';
			errorContainer.style.marginBottom = '20px';
			errorContainer.style.padding = '15px';
			errorContainer.style.background = 'rgba(255, 77, 79, 0.1)';
			errorContainer.style.borderRadius = '8px';
			errorContainer.style.border = '1px solid #ff4d4f';

			submitBtn.closest('.checkout-page__actions').prepend(errorContainer);
		}

		submitBtn.addEventListener('click', function (e) {
			e.preventDefault();

			errorContainer.style.display = 'none';
			errorContainer.innerHTML = '';

			const privacyPolicy = document.querySelector('input[name="privacy_policy"]');
			const publicOffer = document.querySelector('input[name="public_offer"]');

			if (!privacyPolicy.checked || !publicOffer.checked) {
				showError('Пожалуйста, согласитесь с условиями обработки данных и публичной офертой');
				return;
			}

			// 🚀 Включаем состояние загрузки
			console.log('📝 Начинаем оформление заказа...');
			checkoutForm.classList.add('is-loading');

			const originalBtnText = submitBtn.textContent;
			submitBtn.disabled = true;
			submitBtn.textContent = 'Оформление заказа...';
			submitBtn.style.opacity = '0.7';
			submitBtn.style.pointerEvents = 'none';

			const formData = new FormData(checkoutForm);
			formData.append('action', 'process_custom_checkout');
			formData.append('nonce', checkoutNonce);

			const shippingMethod = document.querySelector('input[name="shipping_method"]:checked');
			formData.append('shipping_method', shippingMethod ? shippingMethod.value : '');

			const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
			formData.append('payment_method', paymentMethod ? paymentMethod.value : '');

			formData.append('privacy_policy', privacyPolicy.checked ? '1' : '0');
			formData.append('public_offer', publicOffer.checked ? '1' : '0');

			fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
				method: 'POST',
				body: formData
			})
				.then(response => {
					console.log('📡 Response status:', response.status);
					return response.json();
				})
				.then(data => {
					console.log('📦 Response data:', data);

					if (data.success) {
						console.log('✅ Заказ создан успешно!');
						console.log('🔗 Redirect URL:', data.data.redirect);
						console.log('🆔 Order ID:', data.data.order_id);

						if (data.data.redirect) {
							console.log('🚀 Перенаправление через 500мс...');
							setTimeout(() => {
								window.location.href = data.data.redirect;
							}, 500);
						} else {
							console.error('❌ Redirect URL отсутствует!');
							showError('Заказ создан, но не удалось перенаправить на страницу подтверждения.');
							resetLoadingState();
						}
					} else {
						console.error('❌ Ошибка создания заказа:', data);

						// 🚀 Редирект на страницу ошибки с кодом и сообщением
						const errorCode = data.data.error_code || 'system_error';
						const errorMessage = encodeURIComponent(data.data.message || 'Произошла ошибка при оформлении заказа');
						const orderId = data.data.order_id || '';

						const errorUrl = '<?php echo home_url('/checkout-error/'); ?>?' +
							'error_code=' + errorCode +
							'&error_message=' + errorMessage +
							(orderId ? '&order_id=' + orderId : '');

						console.log('🔗 Redirect to error page:', errorUrl);

						setTimeout(() => {
							window.location.href = errorUrl;
						}, 500);
					}
				})
				.catch(error => {
					console.error(' Network error:', error);

					// 🚀 Редирект на страницу ошибки сети
					const errorUrl = '<?php echo home_url('/checkout-error/'); ?>?' +
						'error_code=system_error' +
						'&error_message=' + encodeURIComponent('Ошибка сети. Проверьте подключение к интернету.');

					setTimeout(() => {
						window.location.href = errorUrl;
					}, 500);
				});
		});
		// Функция сброса состояния загрузки
		function resetLoadingState() {
			checkoutForm.classList.remove('is-loading');
			submitBtn.disabled = false;
			submitBtn.textContent = 'Подтвердить заказ';
			submitBtn.style.opacity = '1';
			submitBtn.style.pointerEvents = 'auto';
		}

		function showError(message) {
			errorContainer.innerHTML = message;
			errorContainer.style.display = 'block';
			errorContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
		}

	}); // <-- Закрывающая скобка для DOMContentLoaded
</script>

<?php get_footer(); ?>