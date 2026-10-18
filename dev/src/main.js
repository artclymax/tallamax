import 'jarallax/dist/jarallax.min.css';
import "@fancyapps/ui/dist/fancybox/fancybox.css";
import "aos/dist/aos.css";
import './scss/style.scss';
//!
import { Swiper } from "swiper/bundle";

import { jarallax } from "jarallax";
import { Fancybox } from "@fancyapps/ui/dist/fancybox/";
import AOS from "AOS";

import { AutoCalc } from "./js/AutoCalc.js";
import { Menu } from './js/Menu.js';
//import { RunningLine } from './js/RunningLine.js';
//import { BackdropList } from './js/BackdropList.js';
import { Modal } from './js/Modal.js';
import { cookies } from "./js/Cookies.js";
//import { AnimationCounter } from "./js/AnimationCounter.js";
//import HiddenDescr from "./js/HiddenDescr.js";
//import HiddenList from "./js/HiddenList.js";
import { imask } from "./js/imask.js";
import { fileBtn } from "./js/FileBtn.js";
//import { CustomFieldSelect } from "./js/CustomFieldSelect.js";
import { Spoiler } from './js/Spoiler.js';
import { ScrollToTop } from './js/ScrollToTop.js';
import { MXSwiper } from './js/MXSwiper.js';
import { CustomSelect } from './js/CustomSelect.js';
import { Tabs } from './js/Tabs.js';
//import { MapScrollLock } from './js/MapScrollLock.js';
//import { cf7CustomValidation } from './js/cf7-validation.js';
//import { SelectFromAcf } from './js/SelectFromAcf.js';
//import { loadMore } from './js/loadMore.js';
//import AirDatepicker from 'air-datepicker';
//import 'air-datepicker/air-datepicker.css';
//document.querySelectorAll('input.form-input-date')?.forEach(input => {
//	new AirDatepicker(input, {
//		selectedDates: [new Date()],
//		isMobile: true,
//		autoClose: true,
//		minDate: new Date(),
//	});
//})
// time
//document.querySelectorAll('input.form-input-time')?.forEach(input => {
//	new AirDatepicker(input, {
//		isMobile: true,
//		autoClose: true,
//		timepicker: true,
//		onlyTimepicker: true
//	});
//})
//cf7CustomValidation();

// FOR CONTACTS FORM 7
//import "./js/redirect-to-thanks-page.js";


new AutoCalc();
//new CustomFieldSelect({
//	input: '.form-wrapper .cf-select',
//	lastEdit: false
//});
new Menu({
	btn: '.burger-btn', //.burger-btn-icon
	menu: '.header-menu',
	activeClass: 'open-header-menu',
	closeBtns: ['a', '.cart-btn']
})
//new Menu({
//	btn: '.filter-mobile-btn',
//	menu: '.filter',
//	activeClass: 'open-filter-menu',
//	closeBtns: ['.filter-close-btn']
//})
//new Menu({
//	btn: '.header__phone-btn', //.burger-btn-icon
//	menu: '.header-phone-box',
//	activeClass: 'open-phone-box',
//	//closeBtns: ['.menu-close-btn']
//})

//new BackdropList();

new Modal();

jarallax(document.querySelectorAll('.jarallax'), {
	speed: 0.2,
});

cookies();
imask();

Fancybox.bind("[data-fancybox]", {
	placeFocusBack: false
});

//new RunningLine();
new ScrollToTop();

new Spoiler();

//new Spoiler('[data-spoiler]', {
//	onlyOneOpen: true,
//	activeClass: 'is-open',
//});

//new Spoiler('[data-spoiler]', { media: 'max-width: 768px' });

new MXSwiper();
//new Tabs();
new CustomSelect({
	selector: 'select',
	forceSend: true,
});

//new MapScrollLock();
/*
window.addEventListener('scroll', function () {
	const header = document.querySelector('.header');

	if (window.scrollY > 50) {
		header.classList.add('scrolled');
	} else {
		header.classList.remove('scrolled');
		const valueUnits = header.offsetHeight;
		document.querySelector(':root').style.setProperty(`--header-height`, valueUnits + 'px');
	}
});
*/

fileBtn();//

//new Tabs();

//document.querySelectorAll('video.wp-video-shortcode').forEach(video => {
//	if (!video.src) {
//		const link = video.querySelector('a');
//		if (link) video.src = link.href;
//	}
//});

document?.querySelectorAll('.wpcf7-acceptance input[type="checkbox"]')?.forEach(el => {
	el.checked = true;
})

AOS.init({
	disable: 'mobile',
	duration: 600,
	offset: 100
});

//new SelectFromAcf('.custom-select-product', {
//	data: '.select-products-data'
//})

//loadMore();

//AnimationCounter();

//HiddenDescr();

//HiddenList();

document.addEventListener('DOMContentLoaded', () => {
	const mainSwiper = document.querySelector('.product-hero__main-swiper');
	const thumbsSwiper = document.querySelector('.product-hero__thumbs-swiper');

	if (mainSwiper) {
		// Если есть миниатюры
		if (thumbsSwiper && thumbsSwiper.querySelectorAll('.swiper-slide').length > 1) {
			const thumbs = new Swiper(thumbsSwiper, {
				slidesPerView: 3,
				spaceBetween: 10,
				freeMode: true,
				watchSlidesProgress: true,
				breakpoints: {
					1024: {
						spaceBetween: 24,
					}
				}
			});

			new Swiper(mainSwiper, {
				slidesPerView: 1,
				spaceBetween: 10,
				thumbs: { swiper: thumbs },
				effect: 'fade',
				rewind: true
			});
		} else {
			new Swiper(mainSwiper, {
				slidesPerView: 1,
				spaceBetween: 10,
				effect: 'fade',
				rewind: true
			});
		}
	}

	// Кнопки + и -
	const minusBtns = document.querySelectorAll('.quantity-box__btn--minus');
	const plusBtns = document.querySelectorAll('.quantity-box__btn--plus');

	minusBtns.forEach(btn => {
		btn.addEventListener('click', function () {
			const input = this.closest('.quantity-box').querySelector('.quantity-box__input');
			let val = parseInt(input.value) || 1;
			let min = parseInt(input.min) || 1;
			if (val > min) {
				input.value = val - 1;
			}
		});
	});

	plusBtns.forEach(btn => {
		btn.addEventListener('click', function () {
			const input = this.closest('.quantity-box').querySelector('.quantity-box__input');
			let val = parseInt(input.value) || 1;
			let max = parseInt(input.max) || 99;
			if (val < max) {
				input.value = val + 1;
			}
		});
	});
});

//!
/**
 * ==================================
 * MINI CART FUNCTIONALITY (v3.0 - Final)
 * ==================================
 */

//if (typeof window.wc_params === 'undefined') {
//	window.wc_params = {
//		wc_ajax_url: window.location.origin + '/?wc-ajax=%%endpoint%%',
//		ajaxurl: window.location.origin + '/wp-admin/admin-ajax.php',
//		cart_url: window.location.origin + '/cart/'
//	};
//}

//const bodyDataset = document.body.dataset;
//const WC_AJAX_URL = bodyDataset.wcAjaxUrl || window.wc_params.wc_ajax_url;
//const AJAX_URL = bodyDataset.ajaxUrl || window.wc_params.ajaxurl;

//class MiniCart {
//	constructor() {
//		this.miniCart = document.getElementById('mini-cart');
//		this.cartBtn = document.querySelector('.header__cart-btn');
//		this.isRefreshing = false;

//		console.log('MiniCart v3.0 init:', {
//			miniCartExists: !!this.miniCart,
//			cartBtnExists: !!this.cartBtn
//		});

//		this.init();
//	}

//	init() {
//		// Открытие корзины
//		if (this.cartBtn) {
//			this.cartBtn.addEventListener('click', (e) => {
//				e.preventDefault();
//				e.stopPropagation();
//				this.open();
//			});
//		}

//		// ✅ Слушаем событие добавления товара в корзину (на document, а не body)
//		document.addEventListener('added_to_cart', (e) => {
//			console.log('Товар добавлен через AJAX, обновляем мини-корзину...');
//			// Небольшая задержка, чтобы WooCommerce успел обработать свои фрагменты
//			setTimeout(() => {
//				if (window.miniCart) {
//					window.miniCart.refresh();
//					window.miniCart.open();
//				}
//			}, 150);
//		});

//		// Закрытие по клику вне контейнера или на крестик
//		document.addEventListener('click', (e) => {
//			if (!this.miniCart || !this.miniCart.classList.contains('is-active')) return;

//			if (e.target.closest('[data-mini-cart-close]')) {
//				this.close();
//				return;
//			}

//			if (!e.target.closest('.mini-cart__container')) {
//				this.close();
//			}
//		});

//		// Закрытие по ESC
//		document.addEventListener('keydown', (e) => {
//			if (e.key === 'Escape' && this.miniCart && this.miniCart.classList.contains('is-active')) {
//				this.close();
//			}
//		});

//		// ⚠️ Обработчик удаления через делегирование УБРАН, 
//		// так как вы используете надежный onclick="window.miniCart.removeItem(...)" в PHP.
//		// Это предотвращает двойные запросы!
//	}

//	async removeItem(cartItemKey) {
//		console.log('🗑️ Удаление из мини-корзины:', cartItemKey);

//		const item = this.miniCart.querySelector(`[data-cart-item-key="${cartItemKey}"]`);
//		if (!item) {
//			console.error('❌ Элемент не найден в мини-корзине');
//			return;
//		}

//		if (item.classList.contains('removing')) return;
//		item.classList.add('removing');

//		try {
//			const ajaxUrl = document.body.dataset.ajaxUrl || window.wc_params.ajaxurl;
//			const nonce = document.body.dataset.removeNonce;

//			const formData = new URLSearchParams();
//			formData.append('action', 'mini_cart_remove_item');
//			formData.append('cart_item_key', cartItemKey);
//			formData.append('nonce', nonce);

//			const response = await fetch(ajaxUrl, {
//				method: 'POST',
//				headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
//				body: formData.toString()
//			});

//			const data = await response.json();
//			console.log('✅ Response:', data);

//			if (data.success) {
//				// 1. Обновляем фрагменты
//				if (data.data.fragments) {
//					console.log('🔄 Фрагменты для обновления:', Object.keys(data.data.fragments));
//					Object.keys(data.data.fragments).forEach(key => {
//						const element = document.querySelector(key);
//						if (element) {
//							console.log(`  ✓ ${key}: найден, обновляем`);
//							element.outerHTML = data.data.fragments[key];
//						} else {
//							console.log(`  ✗ ${key}: НЕ НАЙДЕН на странице`);
//						}
//					});
//				}

//				// 2. 🎯 ПРИНУДИТЕЛЬНОЕ УДАЛЕНИЕ из основной корзины
//				console.log('🔍 Ищем товар в основной корзине...');

//				// Пробуем несколько селекторов
//				const selectors = [
//					`.cart-item[data-cart-item-key="${cartItemKey}"]`,
//					`[data-cart-item-key="${cartItemKey}"]`,
//					`.cart-page__list [data-cart-item-key="${cartItemKey}"]`
//				];

//				let mainCartItem = null;
//				for (const selector of selectors) {
//					mainCartItem = document.querySelector(selector);
//					if (mainCartItem) {
//						console.log(`  ✓ Найден по селектору: "${selector}"`);
//						console.log('  Элемент:', mainCartItem);
//						break;
//					} else {
//						console.log(`  ✗ Не найден по селектору: "${selector}"`);
//					}
//				}

//				if (mainCartItem) {
//					console.log('🎯 Удаляем товар из DOM...');
//					mainCartItem.classList.add('removing');

//					setTimeout(() => {
//						console.log('  → Вызываем mainCartItem.remove()');
//						mainCartItem.remove();
//						console.log('  ✓ Товар удален из DOM');

//						// Проверяем оставшиеся товары
//						const remainingItems = document.querySelectorAll('.cart-item');
//						console.log('  Осталось товаров в DOM:', remainingItems.length);

//						if (remainingItems.length === 0) {
//							console.log('🔄 Корзина пуста, перезагружаем...');
//							setTimeout(() => window.location.reload(), 500);
//						}
//					}, 300);
//				} else {
//					console.error('❌ Товар НЕ НАЙДЕН в основной корзине!');
//					console.log('Все элементы .cart-item на странице:');
//					document.querySelectorAll('.cart-item').forEach((item, idx) => {
//						console.log(`  ${idx}:`, item, 'data-cart-item-key:', item.dataset.cartItemKey);
//					});
//				}

//				// 3. Если корзина пуста глобально
//				if (data.data.cart_count === 0) {
//					console.log('️ Корзина пуста глобально');
//					setTimeout(() => {
//						this.close();
//						window.location.reload();
//					}, 500);
//				}

//				console.log('✅ Удаление завершено');
//			} else {
//				console.error('❌ Ошибка удаления:', data);
//				item.classList.remove('removing');
//			}
//		} catch (error) {
//			console.error('❌ Ошибка запроса:', error);
//			item.classList.remove('removing');
//		}
//	}

//	open() {
//		if (!this.miniCart) return;

//		console.log('Opening mini cart');
//		this.miniCart.classList.add('is-active');
//		this.miniCart.setAttribute('aria-hidden', 'false');
//		document.body.style.overflow = 'hidden';

//		// НЕ вызываем refresh() при открытии! Корзина уже отрендерена PHP.
//	}

//	close() {
//		if (!this.miniCart) return;

//		console.log('Closing mini cart');
//		this.miniCart.classList.remove('is-active');
//		this.miniCart.setAttribute('aria-hidden', 'true');
//		document.body.style.overflow = ''; // Сбрасываем overflow
//	}

//	async refresh() {
//		if (this.isRefreshing) return;
//		this.isRefreshing = true;

//		try {
//			// 1. Обновляем стандартные фрагменты WooCommerce (счетчик)
//			const fragmentsUrl = WC_AJAX_URL.replace('%%endpoint%%', 'get_refreshed_fragments');
//			const fragResponse = await fetch(fragmentsUrl, {
//				method: 'POST',
//				headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
//				body: new URLSearchParams({ action: 'get_refreshed_fragments' })
//			});
//			const fragData = await fragResponse.json();

//			if (fragData.fragments) {
//				Object.keys(fragData.fragments).forEach(key => {
//					const element = document.querySelector(key);
//					if (element) element.outerHTML = fragData.fragments[key];
//				});
//			}

//			// 2. Обновляем содержимое мини-корзины
//			await this.updateContent();

//		} catch (error) {
//			console.error('MiniCart refresh error:', error);
//		} finally {
//			this.isRefreshing = false;
//		}
//	}

//	async updateContent() {
//		try {
//			const response = await fetch(AJAX_URL, {
//				method: 'POST',
//				headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
//				body: new URLSearchParams({ action: 'get_mini_cart_content' })
//			});

//			const result = await response.json();

//			if (result.success && result.data && result.data.html) {
//				const wasActive = this.miniCart.classList.contains('is-active');

//				// Заменяем только container, не трогая корневой элемент
//				const container = this.miniCart.querySelector('.mini-cart__container');
//				if (container) {
//					container.outerHTML = result.data.html;
//				} else {
//					// Fallback: если container не найден, заменяем весь innerHTML
//					this.miniCart.innerHTML = result.data.html;
//				}

//				// Восстанавливаем класс активности
//				if (wasActive) {
//					this.miniCart.classList.add('is-active');
//				}
//			}
//		} catch (error) {
//			console.error('MiniCart updateContent error:', error);
//		}
//	}

//	async removeItem(cartItemKey) {
//		console.log('Removing item:', cartItemKey);

//		const item = this.miniCart.querySelector(`[data-cart-item-key="${cartItemKey}"]`);
//		if (!item) {
//			console.error('Item not found in DOM');
//			return;
//		}

//		// Блокируем повторные клики
//		if (item.classList.contains('removing')) return;
//		item.classList.add('removing');

//		try {
//			// ✅ Используем admin-ajax.php с нашим кастомным action
//			const ajaxUrl = document.body.dataset.ajaxUrl || window.wc_params.ajaxurl;
//			const nonce = document.body.dataset.removeNonce;

//			console.log('URL:', ajaxUrl);
//			console.log('Nonce:', nonce);

//			const formData = new URLSearchParams();
//			formData.append('action', 'mini_cart_remove_item');
//			formData.append('cart_item_key', cartItemKey);
//			formData.append('nonce', nonce);

//			const response = await fetch(ajaxUrl, {
//				method: 'POST',
//				headers: {
//					'Content-Type': 'application/x-www-form-urlencoded'
//				},
//				body: formData.toString()
//			});

//			console.log('Response status:', response.status);

//			const text = await response.text();
//			console.log('Raw response:', text.substring(0, 200)); // Первые 200 символов

//			// ✅ Безопасный парсинг JSON
//			let data;
//			try {
//				data = JSON.parse(text);
//			} catch (e) {
//				console.error('JSON parse error. Response was:', text);
//				throw new Error('Invalid JSON response from server');
//			}

//			console.log('Parsed data:', data);

//			if (data.success) {
//				// Обновляем фрагменты (счетчик)
//				if (data.data.fragments) {
//					Object.keys(data.data.fragments).forEach(key => {
//						const element = document.querySelector(key);
//						if (element) {
//							element.outerHTML = data.data.fragments[key];
//						}
//					});
//				}

//				// Ждем анимацию
//				await new Promise(resolve => setTimeout(resolve, 300));

//				// Полностью обновляем корзину
//				await this.refresh();

//				// Если корзина пуста, закрываем
//				const counter = document.getElementById('cart-counter');
//				if (counter && (counter.innerText === '0' || counter.style.display === 'none')) {
//					this.close();
//				}

//				console.log('Item removed successfully');
//			} else {
//				console.error('Remove failed:', data);
//				item.classList.remove('removing');
//			}
//		} catch (error) {
//			console.error('Remove item error:', error);
//			item.classList.remove('removing');
//		}
//	}
//}

//// Инициализация
//document.addEventListener('DOMContentLoaded', () => {
//	if (document.querySelector('.header__cart-btn')) {
//		window.miniCart = new MiniCart();
//	}
//});




////!======================
//(function () {
//	'use strict';

//	let isProcessing = false;

//	document.addEventListener('DOMContentLoaded', () => {
//		const cartAjaxUrl = document.body.dataset.cartAjaxUrl;
//		const cartNonce = document.body.dataset.cartNonce;

//		if (!cartAjaxUrl || !cartNonce) {
//			console.warn('Cart AJAX not initialized');
//			return;
//		}

//		initCartActions();
//	});

//	function showLoading() {
//		isProcessing = true;
//		document.body.classList.add('cart-processing');
//		const totals = document.getElementById('cart-totals-block');
//		if (totals) totals.classList.add('loading');
//	}

//	function hideLoading() {
//		isProcessing = false;
//		document.body.classList.remove('cart-processing');
//		const totals = document.getElementById('cart-totals-block');
//		if (totals) totals.classList.remove('loading');
//	}

//	function updateFragments(fragments) {
//		if (!fragments) return;
//		Object.keys(fragments).forEach(selector => {
//			const element = document.querySelector(selector);
//			if (element) {
//				element.outerHTML = fragments[selector];

//				// ВАЖНО: После замены Totals, нам нужно заново "обезвредить" кнопки в нем, 
//				// если бы они там были, но у нас кнопки только в списке товаров.
//			}
//		});
//	}

//	function initCartActions() {
//		const cartList = document.querySelector('.cart-page__list');
//		if (!cartList) return;

//		// 1. "ЯДЕРНЫЙ" ТРЮК: Удаляем все чужие обработчики событий с кнопок
//		const targetButtons = cartList.querySelectorAll('.quantity-box__btn, .cart-item__remove');
//		targetButtons.forEach(btn => {
//			// Клонирование узла копирует его и атрибуты, но НЕ копирует обработчики событий!
//			const cleanBtn = btn.cloneNode(true);
//			btn.parentNode.replaceChild(cleanBtn, btn);
//		});

//		// 2. Вешаем наш единственный, чистый обработчик
//		cartList.addEventListener('click', (e) => {
//			// --- ОБРАБОТКА УДАЛЕНИЯ ---
//			const removeBtn = e.target.closest('.cart-item__remove');
//			if (removeBtn) {
//				if (isProcessing) {
//					e.preventDefault();
//					e.stopImmediatePropagation();
//					return;
//				}

//				e.preventDefault();
//				e.stopImmediatePropagation();

//				const cartItemKey = removeBtn.dataset.cartItemKey;
//				const cartItem = removeBtn.closest('.cart-item');

//				if (cartItem) cartItem.classList.add('removing');
//				showLoading();

//				const formData = new URLSearchParams();
//				formData.append('action', 'cart_page_remove_item');
//				formData.append('cart_item_key', cartItemKey);
//				formData.append('nonce', document.body.dataset.cartNonce);

//				fetch(document.body.dataset.cartAjaxUrl, {
//					method: 'POST',
//					headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
//					body: formData.toString()
//				})
//					.then(res => res.json())
//					.then(data => {
//						if (data.success) {
//							setTimeout(() => {
//								updateFragments(data.data.fragments);
//								if (cartItem) cartItem.remove();
//								hideLoading();
//								if (data.data.cart_count === 0) window.location.reload();
//							}, 300);
//						} else {
//							if (cartItem) cartItem.classList.remove('removing');
//							hideLoading();
//						}
//					})
//					.catch(() => {
//						if (cartItem) cartItem.classList.remove('removing');
//						hideLoading();
//					});
//				return;
//			}

//			// --- ОБРАБОТКА КОЛИЧЕСТВА (+ и -) ---
//			const minusBtn = e.target.closest('.quantity-box__btn--minus');
//			const plusBtn = e.target.closest('.quantity-box__btn--plus');

//			if (minusBtn || plusBtn) {
//				if (isProcessing) {
//					e.preventDefault();
//					e.stopImmediatePropagation();
//					return;
//				}

//				e.preventDefault();
//				e.stopImmediatePropagation();

//				const btn = minusBtn || plusBtn;
//				const quantityBox = btn.closest('.quantity-box');
//				const input = quantityBox?.querySelector('.quantity-box__input');

//				if (!input) return;

//				let val = parseInt(input.value) || 1;
//				let min = parseInt(input.min) || 0;
//				let max = parseInt(input.max) || 99;

//				// Изменяем значение
//				if (minusBtn && val > min) {
//					input.value = val - 1;
//				} else if (plusBtn && val < max) {
//					input.value = val + 1;
//				} else {
//					return; // Достигли лимита
//				}

//				// Запускаем обновление (без вызова события 'change', чтобы не триггерить чужие скрипты)
//				updateCartQuantity(input);
//			}
//		});

//		// Обработка ручного ввода (только если мы не в процессе)
//		document.addEventListener('change', (e) => {
//			if (e.target.classList.contains('quantity-box__input')) {
//				if (isProcessing) {
//					e.preventDefault();
//					return;
//				}
//				updateCartQuantity(e.target);
//			}
//		});
//	}

//	function updateCartQuantity(input) {
//		const cartItemKey = input.dataset.cartItemKey;
//		if (!cartItemKey) return;

//		const quantity = parseInt(input.value) || 0;
//		showLoading();

//		const formData = new URLSearchParams();
//		formData.append('action', 'cart_page_update_quantity');
//		formData.append('cart_item_key', cartItemKey);
//		formData.append('quantity', quantity);
//		formData.append('nonce', document.body.dataset.cartNonce);

//		fetch(document.body.dataset.cartAjaxUrl, {
//			method: 'POST',
//			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
//			body: formData.toString()
//		})
//			.then(res => res.json())
//			.then(data => {
//				if (data.success) {
//					updateFragments(data.data.fragments);
//					hideLoading();

//					if (quantity === 0) {
//						const cartItem = input.closest('.cart-item');
//						if (cartItem) {
//							cartItem.classList.add('removing');
//							setTimeout(() => cartItem.remove(), 300);
//						}
//						if (data.data.cart_count === 0) {
//							setTimeout(() => window.location.reload(), 500);
//						}
//					}
//				} else {
//					hideLoading();
//				}
//			})
//			.catch(() => hideLoading());
//	}
//})();

/**
 * ==================================
 * ПОЛНЫЙ JS ДЛЯ КОРЗИНЫ И МИНИ-КОРЗИНЫ (FIXED)
 * ==================================
 */
class CartManager {
	constructor() {
		this.ajaxUrl = document.body.dataset.cartAjaxUrl || (window.wc_params ? window.wc_params.ajaxurl : '');
		this.nonce = document.body.dataset.cartNonce || document.body.dataset.removeNonce || '';
		this.isProcessing = false;

		this.miniCart = document.getElementById('mini-cart');
		this.cartBtn = document.querySelector('.header__cart-btn');

		this.init();
	}

	init() {
		// 1. 🛡️ СЕРЕБРЯНАЯ ПУЛЯ: Удаляем ВСЕ стандартные обработчики WooCommerce с кнопок
		this.stripNativeListeners();

		// 2. ЛОГИКА ОТКРЫТИЯ/ЗАКРЫТИЯ МИНИ-КОРЗИНЫ
		if (this.cartBtn) {
			this.cartBtn.addEventListener('click', (e) => {
				e.preventDefault();
				e.stopPropagation();
				this.openMiniCart();
			});
		}

		document.addEventListener('click', (e) => {
			if (!this.miniCart || !this.miniCart.classList.contains('is-active')) return;
			if (e.target.closest('[data-mini-cart-close]')) {
				this.closeMiniCart();
				return;
			}
			if (e.target.classList.contains('mini-cart__overlay')) {
				this.closeMiniCart();
			}
		});

		document.addEventListener('keydown', (e) => {
			if (e.key === 'Escape' && this.miniCart && this.miniCart.classList.contains('is-active')) {
				this.closeMiniCart();
			}
		});

		// 3. ЕДИНАЯ ЛОГИКА УДАЛЕНИЯ (делегирование на document)
		document.addEventListener('click', (e) => {
			const removeBtn = e.target.closest('.cart-item__remove, .mini-cart__item-remove');
			if (!removeBtn) return;

			if (this.isProcessing) {
				e.preventDefault();
				e.stopImmediatePropagation();
				return;
			}

			e.preventDefault();
			e.stopImmediatePropagation();

			const cartItemKey = removeBtn.dataset.cartItemKey;
			if (!cartItemKey) return;

			this.removeItem(cartItemKey);
		});

		// 4. ЕДИНАЯ ЛОГИКА ИЗМЕНЕНИЯ КОЛИЧЕСТВА КНОПКАМИ (+ и -)
		document.addEventListener('click', (e) => {
			if (this.isProcessing) return;

			const btn = e.target.closest('.quantity-box__btn--minus, .quantity-box__btn--plus');
			if (!btn) return;

			e.preventDefault();
			e.stopImmediatePropagation();

			const quantityBox = btn.closest('.quantity-box');
			const input = quantityBox?.querySelector('.quantity-box__input');
			if (!input) return;

			const cartItemKey = input.dataset.cartItemKey;
			if (!cartItemKey) return;

			let val = parseInt(input.value) || 1;
			const min = parseInt(input.min) || 0;
			const max = parseInt(input.max) || 99;

			if (btn.classList.contains('quantity-box__btn--minus') && val > min) {
				input.value = val - 1;
			} else if (btn.classList.contains('quantity-box__btn--plus') && val < max) {
				input.value = val + 1;
			} else {
				return; // Достигли лимита
			}

			this.updateQuantity(cartItemKey, parseInt(input.value));
		});

		// 5. 🆕 ОБРАБОТКА РУЧНОГО ВВОДА В ПОЛЕ КОЛИЧЕСТВА
		document.addEventListener('change', (e) => {
			if (e.target.classList.contains('quantity-box__input')) {
				if (this.isProcessing) return;

				const input = e.target;
				const cartItemKey = input.dataset.cartItemKey;
				if (!cartItemKey) return;

				let quantity = parseInt(input.value) || 0;
				const min = parseInt(input.min) || 0;
				const max = parseInt(input.max) || 99;

				// Валидация введенного значения
				if (quantity < min) quantity = min;
				if (quantity > max) quantity = max;

				// Обновляем значение в инпуте на случай, если пользователь ввел некорректное число
				input.value = quantity;

				// Запускаем пересчет
				this.updateQuantity(cartItemKey, quantity);
			}
		});
	}

	/**
	 * 🛡️ Клонирует кнопки, чтобы убить все нативные обработчики событий WooCommerce
	 */
	stripNativeListeners() {
		const targets = document.querySelectorAll('.quantity-box__btn, .cart-item__remove, .mini-cart__item-remove');
		targets.forEach(btn => {
			const cleanBtn = btn.cloneNode(true);
			btn.parentNode.replaceChild(cleanBtn, btn);
		});
	}

	openMiniCart() {
		if (!this.miniCart) return;
		this.miniCart.classList.add('is-active');
		this.miniCart.setAttribute('aria-hidden', 'false');
		document.body.style.overflow = 'hidden';
	}

	closeMiniCart() {
		if (!this.miniCart) return;
		this.miniCart.classList.remove('is-active');
		this.miniCart.setAttribute('aria-hidden', 'true');
		document.body.style.overflow = '';
	}

	removeItem(cartItemKey) {
		console.log('🗑️ Удаление товара:', cartItemKey);
		this.isProcessing = true;
		document.body.classList.add('cart-processing');

		const elementsToRemove = document.querySelectorAll(`[data-cart-item-key="${cartItemKey}"]`);
		elementsToRemove.forEach(el => {
			const row = el.closest('.cart-item') || el.closest('.mini-cart__item') || el;
			row.classList.add('removing');
		});

		const formData = new URLSearchParams();
		formData.append('action', 'cart_page_remove_item');
		formData.append('cart_item_key', cartItemKey);
		formData.append('nonce', this.nonce);

		fetch(this.ajaxUrl, {
			method: 'POST',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			body: formData.toString()
		})
			.then(res => res.json())
			.then(data => {
				if (data.success) {
					if (data.data.fragments) {
						Object.keys(data.data.fragments).forEach(selector => {
							const el = document.querySelector(selector);
							if (el) el.outerHTML = data.data.fragments[selector];
						});
					}

					setTimeout(() => {
						elementsToRemove.forEach(el => {
							const row = el.closest('.cart-item') || el.closest('.mini-cart__item') || el;
							row.remove();
						});

						this.isProcessing = false;
						document.body.classList.remove('cart-processing');

						const mainCartItems = document.querySelectorAll('.cart-page__list .cart-item');
						if (mainCartItems.length === 0 && document.querySelector('.cart-page')) {
							setTimeout(() => window.location.reload(), 500);
						}

						if (data.data.cart_count === 0) {
							this.closeMiniCart();
							setTimeout(() => window.location.reload(), 500);
						}
					}, 300);
				} else {
					console.error('❌ Ошибка удаления:', data);
					this.resetProcessingState();
				}
			})
			.catch(err => {
				console.error('❌ Ошибка сети:', err);
				this.resetProcessingState();
			});
	}

	updateQuantity(cartItemKey, quantity) {
		console.log('🔢 Обновление количества:', cartItemKey, '->', quantity);
		this.isProcessing = true;
		document.body.classList.add('cart-processing');

		const formData = new URLSearchParams();
		formData.append('action', 'cart_page_update_quantity');
		formData.append('cart_item_key', cartItemKey);
		formData.append('quantity', quantity);
		formData.append('nonce', this.nonce);

		fetch(this.ajaxUrl, {
			method: 'POST',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			body: formData.toString()
		})
			.then(res => res.json())
			.then(data => {
				if (data.success && data.data.fragments) {
					Object.keys(data.data.fragments).forEach(selector => {
						const el = document.querySelector(selector);
						if (el) el.outerHTML = data.data.fragments[selector];
					});

					if (quantity === 0) {
						const elements = document.querySelectorAll(`[data-cart-item-key="${cartItemKey}"]`);
						elements.forEach(el => {
							const row = el.closest('.cart-item') || el.closest('.mini-cart__item') || el;
							row.classList.add('removing');
							setTimeout(() => row.remove(), 300);
						});
					}
				}
				this.isProcessing = false;
				document.body.classList.remove('cart-processing');
			})
			.catch(err => {
				console.error('❌ Ошибка обновления:', err);
				this.isProcessing = false;
				document.body.classList.remove('cart-processing');
			});
	}

	resetProcessingState() {
		this.isProcessing = false;
		document.body.classList.remove('cart-processing');
		document.querySelectorAll('.removing').forEach(el => el.classList.remove('removing'));
	}
}

document.addEventListener('DOMContentLoaded', () => {
	window.cartManager = new CartManager();
});

/**
 * ==================================
 * CART MODAL - Модальное окно корзины
 * ==================================
 */
export class CartModal extends Modal {
	constructor(params = {}) {
		super({
			modal: '[data-cart-modal]',
			btn: '[data-cart-modal-btn]',
			...params
		});
		this.initCartModal();
	}

	initCartModal() {
		// Слушаем jQuery событие WooCommerce
		if (typeof jQuery !== 'undefined') {
			jQuery(document.body).on('added_to_cart', (event, fragments, cart_hash, $button) => {
				const button = $button[0]; // Нативный DOM элемент
				if (!button) return;

				// Считываем данные прямо из data-атрибутов кнопки
				const productData = {
					name: button.dataset.productName || 'Товар',
					price: button.dataset.productPrice || '',
					image: button.dataset.productImage || '',
					quantity: button.dataset.quantity || 1,
					link: this.getCartUrl()
				};

				// Заполняем и открываем модалку
				this.populateModal(productData);
				this.openCartModal();
			});
		}

		// Обработчик закрытия по кнопке "Продолжить покупки" или крестику
		document.addEventListener('click', (e) => {
			const closeBtn = e.target.closest('[data-cart-continue], [data-modal-close]');
			const isOverlay = e.target.closest('[data-cart-modal]') && !e.target.closest('[data-modal-box]');

			if (closeBtn || isOverlay) {
				e.preventDefault();
				this.closeAll();
				history.pushState('', document.title, window.location.pathname + window.location.search);
			}
		});
	}

	getCartUrl() {
		const cartLink = document.querySelector('a[href*="cart"]');
		return cartLink ? cartLink.href : '/cart/';
	}

	populateModal(data) {
		const modal = document.querySelector('[data-cart-modal]');
		if (!modal) return;

		// Обновляем изображение
		const image = modal.querySelector('[data-cart-modal-image]');
		if (image && data.image) {
			image.src = data.image;
			image.alt = data.name;
			image.style.display = 'block';
		}

		// Обновляем название
		const name = modal.querySelector('[data-cart-modal-name]');
		if (name) name.textContent = data.name;

		// Обновляем количество
		const quantity = modal.querySelector('[data-cart-modal-quantity]');
		if (quantity) quantity.textContent = `x ${data.quantity}`;

		// Обновляем цену
		const price = modal.querySelector('[data-cart-modal-price]');
		if (price && data.price) price.textContent = data.price;

		// Обновляем ссылку на корзину
		const cartLink = modal.querySelector('[data-cart-modal-link]');
		if (cartLink) cartLink.href = data.link;
	}

	openCartModal() {
		const modal = document.querySelector('[data-cart-modal]');
		if (!modal) return;

		modal.classList.add(this.params.activeClass);
		document.documentElement.classList.add(this.params.activeClass);
		document.body.style.overflow = 'hidden'; // Блокируем скролл
	}

	closeAll() {
		super.closeAll();
		document.body.style.overflow = ''; // Разблокируем скролл
	}
}

// Инициализация
const cartModal = new CartModal({
	modal: '[data-cart-modal]',
	activeClass: 'active-modal',
});

/**
 * ==================================
 * QUANTITY COUNTER - Счетчик количества
 * ==================================
 */
document.addEventListener('DOMContentLoaded', () => {
	document.querySelectorAll('.quantity-box').forEach(box => {
		const minusBtn = box.querySelector('.quantity-box__btn--minus');
		const plusBtn = box.querySelector('.quantity-box__btn--plus');
		const input = box.querySelector('.quantity-box__input');

		// Находим кнопку добавления в корзину в том же блоке
		const addToCartBtn = box.closest('.product-hero__cart-actions')?.querySelector('.ajax_add_to_cart');

		const updateQuantity = (change) => {
			if (!input) return;

			let val = parseInt(input.value) || 1;
			const min = parseInt(input.min) || 1;
			const max = parseInt(input.max) || 99;

			val += change;

			if (val >= min && val <= max) {
				input.value = val;
				// 🚀 Обновляем data-quantity у кнопки для AJAX и модалки
				if (addToCartBtn) {
					addToCartBtn.dataset.quantity = val;
				}
			}
		};

		if (minusBtn) {
			minusBtn.addEventListener('click', (e) => {
				e.preventDefault();
				updateQuantity(-1);
			});
		}

		if (plusBtn) {
			plusBtn.addEventListener('click', (e) => {
				e.preventDefault();
				updateQuantity(1);
			});
		}

		// Обработка ручного ввода в поле
		if (input) {
			input.addEventListener('change', () => {
				let val = parseInt(input.value) || 1;
				const min = parseInt(input.min) || 1;
				const max = parseInt(input.max) || 99;

				if (val < min) val = min;
				if (val > max) val = max;

				input.value = val;
				if (addToCartBtn) {
					addToCartBtn.dataset.quantity = val;
				}
			});
		}
	});
});