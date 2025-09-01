document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.add-to-basket-btn').forEach(button => {
        button.addEventListener('click', async (event) => {
            const clickedButton = event.currentTarget; 
            const productId = clickedButton.dataset.productId;
            const redirectUrl = clickedButton.dataset.redirectUrl;

            console.log('Отправка в корзину: productId=', productId);
            console.log('Redirect URL:', redirectUrl);

            try {
                const response = await fetch('/Laputa-Shop/core/Controllers/PoductController.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=AddToBasket&product_id=${productId}&redirect_url=${redirectUrl}`
                });
                const data = await response.json();

                if (data.success) {
                    const basketLink = document.createElement('a');
                    basketLink.href = '/Laputa-Shop/pages/basket.php';
                    basketLink.classList.add('in-basket');
                    basketLink.textContent = 'Товар в корзине';
                    clickedButton.parentNode.replaceChild(basketLink, clickedButton);
                    console.log('Product added to basket:', data.message);
                } else {
                    console.error('Failed to add product to basket:', data.message);
                    alert('Ошибка: ' + data.message);
                }
            } catch (error) {
                console.error('Error adding product to basket:', error);
                alert('Произошла ошибка при добавлении товара в корзину.');
            }
        });
    });

    document.querySelectorAll('.toggle-favourite-btn').forEach(button => {
        button.addEventListener('click', async (event) => {
            const clickedButton = event.currentTarget;
            const productId = clickedButton.dataset.productId;
            const categoryName = clickedButton.dataset.categoryName;
            const blockDbName = clickedButton.dataset.blockDbName;
            const minValue = clickedButton.dataset.minValue;
            const maxValue = clickedButton.dataset.maxValue;
            const redirectUrl = clickedButton.dataset.redirectUrl;
            
            console.log('Переключение избранного: productId=', productId);
            console.log('Category Name:', categoryName);
            console.log('Block DB Name:', blockDbName);
            console.log('Min Value:', minValue);
            console.log('Max Value:', maxValue);
            console.log('Redirect URL:', redirectUrl);

            let queryParams = `action=toggle_favourite&product_id=${productId}`;
            if (categoryName) queryParams += `&name=${categoryName}`;
            if (blockDbName) queryParams += `&block=${blockDbName}`;
            if (minValue) queryParams += `&min_value=${minValue}`;
            if (maxValue) queryParams += `&max_value=${maxValue}`;
            if (redirectUrl) queryParams += `&redirect_url=${redirectUrl}`;

            try {
                const response = await fetch('/Laputa-Shop/core/Controllers/PoductController.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: queryParams
                });
                const data = await response.json();

                if (data.success) {
                    console.log('Current target for favourite:', clickedButton);
                    console.log('InnerHTML of current target:', clickedButton.innerHTML);
                    const img = clickedButton.querySelector('img');
                    if (!img) {
                        console.error('IMG element not found inside the button.', clickedButton);
                        return;
                    }
                    if (data.isFavourite) {
                        img.src = '/Laputa-Shop/image/Image_system/icons8-heart-50 (1).png';
                        img.alt = 'Удалить из избранного';
                    } else {
                        img.src = '/Laputa-Shop/image/Image_system/icons8-heart-50.png';
                        img.alt = 'В избранное';
                    }
                    console.log('Favourite status toggled:', data.message);
                } else {
                    console.error('Failed to toggle favourite status:', data.message);
                    alert('Ошибка: ' + data.message);
                }
            } catch (error) {
                console.error('Error toggling favourite status:', error);
                alert('Произошла ошибка при изменении статуса избранного.');
            }
        });
    });

    document.querySelectorAll('.delete-from-basket-btn').forEach(button => {
        button.addEventListener('click', async (event) => {
            const clickedButton = event.currentTarget;
            const basketId = clickedButton.dataset.basketId;
            const redirectUrl = clickedButton.dataset.redirectUrl;

            if (!confirm('Удалить товар из корзины?')) {
                return;
            }

            try {
                const response = await fetch('/Laputa-Shop/core/Controllers/PoductController.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=deleteBasketProduct&id=${basketId}&redirect_url=${redirectUrl}`
                });
                const data = await response.json();

                if (data.success) {
                    // Remove the entire product card from the DOM
                    const productCard = clickedButton.closest('.basket_card');
                    if (productCard) {
                        productCard.remove();
                    }
                    console.log('Product deleted from basket:', data.message);
                } else {
                    console.error('Failed to delete product from basket:', data.message);
                    alert('Ошибка: ' + data.message);
                }
            } catch (error) {
                console.error('Error deleting product from basket:', error);
                alert('Произошла ошибка при удалении товара из корзины.');
            }
        });
    });
});