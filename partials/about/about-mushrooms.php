<?php

$page = get_queried_object();
$default_page = get_page_by_path('about', OBJECT, 'page');

$title = get_field('mushrooms_title', $page) ?: get_field('mushrooms_title', $default_page) ?: '';
$descr = get_field('mushrooms_descr', $page) ?: get_field('mushrooms_descr', $default_page) ?: '';
$links = get_field('mushrooms_links', $page) ?: get_field('mushrooms_links', $default_page) ?: [];
$slider = get_field('mushrooms_slider', $page) ?: get_field('mushrooms_slider', $default_page) ?: [];
$section_decor = get_field('mushrooms_decor', $page) ?: get_field('mushrooms_decor', $default_page) ?? null;

if (!$title && !$descr && empty($links) && empty($slider)) {
	return;
}
?>

<?php if ($title || $descr || !empty($links) || !empty($slider)): ?>
	<section class="section-full about-mushrooms" id="about-mushrooms">
		<?php if ($section_decor && is_array($section_decor) && !empty($section_decor['ID'])): ?>
			<div class="section-decor" aria-hidden="true">
				<?php echo wp_get_attachment_image(
					$section_decor['ID'],
					'full',
					false,
					['class' => 'img', 'alt' => $section_decor['alt'] ?: 'Декор']
				); ?>
			</div>
		<?php endif; ?>
		<div class="un-container un-container--reverse about-mushrooms__container">

			<div class="un-container__content about-mushrooms__content">

				<!-- Ссылки -->
				<?php if (!empty($links)): ?>
					<ul class="about-mushrooms__links">
						<?php foreach ($links as $link_item):
							$link = $link_item['link'] ?? [];

							if (empty($link['url'])) {
								continue;
							}
							?>
							<li class="about-mushrooms__links-item">
								<a class="about-mushrooms__link" href="<?php echo esc_url($link['url']); ?>" <?php if (!empty($link['target'])): ?> target="<?php echo esc_attr($link['target']); ?>" <?php endif; ?>>
									<?php echo esc_html($link['title']); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<!-- Заголовок -->
				<?php if ($title): ?>
					<h2 class="about-mushrooms__title title-2">
						<?php echo esc_html($title); ?>
					</h2>
				<?php endif; ?>

				<!-- Описание -->
				<?php if ($descr): ?>
					<div class="about-mushrooms__descr descr">
						<?php echo wp_kses_post($descr); ?>
					</div>
				<?php endif; ?>

			</div>

			<!-- Слайдер -->
			<?php if (!empty($slider)): ?>
				<div class="un-container__full about-mushrooms__slider">
					<div class="swiper about-mushrooms-swiper"
						data-swiper='{ "slidesPerView": "auto", "rewind": true, "spaceBetween": 24 }'>
						<div class="swiper-wrapper about-mushrooms-swiper__wrapper">
							<?php foreach ($slider as $slider_item):
								$image = $slider_item ?? null;


								?>
								<div class="swiper-slide about-mushrooms-slide">
									<a class="about-mushrooms-slide__wrapper-link image-box" href="<?php echo esc_url($image['url']); ?>"
										data-fancybox>
										<?php echo wp_get_attachment_image(
											$image['ID'],
											'full',
											false,
											[
												'class' => 'img',
												'alt' => $image['alt'] ?: $title,
												'loading' => 'lazy'
											]
										); ?>
									</a>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="swiper-pagination about-mushrooms-swiper__pagination"
						data-swiper-pagination=".about-mushrooms-swiper"></div>
				</div>
			<?php endif; ?>

		</div>
		<?php if ($section_decor && is_array($section_decor) && !empty($section_decor['ID'])): ?>
			<div class="section-decor section-decor--bottom" aria-hidden="true">
				<?php echo wp_get_attachment_image(
					$section_decor['ID'],
					'full',
					false,
					['class' => 'img', 'alt' => $section_decor['alt'] ?: 'Декор']
				); ?>
			</div>
		<?php endif; ?>
	</section>
<?php endif; ?>