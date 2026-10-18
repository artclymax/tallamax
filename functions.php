<?php

require_once get_template_directory() . '/functions/vite.php';

// === Helpers ===
require_once get_template_directory() . '/functions/helpers/theme_asset_version.php';
require_once get_template_directory() . '/functions/helpers/print_dump.php';
require_once get_template_directory() . '/functions/helpers/mx_logo.php';
require_once get_template_directory() . '/functions/helpers/mx_pagination.php';
//require_once get_template_directory() . '/functions/helpers/mx_category_list.php';
require_once get_template_directory() . '/functions/helpers/trim_text.php';
require_once get_template_directory() . '/functions/helpers/correct_phone.php';
require_once get_template_directory() . '/functions/helpers/smart_breadcrumbs.php';


/* get_json_from_query
$json = get_json_from_query($query);
<div class="select-products-data" data-select-from-acf="<?= esc_attr($json) ?>"></div>
*/
//require_once get_template_directory() . '/functions/helpers/get_json_from_query.php';

/** Добавление картинки для кастомных полей в таблице админки
 * add_admin_thumbnail_column('castom-post-slug'); // projects
 */
//require_once get_template_directory() . '/functions/helpers/add_admin_thumbnail_column.php';
//add_admin_thumbnail_column('portfolio');

//require_once get_template_directory() . '/functions/helpers/get_prev_post_slug.php';
//require_once get_template_directory() . '/functions/helpers/get_next_post_slug.php';
//require_once get_template_directory() . '/functions/helpers/custom_product_category.php';
//require_once get_template_directory() . '/functions/helpers/get_product_attributes_array.php';

// === BASE ====
// Общая настройка темы (лого, название и т.п.)
require_once get_template_directory() . '/functions/default_settings.php';

// Подключение стилей
require_once get_template_directory() . '/functions/connect_styles.php';

// Подключение скриптов
require_once get_template_directory() . '/functions/connect_scripts.php';

// Отключение стилей Woocommerce
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// Поддержка темы на Woocommerce
add_action('after_setup_theme', function () {
	add_theme_support('woocommerce');
});
// Создание меню
require_once get_template_directory() . '/functions/register_nav_menus.php';

// Регистрация новых записей
require_once get_template_directory() . '/functions/register_post_type.php';

// Кастомная админка (новая версия)
require_once get_template_directory() . '/functions/admin/admin-page.php';
require_once get_template_directory() . '/functions/admin/plugin-installer.php';
//add_action('admin_init', function() {
//    if (current_user_can('manage_options')) {
//        delete_transient('verda_admin_post_types');
//    }
//});
// Создание SCF-полей
require_once get_template_directory() . '/functions/scf_data.php';

function mx_fix_orphans($text)
{
	if (is_admin())
		return $text;
	if (!is_string($text))
		return $text;

	// Фикс для Safari: удаляем скрытые символы Figma (LSEP \u2028 и PARAGRAPH SEPARATOR \u2029)
	$lsep = json_decode('"\u2028"');
	$psep = json_decode('"\u2029"');
	$text = str_replace(array($lsep, $psep), ' ', $text);

	// Если нет коротких слов — сразу выходим (оптимизация)
	if (!preg_match('/\s[а-яА-Яa-zA-Z]{1,2}\s/u', $text)) {
		return $text;
	}

	// Разделяем текст на блоки: защищённые (script, style, code, pre, textarea) и обычный текст
	$protected_pattern = '/(<script\b[^>]*>.*?<\/script>|<style\b[^>]*>.*?<\/style>|<code\b[^>]*>.*?<\/code>|<pre\b[^>]*>.*?<\/pre>|<textarea\b[^>]*>.*?<\/textarea>)/uis';

	// Разбиваем текст на части: [текст, защищённый_блок, текст, защищённый_блок, ...]
	$parts = preg_split($protected_pattern, $text, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

	$result = '';
	foreach ($parts as $part) {
		// Если часть — защищённый блок (начинается с <script, <style и т.д.), не трогаем
		if (preg_match('/^<(script|style|code|pre|textarea)\b/i', $part)) {
			$result .= $part;
		} else {
			// Иначе применяем замену неразрывных пробелов
			$result .= preg_replace('/(\s|&nbsp;)([а-яА-Яa-zA-Z]{1,2})\s/u', '$1$2&nbsp;', $part);
		}
	}

	return $result;
}

add_filter('acf/format_value', 'mx_fix_orphans', 20);
add_filter('the_content', 'mx_fix_orphans', 20);
add_filter('the_title', 'mx_fix_orphans', 20);
add_filter('the_excerpt', 'mx_fix_orphans', 20);
add_filter('nav_menu_item_title', 'mx_fix_orphans', 20);

// Внимание: навигация и ACF требуют осторожности
// add_filter('nav_menu_item_title', 'mx_fix_orphans', 20); 
// add_filter('acf/format_value', 'mx_fix_orphans', 20); 


add_action('admin_head', function () {
	echo '<style>
        #postexcerpt p {
            display: none !important;
        }
    </style>';
});
//add_filter('big_image_size_threshold', '__return_false');

add_filter('bcn_breadcrumb_title', function ($title, $type, $id) {

	$front_page_id = get_option('page_on_front');

	// Если это крошка главной
	//if (in_array('home', $type) || $front_page_id) {
	//	return get_the_title($front_page_id);
	//}
	if (in_array('home', $type)) {
		return 'Главная';
	}
	//if (in_array('shop', $type) || $title === 'Товары' || $title === 'Shop') {
	//	return 'Каталог';
	//}
	return $title;

}, 10, 3);

// Убираем разделитель
add_filter('bcn_display_separator', '__return_empty_string');



// === CF7 Redirect: Редирект после отправки формы ===
require_once get_template_directory() . '/functions/cf7-redirect.php';

// === CF7 Leads: Собственная система хранения заявок (замена Flamingo) ===
require_once get_template_directory() . '/functions/cf7-leads.php';

// === CF7: переопределение email получателя через настройки сайта ===
add_filter('wpcf7_mail_components', function ($components, $form) {
	$custom_email = get_option('form_email_to');

	if (!empty($custom_email) && is_email($custom_email)) {
		$components['recipient'] = $custom_email;
	}

	return $components;
}, 10, 2);

add_filter('wpcf7_autop', '__return_false', 20);
add_filter('wpcf7_form_elements', function ($content) {
	//$content = preg_replace('/<span class="wpcf7-form-control-wrap.*?">(.*?)<\/span>/is', '$1', $content);
	$content = str_replace('<br />', '', $content);
	return $content;
});


function sort_all_post_types_by_menu_order($query)
{

	if (is_admin() || !$query->is_main_query()) {
		return;
	}


	$post_type = $query->get('post_type');


	if (empty($post_type) || $post_type === 'any' || is_array($post_type) || is_string($post_type)) {
		$query->set('orderby', 'menu_order');
		$query->set('order', 'ASC');
	}
}
add_action('pre_get_posts', 'sort_all_post_types_by_menu_order', 99);

add_filter('woocommerce_get_breadcrumb', 'custom_product_breadcrumb', 20, 2);
function custom_product_breadcrumb($crumbs, $breadcrumb)
{

	// Проверяем, что мы на странице товара ИЛИ в категории товара
	if ((is_product() || is_product_category()) && !empty($crumbs)) {
		$new_crumbs = array();

		// 1. Оставляем "Главная" (это всегда первый элемент массива)
		$new_crumbs[] = $crumbs[0];

		// 2. Вставляем "Каталог"
		$shop_page_id = wc_get_page_id('shop');
		$shop_url = $shop_page_id > 0 ? get_permalink($shop_page_id) : home_url('/shop/');

		$new_crumbs[] = array('Каталог', $shop_url);

		// 3. Добавляем остальные элементы (Категория, Подкатегория, Товар)
		for ($i = 1; $i < count($crumbs); $i++) {
			$new_crumbs[] = $crumbs[$i];
		}

		// Перезаписываем массив крошек
		$crumbs = $new_crumbs;
	}

	return $crumbs;
}
// меняем валюту на BYN
add_filter('woocommerce_currency_symbol', 'change_existing_currency_symbol', 10, 2);
function change_existing_currency_symbol($currency_symbol, $currency)
{
	switch ($currency) {
		case 'BYN':
			$currency_symbol = ' BYN';
			break;
	}
	return $currency_symbol;
}
// убирает ,00
add_filter('woocommerce_price_trim_zeros', '__return_true');

add_filter('woocommerce_loop_add_to_cart_link', 'add_icon_span_to_loop_button', 10, 3);
function add_icon_span_to_loop_button($html, $product, $args)
{
	$text = esc_html($product->add_to_cart_text());

	// Добавляем span перед текстом кнопки
	$new_text = '<span class="add-to-cart-icon"></span><span class="add-to-cart-text">' . $text . '</span>';

	$html = str_replace($text, $new_text, $html);

	return $html;
}

function declension_items($number)
{
	$number = (int) $number;
	$last_two = $number % 100;
	$last_one = $number % 10;

	if ($last_two >= 11 && $last_two <= 19) {
		return 'товаров';
	}
	if ($last_one === 1) {
		return 'товар';
	}
	if ($last_one >= 2 && $last_one <= 4) {
		return 'товара';
	}
	return 'товаров';
}

/**
 * Mini Cart AJAX handler (содержимое корзины)
 */
add_action('wp_ajax_get_mini_cart_content', 'get_mini_cart_content');
add_action('wp_ajax_nopriv_get_mini_cart_content', 'get_mini_cart_content');

function get_mini_cart_content()
{
	ob_start();
	get_template_part('partials/mini-cart');
	$html = ob_get_clean();

	preg_match('/<div class="mini-cart__container">(.*?)<\/div>\s*<\/div>\s*$/s', $html, $matches);

	if (!empty($matches[1])) {
		wp_send_json_success([
			'html' => '<div class="mini-cart__container">' . $matches[1] . '</div>'
		]);
	} else {
		wp_send_json_success(['html' => $html]);
	}
}

/**
 * AJAX удаление из мини-корзины с ПОЛНОЙ синхронизацией
 */
/*
add_action('wp_ajax_mini_cart_remove_item', 'mini_cart_remove_item_sync');
add_action('wp_ajax_nopriv_mini_cart_remove_item', 'mini_cart_remove_item_sync');

function mini_cart_remove_item_sync()
{
	check_ajax_referer('mini_cart_remove_nonce', 'nonce');

	$cart_item_key = isset($_POST['cart_item_key']) ? sanitize_text_field($_POST['cart_item_key']) : '';

	if (empty($cart_item_key)) {
		wp_send_json_error(['message' => 'Cart item key is empty']);
	}

	$removed = WC()->cart->remove_cart_item($cart_item_key);

	if ($removed) {
		$fragments = [];

		// 1. Счетчик в шапке
		ob_start();
		?>
		<span class="cart-btn__counter" id="cart-counter" <?php echo WC()->cart->get_cart_contents_count() === 0 ? 'style="display:none;"' : ''; ?>>
			<?php echo WC()->cart->get_cart_contents_count(); ?>
		</span>
		<?php
		$fragments['#cart-counter'] = ob_get_clean();

		// 2. Контейнер мини-корзины
		ob_start();
		get_template_part('partials/mini-cart');
		$html = ob_get_clean();
		preg_match('/<div class="mini-cart__container">.*?<\/div>\s*<\/div>\s*$/s', $html, $matches);
		if (!empty($matches[0])) {
			$fragments['.mini-cart__container'] = $matches[0];
		}

		// 3. 🚀 ГЛАВНОЕ: Блок Totals основной корзины (без проверки is_cart!)
		ob_start();
		?>
		<div class="cart-page__totals cart-totals" id="cart-totals-block">
			<h2 class="cart-totals__title title-3"><?php esc_html_e('Ваш заказ', 'woocommerce'); ?></h2>
			<div class="cart-totals__info">
				<?php
				$cart_count = WC()->cart->get_cart_contents_count();
				$items_text = sprintf(_n('%d товар', '%d товара', '%d товаров', $cart_count, 'woocommerce'), $cart_count);
				?>
				<span class="cart-totals__count"><?php echo esc_html($items_text); ?></span>
			</div>
			<table class="cart-totals__table">
				<tbody>
					<tr class="cart-subtotal">
						<th><?php esc_html_e('Подытог', 'woocommerce'); ?></th>
						<td><?php wc_cart_totals_subtotal_html(); ?></td>
					</tr>
					<?php foreach (WC()->cart->get_coupons() as $code => $coupon): ?>
						<tr class="cart-discount coupon-<?php echo esc_attr(sanitize_title($code)); ?>">
							<th><?php wc_cart_totals_coupon_label($coupon); ?></th>
							<td><?php wc_cart_totals_coupon_html($coupon); ?></td>
						</tr>
					<?php endforeach; ?>
					<?php if (wc_shipping_enabled() && WC()->cart->needs_shipping()): ?>
						<tr class="shipping">
							<th><?php esc_html_e('Доставка', 'woocommerce'); ?></th>
							<td>
								<?php if (WC()->cart->show_shipping()):
									wc_cart_totals_shipping_html(); else:
									echo '<p>Рассчитается при оформлении</p>'; endif; ?>
							</td>
						</tr>
					<?php endif; ?>
					<tr class="order-total">
						<th><?php esc_html_e('Итого', 'woocommerce'); ?></th>
						<td><?php wc_cart_totals_order_total_html(); ?></td>
					</tr>
				</tbody>
			</table>
			<div class="cart-totals__checkout">
				<a class="cart-totals__checkout-btn btn" href="<?php echo esc_url(wc_get_checkout_url()); ?>">
					<?php esc_html_e('Перейти к оформлению', 'woocommerce'); ?>
					<svg width="16" height="16" viewBox="0 0 24 24" fill="none">
						<path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
							stroke-linejoin="round" />
					</svg>
				</a>
			</div>
		</div>
		<?php
		$fragments['#cart-totals-block'] = ob_get_clean();

		wp_send_json_success([
			'fragments' => $fragments,
			'cart_count' => WC()->cart->get_cart_contents_count()
		]);
	}

	wp_send_json_error(['message' => 'Failed to remove item']);
}
*/
/**
 * Обновление фрагментов корзины
 */

//!
/**
 * Универсальное AJAX удаление товара (работает и для основной, и для мини-корзины)
 */
add_action('wp_ajax_cart_page_remove_item', 'universal_cart_remove_item');
add_action('wp_ajax_nopriv_cart_page_remove_item', 'universal_cart_remove_item');

function universal_cart_remove_item()
{
	// Проверяем nonce (подходит и от основной, и от мини-корзины)
	$nonce = isset($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
	if (!wp_verify_nonce($nonce, 'cart_page_nonce') && !wp_verify_nonce($nonce, 'mini_cart_remove_nonce')) {
		wp_send_json_error(['message' => 'Security check failed']);
	}

	$cart_item_key = isset($_POST['cart_item_key']) ? sanitize_text_field($_POST['cart_item_key']) : '';
	if (empty($cart_item_key)) {
		wp_send_json_error(['message' => 'Cart item key is empty']);
	}

	$removed = WC()->cart->remove_cart_item($cart_item_key);

	if ($removed) {
		// Получаем ВСЕ актуальные фрагменты (счетчик, мини-корзина, totals)
		$fragments = apply_filters('woocommerce_add_to_cart_fragments', []);

		wp_send_json_success([
			'fragments' => $fragments,
			'cart_count' => WC()->cart->get_cart_contents_count()
		]);
	}

	wp_send_json_error(['message' => 'Failed to remove item']);
}
//!
/**
 * Подключение шаблона мини-корзины
 */
add_action('wp_footer', 'mini_cart_template', 5);

function mini_cart_template()
{
	if (class_exists('WooCommerce')) {
		get_template_part('partials/mini-cart');
	}
}

/**
 *  Передаем nonce и URL в body
 */
add_action('wp_body_open', 'output_wc_ajax_attributes', 5);

function output_wc_ajax_attributes()
{
	if (class_exists('WooCommerce')) {
		$remove_nonce = wp_create_nonce('mini_cart_remove_nonce');
		?>
		<script>
			document.body.setAttribute('data-wc-ajax-url', '<?php echo esc_js(WC_AJAX::get_endpoint('%%endpoint%%')); ?>');
			document.body.setAttribute('data-ajax-url', '<?php echo esc_js(admin_url('admin-ajax.php')); ?>');
			document.body.setAttribute('data-remove-nonce', '<?php echo esc_js($remove_nonce); ?>');
		</script>
		<?php
	}
}

function declension_products($number)
{
	$number = (int) $number;
	$last_two = $number % 100;
	$last_one = $number % 10;

	if ($last_two >= 11 && $last_two <= 19) {
		return 'средств';
	}
	if ($last_one === 1) {
		return 'средство';
	}
	if ($last_one >= 2 && $last_one <= 4) {
		return 'средства';
	}
	return 'средств';
}

//!


/**
 * 2. Обновление фрагментов корзины (РАБОТАЕТ И ДЛЯ AJAX ТОЖЕ)
 */
add_filter('woocommerce_add_to_cart_fragments', 'custom_cart_fragments', 10, 1);

function custom_cart_fragments($fragments)
{
	// 1. Счетчик в шапке (всегда обновляем)
	ob_start();
	?>
	<span class="cart-btn__counter" id="cart-counter" <?php echo WC()->cart->get_cart_contents_count() === 0 ? 'style="display:none;"' : ''; ?>>
		<?php echo WC()->cart->get_cart_contents_count(); ?>
	</span>
	<?php
	$fragments['#cart-counter'] = ob_get_clean();

	// 2. Мини-корзина (если используется)
	if (class_exists('WooCommerce')) {
		ob_start();
		// Убедитесь, что путь к вашему шаблону мини-корзины верный!
		get_template_part('partials/mini-cart');
		$html = ob_get_clean();
		preg_match('/<div class="mini-cart__container">.*?<\/div>\s*<\/div>\s*$/s', $html, $matches);
		if (!empty($matches[0])) {
			$fragments['.mini-cart__container'] = $matches[0];
		}
	}

	// 3. Блок Totals на странице корзины
	// ВАЖНО: Мы убрали if (is_cart()), потому что во время AJAX-запроса is_cart() всегда false!
	// Мы просто всегда отдаем этот фрагмент. Если элемента нет на странице, наш JS его просто проигнорирует.
	ob_start();
	?>
	<div class="cart-page__totals cart-totals" id="cart-totals-block">
		<h2 class="cart-totals__title title-3">
			<?php esc_html_e('Ваш заказ', 'woocommerce'); ?>
		</h2>

		<div class="cart-totals__info">
			<?php
			$cart_count = WC()->cart->get_cart_contents_count();
			$items_text = $cart_count . ' ' . declension_items($cart_count);
			?>
			<span class="cart-totals__count">
				<?php echo esc_html($items_text); ?>
			</span>
		</div>

		<table class="cart-totals__table">
			<tbody>
				<tr class="cart-subtotal">
					<th>
						<?php esc_html_e('Подытог', 'woocommerce'); ?>
					</th>
					<td data-title="<?php esc_attr_e('Подытог', 'woocommerce'); ?>">
						<?php wc_cart_totals_subtotal_html(); ?>
					</td>
				</tr>


				<tr class="shipping">
					<th>
						<?php esc_html_e('Доставка', 'woocommerce'); ?>
					</th>
					<td data-title="<?php esc_attr_e('Доставка', 'woocommerce'); ?>">
						<p class="shipping-calculator-message">Рассчитается после выбора способа доставки</p>
					</td>
				</tr>

				<?php do_action('woocommerce_cart_totals_before_order_total'); ?>

				<tr class="order-total">
					<th>
						<?php esc_html_e('Итого', 'woocommerce'); ?>
					</th>
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

	<?php
	$fragments['#cart-totals-block'] = ob_get_clean();

	return $fragments;
}


/**
 * 4. AJAX обновление количества
 */
add_action('wp_ajax_cart_page_update_quantity', 'cart_page_update_quantity');
add_action('wp_ajax_nopriv_cart_page_update_quantity', 'cart_page_update_quantity');

function cart_page_update_quantity()
{
	check_ajax_referer('cart_page_nonce', 'nonce');
	$cart_item_key = isset($_POST['cart_item_key']) ? sanitize_text_field($_POST['cart_item_key']) : '';
	$quantity = isset($_POST['quantity']) ? absint($_POST['quantity']) : 0;

	if (empty($cart_item_key))
		wp_send_json_error(['message' => 'Empty key']);

	if ($quantity === 0) {
		WC()->cart->remove_cart_item($cart_item_key);
	} else {
		WC()->cart->set_quantity($cart_item_key, $quantity);
	}

	// Получаем фрагменты через наш обновленный фильтр
	$fragments = apply_filters('woocommerce_add_to_cart_fragments', []);

	wp_send_json_success([
		'fragments' => $fragments,
		'cart_count' => WC()->cart->get_cart_contents_count()
	]);
}

/**
 * 5. Передача nonce и URL
 */
add_action('wp_body_open', 'cart_page_ajax_attributes');
function cart_page_ajax_attributes()
{
	if (is_cart() && class_exists('WooCommerce')) {
		$nonce = wp_create_nonce('cart_page_nonce');
		?>
		<script>
			document.body.setAttribute('data-cart-ajax-url', '<?php echo esc_js(admin_url('admin-ajax.php')); ?>');
			document.body.setAttribute('data-cart-nonce', '<?php echo esc_js($nonce); ?>');
		</script>
		<?php
	}
}

/**
 * Полное отключение стандартных JS-скриптов корзины WooCommerce
 */
add_action('wp_enqueue_scripts', 'disable_all_woo_cart_js', 999);
function disable_all_woo_cart_js()
{
	if (is_cart()) {
		wp_dequeue_script('wc-cart');
		wp_dequeue_script('wc-cart-fragments');
		wp_dequeue_script('wc-add-to-cart');
	}
}

//!=================================
/**
 * ============================================
 * КАСТОМНОЕ ОПИСАНИЕ ДЛЯ МЕТОДОВ ДОСТАВКИ
 * ============================================
 */

// Добавляем поле "Описание для checkout" в настройки методов доставки
add_filter('woocommerce_shipping_instance_form_fields_flat_rate', 'add_custom_description_to_shipping_method');
add_filter('woocommerce_shipping_instance_form_fields_free_shipping', 'add_custom_description_to_shipping_method');
add_filter('woocommerce_shipping_instance_form_fields_local_pickup', 'add_custom_description_to_shipping_method');

function add_custom_description_to_shipping_method($fields)
{
	$new_fields = [];

	foreach ($fields as $key => $field) {
		$new_fields[$key] = $field;

		if ($key === 'cost') {
			$new_fields['custom_checkout_description'] = [
				'title' => __('Описание для оформления заказа', 'woocommerce'),
				'type' => 'textarea',
				'description' => __('Краткое описание метода, которое увидит клиент на странице оформления заказа. Например: "Доставка в отделение Европочты".', 'woocommerce'),
				'default' => '',
				'placeholder' => __('Введите описание для клиента...', 'woocommerce'),
			];
		}
	}

	return $new_fields;
}

// Функция получения кастомного описания метода доставки
function get_custom_shipping_method_description($method)
{
	if (method_exists($method, 'get_option')) {
		$custom_desc = $method->get_option('custom_checkout_description', '');
		if (!empty($custom_desc)) {
			return $custom_desc;
		}
	}
	return $method->get_method_description();
}

/**
 * Форматирование цены без лишних нулей (для JS)
 * 12.00 → 12
 * 12.50 → 12.50
 */
function format_price_clean($amount)
{
	$rounded = round($amount, 2);

	if (floor($rounded) == $rounded) {
		return number_format($rounded, 0, '.', '');
	}

	$formatted = number_format($rounded, 2, '.', '');
	$formatted = rtrim($formatted, '0');
	$formatted = rtrim($formatted, '.');

	return $formatted;
}

//!===================================
/**
 * ============================================
 * ОБРАБОТКА ОФОРМЛЕНИЯ ЗАКАЗА (AJAX)
 * ============================================
 */
add_action('wp_ajax_process_custom_checkout', 'handle_custom_checkout');
add_action('wp_ajax_nopriv_process_custom_checkout', 'handle_custom_checkout');

function handle_custom_checkout()
{
	// 1. Проверка безопасности
	check_ajax_referer('custom_checkout_nonce', 'nonce');

	// 2. Проверка корзины
	if (!WC()->cart || WC()->cart->is_empty()) {
		wp_send_json_error(['message' => 'Ваша корзина пуста.']);
	}

	// 3. Получение данных
	$first_name = sanitize_text_field($_POST['billing_first_name'] ?? '');
	$phone = sanitize_text_field($_POST['billing_phone'] ?? '');
	$email = sanitize_email($_POST['billing_email'] ?? '');
	$city = sanitize_text_field($_POST['shipping_city'] ?? '');
	$address = sanitize_text_field($_POST['shipping_address_1'] ?? '');
	$country = sanitize_text_field($_POST['shipping_country'] ?? '');
	$comments = sanitize_textarea_field($_POST['order_comments'] ?? '');
	$shipping_comments = sanitize_textarea_field($_POST['shipping_comments'] ?? '');

	$shipping_method = sanitize_text_field($_POST['shipping_method'] ?? '');
	$payment_method = sanitize_text_field($_POST['payment_method'] ?? '');

	$privacy_policy = isset($_POST['privacy_policy']) && $_POST['privacy_policy'] === '1';
	$public_offer = isset($_POST['public_offer']) && $_POST['public_offer'] === '1';

	// 4. Валидация
	$errors = [];
	if (empty($first_name))
		$errors[] = 'Введите ваше имя.';
	if (empty($phone))
		$errors[] = 'Введите номер телефона.';
	if (empty($email) || !is_email($email))
		$errors[] = 'Введите корректный E-mail.';
	if (empty($city))
		$errors[] = 'Введите город.';
	if (empty($address))
		$errors[] = 'Введите адрес или пункт выдачи.';
	if (empty($shipping_method))
		$errors[] = 'Выберите способ доставки.';
	if (empty($payment_method))
		$errors[] = 'Выберите способ оплаты.';
	if (!$privacy_policy)
		$errors[] = 'Необходимо согласие с политикой обработки данных.';
	if (!$public_offer)
		$errors[] = 'Необходимо согласие с условиями публичной оферты.';

	if (!empty($errors)) {
		wp_send_json_error([
			'message' => implode('<br>', $errors),
			'error_code' => 'validation_error',
		]);
	}

	// 5. Создание заказа
	$order = wc_create_order();
	$order->set_status('pending');

	// Billing
	$order->set_billing_first_name($first_name);
	$order->set_billing_phone($phone);
	$order->set_billing_email($email);

	// Shipping (адрес + страна)
	$order->set_shipping_city($city);
	$order->set_shipping_address_1($address);
	if (!empty($country)) {
		$order->set_shipping_country($country);
	}

	// Комментарии
	$final_note = '';
	if (!empty($shipping_comments))
		$final_note .= "Доставка: " . $shipping_comments . "\n";
	if (!empty($comments))
		$final_note .= "Общий: " . $comments;
	if (!empty($final_note)) {
		$order->set_customer_note(trim($final_note));
	}

	// 6. Добавление товаров
	try {
		foreach (WC()->cart->get_cart() as $cart_item) {
			$order->add_product($cart_item['data'], $cart_item['quantity']);
		}
	} catch (Exception $e) {
		error_log('❌ Error adding products to order: ' . $e->getMessage());
		wp_send_json_error([
			'message' => 'Ошибка при добавлении товаров в заказ. Пожалуйста, попробуйте снова.',
			'error_code' => 'system_error',
		]);
	}

	// 7. 🚚 Добавление shipping item
	if ($shipping_method) {
		$shipping_zones = WC_Shipping_Zones::get_zones();
		$found_method = null;

		foreach ($shipping_zones as $zone) {
			$zone_obj = new WC_Shipping_Zone($zone['id']);
			$methods = $zone_obj->get_shipping_methods();

			foreach ($methods as $method_id => $method) {
				$full_id = $zone['id'] . ':' . $method_id;
				if ($full_id === $shipping_method && $method->is_enabled()) {
					$cost = 0;
					if (method_exists($method, 'get_option')) {
						$cost = floatval($method->get_option('cost', 0));
					}

					$found_method = [
						'label' => $method->get_title(),
						'method_id' => $method_id,
						'instance_id' => $method->instance_id ?? 0,
						'cost' => $cost,
					];
					break 2;
				}
			}
		}

		if ($found_method) {
			$item = new WC_Order_Item_Shipping();
			$item->set_props([
				'method_title' => $found_method['label'],
				'method_id' => $found_method['method_id'],
				'instance_id' => $found_method['instance_id'],
				'total' => $found_method['cost'],
				'taxes' => [],
			]);
			$order->add_item($item);
		} else {
			error_log('❌ Shipping method not found: ' . $shipping_method);
			wp_send_json_error([
				'message' => 'Не удалось найти выбранный способ доставки. Пожалуйста, выберите другой.',
				'error_code' => 'shipping_error',
				'order_id' => $order->get_id(),
			]);
		}
	}

	// 8. 💳 Способ оплаты
	$available_gateways = WC()->payment_gateways()->get_available_payment_gateways();
	if (isset($available_gateways[$payment_method])) {
		$order->set_payment_method($available_gateways[$payment_method]);
		$order->set_payment_method_title($available_gateways[$payment_method]->get_title());
	} else {
		error_log('❌ Payment gateway not found: ' . $payment_method);
		wp_send_json_error([
			'message' => 'Не удалось найти выбранный способ оплаты. Пожалуйста, выберите другой.',
			'error_code' => 'payment_failed',
			'order_id' => $order->get_id(),
		]);
	}

	// 9. Пересчёт и сохранение
	try {
		$order->calculate_totals();
		$order_id = $order->save();
	} catch (Exception $e) {
		error_log(' Error saving order: ' . $e->getMessage());
		wp_send_json_error([
			'message' => 'Не удалось сохранить заказ. Пожалуйста, попробуйте позже.',
			'error_code' => 'system_error',
		]);
	}

	if (!$order_id) {
		wp_send_json_error([
			'message' => 'Не удалось создать заказ. Попробуйте позже.',
			'error_code' => 'system_error',
		]);
	}

	// 10. 📧 Отправка уведомлений
	$mailer = WC()->mailer();
	$emails = $mailer->get_emails();

	if (!empty($emails['WC_Email_New_Order'])) {
		$emails['WC_Email_New_Order']->trigger($order_id);
	}

	if (!$order->needs_payment()) {
		$order->update_status('processing', 'Оплата при доставке');
		if (!empty($emails['WC_Email_Customer_Processing_Order'])) {
			$emails['WC_Email_Customer_Processing_Order']->trigger($order_id);
		}
	} else {
		if (!empty($emails['WC_Email_Customer_On_Hold_Order'])) {
			$emails['WC_Email_Customer_On_Hold_Order']->trigger($order_id);
		}
	}

	// 11. Очистка корзины
	WC()->cart->empty_cart();

	// 12. Редирект на страницу успешного заказа
	$thank_you_page = get_page_by_path('success-order');

	if (!$thank_you_page) {
		$thank_you_page_id = 123; // ← ЗАМЕНИТЕ НА РЕАЛЬНЫЙ ID
		$thank_you_page = get_post($thank_you_page_id);
	}

	if ($thank_you_page && $thank_you_page->post_status === 'publish') {
		$redirect_url = add_query_arg('order_id', $order_id, get_permalink($thank_you_page->ID));
		error_log('✅ Success page found: ' . $redirect_url);
	} else {
		$redirect_url = $order->get_checkout_order_received_url();
		error_log('️ Success page not found, using WooCommerce default: ' . $redirect_url);
	}

	wp_send_json_success([
		'redirect' => $redirect_url,
		'order_id' => $order_id
	]);
}

/**
 * Добавляем страну в email уведомления WooCommerce
 */
add_filter('woocommerce_email_order_meta_fields', 'add_shipping_country_to_email', 10, 3);

function add_shipping_country_to_email($fields, $sent_to_admin, $order)
{
	if ($order->get_shipping_country()) {
		$fields['shipping_country'] = array(
			'label' => __('Страна доставки', 'woocommerce'),
			'value' => $order->get_shipping_country(),
		);
	}
	return $fields;
}

/**
 * Добавляем data-атрибуты (картинка, название, цена) к кнопке "В корзину"
 */
add_filter('woocommerce_loop_add_to_cart_link', 'add_custom_data_to_add_to_cart_button', 10, 3);
function add_custom_data_to_add_to_cart_button($html, $product, $args)
{
	// Получаем данные товара
	$image_id = $product->get_image_id();
	$image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
	$product_name = $product->get_name();

	// 🚀 ИСПРАВЛЕНО: получаем цену БЕЗ HTML-тегов
	$product_price = strip_tags(wc_price($product->get_price()));

	// Формируем строку с data-атрибутами
	$custom_data = sprintf(
		'data-product-image="%s" data-product-name="%s" data-product-price="%s"',
		esc_url($image_url),
		esc_attr($product_name),
		esc_attr(trim($product_price))
	);

	// Вставляем атрибуты перед class="button"
	return str_replace('class="button', $custom_data . ' class="button', $html);
}