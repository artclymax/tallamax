<?php
/**
 * Template Part: Hero Section
 * Description: Главная секция с ритуалами ухода TallaMax
 */

$page_id = get_the_ID();

// ==================== КОНТЕНТ ====================
$eyebrow = get_field('hero_eyebrow', $page_id) ?? '';
$title = get_field('hero_title', $page_id) ?? '';
$descr = get_field('hero_descr', $page_id) ?? '';
$btn = get_field('hero_btn', $page_id) ?? null;
$features = get_field('hero_features', $page_id) ?? [];

// ==================== СПИСКИ ====================
$rituals = get_field('hero_rituals', $page_id) ?? [];

// ==================== МЕДИА ====================
$bg_desktop = get_field('hero_bg_desktop', $page_id) ?? null;
$bg_mobile = get_field('hero_bg_mobile', $page_id) ?? null;

// Если нет контента — не выводим секцию
if (!$title && empty($rituals)) {
	return;
}

// Данные кнопки
$btn_url = '';
$btn_title = '';
$btn_target = '_self';

if ($btn && !empty($btn['url'])) {
	$btn_url = $btn['url'];
	$btn_title = $btn['title'];
	$btn_target = !empty($btn['target']) ? $btn['target'] : '_self';
}
?>

<section class="hero jarallax" id="hero">
	<div class="container hero__container">

		<!-- Левая часть: контент -->
		<div class="hero__content" data-aos="fade-up">

			<!-- Надзаголовок -->
			<?php if ($eyebrow): ?>
				<p class="hero__eyebrow eyebrow">
					<?php echo esc_html($eyebrow); ?>
				</p>
			<?php endif; ?>

			<!-- Заголовок и описание -->
			<div class="hero__header">
				<?php if ($title): ?>
					<h1 class="hero__title title-1">
						<?php echo esc_html($title); ?>
					</h1>
				<?php endif; ?>

				<?php if ($descr): ?>
					<div class="hero__descr descr">
						<?php echo wp_kses_post($descr); ?>
					</div>
				<?php endif; ?>

				<?php if ($btn_url): ?>
					<a class="hero__btn btn" href="<?php echo esc_url($btn_url); ?>" <?php if ($btn_target !== '_self'): ?>target="
					<?php echo esc_attr($btn_target); ?>" <?php endif; ?>>
						<?php echo esc_html($btn_title); ?>
					</a>
				<?php endif; ?>
			</div>

			<!-- Преимущества (иконки) -->
			<?php if (!empty($features)): ?>
				<ul class="hero__features hero-features" data-aos="fade-up" data-aos-delay="100">
					<?php foreach ($features as $index =>$feature):
						$feature_icon = $feature['icon'] ?? null;
						$feature_text = $feature['text'] ?? '';
						if (!$feature_text)
							continue;
						?>
						<li class="hero-features__item">
							<div class="hero-features__icon">
								<?php if ($feature_icon && is_array($feature_icon) && !empty($feature_icon['ID'])): ?>
									<?php echo wp_get_attachment_image(
										$feature_icon['ID'],
										'thumbnail',
										false,
										[
											'class' => 'img',
											'alt' => $feature_icon['alt'] ?: 'Иконка преимущества',
										]
									); ?>
								<?php endif; ?>
							</div>
							<p class="hero-features__descr">
								<?php echo wp_kses_post($feature_text); ?>
							</p>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

		</div>

		<!-- Правая часть: ритуалы -->
		<?php if (!empty($rituals)): ?>
			<ul class="hero__rituals hero-rituals">
				<?php foreach ($rituals as $index => $ritual):
					$ritual_image = $ritual['image'] ?? null;
					$ritual_title = $ritual['title'] ?? '';
					$ritual_descr = $ritual['descr'] ?? '';
					$category_id = $ritual['link'] ?? null;
					$ritual_url = '';
					if ($category_id) {
						$ritual_url = get_term_link((int) $category_id, 'product_cat');
						// Защита от ошибок
						if (is_wp_error($ritual_url)) {
							$ritual_url = '';
						}
					}

					?>
					<li class="hero-rituals__item hero-rituals-item" data-aos="fade-up"
						data-aos-delay="<?php echo $index * 100; ?>">
						<a class="hero-rituals-item__link-wrapper icon icon--after icon--arrow-right"
							href="<?php echo esc_url($ritual_url); ?>">

							<div class="hero-rituals-item__content">
								<?php if ($ritual_title): ?>
									<h3 class="hero-rituals-item__title title-3">
										<?php echo esc_html($ritual_title); ?>
									</h3>
								<?php endif; ?>

								<?php if ($ritual_descr): ?>
									<div class="hero-rituals-item__descr descr">
										<p>
											<?php echo wp_kses_post($ritual_descr); ?>
										</p>
									</div>
								<?php endif; ?>
							</div>
						</a>

						<!-- Фоновое изображение карточки -->
						<?php if ($ritual_image && is_array($ritual_image) && !empty($ritual_image['ID'])): ?>
							<div class="hero-rituals-item__bg image-box">
								<?php echo wp_get_attachment_image(
									$ritual_image['ID'],
									'medium_large',
									false,
									[
										'class' => 'img',
										'alt' => $ritual_image['alt'] ?: $ritual_title,
										'loading' => 'lazy',
									]
								); ?>
							</div>
						<?php endif; ?>

					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

	</div>

	<!-- Фоновые изображения секции -->
	<div class="hero__bg-box image-box jarallax-img">
		<?php if ($bg_desktop && is_array($bg_desktop) && !empty($bg_desktop['ID'])): ?>
			<img class="hero__bg-big hidden-mobile" src="<?php echo esc_url($bg_desktop['url']); ?>"
				alt="<?php echo esc_attr($bg_desktop['alt'] ?: 'Фон hero секции'); ?>" />
		<?php endif; ?>

		<?php if ($bg_mobile && is_array($bg_mobile) && !empty($bg_mobile['ID'])): ?>
			<img class="hero__bg-small visible-mobile" src="<?php echo esc_url($bg_mobile['url']); ?>"
				alt="<?php echo esc_attr($bg_mobile['alt'] ?: 'Фон hero секции'); ?>" />
		<?php endif; ?>
	</div>
</section>