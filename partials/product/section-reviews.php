<?php
global $product;
if (!$product || !is_a($product, 'WC_Product'))
	return;

$product_id = $product->get_id();

// ACF-поля секции (берем с самой страницы товара)
$section_title = get_field('product_reviews_title', $product_id) ?? 'Отзывы о средстве';
$section_btn = get_field('product_reviews_btn', $product_id) ?? [];
$section_decor = get_field('product_reviews_decor', $product_id) ?? null;
$bg_image = get_field('product_reviews_bg_image', $product_id) ?? null;

// Выбранные отзывы через relationship (возвращает массив ID)
$selected_review_ids = get_field('product_selected_reviews', $product_id) ?? [];

// Формируем аргументы запроса
$reviews_args = [
	'post_type' => 'review',
	'post_status' => 'publish',
	'posts_per_page' => -1, // Показываем все выбранные или все доступные
	'orderby' => 'menu_order',
	'order' => 'ASC',
];

// Если выбраны конкретные отзывы — ограничиваем выборку
if (!empty($selected_review_ids)) {
	$reviews_args['post__in'] = $selected_review_ids;
	$reviews_args['orderby'] = 'post__in'; // Сохраняем порядок выбора
}

$reviews_query = new WP_Query($reviews_args);

if ($section_title || $reviews_query->have_posts()):
	?>
	<section class="section-reviews section-reviews--product jarallax" id="section-reviews">

		<!-- Декор -->
		<?php if ($section_decor && is_array($section_decor) && !empty($section_decor['ID'])): ?>
			<div class="section-decor" aria-hidden="true">
				<?php echo wp_get_attachment_image(
					$section_decor['ID'],
					'large',
					false,
					['class' => 'img', 'alt' => $section_decor['alt'] ?: '']
				); ?>
			</div>
		<?php endif; ?>

		<div class="container section-reviews__container section-gap">

			<!-- Header -->
			<div class="section-reviews__header" data-aos="fade-up" data-aos-delay="100">
				<?php if ($section_title): ?>
					<h2 class="section-reviews__title title-2">
						<?php echo wp_kses_post($section_title); ?>
					</h2>
				<?php endif; ?>

				<?php if (!empty($section_btn) && !empty($section_btn['url'])): ?>
					<a class="section-reviews__btn btn" href="<?php echo esc_url($section_btn['url']); ?>" <?php if (!empty($section_btn['target'])): ?>target="
				<?php echo esc_attr($section_btn['target']); ?>" <?php endif; ?>>
						<?php echo esc_html($section_btn['title']); ?>
					</a>
				<?php endif; ?>
			</div>

			<?php if ($reviews_query->have_posts()): ?>

				<!-- SWIPER -->
				<div class="swiper-slider" data-aos="fade-up">
					<div class="swiper reviews-swiper"
						data-swiper='{ "slidesPerView": 1, "spaceBetween": 20, "rewind": true, "breakpoints": { "640": { "slidesPerView": 1.5, "spaceBetween": 20 }, "768": { "slidesPerView": 2.5, "spaceBetween": 20 }, "1024": { "slidesPerView": 3, "spaceBetween": 20 } } }'>

						<div class="swiper-wrapper reviews-swiper__wrapper">
							<?php while ($reviews_query->have_posts()):
								$reviews_query->the_post();
								$type = get_field('review_type') ?: 'text';
								$name = get_field('review_name') ?: get_the_title();
								$descr = get_field('review_descr') ?: '';
								$size = get_field('review_size') ?: '';
								$video_url = get_field('review_video_url') ?: '';
								$video_file = get_field('review_video_file') ?: null;
								$thumbnail = get_field('review_thumbnail') ?: null;
								$linked_product_id = get_field('review_linked_product') ?: null;

								// Логика видео: приоритет ссылки, затем файла
								$video_href = '';
								if (!empty($video_url)) {
									$video_href = esc_url($video_url);
								} elseif ($video_file && is_array($video_file) && !empty($video_file['url'])) {
									$video_href = esc_url($video_file['url']);
								}

								$size_class = '';
								if ($size === 'large')
									$size_class = 'review-card--large';
								elseif ($size === 'small')
									$size_class = 'review-card--small';
								?>
								<div class="swiper-slide reviews-swiper__slide">
									<div
										class="review-card <?php echo esc_attr($size_class); ?> reviews-type--<?php echo esc_attr($type); ?>">
										<?php if ($type === 'video' && $video_href): ?>
											<a class="review-card__link" href="<?php echo $video_href; ?>" data-fancybox="reviews"
												data-caption="<?php echo esc_attr($name); ?>">
												<span class="review-card__badge labels-box label icon icon-video">Видеоотзыв</span>
												<?php if ($thumbnail && is_array($thumbnail) && !empty($thumbnail['ID'])): ?>
													<div class="review-card__image image-box icon icon-video">
														<?php echo wp_get_attachment_image(
															$thumbnail['ID'],
															'large',
															false,
															['class' => 'img', 'alt' => $thumbnail['alt'] ?: $name, 'loading' => 'lazy']
														); ?>
													</div>
												<?php endif; ?>
												<div class="review-card__content">
													<h3 class="review-card__title title-3">
														<?php echo esc_html($name); ?>
													</h3>
													<?php if ($descr): ?>
														<div class="review-card__descr descr">
															<?php echo wp_kses_post($descr); ?>
														</div>
													<?php endif; ?>
												</div>
											</a>
										<?php else: ?>
											<div class="review-card__content review-card__content--text">
												<?php if ($descr): ?>
													<div class="review-card__descr descr">
														<?php echo wp_kses_post($descr); ?>
													</div>
												<?php endif; ?>
												<h3 class="review-card__title title-3">
													<?php echo esc_html($name); ?>
												</h3>
											</div>
										<?php endif; ?>
									</div>
								</div>
							<?php endwhile; ?>
						</div>
					</div>
					<!-- Навигация Swiper -->
					<div class="swiper-pagination swiper-slider__pagination" data-swiper-pagination=".reviews-swiper"></div>
				</div>

			<?php endif; ?>
		</div>

		<!-- Фоновое изображение (Jarallax) -->
		<?php if ($bg_image && is_array($bg_image) && !empty($bg_image['ID'])): ?>
			<div class="section-reviews__image image-box jarallax-img">
				<?php echo wp_get_attachment_image(
					$bg_image['ID'],
					'full',
					false,
					['class' => 'img jarallax-img', 'alt' => $bg_image['alt'] ?: '', 'loading' => 'eager']
				); ?>
			</div>
		<?php endif; ?>

	</section>
	<?php
	wp_reset_postdata();
endif;
?>