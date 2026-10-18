<!-- Modal: Product Added to Cart -->
<div id="cart-added-modal" class="modal cart-added-modal" data-cart-modal>
	<div class="modal__overlay" data-modal-close></div>

	<div class="modal__box cart-added-modal__box" data-modal-box>
		<button class="modal__close modal__close-btn modal-close-btn" data-modal-close type="button" aria-label="Закрыть">
			<svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
				<path d="M13 13L22.75 22.75M13 13L3.25 3.25M13 13L3.25 22.75M13 13L22.75 3.25"
					stroke="url(#paint0_linear_92_6097)" stroke-width="2" stroke-linecap="round" />
				<defs>
					<linearGradient id="paint0_linear_92_6097" x1="12.1917" y1="3.25" x2="12.1917" y2="22.75"
						gradientUnits="userSpaceOnUse">
						<stop stop-color="#D3B28B" />
						<stop offset="1" stop-color="#C79F6F" />
					</linearGradient>
				</defs>
			</svg>
		</button>
		<div class="modal__body">
			<div class="cart-added-modal__success-icon">
				<svg width="76" height="76" viewBox="0 0 76 76" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect x="0.5" y="0.5" width="75" height="75" rx="37.5" stroke="#C79F70" />
					<path d="M52.25 28.5L32.3 49.875L23.75 41.8594" stroke="url(#paint0_linear_92_6142)" stroke-width="3"
						stroke-linejoin="round" />
					<defs>
						<linearGradient id="paint0_linear_92_6142" x1="36.8187" y1="28.5" x2="36.8187" y2="49.875"
							gradientUnits="userSpaceOnUse">
							<stop stop-color="#D3B28B" />
							<stop offset="1" stop-color="#C79F6F" />
						</linearGradient>
					</defs>
				</svg>
			</div>

			<h2 class="modal__title title-2" data-cart-modal-title>Товар добавлен в корзину</h2>

			<div class="cart-added-modal__product">
				<div class="cart-added-modal__product-image">
					<img data-cart-modal-image src="" alt="" class="img" style="display: none;">
				</div>

				<div class="cart-added-modal__product-info">
					<h3 class="cart-added-modal__product-name" data-cart-modal-name>Название товара</h3>
					<div class="cart-added-modal__product-meta">
						<span class="cart-added-modal__product-quantity" data-cart-modal-quantity>x 1</span>
						<span class="cart-added-modal__product-price" data-cart-modal-price>0 BYN</span>
					</div>
				</div>
			</div>

			<div class="cart-added-modal__actions">
				<a href="<?php echo esc_url(home_url('/cart/')); ?>" class="btn cart-added-modal__btn" >
					Перейти в корзину
				</a>

				<button type="button" class="btn btn--stroke cart-added-modal__btn" data-cart-continue>
					Продолжить покупки
				</button>
			</div>
		</div>
	</div>
</div>