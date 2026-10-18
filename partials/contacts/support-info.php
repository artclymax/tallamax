<?php
$page = get_queried_object();

$cards = get_field('support_info_cards', $page) ?? [];
$section_decor = get_field('support_info_decor', $page) ?? null;

if (!empty($cards) || ($section_decor && !empty($section_decor['ID']))):
	?>
	<section class="section-full support-info" id="support-info">
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

		<div class="container support-info__container">
			<?php if (!empty($cards)): ?>
				<ul class="support-info__cards grid">
					<?php foreach ($cards as $index => $card):
						$card_icon = $card['icon'] ?? null;
						$card_title = $card['title'] ?? '';
						$card_descr = $card['descr'] ?? '';
						$card_bg = $card['bg'] ?? null;

						if (!$card_title && !$card_descr)
							continue;
						?>
						<li class="support-info__card support-info-card card-box" data-aos="fade-up" data-aos-delay="<?= $index * 100; ?>">
							<div class="support-info-card__content">
								<div class="support-info-card__header">
									<?php if ($card_icon && is_array($card_icon) && !empty($card_icon['ID'])): ?>
										<div class="support-info-card__icon">
											<?php echo wp_get_attachment_image(
												$card_icon['ID'],
												'medium',
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
										<h3 class="support-info-card__title title-4">
											<?php echo esc_html($card_title); ?>
										</h3>
									<?php endif; ?>
								</div>

								<?php if ($card_descr): ?>
									<div class="support-info-card__descr descr">
										<?php echo wp_kses_post($card_descr); ?>
									</div>
								<?php endif; ?>
							</div>

							<?php if ($card_bg && is_array($card_bg) && !empty($card_bg['ID'])): ?>
								<div class="support-info-card__bg image-box">
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
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>