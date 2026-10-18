<?php
$page = $args['page'] ?? get_queried_object();
$class = $args['class'] ?? '';

if (is_archive() || is_tax()) {
	$archive_name = $args['page'] ?: get_queried_object()->has_archive;
	if (is_tax()) {
		$archive_name = $args['page'] ?: get_taxonomy(get_queried_object()->taxonomy)->object_type[0];

	}
	$page = get_page_by_path($archive_name, OBJECT, 'page');
}

$label = get_field('hero_label', $page) ?: get_the_title() ?? '';
$title = get_field('hero_title', $page) ?: get_the_title() ?? '';
$descr = get_field('hero_descr', $page) ?? '';
$image = get_field('hero_image', $page) ?? null;

if ($title || $descr || ($image && is_array($image) && !empty($image['ID']))):
	?>
	<section class="section hero-page jarallax <?= esc_attr($class) ?>" id="hero-page">
		<div class="hero-page__overlay"></div>
		<div class="container hero-page__container" data-aos="fade-up">
			<div class="hero-page__content">
				<!-- Breadcrumbs -->
				<div class="hero-page__breadcrumbs page-breadcrumbs">
					<?php if (function_exists('bcn_display')) {
						bcn_display();
					} ?>
				</div>

				<!-- Label -->
				<?php if ($label): ?>
					<div class="hero-page__label eyebrow">
						<?php echo esc_html($label); ?>
					</div>
				<?php endif; ?>

				<!-- Title -->
				<h1 class="hero-page__title title-1 descr">
					<?php echo wp_kses_post($title); ?>
				</h1>

				<!-- Description -->
				<?php if ($descr): ?>
					<div class="hero-page__descr descr">
						<?php echo wp_kses_post($descr); ?>
					</div>
				<?php endif; ?>
			</div>

			<!-- Image -->
			<?php if ($image && is_array($image) && !empty($image['ID'])): ?>
				<div class="hero-page__image image-box jarallax-img">
					<?php echo wp_get_attachment_image(
						$image['ID'],
						'full',
						false,
						[
							'class' => 'img jarallax-img',
							'alt' => $image['alt'] ?: $title,
						]
					); ?>
				</div>
			<?php endif; ?>
		</div>
	</section>
<?php endif; ?>