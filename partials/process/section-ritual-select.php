<?php
$page = get_queried_object();

$title = get_field('section_ritual_title', $page) ?? '';
$descr = get_field('section_ritual_descr', $page) ?? '';
$cards = get_field('section_ritual_cards', $page) ?? [];
$btn = get_field('section_ritual_btn', $page) ?? [];
$section_decor = get_field('section_ritual_decor', $page) ?? null;
if ($title || $descr || !empty($cards) || (!empty($btn) && !empty($btn['url']))):
	?>
	<section class="section section-ritual-select" id="section-ritual-select">
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
		<div class="container section-ritual-select__container section-gap" data-aos="fade-up" data-aos-delay="100">
			<?php get_template_part('partials/section-header', null, [
				'title' => $title,
				'descr' => $descr,
			]); ?>

			<?php if (!empty($cards)): ?>
				<ul class="section-ritual-select__cards">
					<?php foreach ($cards as $index => $card):
						$card_term_id = $card['term'] ?? null;
						$card_icon = $card['icon'] ?? null;
						$card_title = $card['title'] ?? '';

						if (!$card_term_id)
							continue;

						$term = get_term($card_term_id, 'pa_zadacha');
						if (!$term || is_wp_error($term))
							continue;

						$term_url = get_term_link($term);
						if (is_wp_error($term_url))
							continue;

						$final_title = $card_title ?: $term->name;
						?>
						<li class="section-ritual-select__card section-ritual-select-card" data-aos="fade-up" data-aos-delay="<?= $index * 100; ?>">
							<a class="section-ritual-select-card__wrapper-link card-box" href="<?php echo esc_url($term_url); ?>">
								<?php if ($card_icon && is_array($card_icon) && !empty($card_icon['ID'])): ?>
									<div class="section-ritual-select-card__icon">
										<?php echo wp_get_attachment_image(
											$card_icon['ID'],
											'medium',
											false,
											[
												'class' => 'img',
												'alt' => $card_icon['alt'] ?: $final_title,
												'loading' => 'lazy'
											]
										); ?>
									</div>
								<?php endif; ?>

								<?php if ($final_title): ?>
									<h3 class="section-ritual-select-card__title title-4">
										<?php echo esc_html($final_title); ?>
									</h3>
								<?php endif; ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<?php if (!empty($btn) && !empty($btn['url'])): ?>
				<a class="section-ritual-select__btn btn" href="<?php echo esc_url($btn['url']); ?>" <?php if (!empty($btn['target'])): ?>target="
			<?php echo esc_attr($btn['target']); ?>" <?php endif; ?> data-aos="fade-up" data-aos-delay="100">
					<?php echo esc_html($btn['title']); ?>
				</a>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>