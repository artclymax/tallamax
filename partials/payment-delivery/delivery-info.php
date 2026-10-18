<?php
$page = get_queried_object();

$items = get_field('delivery_info_list', $page) ?? [];

if (!empty($items)):
	?>
	<section class="section delivery-info" id="delivery-info">
		<div class="container delivery-info__container">
			<ul class="delivery-info__list grid">
				<?php foreach ($items as $index => $item):
					$item_icon = $item['icon'] ?? null;
					$item_title = $item['title'] ?? '';
					$item_descr = $item['descr'] ?? '';

					if (!$item_title && !$item_descr)
						continue;
					?>
					<li class="delivery-info__item delivery-card delivery-card--info" data-aos="fade-up" data-aos-delay="<?= $index * 100; ?>">
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