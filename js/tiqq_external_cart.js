window.addEventListener("message", (event) => {
    if(event.data.type == 'addToCart') {
        let cart_update = new Date(window.localStorage.getItem('tiqq_external_cart_last_update'));
        let cart = JSON.parse(window.localStorage.getItem('tiqq_external_cart'));
        if(cart == null || ((new Date() - cart_update) / 60000) > 720) { cart = []; }
        cart.push(event.data.content);

        window.localStorage.setItem(
            'tiqq_external_cart',
            JSON.stringify(cart)
        );

        window.localStorage.setItem(
            'tiqq_external_cart_last_update',
            new Date()
        );
    }

    if(event.data.type == 'forceUpdateCart') {
        window.localStorage.setItem(
            'tiqq_external_cart',
            JSON.stringify(event.data.content)
        );

        window.localStorage.setItem(
            'tiqq_external_cart_last_update',
            new Date()
        );
    }

    if(event.data.type == 'requestCart') {
        sendTiqqCart()
    }
}, false);

function sendTiqqCart() {
    let cart_update = new Date(window.localStorage.getItem('tiqq_external_cart_last_update'));
    let cart = JSON.parse(window.localStorage.getItem('tiqq_external_cart'));

    if(cart_update == null || ((new Date() - cart_update) / 60000) < 720) {
        document.getElementById('tiqq-cart-frame').contentWindow.postMessage({
            type: 'cartItems',
            content: cart
        }, "*");
    }
}