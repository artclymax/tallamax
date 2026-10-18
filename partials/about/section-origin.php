<?php
$page = get_queried_object();

$title = get_field('section_origin_title', $page) ?? '';
$cards = get_field('section_origin_cards', $page) ?? [];
$section_decor = get_field('section_origin_decor', $page) ?? null;

if ($title || !empty($cards) || ($section_decor && !empty($section_decor['ID']))):
	?>
	<section class="section-full section-stages section-origin" id="section-origin">
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

						if (!$card_title && !$card_descr)
							continue;

						$card_number = sprintf('%02d', $index + 1);
						?>
						<li class="section-stages__card section-stages-card card-box" data-aos="fade-up"
							data-aos-delay="<?= $index * 100; ?>">
							<?php if ($card_bg && is_array($card_bg) && !empty($card_bg['ID'])): ?>
								<div class="section-stages-card__bg image-box">
									<?php echo wp_get_attachment_image(
										$card_bg['ID'],
										'large',
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
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>

		
	</section>
<?php endif; ?>