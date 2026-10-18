<?php
$page = get_queried_object();

$title = get_field('legal_info_title', $page) ?? '';
$list_primary = get_field('legal_info_list_primary', $page) ?? [];
$list_secondary = get_field('legal_info_list_secondary', $page) ?? [];

if ($title || !empty($list_primary) || !empty($list_secondary)):
	?>
	<section class="section legal-info" id="legal-info">
		<div class="container legal-info__container">
			<div class="legal-info__body" data-aos="fade-up">
				<?php get_template_part('partials/section-header', null, [
					'title' => $title,
				]); ?>

				<div class="legal-info__content">
					<?php if (!empty($list_primary)): ?>
						<ul class="legal-info__list">
							<?php foreach ($list_primary as $item):
								$item_key = $item['key'] ?? '';
								$item_value = $item['value'] ?? '';

								if (!$item_key && !$item_value)
									continue;
								?>
								<li class="legal-info__item legal-info-item">
									<p class="legal-info-item__key">
										<?php echo esc_html($item_key); ?>
									</p>
									<p class="legal-info-item__value">
										<?php echo esc_html($item_value); ?>
									</p>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>

					<?php if (!empty($list_secondary)): ?>
						<ul class="legal-info__list">
							<?php foreach ($list_secondary as $item):
								$item_key = $item['key'] ?? '';
								$item_value = $item['value'] ?? '';

								if (!$item_key && !$item_value)
									continue;
								?>
								<li class="legal-info__item legal-info-item">
									<p class="legal-info-item__key">
										<?php echo esc_html($item_key); ?>
									</p>
									<p class="legal-info-item__value">
										<?php echo esc_html($item_value); ?>
									</p>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>