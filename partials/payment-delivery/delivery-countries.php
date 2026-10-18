<?php
$page = get_queried_object();

$items = get_field('delivery_countries_list', $page) ?? [];

if (!empty($items)):
	?>
	<section class="section delivery-countries" id="delivery-countries">
		<div class="container delivery-countries__container">
			<ul class="delivery-countries__list grid">
				<?php foreach ($items as $index => $item):
					$item_icon = $item['icon'] ?? null;
					$item_title = $item['title'] ?? '';
					$item_descr = $item['descr'] ?? '';

					if (!$item_title && !$item_descr)
						continue;
					?>
					<li class="delivery-countries__item delivery-card" data-aos="fade-up" data-aos-delay="<?= $index * 100; ?>">
						<?php if ($item_icon && is_array($item_icon) && !empty($item_icon['ID'])): ?>
							<div class="delivery-card__icon">
								<?php echo wp_get_attachment_image(
									$item_icon['ID'],
									'medium',
									false,
									[
										'class' => 'img',
										'alt' => $item_icon['alt'] ?: $item_title,
										'loading' => 'lazy'
									]
								); ?>
							</div>
						<?php endif; ?>

						<div class="delivery-card__content">
							<?php if ($item_title): ?>
								<h3 class="delivery-card__title title-4">
									<?php echo esc_html($item_title); ?>
								</h3>
							<?php endif; ?>

							<?php if ($item_descr): ?>
								<div class="delivery-card__descr descr">
									<?php echo wp_kses_post($item_descr); ?>
								</div>
							<?php endif; ?>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
<?php endif; ?>