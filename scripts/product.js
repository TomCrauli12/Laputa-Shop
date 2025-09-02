document.addEventListener('DOMContentLoaded', function() {
    const imagesList = document.querySelector('.images_list');
    const mainImages = document.querySelector('.main_images');
    const mainImageLink = mainImages.querySelector('a');
    const mainImage = mainImages.querySelector('img');
    
    const originalMainImage = {
        src: mainImage.src,
        alt: mainImage.alt
    };

    imagesList.addEventListener('click', function(e) {
        if (e.target.tagName === 'IMG') {
            e.preventDefault();
            swapImages(e.target.closest('a'));
        }
    });
    

    mainImageLink.addEventListener('click', function(e) {
        e.preventDefault();
        returnToGallery();
    });
    function swapImages(clickedThumbnail) {
        const thumbnailImg = clickedThumbnail.querySelector('img');
        const mainImg = mainImage;
        
        const tempSrc = mainImg.src;
        const tempAlt = mainImg.alt;
        
        mainImg.src = thumbnailImg.src;
        mainImg.alt = thumbnailImg.alt;
        
        thumbnailImg.src = tempSrc;
        thumbnailImg.alt = tempAlt;
    }
    
    function returnToGallery() {
        const thumbnails = imagesList.querySelectorAll('a');
        let emptySlot = null;
        
        const currentMainSrc = mainImage.src;
        let alreadyInGallery = false;
        
        thumbnails.forEach(thumbnail => {
            if (thumbnail.querySelector('img').src === currentMainSrc) {
                alreadyInGallery = true;
            }
        });
        
        if (alreadyInGallery) {
            mainImage.src = originalMainImage.src;
            mainImage.alt = originalMainImage.alt;
        } else {
            thumbnails.forEach(thumbnail => {
                const thumbImg = thumbnail.querySelector('img');
                if (thumbImg.src === originalMainImage.src && !emptySlot) {
                    emptySlot = thumbnail;
                }
            });
            
            if (emptySlot) {
                const emptySlotImg = emptySlot.querySelector('img');
                const tempSrc = emptySlotImg.src;
                const tempAlt = emptySlotImg.alt;
                
                emptySlotImg.src = mainImage.src;
                emptySlotImg.alt = mainImage.alt;
                
                mainImage.src = tempSrc;
                mainImage.alt = tempAlt;
            }
        }
    }
    
    const style = document.createElement('style');
    style.textContent = `
        .images_list a {
            transition: all 0.3s ease;
        }
        .images_list a:hover {
            transform: scale(1.05);
        }
        .main_images a {
            cursor: pointer;
        }
        .main_images a:hover img {
            opacity: 0.9;
        }
    `;
    document.head.appendChild(style);
});