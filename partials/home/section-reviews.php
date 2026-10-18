<?php
$page = $args['page'] ?? get_queried_object();

// Инициализация переменных настроек секции
$section_title = get_field('reviews_title', $page) ?? 'Ритуал, который хочется повторить';
$section_btn = get_field('reviews_btn', $page) ?? [];
$section_decor = get_field('reviews_decor', $page) ?? null;
$bg_image = get_field('reviews_bg_image', $page) ?? null;

$reviews_query = new WP_Query([
	'post_type' => 'review',
	'posts_per_page' => -1,
	'post_status' => 'publish',
	'orderby' => 'menu_order',
	'order' => 'ASC',
]);

// Защитная обёртка: показываем секцию, если есть заголовок или отзывы
if ($section_title || $reviews_query->have_posts()):
	?>
	<section class="section-full section-reviews jarallax" id="section-reviews">

		<!-- Декор -->
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

		<div class="container section-reviews__container section-gap">

			<!-- Header секции -->
			<div class="section-reviews__header" data-aos="fade-up">
				<?php if ($section_title): ?>
					<h2 class="section-reviews__title title-2"><?php echo wp_kses_post($section_title); ?></h2>
				<?php endif; ?>

				<?php if (!empty($section_btn) && !empty($section_btn['url'])): ?>
					<a class="section-reviews__btn btn" href="<?php echo esc_url($section_btn['url']); ?>" <?php if (!empty($section_btn['target'])): ?>target="<?php echo esc_attr($section_btn['target']); ?>" <?php endif; ?>>
						<?php echo esc_html($section_btn['title']); ?>
					</a>
				<?php endif; ?>
			</div>

			<?php if ($reviews_query->have_posts()): ?>

				<!-- GRID (Десктоп) -->
				<ul class="section-reviews__grid grid hidden-mobile" data-aos="fade-up" data-aos-delay="100">
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
						<li
							class="section-reviews__item review-card <?php echo esc_attr($size_class); ?> reviews-type--<?php echo esc_attr($type); ?>">
							<?php if ($type === 'video' && $video_href): ?>
								<a class="review-card__link" href="<?php echo $video_href; ?>" data-fancybox="reviews"
									data-caption="<?php echo esc_attr($name); ?>">
									<span class="review-card__badge labels-box label icon icon-video">Видеоотзыв</span>
									<?php if ($thumbnail && is_array($thumbnail) && !empty($thumbnail['ID'])): ?>
										<div class="review-card__image image-box icon icon-video">
											<?php echo wp_get_attachment_image($thumbnail['ID'], 'large', false, ['class' => 'img', 'alt' => $thumbnail['alt'] ?: $name, 'loading' => 'lazy']); ?>
										</div>
									<?php endif; ?>
									<div class="review-card__content">
										<h3 class="review-card__title title-3"><?php echo esc_html($name); ?></h3>
										<?php if ($descr): ?>
											<div class="review-card__descr descr"><?php echo wp_kses_post($descr); ?></div>
										<?php endif; ?>
									</div>
								</a>
							<?php else: ?>
								<div class="review-card__content review-card__content--text">
									<?php if ($descr): ?>
										<div class="review-card__descr descr"><?php echo wp_kses_post($descr); ?></div>
									<?php endif; ?>
									<h3 class="review-card__title title-3"><?php echo esc_html($name); ?></h3>
								</div>
							<?php endif; ?>
						</li>
					<?php endwhile; ?>
				</ul>

				<div class="swiper-slider visible-mobile">
					<div class="swiper reviews-swiper"
						data-swiper='{ "slidesPerView": 1, "spaceBetween": 20, "rewind": true, "breakpoints": { "640": { "slidesPerView": 1.5, "spaceBetween": 20 }, "768": { "slidesPerView": 2, "spaceBetween": 20 } } }'>
						<div class="swiper-wrapper reviews-swiper__wrapper">
							<?php
							// Сбрасываем цикл для мобильного слайдера
							$reviews_query->rewind_posts();
							while ($reviews_query->have_posts()):
								$reviews_query->the_post();
								$type = get_field('review_type') ?: 'text';
								$name = get_field('review_name') ?: get_the_title();
								$descr = get_field('review_descr') ?: '';
								$size = get_field('review_size') ?: '';
								$video_url = get_field('review_video_url') ?: '';
								$video_file = get_field('review_video_file') ?: null;
								$thumbnail = get_field('review_thumbnail') ?: null;

								$video_href = '';
								if (!empty($video_url))
									$video_href = esc_url($video_url);
								elseif ($video_file && is_array($video_file) && !empty($video_file['url']))
									$video_href = esc_url($video_file['url']);

								$size_class = ($size === 'large') ? 'review-card--large' : (($size === 'small') ? 'review-card--small' : '');
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
														<?php echo wp_get_attachment_image($thumbnail['ID'], 'large', false, ['class' => 'img', 'alt' => $thumbnail['alt'] ?: $name, 'loading' => 'lazy']); ?>
													</div>
												<?php endif; ?>
												<div class="review-card__content">
													<h3 class="review-card__title title-3"><?php echo esc_html($name); ?></h3>
													<?php if ($descr): ?>
														<div class="review-card__descr descr"><?php echo wp_kses_post($descr); ?></div>
													<?php endif; ?>
												</div>
											</a>
										<?php else: ?>
											<div class="review-card__content review-card__content--text">
												<?php if ($descr): ?>
													<div class="review-card__descr descr"><?php echo wp_kses_post($descr); ?></div><?php endif; ?>
												<h3 class="review-card__title title-3"><?php echo esc_html($name); ?></h3>
											</div>
										<?php endif; ?>
									</div>
								</div>
							<?php endwhile; ?>
						</div>
					</div>
					<div class="swiper-pagination swiper-slider__pagination" data-swiper-pagination=".reviews-swiper"></div>
				</div>

			<?php endif; ?>
		</div>

		<?php if ($bg_image && is_array($bg_image) && !empty($bg_image['ID'])): ?>
			<div class="section-reviews__image image-box jarallax-img">
				<?php echo wp_get_attachment_image($bg_image['ID'], 'full', false, ['class' => 'img jarallax-img', 'alt' => $bg_image['alt'] ?: '', 'loading' => 'eager']); ?>
			</div>
		<?php endif; ?>

	</section>
	<?php
	wp_reset_postdata();
endif;
?>