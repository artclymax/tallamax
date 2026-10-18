<?php
// ACF-поля товара
$composition = get_field('product_composition') ?? '';
$skin_type = get_field('product_skin_type') ?? '';
$key_assets = get_field('product_key_assets') ?? '';
$delivery_payment = get_field('product_delivery_payment') ?? '';
$usage = get_field('product_usage') ?? '';

// WooCommerce описание (лучше использовать $product->get_description(), но get_the_content() тоже работает в цикле)
$description = get_the_content() ?? '';

// Проверяем, есть ли хоть какой-то контент
if (!$description && !$composition && !$skin_type && !$key_assets && !$delivery_payment && !$usage) {
	return;
}
?>

<section class="section product-details" id="product-details">
	<div class="container product-details__container section-gap">

		<div class="product-details__list spoilers-list grid">

			<!-- КОЛОНКА 1 -->
			<div class="product-details__col">
				<?php if ($description): ?>
					<div class="spoiler-item spoiler-active" data-spoiler data-aos="fade-up" data-aos-delay="100">
						<button class="spoiler-item__btn" data-spoiler-title type="button">
							<h3 class="spoiler-item__title">Описание</h3>
							<span class="spoiler-item__icon"></span>
						</button>
						<div class="spoiler-item__content" data-spoiler-content>
							<div class="spoiler-item__content-wrapper">
								<div class="spoiler-item__descr descr">
									<?php echo wp_kses_post($description); ?>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<!-- Способ применения -->
				<?php if ($usage): ?>
					<div class="spoiler-item" data-spoiler data-aos="fade-up" data-aos-delay="200">
						<button class="spoiler-item__btn" data-spoiler-title type="button">
							<h3 class="spoiler-item__title">Способ применения</h3>
							<span class="spoiler-item__icon"></span>
						</button>
						<div class="spoiler-item__content" data-spoiler-content>
							<div class="spoiler-item__content-wrapper">
								<div class="spoiler-item__descr descr">
									<?php echo wp_kses_post($usage); ?>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<!-- КОЛОНКА 2 -->
			<div class="product-details__col">
				<!-- Состав -->
				<?php if ($composition): ?>
					<div class="spoiler-item" data-spoiler data-aos="fade-up" data-aos-delay="300">
						<button class="spoiler-item__btn" data-spoiler-title type="button">
							<h3 class="spoiler-item__title">Состав</h3>
							<span class="spoiler-item__icon"></span>
						</button>
						<div class="spoiler-item__content" data-spoiler-content>
							<div class="spoiler-item__content-wrapper">
								<div class="spoiler-item__descr descr">
									<?php echo wp_kses_post($composition); ?>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<!-- Ключевые активы -->
				<?php if ($key_assets): ?>
					<div class="spoiler-item" data-spoiler data-aos="fade-up" data-aos-delay="400">
						<button class="spoiler-item__btn" data-spoiler-title type="button">
							<h3 class="spoiler-item__title">Ключевые активы</h3>
							<span class="spoiler-item__icon"></span>
						</button>
						<div class="spoiler-item__content" data-spoiler-content>
							<div class="spoiler-item__content-wrapper">
								<div class="spoiler-item__descr descr">
									<?php echo wp_kses_post($key_assets); ?>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<!-- КОЛОНКА 3 -->
			<div class="product-details__col">
				<!-- Для какого типа кожи -->
				<?php if ($skin_type): ?>
					<div class="spoiler-item" data-spoiler data-aos="fade-up" data-aos-delay="500">
						<button class="spoiler-item__btn" data-spoiler-title type="button">
							<h3 class="spoiler-item__title">Для какого типа кожи</h3>
							<span class="spoiler-item__icon"></span>
						</button>
						<div class="spoiler-item__content" data-spoiler-content>
							<div class="spoiler-item__content-wrapper">
								<div class="spoiler-item__descr descr">
									<?php echo wp_kses_post($skin_type); ?>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>

				<!-- Доставка и оплата -->
				<?php if ($delivery_payment): ?>
					<div class="spoiler-item" data-spoiler data-aos="fade-up" data-aos-delay="600">
						<button class="spoiler-item__btn" data-spoiler-title type="button">
							<h3 class="spoiler-item__title">Доставка и оплата</h3>
							<span class="spoiler-item__icon"></span>
						</button>
						<div class="spoiler-item__content" data-spoiler-content>
							<div class="spoiler-item__content-wrapper">
								<div class="spoiler-item__descr descr">
									<?php echo wp_kses_post($delivery_payment); ?>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>

		</div>
	</div>
</section>