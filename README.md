# Laravel JSON-LD

Пакет для Laravel, который рендерит schema-сущности JSON-LD через fluent API фасада. Поддерживает типы Person, Organization, Article, Product, WebSite, LocalBusiness и TravelAgency, а также строгую валидацию и интеграцию с Blade.

## Installation

```bash
composer require asmi046/laravel-jsonld
```

## Configuration

Опубликуйте конфигурационный файл:

```bash
php artisan vendor:publish --tag=jsonld-config
```

### Configuration Options

```php
// config/jsonld.php
return [
    // Включить строгую валидацию (обязательные поля должны быть заполнены)
    'strict' => true,

    // Красивое форматирование JSON
    'pretty_print' => false,

    // Режим экранирования HTML: 'none', 'json_encode', 'htmlspecialchars'
    'escape_mode' => 'json_encode',

    // Флаги json_encode
    'json_flags' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
];
```

## Usage

### Fluent Builder API

```php
use Asmi\JsonLd\Facades\JsonLd;

// Person
$person = JsonLd::person()
    ->name('John Doe')
    ->jobTitle('Software Developer')
    ->email('john@example.com')
    ->url('https://johndoe.com')
    ->render();

// Organization
$org = JsonLd::organization()
    ->name('Acme Corporation')
    ->url('https://acme.com')
    ->logo('https://acme.com/logo.png')
    ->email('contact@acme.com')
    ->telephone('+1-555-0100')
    ->render();

// Article
$article = JsonLd::article()
    ->headline('Understanding JSON-LD')
    ->description('Learn how to use JSON-LD for structured data...')
    ->datePublished('2026-04-09')
    ->dateModified('2026-04-10')
    ->image('https://example.com/image.jpg')
    ->author(JsonLd::person()->name('Jane Smith'))
    ->render();

// Product
$product = JsonLd::product()
    ->name('Awesome Product')
    ->description('The best product ever')
    ->price(99.99)
    ->priceCurrency('USD')
    ->image('https://example.com/product.jpg')
    ->brand(JsonLd::organization()->name('Brand Inc'))
    ->url('https://example.com/product')
    ->render();

// WebSite
$website = JsonLd::website()
    ->name('My Website')
    ->url('https://example.com')
    ->description('Welcome to my website')
    ->logo('https://example.com/logo.png')
    ->render();

// LocalBusiness
$localBusiness = JsonLd::localBusiness()
    ->name('Кофейня на Арбате')
    ->url('https://coffeeshop.ru')
    ->telephone('+7-495-000-0000')
    ->address('Арбат, 10, Москва')
    ->openingHours('Mo-Fr 08:00-22:00')
    ->priceRange('$$')
    ->geo(['@type' => 'GeoCoordinates', 'latitude' => 55.7522, 'longitude' => 37.5722])
    ->paymentAccepted(['Cash', 'Credit Card'])
    ->render();

// TravelAgency
$travelAgency = JsonLd::travelAgency()
    ->name('Путешествия мечты')
    ->url('https://dream-travel.ru')
    ->telephone('+7-800-000-0000')
    ->email('info@dream-travel.ru')
    ->openingHours('Mo-Su 09:00-21:00')
    ->areaServed(['Россия', 'Европа', 'Азия'])
    ->serviceType('Туристические туры')
    ->render();
```

### Factory API

```php
// Создание сущности через метод make
$person = JsonLd::make('Person', [
    'name' => 'John Doe',
    'jobTitle' => 'Developer',
    'email' => 'john@example.com',
])->render();

$org = JsonLd::make('Organization', [
    'name' => 'Acme Corp',
    'url' => 'https://acme.com',
])->render();

$localBusiness = JsonLd::make('LocalBusiness', [
    'name' => 'Кофейня на Арбате',
    'telephone' => '+7-495-000-0000',
    'openingHours' => 'Mo-Fr 08:00-22:00',
])->render();

$travelAgency = JsonLd::make('TravelAgency', [
    'name' => 'Путешествия мечты',
    'areaServed' => ['Россия', 'Европа'],
    'serviceType' => 'Туристические туры',
])->render();
```

### Using Helper Functions

```php
// Fluent helper-функции
$person = jsonld_person()
    ->name('John Doe')
    ->jobTitle('Developer')
    ->render();

$org = jsonld_organization()->name('Acme Corp')->render();
$article = jsonld_article()->headline('My Post')->datePublished('2026-04-09')->render();
$product = jsonld_product()->name('Product')->price(99.99)->render();
$website = jsonld_website()->name('Site')->url('https://example.com')->render();
$localBusiness = jsonld_local_business()->name('Кофейня')->openingHours('Mo-Fr 08:00-22:00')->render();
$travelAgency = jsonld_travel_agency()->name('Агентство')->areaServed('Россия')->render();

// Factory helper
$person = jsonld_make('Person', ['name' => 'John']);
$localBusiness = jsonld_make('LocalBusiness', ['name' => 'Кофейня']);
$travelAgency = jsonld_make('TravelAgency', ['name' => 'Агентство']);
```

### In Blade Templates

```blade
<!-- Использование Blade-директивы -->
@jsonld($person)

<!-- Использование helper в выражении -->
{{ $article->render() }}

<!-- Построение inline -->
{{ JsonLd::person()->name('John')->render() }}
```

### Getting Different Output Formats

```php
$person = JsonLd::person()->name('John Doe');

// Рендер как HTML script tag (по умолчанию)
echo $person->render();

// Получить как JSON-строку
$json = $person->toJson();

// Получить как PHP-массив
$array = $person->toArray();
```

## Entity Types

### Person

**Обязательные поля**: `name`

**Основные поля**:

- `name` - Полное имя
- `email` - Email-адрес
- `jobTitle` - Должность
- `url` - URL сайта
- `image` - URL изображения профиля
- `telephone` - Телефон
- `description` - Биография или описание
- `affiliation` - Связанная организация
- `address` - Физический адрес

### Organization

**Обязательные поля**: `name`

**Основные поля**:

- `name` - Название организации
- `url` - URL сайта
- `logo` - URL логотипа
- `description` - Описание организации
- `email` - Контактный email
- `telephone` - Контактный телефон
- `address` - Физический адрес
- `location` - Информация о местоположении
- `sameAs` - Массив ссылок на соцсети
- `contactPoint` - Данные контактной точки

### Article

**Обязательные поля**: `headline`, `datePublished`

**Основные поля**:

- `headline` - Заголовок статьи
- `description` - Описание/анонс статьи
- `image` - URL главного изображения
- `author` - Person или Organization (см. Person/Organization)
- `datePublished` - Дата публикации (ISO 8601)
- `dateModified` - Дата последнего изменения
- `url` - URL статьи
- `articleBody` - Полный текст статьи
- `keywords` - Ключевые слова
- `publisher` - Организация-издатель
- `articleSection` - Раздел/категория статьи

### Product

**Обязательные поля**: `name`

**Основные поля**:

- `name` - Название товара
- `description` - Описание товара
- `image` - URL изображения товара
- `brand` - Бренд (Organization)
- `price` - Цена
- `priceCurrency` - Код валюты (USD, EUR и т.д.)
- `url` - URL товара
- `availability` - Статус наличия
- `rating` - Объект рейтинга
- `review` - Объект отзыва
- `manufacturer` - Производитель (Organization)
- `sku` - Артикул товара

### WebSite

**Обязательные поля**: `name`, `url`

**Основные поля**:

- `name` - Название сайта
- `url` - URL сайта
- `description` - Описание сайта
- `image` - Изображение сайта
- `logo` - URL логотипа
- `language` - Код языка
- `potentialAction` - Действия (например SearchAction)
- `copyrightHolder` - Правообладатель
- `author` - Автор сайта

### LocalBusiness

Наследует все поля `Organization`. Представляет физическое местное заведение.

**Обязательные поля**: `name`

**Основные поля (унаследованы от Organization)**:

- `name` - Название заведения
- `url` - URL сайта
- `telephone` - Телефон
- `email` - Email
- `address` - Физический адрес
- `logo` - URL логотипа
- `description` - Описание
- `sameAs` - Ссылки на соцсети

**Специфичные поля**:

- `openingHours` - Часы работы (например `Mo-Fr 08:00-22:00`)
- `priceRange` - Ценовой диапазон (`$`, `$$`, `$$$` и т.д.)
- `geo` - Географические координаты (`@type: GeoCoordinates`, `latitude`, `longitude`)
- `paymentAccepted` - Принимаемые способы оплаты (строка или массив)

### TravelAgency

Наследует все поля `LocalBusiness`. Представляет туристическое агентство.

**Обязательные поля**: `name`

**Специфичные поля**:

- `areaServed` - Обслуживаемые регионы (строка или массив)
- `serviceType` - Тип туристических услуг

## Validation

Пакет проверяет обязательные поля в строгом режиме (включен по умолчанию). При ошибках валидации выбрасывается `ValidationException` с детализацией по полям:

```php
use Asmi\JsonLd\Exceptions\ValidationException;

try {
    $person = JsonLd::person()->render(); // Отсутствует обязательное поле 'name'
} catch (ValidationException $e) {
    $errors = $e->getErrors();
    // ['name' => "Required field 'name' is missing."]
}
```

Отключить строгую валидацию:

```php
// In config/jsonld.php
'strict' => false,

// Или временно
config(['jsonld.strict' => false]);
$person = JsonLd::person()->render(); // Исключение выброшено не будет
```

## Пример вывода

```html
<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Person",
    "name": "John Doe",
    "jobTitle": "Developer",
    "email": "john@example.com"
  }
</script>
```

С включенным `pretty_print`:

```html
<script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@type": "Person",
    "name": "John Doe",
    "jobTitle": "Developer",
    "email": "john@example.com"
  }
</script>
```

## Testing

```bash
php vendor/bin/phpunit

# С coverage
php vendor/bin/phpunit --coverage-html coverage
```

## Contributing

Подробности смотрите в [CONTRIBUTING.md](CONTRIBUTING.md).

## License

Лицензия MIT. Подробности в [LICENSE](LICENSE).
