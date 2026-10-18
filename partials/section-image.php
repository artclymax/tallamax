<?php
$page = $args['page'] ?? get_queried_object();

$image = get_field('section_image', $page) ?? get_field('section_image', 'option') ?? null;

if (!empty($image)): ?>
	<div class="section-image image-box jarallax">
		<?php echo wp_get_attachment_image(
			$image['ID'],
			'full',
			false,
			array(
				'class' => 'img jarallax-img',
				'alt' => $image['alt'] ?: ''
			)
		); ?>
	</div>
<?php endif; ?>