<?php
$page = get_queried_object();

$title = get_field('section_ritual_prepared_title', $page) ?? '';
$cards = get_field('section_ritual_prepared_cards', $page) ?? [];

if ($title || !empty($cards)):
	?>
	<section class="section-full section-ritual-prepared" id="section-ritual-prepared">
		<div class="container section-ritual-prepared__container section-gap" data-aos="fade-up" data-aos-delay="100">
			<?php get_template_part('partials/section-header', null, [
				'title' => $title,
			]); ?>

			<?php if (!empty($cards)): ?>
				<ul class="section-ritual-prepared__cards grid">
					<?php foreach ($cards as $index => $card):
						$card_term_id = $card['term'] ?? null;
						$card_image = $card['image'] ?? null;
						$card_label = $card['label'] ?? '';
						$card_title = $card['title'] ?? '';
						$card_descr = $card['descr'] ?? '';
						$card_btn_text = $card['btn_text'] ?? '';

						if (!$card_term_id)
							continue;

						$term = get_term($card_term_id, 'pa_zadacha');
						if (!$term || is_wp_error($term))
							continue;

						$term_url = get_term_link($term);
						if (is_wp_error($term_url))
							continue;

						$final_btn_text = $card_btn_text ?: 'Смотреть набор';
						?>
						<li class="section-ritual-prepared__card section-ritual-prepared-card">
							<a class="section-ritual-prepared-card__wrapper-link" href="<?php echo esc_url($term_url); ?>" data-aos="fade-up" data-aos-delay="<?= $index * 100; ?>">
								<?php if ($card_image && is_array($card_image) && !empty($card_image['ID'])): ?>
									<div class="section-ritual-prepared-card__image image-box">
										<?php echo wp_get_attachment_image(
											$card_image['ID'],
											'full',
											false,
											[
												'class' => 'img',
												'alt' => $card_image['alt'] ?: $card_title,
												'loading' => 'lazy'
											]
										); ?>
										<?php if ($card_label): ?>
											<span class="section-ritual-prepared-card__label label labels-box">
												<?php echo esc_html($card_label); ?>
											</span>
										<?php endif; ?>
									</div>
								<?php endif; ?>

								<div class="section-ritual-prepared-card__content">
									<?php if ($card_title): ?>
										<h3 class="section-ritual-prepared-card__title title-3">
											<?php echo esc_html($card_title); ?>
										</h3>
									<?php endif; ?>

									<?php if ($card_descr): ?>
										<div class="section-ritual-prepared-card__descr descr">
											<?php echo wp_kses_post($card_descr); ?>
										</div>
									<?php endif; ?>

									<span class="section-ritual-prepared-card__btn btn btn--stroke">
										<?php echo esc_html($final_btn_text); ?>
									</span>
								</div>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>