<?php
$page = get_queried_object();

$features = get_field('delivery_features_list', $page) ?? [];

if (!empty($features)):
	?>
	<section class="section delivery-features" id="delivery-features">
		<div class="container delivery-features__container">
			<ul class="delivery-features__list grid">
				<?php foreach ($features as $index => $item):
					$item_icon = $item['icon'] ?? null;
					$item_title = $item['title'] ?? '';

					if (!$item_title)
						continue;
					?>
					<li class="delivery-features__item delivery-feature-card" data-aos="fade-up" data-aos-delay="<?= $index * 100; ?>">
						<?php if ($item_icon && is_array($item_icon) && !empty($item_icon['ID'])): ?>
							<div class="delivery-feature-card__icon">
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

						<h3 class="delivery-feature-card__title title-4">
							<?php echo esc_html($item_title); ?>
						</h3>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
<?php endif; ?>