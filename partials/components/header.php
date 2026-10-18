<?php
$page = 'option';

$class = $args['class'] ?? '';
$btn = get_field('header_btn', $page) ?? [];
$cart_count = WC()->cart->get_cart_contents_count();
$bg_menu = get_template_directory_uri() . '/assets/images/menu-bg.webp';
?>

<header class="header <?= esc_attr($class) ?>" data-auto-calc="header, height" >
	<div class="container header__container" data-aos="fade-up" data-aos-delay="100">
		<div class="header__logo logo">
			<?php mx_logo(); ?>
		</div>
		<nav class="header__menu header-menu" style="--bg-menu: url('<?= esc_attr($bg_menu) ?>')">
			<div class="header-menu__main-menu">
				<?php
				wp_nav_menu(array(
					'theme_location' => 'header-menu',
					'container' => false,
					'menu_class' => 'header-menu__list',
					'fallback_cb' => false,
					'depth' => 1
				));
				?>
			</div>
			<?php if (!empty($btn)): ?>
				<a class="header-menu__btn header__btn btn btn--stroke visible-tablet"
					href="<?php echo esc_url($btn['url']) ?>">
					<?php echo esc_html($btn['title']) ?>
				</a>
			<?php endif; ?>
		</nav>
		<div class="header__btn-box">
			<a class="header__cart-btn cart-btn" href="#" aria-label="Корзина">
				<span class="cart-btn__counter" id="cart-counter" <?php echo $cart_count === 0 ? 'style="display:none;"' : ''; ?>>
					<?php echo esc_html($cart_count); ?>
				</span>
				<span class="cart-btn__icon">
				</span>
			</a>
			<?php if (!empty($btn)): ?>
				<a class="header__btn btn btn--stroke hidden-tablet" href="<?php echo esc_url($btn['url']) ?>">
					<?php echo esc_html($btn['title']) ?>
				</a>
			<?php endif; ?>
			<!-- BURGER -->
			<button class="header__burger-btn burger-btn visible-tablet" type="button" aria-label="Открыть/закрыть меню">
				<span></span>
			</button>
		</div>
	</div>
</header>