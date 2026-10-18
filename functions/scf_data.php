<?php


if (function_exists('acf_add_options_page')) {
	acf_add_options_page(array(
		'page_title' => 'Контактные данные',
		'menu_title' => 'Контактные данные',
		'menu_slug' => 'opt-contacts',
		'position' => 20,
	));

	acf_add_options_page(array(
		'page_title' => 'Общие поля страниц',
		'menu_title' => 'Общие поля страниц',
		'menu_slug' => 'opt-page',
		'position' => 15,
	));


	acf_add_options_page(array(
		'page_title' => 'Шапка',
		'menu_title' => 'Шапка',
		'menu_slug' => 'opt-header',
		'position' => 21,
	));

	acf_add_options_page(array(
		'page_title' => 'Подвал / Футер',
		'menu_title' => 'Подвал / Футер',
		'menu_slug' => 'opt-footer',
		'position' => 22,
	));

	acf_add_options_page(array(
		'page_title' => 'Модальные окна',
		'menu_title' => 'Модальные окна',
		'menu_slug' => 'opt-modals',
		'position' => 23,
	));

	acf_add_options_page(array(
		'page_title' => 'Страница благодарности',
		'menu_title' => 'Страница благодарности',
		'menu_slug' => 'opt-thank_you',
		'position' => 24,
	));

	acf_add_options_page(array(
		'page_title' => 'Страница 404',
		'menu_title' => 'Страница 404',
		'menu_slug' => 'opt-page-404',
		'position' => 24,
	));

}

// OPTIONS
add_action('acf/init', function () {
	if (!function_exists('acf_add_local_field_group')) {
		return;
	}

	// HEADER
	acf_add_local_field_group(array(
		'key' => 'group_header_settings',
		'title' => 'Поля шапки',
		'fields' => array(
			array(
				'key' => 'field_header_info_message',
				'name' => 'header_info_message',
				'type' => 'message',
				'message' => '<b>Логотип</b> - перейдите в Панель управления сайтом > Основные настройки > Логотип сайта. <a href="' . admin_url('/admin.php?page=verda-settings&tab=general') . '" target="_blank">Перейти</a><br/><b>Меню</b> - перейдите в Панель управления сайтом > Меню > Меню шапки. <a href="' . admin_url('/admin.php?page=verda-settings&tab=menus') . '" target="_blank">Перейти</a><br/><b>Контакты</b> - перейдите в Панель управления сайтом > Редактирование контента > Основные секции > Контактные данные. <a href="' . admin_url('/admin.php?page=opt-contacts') . '" target="_blank">Перейти</a>',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			),
			// телефон
			//array(
			//	'key' => 'field_header_phone',
			//	'label' => 'Телефон в шапке',
			//	'name' => 'header_phone',
			//	'type' => 'text',
			//	'instructions' => 'Если не указывать будут использоваться телефоны из контактных данных',
			//),

			// Кнопка
			array(
				'key' => 'field_header_btn',
				'label' => 'Кнопка в шапке',
				'name' => 'header_btn',
				'type' => 'link',
				'instructions' => 'Ссылка на модальное окно (якорь #modal-call) или страницу.',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'opt-header',
				),
			),
		),
	));

	// FOOTER
	acf_add_local_field_group([
		'key' => 'group_footer',
		'title' => 'Футер',
		'fields' => [
			array(
				'key' => 'field_header_info_message',
				'name' => 'header_info_message',
				'type' => 'message',
				'message' => '<b>Логотип</b> - перейдите в Панель управления сайтом > Основные настройки > Логотип сайта. <a href="' . admin_url('/admin.php?page=verda-settings&tab=general') . '" target="_blank">Перейти</a><br/><b>Меню</b> - перейдите в Панель управления сайтом > Меню > Меню шапки. <a href="' . admin_url('/admin.php?page=verda-settings&tab=menus') . '" target="_blank">Перейти</a><br/><b>Контакты</b> - перейдите в Панель управления сайтом > Редактирование контента > Основные секции > Контактные данные. <a href="' . admin_url('/admin.php?page=opt-contacts') . '" target="_blank">Перейти</a>',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			),
			[
				'key' => 'field_footer_logo',
				'label' => 'Логотип',
				'name' => 'footer_logo',
				'type' => 'image',
				'instructions' => 'Если не загружен то будет использоваться как в шапке',
			],
			[
				'key' => 'field_footer_company',
				'label' => 'Название компании',
				'name' => 'footer_company',
				'type' => 'text',
				'instructions' => 'Если пусто — берётся из настроек сайта',
			],
			[
				'key' => 'field_footer_descr',
				'label' => 'Описание компании',
				'name' => 'footer_descr',
				'type' => 'textarea',
				'rows' => 3,
				'instructions' => 'Если пусто — берётся из настроек сайта',
				'new_lines' => 'wpautop',
			],
			[
				'key' => 'field_footer_copy',
				'label' => 'Текст копирайта',
				'name' => 'footer_copy',
				'type' => 'text',
				'instructions' => 'Например: "Все права защищены"',
			],
			[
				'key' => 'field_footer_links',
				'label' => 'Ссылки',
				'name' => 'footer_links',
				'type' => 'repeater',
				'instructions' => 'Социальные сети, документы, страницы и т.д.',
				'layout' => 'block',
				'collapsed' => 'field_footer_links_link',
				'button_label' => 'Добавить ссылку',
				'sub_fields' => [
					[
						'key' => 'field_footer_links_link',
						'label' => 'Ссылка',
						'name' => 'footer_links_link',
						'type' => 'link',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'opt-footer',
				],
			],
		],
	]);

	// CONTACTS
	acf_add_local_field_group([
		'key' => 'group_contacts_page',
		'title' => 'Контактные данные',
		'fields' => [
			[
				'key' => 'field_contacts_message',
				'label' => 'Инструкция',
				'type' => 'message',
				'message' => '<b>Контактные данные</b><br/>Глобальные настройки контактов для секции "Контакты". У каждой соцсети есть переключатель "Показывать на сайте" — скрытые соцсети не выводятся, но остаются в админке.',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			],

			[
				'key' => 'field_contacts_tab_phones',
				'label' => 'Телефон',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_contacts_phone_icon',
				'label' => 'Иконка для карточки "Телефон"',
				'name' => 'contacts_phone_icon',
				'type' => 'image',
				'return_format' => 'array',
			],

			[
				'key' => 'field_contacts_phone_descr',
				'label' => 'Описание для карточки "Телефон"',
				'name' => 'contacts_phone_descr',
				'type' => 'textarea',
				'new_lines' => 'wpautop',
				'rows' => 3,
				'placeholder' => 'Для связи по оформленным заказам и уточнения деталей доставки.',
			],

			[
				'key' => 'field_contacts_phones',
				'label' => 'Телефоны',
				'name' => 'contacts_phones',
				'type' => 'repeater',
				'layout' => 'block',
				'collapsed' => 'field_contact_phone_number',
				'button_label' => 'Добавить телефон',
				'sub_fields' => [
					[
						'key' => 'field_contact_phone_number',
						'label' => 'Номер телефона',
						'name' => 'phone',
						'type' => 'text',
					],
				],
			],

			[
				'key' => 'field_contacts_tab_email',
				'label' => 'Email',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_contacts_email_icon',
				'label' => 'Иконка для карточки "Email"',
				'name' => 'contacts_email_icon',
				'type' => 'image',
				'return_format' => 'array',
			],

			[
				'key' => 'field_contacts_email_descr',
				'label' => 'Описание для карточки "Email"',
				'name' => 'contacts_email_descr',
				'type' => 'textarea',
				'new_lines' => 'wpautop',
				'rows' => 3,
			],

			[
				'key' => 'field_contacts_emails',
				'label' => 'Email адреса',
				'name' => 'contacts_emails',
				'type' => 'repeater',
				'layout' => 'block',
				'collapsed' => 'field_contact_email_link',
				'button_label' => 'Добавить email',
				'sub_fields' => [
					[
						'key' => 'field_contact_email_link',
						'label' => 'Email',
						'name' => 'email',
						'type' => 'email',
					],
				],
			],

			[
				'key' => 'field_contacts_tab_messengers',
				'label' => 'Мессенджеры и соцсети',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_contacts_socials',
				'label' => 'Социальные сети',
				'name' => 'contacts_socials',
				'type' => 'repeater',
				'layout' => 'block',
				'collapsed' => 'field_contacts_social_title',
				'button_label' => 'Добавить соцсеть',
				'sub_fields' => [
					[
						'key' => 'field_contacts_social_show',
						'label' => 'Показывать на странице контактов',
						'name' => 'show',
						'type' => 'true_false',
						'ui' => 1,
						'default_value' => 1,
					],

					[
						'key' => 'field_contacts_social_icon',
						'label' => 'Иконка',
						'name' => 'icon',
						'type' => 'image',
						'return_format' => 'array',
					],

					[
						'key' => 'field_contacts_social_title',
						'label' => 'Название соцсети',
						'name' => 'title',
						'type' => 'text',
						'placeholder' => 'Telegram',
					],

					[
						'key' => 'field_contacts_social_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'textarea',
						'new_lines' => 'wpautop',
						'rows' => 3,
					],

					[
						'key' => 'field_contacts_social_link',
						'label' => 'Ссылка на соцсеть',
						'name' => 'link',
						'type' => 'link',
						'return_format' => 'array',
					],
				],
			],

			[
				'key' => 'field_contacts_tab_address_time',
				'label' => 'Адрес и время работы',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_contacts_address',
				'label' => 'Адрес',
				'name' => 'contacts_address',
				'type' => 'wysiwyg',
			],

			[
				'key' => 'field_contacts_time',
				'label' => 'Время работы',
				'name' => 'contacts_time',
				'type' => 'wysiwyg',
			],
		],
		'location' => [
			[
				[
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'opt-contacts',
				],
			],
		],
	]);
	// MODALS
	acf_add_local_field_group(array(
		'key' => 'group_opt_modals',
		'title' => 'Глобальные модальные окна',
		'fields' => array(
			array(
				'key' => 'field_modals_list',
				'label' => 'Список модальных окон',
				'name' => 'modals',
				'type' => 'repeater',
				'layout' => 'block',
				'collapsed' => 'field_modal_id',
				'button_label' => 'Добавить модальное окно',
				'sub_fields' => array(
					array(
						'key' => 'field_modal_id',
						'label' => 'ID модального окна',
						'name' => 'id',
						'type' => 'text',
						'required' => 1,
						'maxlength' => 50,
						'instructions' => 'Только латиница, цифры, дефис. Пример: <code>order-form</code>. Используется в <code>id</code> и <code>data-modal</code>.',
						'prepend' => '#',
						'character_limit' => 50,
						'allow_custom' => 0,
					),
					array(
						'key' => 'field_modal_title',
						'label' => 'Заголовок',
						'name' => 'title',
						'type' => 'text',
					),
					array(
						'key' => 'field_modal_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'wysiwyg',
					),
					array(
						'key' => 'field_modal_shortcode',
						'label' => 'Шорткод формы',
						'name' => 'shortcode',
						'type' => 'text',
						'placeholder' => '[contact-form-7 id="123"]',
						'instructions' => 'Вставьте шорткод форм (CF7, WPForms, Forminator и свой шорткод).',
					),
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'opt-modals',
				),
			),
		),
	));


	// THANK YOU
	acf_add_local_field_group(array(
		'key' => 'flds_opt_thank_you',
		'title' => 'Страница благодарности',
		'fields' => array(
			array(
				'key' => 'field_thank_you_subtitle',
				'name' => 'thank_you_subtitle',
				'label' => 'Надзаголовок',
				'type' => 'text',
			),

			array(
				'key' => 'field_thank_you_title',
				'name' => 'thank_you_title',
				'label' => 'Заголовок',
				'type' => 'text',
			),
			array(
				'key' => 'field_thank_you_descr',
				'name' => 'thank_you_descr',
				'label' => 'Описание',
				'type' => 'wysiwyg',
			),
			array(
				'key' => 'field_thank_you_btn',
				'name' => 'thank_you_btn',
				'label' => 'Кнопка',
				'type' => 'link',
			),
			array(
				'key' => 'field_thank_you_btn_second',
				'name' => 'thank_you_btn_second',
				'label' => 'Кнопка вторая',
				'type' => 'link',
			),
			array(
				'key' => 'field_thank_you_image',
				'name' => 'thank_you_image',
				'label' => 'Картинка',
				'type' => 'image',
			),

		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'opt-thank_you',
				),
			),
		),
	));

	// PAGE 404 
	acf_add_local_field_group(array(
		'key' => 'flds_opt_page_404',
		'title' => 'Страница 404',
		'fields' => array(
			array(
				'key' => 'field_page_404_subtitle',
				'name' => 'page_404_subtitle',
				'label' => 'Надзаголовок',
				'type' => 'text',
			),
			array(
				'key' => 'field_page_404_title',
				'name' => 'page_404_title',
				'label' => 'Заголовок',
				'type' => 'text',
			),
			array(
				'key' => 'field_page_404_descr',
				'name' => 'page_404_descr',
				'label' => 'Описание',
				'type' => 'wysiwyg',
			),
			array(
				'key' => 'field_page_404_btn',
				'name' => 'page_404_btn',
				'label' => 'Кнопка',
				'type' => 'link',
			),
			array(
				'key' => 'field_page_404_btn_second',
				'name' => 'page_404_btn_second',
				'label' => 'Кнопка вторая',
				'type' => 'link',
			),
			array(
				'key' => 'field_page_404_image',
				'name' => 'page_404_image',
				'label' => 'Картинка',
				'type' => 'image',
			),


		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'opt-page-404',
				),
			),
		),
	));

	// product


	// SECTIONS
});


add_action('acf/init', 'register_fields');
function register_fields()
{
	$home_page = get_page_by_path('home', OBJECT, 'page');


	acf_add_local_field_group([
		'key' => 'group_hero_section',
		'title' => 'Первый экран',
		'fields' => [

			// ==================== ВКЛАДКА: КОНТЕНТ ====================
			[
				'key' => 'field_hero_tab_content',
				'label' => 'Контент',
				'name' => '',
				'type' => 'tab',
			],
			[
				'key' => 'field_hero_eyebrow',
				'label' => 'Надзаголовок',
				'name' => 'hero_eyebrow',
				'type' => 'text',
				'default_value' => 'Премиальный уход для лица',
			],
			[
				'key' => 'field_hero_title',
				'label' => 'Заголовок H1',
				'name' => 'hero_title',
				'type' => 'text',
				'default_value' => 'Система ухода, которую легко выбрать',
				'placeholder' => 'Главный заголовок секции',
			],
			[
				'key' => 'field_hero_descr',
				'label' => 'Описание',
				'name' => 'hero_descr',
				'type' => 'wysiwyg',
				'default_value' => 'Косметика ТаллаМакс объединяет экстракт Amanita Muscaria, современные активные компоненты и продуманные текстуры для ежедневного ухода за кожей',
			],
			[
				'key' => 'field_hero_btn',
				'label' => 'Кнопка',
				'name' => 'hero_btn',
				'type' => 'link',
				'default_value' => [
					'url' => home_url('/shop/'),
					'title' => 'К покупкам',
				],
			],
			[
				'key' => 'field_hero_features',
				'label' => 'Список преимуществ',
				'name' => 'hero_features',
				'type' => 'repeater',
				'button_label' => 'Добавить преимущество',
				'collapsed' => 'field_feature_text',
				'layout' => 'block',
				'sub_fields' => [
					[
						'key' => 'field_feature_icon',
						'label' => 'Иконка',
						'name' => 'icon',
						'type' => 'image',
					],
					[
						'key' => 'field_feature_text',
						'label' => 'Текст',
						'name' => 'text',
						'type' => 'textarea',
						'rows' => 2,
						'new_lines' => 'wpautop',
					],
				],
			],

			// ==================== ВКЛАДКА: СПИСКИ ====================
			[
				'key' => 'field_hero_tab_lists',
				'label' => 'Ритуалы ухода',
				'name' => '',
				'type' => 'tab',
			],
			[
				'key' => 'field_hero_rituals',
				'label' => 'Ритуалы',
				'name' => 'hero_rituals',
				'type' => 'repeater',
				'button_label' => 'Добавить ритуал',
				'collapsed' => 'field_ritual_title',
				'layout' => 'block',
				'sub_fields' => [
					[
						'key' => 'field_hero_ritual_image',
						'label' => 'Фоновое изображение',
						'name' => 'image',
						'type' => 'image',
					],
					[
						'key' => 'field_hero_ritual_title',
						'label' => 'Заголовок',
						'name' => 'title',
						'type' => 'text',
					],
					[
						'key' => 'field_hero_ritual_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'textarea',
						'rows' => 2,
						'new_lines' => 'wpautop',
					],
					[
						'key' => 'field_hero_ritual_link',
						'label' => 'Ссылка на категорию',
						'name' => 'link',
						'type' => 'taxonomy',
						'taxonomy' => 'product_cat',
						'field_type' => 'select',
						'allow_null' => 1,
					],
				],
			],

			// ==================== ВКЛАДКА: МЕДИА ====================
			[
				'key' => 'field_hero_tab_media',
				'label' => 'Медиа',
				'name' => '',
				'type' => 'tab',
			],
			[
				'key' => 'field_hero_bg_desktop',
				'label' => 'Фон (десктоп)',
				'name' => 'hero_bg_desktop',
				'type' => 'image',
				'instructions' => 'Большое фоновое изображение для десктопа (скрыто на мобильных).',
			],
			[
				'key' => 'field_hero_bg_mobile',
				'label' => 'Фон (мобильный)',
				'name' => 'hero_bg_mobile',
				'type' => 'image',
				'instructions' => 'Фоновое изображение для мобильных устройств.',
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'front-page.php',
				],
			],
		],
		'menu_order' => 1,
	]);
	acf_add_local_field_group([
		'key' => 'group_products_section',
		'title' => 'Секция "Продукты"',
		'fields' => [

			// ==================== ВКЛАДКА: КОНТЕНТ ====================
			[
				'key' => 'field_products_tab_content',
				'label' => 'Контент',
				'name' => '',
				'type' => 'tab',
			],
			[
				'key' => 'field_products_section_decor',
				'label' => 'Декоративное изображение',
				'name' => 'products_section_decor',
				'type' => 'image',
				'instructions' => 'Декоративное изображение для секции (если не загрузить то не будет отображаться).',
			],
			[
				'key' => 'field_products_section_decor_mobile',
				'label' => 'Декоративное изображение (мобильная версия)',
				'name' => 'products_section_decor_mobile',
				'type' => 'image',
				'instructions' => 'Декоративное изображение для секции (мобильная версия).',
			],
			[
				'key' => 'field_products_title',
				'label' => 'Заголовок секции',
				'name' => 'products_title',
				'type' => 'textarea',
				'rows' => 2,
				'new_lines' => 'wpautop',
				'default_value' => 'Средства для ежедневного ухода',
			],
			[
				'key' => 'field_products_all_btn',
				'label' => 'Кнопка "Все средства"',
				'name' => 'products_all_btn',
				'type' => 'link',
				'default_value' => [
					'url' => '/shop/',
					'title' => 'Все средства',
				],
			],

			// ==================== ВКЛАДКА: НАСТРОЙКИ ====================
			[
				'key' => 'field_products_tab_settings',
				'label' => 'Настройки',
				'name' => '',
				'type' => 'tab',
			],
			[
				'key' => 'field_products_per_page',
				'label' => 'Количество товаров',
				'name' => 'products_per_page',
				'type' => 'number',
				'default_value' => 8,
				'instructions' => 'Сколько товаров показывать в слайдере.',
			],
			[
				'key' => 'field_products_message',
				'label' => 'Информация',
				'type' => 'message',
				'message' => '<br> Чтобы добавить товар > В боковом меню Товары > Добавить товар <a href="' . admin_url('/post-new.php?post_type=product') . '" target="_blank">Перейти</a><br>Категория со слагом <code>misc</code> исключается из списка.',
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'front-page.php',
				],
			],
		],
		'menu_order' => 2,
	]);

}

// hero-page
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_hero_page',
		'title' => 'Первый экран',
		'fields' => [
			[
				'key' => 'field_hero_page_tab_content',
				'label' => 'Контент',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],
			[
				'key' => 'field_hero_page_label',
				'label' => 'Надзаголовок (label)',
				'name' => 'hero_label',
				'type' => 'text',
				'instructions' => 'Небольшой текст над основным заголовком. Необязательно.',
			],
			[
				'key' => 'field_hero_page_title',
				'label' => 'Заголовок H1',
				'name' => 'hero_title',
				'type' => 'textarea',
				'rows' => 2,
				'new_lines' => 'br',
				'instructions' => 'Если оставить пустым, подставится стандартный заголовок страницы или архива.',
			],
			[
				'key' => 'field_hero_page_descr',
				'label' => 'Описание',
				'name' => 'hero_descr',
				'type' => 'wysiwyg',
				'instructions' => 'Краткое описание под заголовком',
			],

			[
				'key' => 'field_hero_page_tab_media',
				'label' => 'Медиа',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],
			[
				'key' => 'field_hero_page_image',
				'label' => 'Фоновое изображение',
				'name' => 'hero_image',
				'type' => 'image',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
				],
				[
					'param' => 'post_template',
					'operator' => '!=',
					'value' => 'front-page.php',
				],
			],
		],
	]);
}
// section-image
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_section_image',
		'title' => 'Секция с фоном',
		'fields' => [
			[
				'key' => 'field_section_image',
				'label' => 'Фоновое изображение',
				'name' => 'section_image',
				'type' => 'image',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product',
				],
			],
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-process.php',
				],
			],
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-about.php',
				],
			],
			[
				[
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'opt-page',
				],
			],
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-payment-delivery.php',
				],
			],
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-contacts.php',
				],
			],
		],
	]);
}
// ritual-steps
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_ritual_steps',
		'title' => 'Секция "Как собрать ритуал"',
		'fields' => [
			[
				'key' => 'field_ritual_title',
				'label' => 'Заголовок секции',
				'name' => 'ritual_title',
				'type' => 'text',
			],
			[
				'key' => 'field_ritual_descr',
				'label' => 'Описание',
				'name' => 'ritual_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_ritual_steps',
				'label' => 'Шаги ритуала',
				'name' => 'ritual_steps',
				'type' => 'repeater',
				'layout' => 'block',
				'button_label' => 'Добавить шаг',
				'sub_fields' => [
					[
						'key' => 'field_ritual_step_title',
						'label' => 'Заголовок шага',
						'name' => 'title',
						'type' => 'text',
					],
					[
						'key' => 'field_ritual_step_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'textarea',
						'rows' => 2,
						'new_lines' => 'wpautop',
						'placeholder' => 'Краткое описание шага',
					],
					[
						'key' => 'field_ritual_step_image',
						'label' => 'Изображение',
						'name' => 'image',
						'type' => 'image',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product',
				],
			],
			[
				[
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'opt-page',
				],
			],
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-about.php',
				],
			],
		],
	]);
}

// cta-section
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_cta_section',
		'title' => 'Секция призыва к действию',
		'fields' => [
			[
				'key' => 'field_cta_title',
				'label' => 'Заголовок',
				'name' => 'cta_title',
				'type' => 'text',
			],
			[
				'key' => 'field_cta_descr',
				'label' => 'Описание',
				'name' => 'cta_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_cta_btn',
				'label' => 'Кнопка',
				'name' => 'cta_btn',
				'type' => 'link',
			],
			[
				'key' => 'field_cta_image',
				'label' => 'Изображение',
				'name' => 'cta_image',
				'type' => 'image',
			],
		],
		'location' => [
			[
				[
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'opt-page',
				],
			],
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product',
				],
			],
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-process.php',
				],
			],
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-about.php',
				],
			],
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-payment-delivery.php',
				],
			],
		],
	]);
}

// seo-section
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_seo_section',
		'title' => 'SEO-секция',
		'fields' => [
			[
				'key' => 'field_seo_title',
				'label' => 'Заголовок H2',
				'name' => 'seo_title',
				'type' => 'text',
			],
			[
				'key' => 'field_seo_descr',
				'label' => 'SEO-текст',
				'name' => 'seo_descr',
				'type' => 'wysiwyg',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'page',
				],
			],
		],
	]);
}

// product-hero
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_product_hero',
		'title' => 'Первый экран товара',
		'fields' => [

			[
				'key' => 'field_product_hero_tab_content',
				'label' => 'Контент',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],
			[
				'key' => 'field_product_hero_subtitle',
				'label' => 'Подзаголовок (тип товара)',
				'name' => 'product_subtitle',
				'type' => 'text',
			],
			[
				'key' => 'field_product_hero_descr',
				'label' => 'Описание первого экрана',
				'name' => 'product_hero_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_product_hero_ritual_name',
				'label' => 'Название ритуала (label)',
				'name' => 'product_ritual_name',
				'type' => 'text',
			],
			[
				'key' => 'field_product_hero_ritual_term',
				'label' => 'Ритуал (Категория)',
				'name' => 'product_ritual_term',
				'type' => 'taxonomy',
				'taxonomy' => 'product_cat',
				'field_type' => 'select', // Можно также использовать 'radio'
				'return_format' => 'object', // Возвращаем полный объект термина
				'allow_null' => 1,
				'instructions' => 'Выберите категорию ритуала. Название и ссылка подставятся автоматически',
			],

			[
				'key' => 'field_product_hero_tab_features',
				'label' => 'Преимущества',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],
			[
				'key' => 'field_product_hero_features',
				'label' => 'Список преимуществ',
				'name' => 'product_features',
				'type' => 'repeater',
				'layout' => 'row',
				'button_label' => 'Добавить преимущество',
				'sub_fields' => [
					[
						'key' => 'field_product_hero_feature_icon',
						'label' => 'Иконка',
						'name' => 'icon',
						'type' => 'image',
					],
					[
						'key' => 'field_product_hero_feature_title',
						'label' => 'Заголовок',
						'name' => 'title',
						'type' => 'text',
					],
					[
						'key' => 'field_product_hero_feature_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'textarea',
						'rows' => 2,
						'new_lines' => 'wpautop',
					],
				],
			],

			[
				'key' => 'field_product_hero_tab_specs',
				'label' => 'Свойства',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],
			[
				'key' => 'field_product_hero_specs',
				'label' => 'Список свойств',
				'name' => 'product_specs',
				'type' => 'repeater',
				'layout' => 'row',
				'button_label' => 'Добавить свойство',
				'sub_fields' => [
					[
						'key' => 'field_product_hero_spec_icon',
						'label' => 'Иконка',
						'name' => 'icon',
						'type' => 'image',
					],
					[
						'key' => 'field_product_hero_spec_text',
						'label' => 'Текст',
						'name' => 'text',
						'type' => 'text',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product',
				],
			],
		],
	]);
}

// product-details
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_product_details',
		'title' => 'Детали товара (аккордеон)',
		'fields' => [


			[
				'key' => 'field_product_details_tab_composition',
				'label' => 'Состав',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],
			[
				'key' => 'field_product_composition',
				'label' => 'Состав',
				'name' => 'product_composition',
				'type' => 'wysiwyg',
			],

			[
				'key' => 'field_product_details_tab_skin_type',
				'label' => 'Для какого типа кожи',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],
			[
				'key' => 'field_product_skin_type',
				'label' => 'Для какого типа кожи',
				'name' => 'product_skin_type',
				'type' => 'wysiwyg',
			],

			[
				'key' => 'field_product_details_tab_assets',
				'label' => 'Ключевые активы',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],
			[
				'key' => 'field_product_key_assets',
				'label' => 'Ключевые активы',
				'name' => 'product_key_assets',
				'type' => 'wysiwyg',
			],

			[
				'key' => 'field_product_details_tab_delivery',
				'label' => 'Доставка и оплата',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],
			[
				'key' => 'field_product_delivery_payment',
				'label' => 'Доставка и оплата',
				'name' => 'product_delivery_payment',
				'type' => 'wysiwyg',
			],

			[
				'key' => 'field_product_details_tab_usage',
				'label' => 'Способ применения',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],
			[
				'key' => 'field_product_usage',
				'label' => 'Способ применения',
				'name' => 'product_usage',
				'type' => 'wysiwyg',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product',
				],
			],
		],
	]);
}

// product-pairing
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_product_pairing',
		'title' => 'Сопутствующие товары',
		'fields' => [
			[
				'key' => 'field_pairing_message',
				'label' => 'Инструкция',
				'type' => 'message',
				'message' => '<b>Как работает этот блок:</b><br/>1. Если вы выберете товары вручную ниже, покажутся <b>только они</b>.<br/>2. Если поле пустое, система возьмёт товары из вкладок "Дополнительные товары" (Cross-sells) и "Похожие товары" (Up-sells) в настройках самого товара WooCommerce.<br/>3. Если и там пусто, будут показаны 8 случайных товаров (кроме текущего).',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			],
			[
				'key' => 'field_pairing_tab_main',
				'label' => 'Настройки секции',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],
			[
				'key' => 'field_pairing_section_title',
				'label' => 'Заголовок секции',
				'name' => 'pairing_section_title',
				'type' => 'text',
				'default_value' => 'С этим средством сочетается',
			],
			[
				'key' => 'field_pairing_products_per_page',
				'label' => 'Количество товаров',
				'name' => 'pairing_products_per_page',
				'type' => 'number',
				'default_value' => 8,
				'min' => 1,
				'max' => 12,
				'step' => 1,
			],
			[
				'key' => 'field_pairing_tab_custom',
				'label' => 'Ручной выбор (Приоритет)',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],
			[
				'key' => 'field_pairing_custom_products',
				'label' => 'Выбрать средства вручную',
				'name' => 'pairing_custom_products',
				'type' => 'relationship',
				'post_type' => ['product'],
				'return_format' => 'id',
				'max' => 12,
				'instructions' => 'Начните вводить название товара. Если это поле заполнено, оно имеет высший приоритет над настройками WooCommerce.',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product',
				],
			],
		],
	]);
}

// section-reviews

if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_reviews_section',
		'title' => 'Секция "Отзывы"',
		'fields' => [

			[
				'key' => 'field_reviews_message',
				'label' => 'Как добавить отзывы?',
				'type' => 'message',
				'message' => '⚠️ <b>Внимание:</b> Сами отзывы добавляются не здесь, а в отдельном разделе меню: <a href="' . admin_url('edit.php?post_type=review') . '" target="_blank"><b>Отзывы → Все отзывы</b></a>.<br>Здесь вы настраиваете только внешний вид этой секции (заголовок, кнопку и фон)',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			],
			[
				'key' => 'field_reviews_tab_content',
				'label' => 'Контент',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],
			[
				'key' => 'field_reviews_title',
				'label' => 'Заголовок секции',
				'name' => 'reviews_title',
				'type' => 'text',
				'placeholder' => 'Ритуал, который хочется повторить',
			],
			[
				'key' => 'field_reviews_btn',
				'label' => 'Кнопка',
				'name' => 'reviews_btn',
				'type' => 'link',
				'instructions' => 'Например, ссылка на страницу со всеми отзывами.',
			],
			[
				'key' => 'field_reviews_tab_media',
				'label' => 'Медиа',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],
			[
				'key' => 'field_reviews_decor',
				'label' => 'Декоративное изображение',
				'name' => 'reviews_decor',
				'type' => 'image',
				'instructions' => 'Небольшой декоративный элемент (необязательно).',
			],
			[
				'key' => 'field_reviews_bg_image',
				'label' => 'Фоновое изображение',
				'name' => 'reviews_bg_image',
				'type' => 'image',
				'instructions' => 'Большое фоновое изображение с эффектом параллакса (Jarallax).',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'front-page.php',
				],
			],
		],
	]);
}
// single-review
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_review_cpt',
		'title' => 'Данные отзыва',
		'fields' => [
			[
				'key' => 'field_review_type',
				'label' => 'Тип отзыва',
				'name' => 'review_type',
				'type' => 'select',
				'choices' => [
					'text' => 'Текстовый',
					'video' => 'Видео',
				],
				'default_value' => 'text',
			],
			[
				'key' => 'field_review_name',
				'label' => 'Имя автора',
				'name' => 'review_name',
				'type' => 'text',
			],
			[
				'key' => 'field_review_descr',
				'label' => 'Текст отзыва',
				'name' => 'review_descr',
				'type' => 'textarea',
				'rows' => 4,
				'new_lines' => 'wpautop',
			],
			[
				'key' => 'field_review_size',
				'label' => 'Размер карточки',
				'name' => 'review_size',
				'type' => 'select',
				'choices' => [
					'' => 'Стандартный',
					'large' => 'Большой (large)',
					'small' => 'Маленький (small)',
				],
				'default_value' => '',
			],
			[
				'key' => 'field_review_video_url',
				'label' => 'Ссылка на видео (YouTube/Vimeo)',
				'name' => 'review_video_url',
				'type' => 'url',
				'instructions' => 'Приоритетное поле. Если заполнено, используется оно.',
			],
			[
				'key' => 'field_review_video_file',
				'label' => 'Или загрузить видеофайл',
				'name' => 'review_video_file',
				'type' => 'file',
				'return_format' => 'array',
				'instructions' => 'Используется, если ссылка не заполнена.',
			],
			[
				'key' => 'field_review_thumbnail',
				'label' => 'Превью видео / Изображение',
				'name' => 'review_thumbnail',
				'type' => 'image',
				'instructions' => 'Для видео: обложка. Для текста: необязательно.',
			],
			[
				'key' => 'field_review_linked_product',
				'label' => 'Привязка к товару',
				'name' => 'review_linked_product',
				'type' => 'relationship',
				'post_type' => ['product'],
				'return_format' => 'id',
				'instructions' => 'Выберите товар, к которому относится этот отзыв. Необязательно.',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'review',
				],
			],
		],
	]);
}
// product-reviews
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_product_reviews_section',
		'title' => 'Секция "Отзывы о средстве"',
		'fields' => [
			// Инструкция
			[
				'key' => 'field_product_reviews_message',
				'label' => 'Инструкция',
				'type' => 'message',
				'message' => '<b>Как это работает:</b><br/>• Если вы выберете конкретные отзывы ниже — покажутся <b>только они</b>.<br/>• Если поле пустое — секция покажет <b>все опубликованные отзывы</b> из раздела <a href="' . admin_url('edit.php?post_type=review') . '" target="_blank"><b>Отзывы</b></a>.<br/><br/>Здесь настраивается только внешний вид секции.',
				'new_lines' => 'wpautop',
				'esc_html' => 0,
			],

			[
				'key' => 'field_product_reviews_tab_content',
				'label' => 'Контент',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],
			[
				'key' => 'field_product_reviews_title',
				'label' => 'Заголовок секции',
				'name' => 'product_reviews_title',
				'type' => 'text',
				'placeholder' => 'Отзывы о средстве',
			],
			[
				'key' => 'field_product_reviews_btn',
				'label' => 'Кнопка',
				'name' => 'product_reviews_btn',
				'type' => 'link',
				'instructions' => 'Например: "Больше отзывов" со ссылкой на страницу всех отзывов.',
			],

			[
				'key' => 'field_product_reviews_tab_select',
				'label' => 'Выбор отзывов',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],
			[
				'key' => 'field_product_selected_reviews',
				'label' => 'Выбрать отзывы вручную',
				'name' => 'product_selected_reviews',
				'type' => 'relationship',
				'post_type' => ['review'],
				'return_format' => 'id',
				'max' => 12,
				'instructions' => 'Начните вводить название отзыва. Если оставить пустым — покажутся все отзывы. Порядок в списке = порядок в слайдере.',
			],

		],
		'location' => [
			[
				[
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'product',
				],
			],
		],
	]);
}

// whats-next
acf_add_local_field_group([
	'key' => 'group_whats_next_section',
	'title' => 'Секция "Что дальше?"',
	'fields' => [
		[
			'key' => 'field_whats_next_title',
			'label' => 'Заголовок секции',
			'name' => 'whats_next_section_title',
			'type' => 'text',
			'default_value' => 'Что дальше?',
		],
		[
			'key' => 'field_whats_next_steps',
			'label' => 'Шаги',
			'name' => 'whats_next_steps',
			'type' => 'repeater',
			'layout' => 'block',
			'button_label' => 'Добавить шаг',
			'sub_fields' => [
				[
					'key' => 'field_whats_next_step_icon',
					'label' => 'Иконка',
					'name' => 'icon',
					'type' => 'image',
				],
				[
					'key' => 'field_whats_next_step_title',
					'label' => 'Заголовок шага',
					'name' => 'step_title',
					'type' => 'text',
					'required' => 1,
				],
				[
					'key' => 'field_whats_next_step_descr',
					'label' => 'Описание',
					'name' => 'step_descr',
					'type' => 'textarea',
					'rows' => 3,
					'new_lines' => 'wpautop',
				],
			],
		],
	],
	'location' => [
		[
			[
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'page-success-order.php',
			],
		],
	],
]);

// section-stages
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_section_stages',
		'title' => 'Секция "Этапы ухода"',
		'fields' => [

			[
				'key' => 'field_section_stages_tab_content',
				'label' => 'Контент',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_section_stages_title',
				'label' => 'Заголовок секции',
				'name' => 'section_stages_title',
				'type' => 'text',
				'placeholder' => 'Подробнее об этапах',
			],

			[
				'key' => 'field_section_stages_tab_cards',
				'label' => 'Карточки',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_section_stages_cards',
				'label' => 'Карточки этапов',
				'name' => 'section_stages_cards',
				'type' => 'repeater',
				'layout' => 'block',
				'button_label' => 'Добавить карточку',
				'sub_fields' => [
					[
						'key' => 'field_section_stages_card_bg',
						'label' => 'Фоновое изображение',
						'name' => 'bg',
						'type' => 'image',
						'return_format' => 'array',
					],

					[
						'key' => 'field_section_stages_card_title',
						'label' => 'Заголовок карточки',
						'name' => 'title',
						'type' => 'text',
					],

					[
						'key' => 'field_section_stages_card_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'textarea',
						'new_lines' => 'wpautop',
						'rows' => 4,
					],

					[
						'key' => 'field_section_stages_card_category',
						'label' => 'Категория товаров',
						'name' => 'category',
						'type' => 'taxonomy',
						'taxonomy' => 'product_cat',
						'field_type' => 'select',
						'multiple' => 0,
						'allow_null' => 0,
						'return_format' => 'id',
					],

					[
						'key' => 'field_section_stages_card_btn_text',
						'label' => 'Текст кнопки (необязательно)',
						'name' => 'btn_text',
						'type' => 'text',
						'instructions' => 'Если оставить пустым, будет использоваться название категории',
						'default_value' => 'Смотреть средства',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-process.php',
				],
			],
		],
	]);
}

// section-ritual
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_section_ritual_select',
		'title' => 'Секция "Подбор ритуала"',
		'fields' => [

			[
				'key' => 'field_section_ritual_tab_content',
				'label' => 'Контент',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],
			[
				'key' => 'field_section_ritual_section_decor',
				'label' => 'Декоративное изображение',
				'name' => 'section_ritual_decor',
				'type' => 'image',
				'instructions' => 'Декоративное изображение для секции (если не загрузить то не будет отображаться).',
			],
			[
				'key' => 'field_section_ritual_decor_mobile',
				'label' => 'Декоративное изображение (мобильная версия)',
				'name' => 'section_ritual_decor_mobile',
				'type' => 'image',
				'instructions' => 'Декоративное изображение для секции (мобильная версия).',
			],
			[
				'key' => 'field_section_ritual_title',
				'label' => 'Заголовок секции',
				'name' => 'section_ritual_title',
				'type' => 'text',
				'default_value' => 'Подберите ритуал под задачу',
			],

			[
				'key' => 'field_section_ritual_descr',
				'label' => 'Описание секции',
				'name' => 'section_ritual_descr',
				'type' => 'wysiwyg',
			],

			[
				'key' => 'field_section_ritual_btn',
				'label' => 'Кнопка внизу секции',
				'name' => 'section_ritual_btn',
				'type' => 'link',
				'return_format' => 'array',
			],

			[
				'key' => 'field_section_ritual_tab_cards',
				'label' => 'Карточки',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_section_ritual_cards',
				'label' => 'Карточки задач',
				'name' => 'section_ritual_cards',
				'type' => 'repeater',
				'layout' => 'block',
				'button_label' => 'Добавить карточку',
				'sub_fields' => [
					[
						'key' => 'field_section_ritual_card_term',
						'label' => 'Задача (термин)',
						'name' => 'term',
						'type' => 'taxonomy',
						'taxonomy' => 'pa_zadacha',
						'field_type' => 'select',
						'multiple' => 0,
						'allow_null' => 0,
						'return_format' => 'id',
					],

					[
						'key' => 'field_section_ritual_card_icon',
						'label' => 'Иконка',
						'name' => 'icon',
						'type' => 'image',
						'return_format' => 'array',
					],

					[
						'key' => 'field_section_ritual_card_title',
						'label' => 'Заголовок карточки (необязательно)',
						'name' => 'title',
						'type' => 'text',
						'instructions' => 'Если оставить пустым, будет использоваться название термина',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-process.php',
				],
			],
		],
	]);
}

//section-ritual-prepared
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_section_ritual_prepared',
		'title' => 'Секция "Готовые ритуалы"',
		'fields' => [

			[
				'key' => 'field_section_ritual_prepared_tab_content',
				'label' => 'Контент',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_section_ritual_prepared_title',
				'label' => 'Заголовок секции',
				'name' => 'section_ritual_prepared_title',
				'type' => 'text',
				'placeholder' => 'Готовые ритуалы ухода',
			],

			[
				'key' => 'field_section_ritual_prepared_tab_cards',
				'label' => 'Карточки',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_section_ritual_prepared_cards',
				'label' => 'Карточки ритуалов',
				'name' => 'section_ritual_prepared_cards',
				'type' => 'repeater',
				'layout' => 'block',
				'button_label' => 'Добавить ритуал',
				'sub_fields' => [
					[
						'key' => 'field_section_ritual_prepared_card_term',
						'label' => 'Задача (термин)',
						'name' => 'term',
						'type' => 'taxonomy',
						'taxonomy' => 'pa_zadacha',
						'field_type' => 'select',
						'multiple' => 0,
						'allow_null' => 0,
						'return_format' => 'id',
					],

					[
						'key' => 'field_section_ritual_prepared_card_image',
						'label' => 'Изображение',
						'name' => 'image',
						'type' => 'image',
						'return_format' => 'array',
					],

					[
						'key' => 'field_section_ritual_prepared_card_label',
						'label' => 'Лейбл',
						'name' => 'label',
						'type' => 'text',
						'placeholder' => 'Базовый ритуал',
					],

					[
						'key' => 'field_section_ritual_prepared_card_title',
						'label' => 'Заголовок карточки',
						'name' => 'title',
						'type' => 'text',
						'placeholder' => 'Ежедневная забота',
					],

					[
						'key' => 'field_section_ritual_prepared_card_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'textarea',
						'new_lines' => 'wpautop',
						'rows' => 3,
					],

					[
						'key' => 'field_section_ritual_prepared_card_btn_text',
						'label' => 'Текст кнопки (необязательно)',
						'name' => 'btn_text',
						'type' => 'text',
						'instructions' => 'Если оставить пустым, будет использоваться текст "Смотреть набор"',
						'placeholder' => 'Смотреть набор',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-process.php',
				],
			],
		],
	]);
}
// section faq
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_section_faq',
		'title' => 'Секция "Частые вопросы"',
		'fields' => [
			[
				'key' => 'field_section_faq_tab_content',
				'label' => 'Контент',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_section_faq_title',
				'label' => 'Заголовок секции',
				'name' => 'section_faq_title',
				'type' => 'text',
				'placeholder' => 'Частые вопросы',
			],

			[
				'key' => 'field_section_faq_tab_items',
				'label' => 'Вопросы',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_section_faq_items',
				'label' => 'Список вопросов',
				'name' => 'section_faq_items',
				'type' => 'repeater',
				'layout' => 'block',
				'button_label' => 'Добавить вопрос',
				'sub_fields' => [
					[
						'key' => 'field_section_faq_item_question',
						'label' => 'Вопрос',
						'name' => 'question',
						'type' => 'text',
					],

					[
						'key' => 'field_section_faq_item_answer',
						'label' => 'Ответ',
						'name' => 'answer',
						'type' => 'textarea',
						'new_lines' => 'wpautop',
						'rows' => 4,
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-process.php',
				],
			],
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-payment-delivery.php',
				],
			],
		],
	]);
}

// section-composition
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_section_composition',
		'title' => 'Секция "Состав"',
		'fields' => [

			[
				'key' => 'field_section_composition_tab_content',
				'label' => 'Контент',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_section_composition_title',
				'label' => 'Заголовок секции',
				'name' => 'section_composition_title',
				'type' => 'text',
			],

			[
				'key' => 'field_section_composition_descr',
				'label' => 'Описание секции',
				'name' => 'section_composition_descr',
				'type' => 'wysiwyg',
			], // <-- ТУТ БЫЛА ОШИБКА. Закрываем поле описания перед началом нового поля.

			[
				'key' => 'field_section_composition_btn',
				'label' => 'Кнопка',
				'name' => 'section_composition_btn',
				'type' => 'link',
				'return_format' => 'array',
			],

			[
				'key' => 'field_section_composition_tab_cards',
				'label' => 'Карточки',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_section_composition_cards',
				'label' => 'Карточки преимуществ',
				'name' => 'section_composition_cards',
				'type' => 'repeater',
				'layout' => 'block',
				'button_label' => 'Добавить карточку',
				'sub_fields' => [
					[
						'key' => 'field_section_composition_card_icon',
						'label' => 'Иконка',
						'name' => 'icon',
						'type' => 'image',
						'return_format' => 'array',
					],

					[
						'key' => 'field_section_composition_card_title',
						'label' => 'Заголовок карточки',
						'name' => 'title',
						'type' => 'text',
					],

					[
						'key' => 'field_section_composition_card_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'textarea',
						'new_lines' => 'wpautop',
						'rows' => 3,
					],
				], // <-- ТУТ БЫЛА ОШИБКА. Закрываем sub_fields репитера.
			], // <-- ТУТ БЫЛА ОШИБКА. Закрываем сам репитер.

			[
				'key' => 'field_section_composition_tab_media',
				'label' => 'Медиа',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_section_composition_bg',
				'label' => 'Фоновое изображение секции',
				'name' => 'section_composition_bg',
				'type' => 'image',
				'return_format' => 'array',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'front-page.php',
				],
			],
		],
	]);
}
// section about
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_section_about',
		'title' => 'Секция "О бренде"',
		'fields' => [

			[
				'key' => 'field_section_about_tab_content',
				'label' => 'Контент',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_section_about_title',
				'label' => 'Заголовок секции',
				'name' => 'section_about_title',
				'type' => 'text',
				'placeholder' => 'ТаллаМакс — уход с авторским подходом',
			],

			[
				'key' => 'field_section_about_descr',
				'label' => 'Описание секции',
				'name' => 'section_about_descr',
				'type' => 'wysiwyg',
			],

			[
				'key' => 'field_section_about_quote',
				'label' => 'Цитата',
				'name' => 'section_about_quote',
				'type' => 'wysiwyg',
				'instructions' => 'Отображается в блоке с кавычками под описанием',
			],

			[
				'key' => 'field_section_about_tab_values',
				'label' => 'Ценности',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_section_about_values',
				'label' => 'Список ценностей',
				'name' => 'section_about_values',
				'type' => 'repeater',
				'layout' => 'block',
				'button_label' => 'Добавить ценность',
				'sub_fields' => [
					[
						'key' => 'field_section_about_value_icon',
						'label' => 'Иконка',
						'name' => 'icon',
						'type' => 'image',
						'return_format' => 'array',
					],

					[
						'key' => 'field_section_about_value_title',
						'label' => 'Заголовок ценности',
						'name' => 'title',
						'type' => 'text',
					],

					[
						'key' => 'field_section_about_value_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'textarea',
						'new_lines' => 'wpautop',
						'rows' => 3,
					],
				],
			],

			[
				'key' => 'field_section_about_tab_media',
				'label' => 'Медиа',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_section_about_image',
				'label' => 'Изображение слева',
				'name' => 'section_about_image',
				'type' => 'image',
				'return_format' => 'array',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-about.php',
				],
			],
		],
	]);
}

// section brand
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_section_brand',
		'title' => 'Секция "Бренд"',
		'fields' => [

			[
				'key' => 'field_section_brand_tab_content',
				'label' => 'Контент',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_section_brand_title',
				'label' => 'Заголовок секции',
				'name' => 'section_brand_title',
				'type' => 'text',
			],

			[
				'key' => 'field_section_brand_descr',
				'label' => 'Описание секции',
				'name' => 'section_brand_descr',
				'type' => 'wysiwyg',
			],

			[
				'key' => 'field_section_brand_btn',
				'label' => 'Кнопка',
				'name' => 'section_brand_btn',
				'type' => 'link',
				'return_format' => 'array',
			],

			[
				'key' => 'field_section_brand_tab_features',
				'label' => 'Особенности',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_section_brand_features',
				'label' => 'Список особенностей',
				'name' => 'section_brand_features',
				'type' => 'repeater',
				'layout' => 'block',
				'button_label' => 'Добавить особенность',
				'sub_fields' => [
					[
						'key' => 'field_section_brand_feature_icon',
						'label' => 'Иконка',
						'name' => 'icon',
						'type' => 'image',
						'return_format' => 'array',
					],

					[
						'key' => 'field_section_brand_feature_title',
						'label' => 'Заголовок особенности',
						'name' => 'title',
						'type' => 'text',
					],

					[
						'key' => 'field_section_brand_feature_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'textarea',
						'new_lines' => 'wpautop',
						'rows' => 3,
					],
				],
			],

			[
				'key' => 'field_section_brand_tab_media',
				'label' => 'Медиа',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_section_brand_image',
				'label' => 'Изображение слева',
				'name' => 'section_brand_image',
				'type' => 'image',
				'return_format' => 'array',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'front-page.php',
				],
			],
		],
	]);
}

// section-subscribe
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_section_subscribe',
		'title' => 'Секция "Подписка"',
		'fields' => [

			[
				'key' => 'field_section_subscribe_tab_content',
				'label' => 'Контент',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_section_subscribe_title',
				'label' => 'Заголовок секции',
				'name' => 'section_subscribe_title',
				'type' => 'text',
				'placeholder' => 'Присоединяйтесь к ритуалу',
			],

			[
				'key' => 'field_section_subscribe_descr',
				'label' => 'Описание секции',
				'name' => 'section_subscribe_descr',
				'type' => 'wysiwyg',
			],

			[
				'key' => 'field_section_subscribe_form',
				'label' => 'Шорткод формы',
				'name' => 'section_subscribe_form',
				'type' => 'text',
				'placeholder' => '[contact-form-7 id="123" title="Подписка"]',
				'instructions' => 'Вставьте шорткод формы Contact Form 7',
			],

			[
				'key' => 'field_section_subscribe_tab_media',
				'label' => 'Медиа',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_section_subscribe_image',
				'label' => 'Изображение слева',
				'name' => 'section_subscribe_image',
				'type' => 'image',
				'return_format' => 'array',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'front-page.php',
				],
			],
		],
	]);
}

// section-origin
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_section_origin',
		'title' => 'Секция "История бренда"',
		'fields' => [

			[
				'key' => 'field_section_origin_tab_content',
				'label' => 'Контент',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_section_origin_title',
				'label' => 'Заголовок секции',
				'name' => 'section_origin_title',
				'type' => 'text',
			],

			[
				'key' => 'field_section_origin_tab_cards',
				'label' => 'Карточки',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_section_origin_cards',
				'label' => 'Карточки этапов',
				'name' => 'section_origin_cards',
				'type' => 'repeater',
				'layout' => 'block',
				'button_label' => 'Добавить карточку',
				'sub_fields' => [
					[
						'key' => 'field_section_origin_card_bg',
						'label' => 'Фоновое изображение',
						'name' => 'bg',
						'type' => 'image',
						'return_format' => 'array',
					],

					[
						'key' => 'field_section_origin_card_title',
						'label' => 'Заголовок карточки',
						'name' => 'title',
						'type' => 'text',
						'placeholder' => 'Идея',
					],

					[
						'key' => 'field_section_origin_card_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'textarea',
						'new_lines' => 'wpautop',
						'rows' => 3,
					],
				],
			],

			[
				'key' => 'field_section_origin_tab_media',
				'label' => 'Медиа',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_section_origin_decor',
				'label' => 'Декор секции',
				'name' => 'section_origin_decor',
				'type' => 'image',
				'return_format' => 'array',
				'instructions' => 'Декоративный элемент фона секции (PNG с прозрачностью)',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-about.php',
				],
			],
		],
	]);
}
// section-key-ingredient
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_section_key_ingredient',
		'title' => 'Секция "Ключевой компонент"',
		'fields' => [

			[
				'key' => 'field_section_key_ingredient_tab_content',
				'label' => 'Контент',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_section_key_ingredient_title',
				'label' => 'Заголовок секции',
				'name' => 'section_key_ingredient_title',
				'type' => 'text',
			],

			[
				'key' => 'field_section_key_ingredient_descr',
				'label' => 'Описание секции',
				'name' => 'section_key_ingredient_descr',
				'type' => 'wysiwyg',
			],

			[
				'key' => 'field_section_key_ingredient_tab_values',
				'label' => 'Ценности',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_section_key_ingredient_values',
				'label' => 'Список ценностей',
				'name' => 'section_key_ingredient_values',
				'type' => 'repeater',
				'layout' => 'block',
				'button_label' => 'Добавить ценность',
				'sub_fields' => [
					[
						'key' => 'field_section_key_ingredient_value_icon',
						'label' => 'Иконка',
						'name' => 'icon',
						'type' => 'image',
						'return_format' => 'array',
					],

					[
						'key' => 'field_section_key_ingredient_value_title',
						'label' => 'Заголовок ценности',
						'name' => 'title',
						'type' => 'text',
						'placeholder' => 'Контролируемая форма',
					],

					[
						'key' => 'field_section_key_ingredient_value_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'textarea',
						'new_lines' => 'wpautop',
						'rows' => 3,
					],
				],
			],

			[
				'key' => 'field_section_key_ingredient_tab_media',
				'label' => 'Медиа',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_section_key_ingredient_image',
				'label' => 'Изображение слева',
				'name' => 'section_key_ingredient_image',
				'type' => 'image',
				'return_format' => 'array',
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-about.php',
				],
			],
		],
	]);
}

// section-our-values
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_section_our_values',
		'title' => 'Секция "Наши ценности"',
		'fields' => [

			[
				'key' => 'field_section_our_values_tab_content',
				'label' => 'Контент',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_section_our_values_title',
				'label' => 'Заголовок секции',
				'name' => 'section_our_values_title',
				'type' => 'text',
				'placeholder' => 'Наши ценности',
			],

			[
				'key' => 'field_section_our_values_tab_list',
				'label' => 'Ценности',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_section_our_values_list',
				'label' => 'Список ценностей',
				'name' => 'section_our_values_list',
				'type' => 'repeater',
				'layout' => 'block',
				'button_label' => 'Добавить ценность',
				'sub_fields' => [
					[
						'key' => 'field_section_our_values_item_icon',
						'label' => 'Иконка',
						'name' => 'icon',
						'type' => 'image',
						'return_format' => 'array',
					],

					[
						'key' => 'field_section_our_values_item_title',
						'label' => 'Заголовок ценности',
						'name' => 'title',
						'type' => 'text',
						'placeholder' => 'Эстетика',
					],

					[
						'key' => 'field_section_our_values_item_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'textarea',
						'new_lines' => 'wpautop',
						'rows' => 3,
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-about.php',
				],
			],
		],
	]);
}

// delivery-countries
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_delivery_countries',
		'title' => 'Секция "Страны доставки"',
		'fields' => [

			[
				'key' => 'field_delivery_countries_tab_list',
				'label' => 'Страны',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_delivery_countries_list',
				'label' => 'Список стран доставки',
				'name' => 'delivery_countries_list',
				'type' => 'repeater',
				'layout' => 'block',
				'button_label' => 'Добавить страну',
				'sub_fields' => [
					[
						'key' => 'field_delivery_countries_item_icon',
						'label' => 'Иконка',
						'name' => 'icon',
						'type' => 'image',
						'return_format' => 'array',
					],

					[
						'key' => 'field_delivery_countries_item_title',
						'label' => 'Заголовок (страна)',
						'name' => 'title',
						'type' => 'text',
					],

					[
						'key' => 'field_delivery_countries_item_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'textarea',
						'new_lines' => 'wpautop',
						'rows' => 4,
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-payment-delivery.php',
				],
			],
		],
	]);
}
// delivery-features
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_delivery_features',
		'title' => 'Секция "Преимущества доставки"',
		'fields' => [
			[
				'key' => 'field_delivery_features_tab_list',
				'label' => 'Преимущества',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_delivery_features_list',
				'label' => 'Список преимуществ',
				'name' => 'delivery_features_list',
				'type' => 'repeater',
				'layout' => 'block',
				'button_label' => 'Добавить преимущество',
				'sub_fields' => [
					[
						'key' => 'field_delivery_features_item_icon',
						'label' => 'Иконка',
						'name' => 'icon',
						'type' => 'image',
					],

					[
						'key' => 'field_delivery_features_item_title',
						'label' => 'Заголовок',
						'name' => 'title',
						'type' => 'text',
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-payment-delivery.php',
				],
			],
		],
	]);
}

// delivery-info
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_delivery_info',
		'title' => 'Секция "Оплата и возврат"',
		'fields' => [

			[
				'key' => 'field_delivery_info_tab_list',
				'label' => 'Информация',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_delivery_info_list',
				'label' => 'Список блоков информации',
				'name' => 'delivery_info_list',
				'type' => 'repeater',
				'layout' => 'block',
				'button_label' => 'Добавить блок',
				'sub_fields' => [
					[
						'key' => 'field_delivery_info_item_icon',
						'label' => 'Иконка',
						'name' => 'icon',
						'type' => 'image',
						'return_format' => 'array',
					],

					[
						'key' => 'field_delivery_info_item_title',
						'label' => 'Заголовок',
						'name' => 'title',
						'type' => 'text',
					],

					[
						'key' => 'field_delivery_info_item_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'textarea',
						'new_lines' => 'wpautop',
						'rows' => 4,
					],
				],
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-payment-delivery.php',
				],
			],
		],
	]);
}

// legal-info
acf_add_local_field_group([
	'key' => 'group_legal_info',
	'title' => 'Секция "Юридическая информация"',
	'fields' => [

		[
			'key' => 'field_legal_info_tab_content',
			'label' => 'Контент',
			'name' => '',
			'type' => 'tab',
			'placement' => 'top',
			'endpoint' => 0,
		],

		[
			'key' => 'field_legal_info_title',
			'label' => 'Заголовок секции',
			'name' => 'legal_info_title',
			'type' => 'text',
		],

		[
			'key' => 'field_legal_info_tab_lists',
			'label' => 'Списки',
			'name' => '',
			'type' => 'tab',
			'placement' => 'top',
			'endpoint' => 0,
		],

		[
			'key' => 'field_legal_info_list_primary',
			'label' => 'Основной список (левая колонка)',
			'name' => 'legal_info_list_primary',
			'type' => 'repeater',
			'collapsed' => 'field_legal_info_primary_key',
			'button_label' => 'Добавить строку',
			'sub_fields' => [
				[
					'key' => 'field_legal_info_primary_key',
					'label' => 'Ключ (название поля)',
					'name' => 'key',
					'type' => 'text',
				],

				[
					'key' => 'field_legal_info_primary_value',
					'label' => 'Значение',
					'name' => 'value',
					'type' => 'text',
				],
			],
		],

		[
			'key' => 'field_legal_info_list_secondary',
			'label' => 'Дополнительный список (правая колонка)',
			'name' => 'legal_info_list_secondary',
			'type' => 'repeater',
			'collapsed' => 'field_legal_info_secondary_key',
			'button_label' => 'Добавить строку',
			'sub_fields' => [
				[
					'key' => 'field_legal_info_secondary_key',
					'label' => 'Ключ (название поля)',
					'name' => 'key',
					'type' => 'text',
				],

				[
					'key' => 'field_legal_info_secondary_value',
					'label' => 'Значение',
					'name' => 'value',
					'type' => 'text',
				],
			],
		],
	],
	'location' => [
		[
			[
				'param' => 'page_template',
				'operator' => '==',
				'value' => 'page-contacts.php',
			],
		],
	],
]);
// support-info
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_support_info',
		'title' => 'Секция "Информация поддержки"',
		'fields' => [

			[
				'key' => 'field_support_info_tab_cards',
				'label' => 'Карточки',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_support_info_cards',
				'label' => 'Карточки информации',
				'name' => 'support_info_cards',
				'type' => 'repeater',
				'layout' => 'block',
				'collapsed' => 'field_support_info_card_title',
				'button_label' => 'Добавить карточку',
				'sub_fields' => [
					[
						'key' => 'field_support_info_card_icon',
						'label' => 'Иконка',
						'name' => 'icon',
						'type' => 'image',
						'return_format' => 'array',
					],

					[
						'key' => 'field_support_info_card_title',
						'label' => 'Заголовок карточки',
						'name' => 'title',
						'type' => 'text',
					],

					[
						'key' => 'field_support_info_card_descr',
						'label' => 'Описание',
						'name' => 'descr',
						'type' => 'wysiwyg',
					],

					[
						'key' => 'field_support_info_card_bg',
						'label' => 'Фоновое изображение',
						'name' => 'bg',
						'type' => 'image',
						'return_format' => 'array',
					],
				],
			],

			[
				'key' => 'field_support_info_tab_media',
				'label' => 'Медиа',
				'name' => '',
				'type' => 'tab',
				'placement' => 'top',
				'endpoint' => 0,
			],

			[
				'key' => 'field_support_info_decor',
				'label' => 'Декор секции',
				'name' => 'support_info_decor',
				'type' => 'image',
				'return_format' => 'array',
			],
		],
		'location' => [
			[
				[
					'param' => 'page_template',
					'operator' => '==',
					'value' => 'page-contacts.php',
				],
			],
		],
	]);
}

//!================================
if (function_exists('acf_add_local_field_group')) {
	acf_add_local_field_group([
		'key' => 'group_about_mushrooms',
		'title' => 'Секция: О грибах',
		'fields' => [
			[
				'key' => 'field_mushrooms_decor',
				'label' => 'Декор секции',
				'name' => 'mushrooms_decor',
				'type' => 'image',
				'return_format' => 'array',
				'instructions' => 'Декоративный элемент фона секции (PNG с прозрачностью)',
			],
			[
				'key' => 'field_about_mushrooms_title',
				'label' => 'Заголовок',
				'name' => 'mushrooms_title',
				'type' => 'text',
			],
			[
				'key' => 'field_about_mushrooms_descr',
				'label' => 'Описание',
				'name' => 'mushrooms_descr',
				'type' => 'wysiwyg',
			],
			[
				'key' => 'field_about_mushrooms_links',
				'label' => 'Ссылки',
				'name' => 'mushrooms_links',
				'type' => 'repeater',
				'layout' => 'table',
				'collapsed' => 'field_about_mushrooms_links_link',
				'button_label' => 'Добавить ссылку',
				'sub_fields' => [
					[
						'key' => 'field_about_mushrooms_links_link',
						'label' => 'Ссылка',
						'name' => 'link',
						'type' => 'link',
					],
				],
			],
			[
				'key' => 'field_about_mushrooms_slider',
				'label' => 'Галерея изображений',
				'name' => 'mushrooms_slider',
				'type' => 'gallery'
			],
		],
		'location' => [
			[
				[
					'param' => 'post_template',
					'operator' => '==',
					'value' => 'page-about.php',
				],
			],
		],
	]);
}