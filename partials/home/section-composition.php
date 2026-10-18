<?php
$page = get_queried_object();

$title = get_field('section_composition_title', $page) ?? '';
$descr = get_field('section_composition_descr', $page) ?? '';
$btn = get_field('section_composition_btn', $page) ?? [];
$cards = get_field('section_composition_cards', $page) ?? [];
$bg = get_field('section_composition_bg', $page) ?? null;

if ($title || $descr || !empty($cards) || (!empty($btn) && !empty($btn['url'])) || ($bg && !empty($bg['ID']))):
	?>
	<section class="section-full section-composition jarallax" id="section-composition">
		<div class="container section-composition__container">
			<div class="section-composition__content" data-aos="fade-up">
				<?php get_template_part('partials/section-header', null, [
					'title' => $title,
					'descr' => $descr,
				]); ?>

				<?php if (!empty($btn) && !empty($btn['url'])): ?>
					<a class="section-composition__btn btn" href="<?php echo esc_url($btn['url']); ?>" <?php if (!empty($btn['target'])): ?>target="<?php echo esc_attr($btn['target']); ?>" <?php endif; ?>>
						<?php echo esc_html($btn['title']); ?>
					</a>
				<?php endif; ?>
			</div>

			<?php if (!empty($cards)): ?>
				<ul class="section-composition__cards" data-aos="fade-up" data-aos-delay="100">
					<?php foreach ($cards as $index => $card):
						$card_icon = $card['icon'] ?? null;
						$card_title = $card['title'] ?? '';
						$card_descr = $card['descr'] ?? '';

						if (!$card_title && !$card_descr)
							continue;
						?>
						<li class="section-composition__card section-composition-card">
							<?php if ($card_icon && is_array($card_icon) && !empty($card_icon['ID'])): ?>
								<div class="section-composition-card__icon">
									<?php echo wp_get_attachment_image(
										$card_icon['ID'],
										'full',
										false,
										[
											'class' => 'img',
											'alt' => $card_icon['alt'] ?: $card_title,
											'loading' => 'lazy'
										]
									); ?>
								</div>
							<?php endif; ?>

							<?php if ($card_title): ?>
								<h3 class="section-composition-card__title title-4">
									<?php echo esc_html($card_title); ?>
								</h3>
							<?php endif; ?>

							<?php if ($card_descr): ?>
								<div class="section-composition-card__descr descr">
									<?php echo wp_kses_post($card_descr); ?>
								</div>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>

		<?php if ($bg && is_array($bg) && !empty($bg['ID'])): ?>
			<div class="section-composition__bg image-box jarallax-img">
				<?php echo wp_get_attachment_image(
					$bg['ID'],
					'full',
					false,
					[
						'class' => 'img',
						'alt' => $bg['alt'] ?: $title,
						'loading' => 'lazy'
					]
				); ?>
			</div>
		<?php endif; ?>
	</section>
<?php endif; ?>