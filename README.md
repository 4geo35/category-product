### Установка

Добавить `"./vendor/4geo35/category-product/src/resources/views/components/**/*.blade.php",
        "./vendor/4geo35/category-product/src/resources/views/admin/**/*.blade.php",
        "./vendor/4geo35/category-product/src/resources/views/livewire/admin/**/*.blade.php",` в `tailwind.admin.config.js`, созданный в пакете `tailwindcss-theme`.

Добавить `"./vendor/4geo35/category-product/src/resources/views/components/**/*.blade.php",
        "./vendor/4geo35/category-product/src/resources/views/web/**/*.blade.php",
        "./vendor/4geo35/category-product/src/resources/views/livewire/web/**/*.blade.php",` в `tailwind.config.js`, созданный в пакете `tailwindcss-theme`.

Запустить миграции для создания таблиц `php artisan migrate`

Добавить `"flickity": "^2.3.0", "flickity-as-nav-for": "^2.0",` в `package.json`

Добавить `@import "flickity/css/flickity.css";` в `app.css`;

Добавить `import Flickity from "flickity"`, `import "flickity-as-nav-for"`, `window.Flickity = Flickity` в `app.js`

Установить диапазон `npm i nouislider`

Добавить `@import "nouislider/dist/nouislider.css";` в `app.css`

Добавить `import noUiSlider from "nouislider"`, `window.noUiSlider = noUiSlider` в `app.js`
