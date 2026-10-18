<?php
$page = get_queried_object();

$title = get_field('section_stages_title', $page) ?? '';
$cards = get_field('section_stages_cards', $page) ?? [];

if ($title || !empty($cards)):
	?>
	<section class="section-full section-stages" id="section-stages">
		<div class="container section-stages__container section-gap" data-aos="fade-up" data-aos-delay="100">
			<?php get_template_part('partials/section-header', null, [
				'title' => $title,
			]); ?>

			<?php if (!empty($cards)): ?>
				<ul class="section-stages__cards">
					<?php foreach ($cards as $index => $card):
						$card_bg = $card['bg'] ?? null;
						$card_title = $card['title'] ?? '';
						$card_descr = $card['descr'] ?? '';
						$card_category_id = $card['category'] ?? null;
						$card_btn_text = $card['btn_text'] ?? '';

						if (!$card_title && !$card_descr && !$card_category_id)
							continue;

						$card_number = sprintf('%02d', $index + 1);

						$category_url = '';
						$category_name = '';
						if ($card_category_id) {
							$term = get_term($card_category_id, 'product_cat');
							if ($term && !is_wp_error($term)) {
								$category_url = get_term_link($term);
								$category_name = $term->name;
							}
						}

						$final_btn_text = $card_btn_text ?: $category_name;
						?>
						<li class="section-stages__card section-stages-card card-box" data-aos="fade-up" data-aos-delay="<?php echo ($index + 1) * 100; ?>">
							<?php if ($card_bg && is_array($card_bg) && !empty($card_bg['ID'])): ?>
								<div class="section-stages-card__bg image-box">
									<?php echo wp_get_attachment_image(
										$card_bg['ID'],
										'full',
										false,
										[
											'class' => 'img',
											'alt' => $card_bg['alt'] ?: $card_title,
											'loading' => 'lazy'
										]
									); ?>
								</div>
							<?php endif; ?>

							<div class="section-stages-card__content">
								<span class="section-stages-card__number title-3">
									<?php echo esc_html($card_number); ?>
								</span>

								<?php if ($card_title): ?>
									<h3 class="section-stages-card__title title-3">
										<?php echo esc_html($card_title); ?>
									</h3>
								<?php endif; ?>

								<?php if ($card_descr): ?>
									<div class="section-stages-card__descr descr">
										<?php echo wp_kses_post($card_descr); ?>
									</div>
								<?php endif; ?>

								<?php if ($category_url && !is_wp_error($category_url)): ?>
									<a class="section-stages-card__btn btn btn--small" href="<?php echo esc_url($category_url); ?>">
										<?php echo esc_html($final_btn_text); ?>
									</a>
								<?php endif; ?>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>