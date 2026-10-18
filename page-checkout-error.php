<?php
/**
 * Template Name: Checkout Error Page
 * Страница ошибки оформления заказа
 */

get_header();

// Получаем данные об ошибке из URL
$error_code = isset($_GET['error_code']) ? sanitize_text_field($_GET['error_code']) : 'unknown';
$error_message = isset($_GET['error_message']) ? urldecode($_GET['error_message']) : '';
$order_id = isset($_GET['order_id']) ? absint($_GET['order_id']) : 0;
$image = get_field('hero_image', $page) ?? null;
// Тексты в зависимости от кода ошибки
$error_texts = [
	'payment_failed' => [
		'title' => 'Не удалось произвести оплату',
		'message' => 'Платёж не был завершён. Пожалуйста, проверьте данные карты или выберите другой способ оплаты.',
	],
	'validation_error' => [
		'title' => 'Ошибка в данных формы',
		'message' => 'Некоторые поля заполнены некорректно. Пожалуйста, проверьте введённые данные и попробуйте снова.',
	],
	'stock_error' => [
		'title' => 'Товар недоступен',
		'message' => 'К сожалению, один или несколько товаров в вашей корзине больше недоступны. Пожалуйста, обновите корзину.',
	],
	'shipping_error' => [
		'title' => 'Не удалось рассчитать доставку',
		'message' => 'Невозможно доставить заказ по указанному адресу. Пожалуйста, проверьте адрес или свяжитесь с нами.',
	],
	'system_error' => [
		'title' => 'Техническая ошибка',
		'message' => 'Произошла непредвиденная ошибка. Пожалуйста, попробуйте позже или свяжитесь с нами.',
	],
];

$error_data = $error_texts[$error_code] ?? [
	'title' => 'Не удалось оформить заказ',
	'message' => 'Что-то пошло не так. Попробуйте ещё раз или свяжитесь с нами, если ошибка повторится.',
];

// Если есть конкретное сообщение из PHP, используем его
if (!empty($error_message)) {
	$error_data['message'] = $error_message;
}

// Получаем заказ, если он был создан
$order = $order_id ? wc_get_order($order_id) : false;
?>

<section class="success-order-page checkout-error-page" id="checkout-error-page">
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
	<div class="container success-order-page__container" data-aos="fade-up">

		<div class="success-order-page__content">

			<!-- Breadcrumbs -->
			<div class="success-order-page__breadcrumbs page-breadcrumbs">
				<?php if (function_exists('bcn_display')) {
					bcn_display();
				} ?>
			</div>

			<!-- Заголовок -->
			<div class="success-order-page__header">
				<span class="success-order-page__subtitle"><?php echo esc_html($error_data['title']); ?></span>
				<h1 class="success-order-page__title title-1 descr">
					<?php echo wp_kses_post($error_data['title']); ?>
				</h1>
				<div class="success-order-page__description descr">
					<?php echo wp_kses_post($error_data['message']); ?>
				</div>
			</div>

			<!-- Иконка ошибки -->
			<div class="success-order-page__decor-icon">
				<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/error-icon.webp') ?>" alt="">
			</div>
			<!-- Кнопки действий -->
			<div class="checkout-error-page__actions">
				<a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="checkout-error-page__btn btn">
					Вернуться к оформлению
				</a>

				<a href="https://t.com/your_telegram" target="_blank" class="checkout-error-page__btn btn btn--stroke" style="--bg-icon: url('">
					Написать в Telegram
				</a>
			</div>

		</div>

	</div>
</section>

<?php get_footer(); ?>