const cartCountEl = document.getElementById('cart-count');
const openCartBtn = document.getElementById('open-cart-btn');
const cartModal = document.getElementById('cart-modal');
const closeCartBtn = document.getElementById('close-cart-btn');
const modalHeading = document.getElementById('modal-heading');
const cartFeedback = document.getElementById('cart-feedback');
const modalFeedback = document.getElementById('modal-feedback');
const miniCartView = document.getElementById('mini-cart-view');
const cartItemsContainer = document.getElementById('cart-items-container');
const cartSubtotalEl = document.getElementById('cart-subtotal');
const productDetailView = document.getElementById('product-detail-view');
const backToCartBtn = document.getElementById('back-to-cart-btn');
const pdContent = document.getElementById('pd-content');
const pdQtyInput = document.getElementById('pd-qty-input');
const pdQtyMinus = document.getElementById('pd-qty-minus');
const pdQtyPlus = document.getElementById('pd-qty-plus');
const pdUpdateBtn = document.getElementById('pd-update-btn');
const pdRemoveBtn = document.getElementById('pd-remove-btn');
const productCatalog = new Map(JSON.parse(document.getElementById('product-data').textContent)
    .map(product => [String(product.product_id), product]));

let currentDetailItem = null;
let detailMode = 'cart';
let cartRequestPending = false;
let modalTrigger = null;
let pointerStartedOutside = false;

function appUrl(path) {
    return window.baseUrl.replace(/\/+$/, '') + '/' + String(path).replace(/^\/+/, '');
}

function element(tag, className, text) {
    const node = document.createElement(tag);
    if (className) node.className = className;
    if (text !== undefined) node.textContent = text;
    return node;
}

function showFeedback(message, isError = false) {
    const target = cartModal.open ? modalFeedback : cartFeedback;
    target.textContent = message;
    target.classList.toggle('is-error', isError);
    target.hidden = !message;
}

function resetModalView() {
    modalFeedback.textContent = '';
    modalFeedback.hidden = true;
    cartModal.scrollTop = 0;
}

function openModal() {
    if (!cartModal.open) {
        modalTrigger = document.activeElement;
        cartModal.showModal();
        document.documentElement.classList.add('modal-open');
    }
    cartModal.scrollTop = 0;
    modalHeading.focus({ preventScroll: true });
}

function updateCartUI(cart) {
    cartCountEl.textContent = cart.item_count;
    cartSubtotalEl.textContent = Number(cart.subtotal).toFixed(2);
    cartItemsContainer.replaceChildren();

    if (cart.items.length === 0) {
        cartItemsContainer.append(element('p', '', 'Your cart is empty.'));
        return;
    }

    cart.items.forEach(item => {
        const row = element('button', 'cart-item');
        row.type = 'button';
        row.setAttribute('aria-label', 'View details for ' + item.name);
        const picture = element(item.image_url ? 'img' : 'span', item.image_url ? '' : 'cart-item-placeholder');
        if (item.image_url) {
            picture.src = appUrl(item.image_url);
            picture.alt = item.name;
        } else {
            picture.setAttribute('aria-hidden', 'true');
        }
        const info = element('span', 'cart-item-info');
        info.append(
            element('span', 'cart-item-name', item.name),
            element('span', 'cart-item-qty', 'Qty: ' + item.quantity + ' × ₱' + Number(item.unit_price).toFixed(2))
        );
        row.append(picture, info, element('span', 'cart-item-total', '₱' + Number(item.line_total).toFixed(2)));
        row.addEventListener('click', () => openProductDetail(item, 'cart'));
        cartItemsContainer.append(row);
    });
}

// The same detail view supports browsing a product and editing a cart item.
function openProductDetail(item, mode) {
    currentDetailItem = item;
    detailMode = mode;
    const product = { ...productCatalog.get(String(item.product_id)), ...item };
    pdContent.replaceChildren();

    const images = product.images?.length ? product.images : (product.image_url ? [{ url: product.image_url }] : []);
    images.forEach(image => {
        const picture = element('img', 'pd-detail-image');
        picture.src = appUrl(image.url);
        picture.alt = product.name;
        pdContent.append(picture);
    });
    if (images.length === 0) {
        pdContent.append(element('p', '', 'No image available.'));
    }
    pdContent.append(
        element('h3', '', product.name),
        element('p', 'pd-description', product.description || 'No description available.'),
        element('p', '', 'Unit Price: ₱' + Number(mode === 'cart' ? item.unit_price : product.price).toFixed(2))
    );
    if (product.sku) pdContent.append(element('p', '', 'SKU: ' + product.sku));
    if (product.stock_quantity !== undefined) {
        pdContent.append(element('p', '', 'Stock available: ' + product.stock_quantity));
    }

    pdQtyInput.value = mode === 'cart' ? item.quantity : 1;
    pdQtyInput.setCustomValidity('');
    backToCartBtn.hidden = mode !== 'cart';
    pdRemoveBtn.hidden = mode !== 'cart';
    pdUpdateBtn.textContent = mode === 'cart' ? 'Update Quantity' : 'Add to Cart';
    miniCartView.hidden = true;
    productDetailView.hidden = false;
    modalHeading.textContent = 'Product Details';
    resetModalView();
    openModal();
}

function showMiniCartView() {
    productDetailView.hidden = true;
    miniCartView.hidden = false;
    modalHeading.textContent = 'Your Cart';
    currentDetailItem = null;
    resetModalView();
    if (cartModal.open) modalHeading.focus({ preventScroll: true });
}

async function fetchCart() {
    try {
        const response = await fetch(appUrl('/cart/api'));
        const data = await response.json();
        if (!response.ok || !data.success) throw new Error(data.message || 'Unable to load your cart. Please try again.');
        updateCartUI(data.cart);
    } catch (error) {
        showFeedback(error.message, true);
    }
}

async function changeCart(action, productId, quantity) {
    if (cartRequestPending) return false;
    cartRequestPending = true;
    const actionButtons = [...document.querySelectorAll('.add-to-cart-btn'), pdUpdateBtn, pdRemoveBtn];
    actionButtons.forEach(button => { button.disabled = true; });
    try {
        const response = await fetch(appUrl('/cart/' + action), {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ product_id: productId, quantity })
        });
        const data = await response.json();
        if (!response.ok || !data.success) throw new Error(data.message || 'Unable to change your cart. Please try again.');
        updateCartUI(data.cart);
        return true;
    } catch (error) {
        showFeedback(error.message, true);
        return false;
    } finally {
        cartRequestPending = false;
        actionButtons.forEach(button => { button.disabled = false; });
    }
}

openCartBtn.addEventListener('click', () => {
    showMiniCartView();
    openModal();
});
closeCartBtn.addEventListener('click', () => cartModal.close());
backToCartBtn.addEventListener('click', showMiniCartView);

// Bounds distinguish the backdrop from empty space inside the dialog.
// Requiring an outside press also prevents dismissal when dragging out.
function isOutsideDialog(event) {
    const bounds = cartModal.getBoundingClientRect();
    return event.clientX < bounds.left || event.clientX > bounds.right
        || event.clientY < bounds.top || event.clientY > bounds.bottom;
}

cartModal.addEventListener('pointerdown', event => {
    pointerStartedOutside = event.target === cartModal && isOutsideDialog(event);
});
cartModal.addEventListener('pointercancel', () => { pointerStartedOutside = false; });
cartModal.addEventListener('click', event => {
    if (pointerStartedOutside && event.target === cartModal && isOutsideDialog(event)) cartModal.close();
    pointerStartedOutside = false;
});
cartModal.addEventListener('close', () => {
    document.documentElement.classList.remove('modal-open');
    pointerStartedOutside = false;
    if (modalTrigger?.isConnected) modalTrigger.focus({ preventScroll: true });
});

document.querySelectorAll('.product-details-btn').forEach(button => {
    button.addEventListener('click', () => {
        const product = productCatalog.get(button.dataset.id);
        if (product) openProductDetail(product, 'preview');
    });
});

document.querySelectorAll('.add-to-cart-btn').forEach(button => {
    button.addEventListener('click', async () => {
        if (await changeCart('add', button.dataset.id, 1)) showFeedback('Added to cart!');
    });
});

pdQtyInput.addEventListener('input', () => pdQtyInput.setCustomValidity(''));
pdQtyMinus.addEventListener('click', () => {
    pdQtyInput.value = Math.max(1, (Number.parseInt(pdQtyInput.value, 10) || 1) - 1);
    pdQtyInput.setCustomValidity('');
});
pdQtyPlus.addEventListener('click', () => {
    pdQtyInput.value = Math.max(1, (Number.parseInt(pdQtyInput.value, 10) || 0) + 1);
    pdQtyInput.setCustomValidity('');
});

pdUpdateBtn.addEventListener('click', async () => {
    if (!currentDetailItem) return;
    const quantity = Number(pdQtyInput.value);
    pdQtyInput.setCustomValidity(Number.isSafeInteger(quantity) && quantity >= 1 ? '' : 'Enter a whole quantity of at least 1.');
    if (!pdQtyInput.reportValidity()) return;
    const item = currentDetailItem;
    const mode = detailMode;
    if (await changeCart(mode === 'preview' ? 'add' : 'update', item.product_id, quantity)) {
        if (currentDetailItem === item && detailMode === mode) showMiniCartView();
        showFeedback(mode === 'preview' ? 'Added to cart!' : 'Quantity updated.');
    }
});
pdRemoveBtn.addEventListener('click', async () => {
    if (!currentDetailItem || !confirm('Remove this item from your cart?')) return;
    const item = currentDetailItem;
    if (await changeCart('remove', item.product_id)) {
        if (currentDetailItem === item) showMiniCartView();
        showFeedback('Item removed.');
    }
});

fetchCart();
