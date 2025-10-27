### Установка

Добавить `"./vendor/4geo35/category-product/src/resources/views/components/**/*.blade.php",
        "./vendor/4geo35/category-product/src/resources/views/admin/**/*.blade.php",
        "./vendor/4geo35/category-product/src/resources/views/livewire/admin/**/*.blade.php",` в `tailwind.admin.config.js`, созданный в пакете `tailwindcss-theme`.

Добавить `"./vendor/4geo35/category-product/src/resources/views/components/**/*.blade.php",
        "./vendor/4geo35/category-product/src/resources/views/web/**/*.blade.php",
        "./vendor/4geo35/category-product/src/resources/views/livewire/web/**/*.blade.php",` в `tailwind.config.js`, созданный в пакете `tailwindcss-theme`.

Добавить `require("./vendor/4geo35/category-product/src/resources/tailwind-plugins/productGrid"),` к плагинам в `tailwind.config.js`, созданный в пакете `tailwindcss-theme`

Запустить миграции для создания таблиц `php artisan migrate`


Установить диапазон `npm i nouislider`

Добавить в `app.css`:
    
    @import "nouislider/dist/nouislider.css";

Добавить в `app.js`:

    import noUiSlider from "nouislider"
    window.noUiSlider = noUiSlider

Установить слайдер `npm install swiper`

Добавить в `app.js`:

    import Swiper from "swiper/bundle"
    import "swiper/css/bundle"
    window.Swiper = Swiper

Установить lightbox `npm install fslightbox`, добавить в `app.js`:

    import "fslightbox"
