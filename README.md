# Laravel JSON-LD

A Laravel package for rendering JSON-LD schema entities with a fluent facade API. Supports Person, Organization, Article, Product, and WebSite schema types with strict validation and Blade integration.

## Installation

```bash
composer require asmi046/laravel-jsonld
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --tag=jsonld-config
```

### Configuration Options

```php
// config/jsonld.php
return [
    // Enable strict validation (required fields must be present)
    'strict' => true,

    // Pretty print JSON output
    'pretty_print' => false,

    // HTML escape mode: 'none', 'json_encode', 'htmlspecialchars'
    'escape_mode' => 'json_encode',

    // JSON encode flags
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
```

### Factory API

```php
// Create entity using make method
$person = JsonLd::make('Person', [
    'name' => 'John Doe',
    'jobTitle' => 'Developer',
    'email' => 'john@example.com',
])->render();

$org = JsonLd::make('Organization', [
    'name' => 'Acme Corp',
    'url' => 'https://acme.com',
])->render();
```

### Using Helper Functions

```php
// Fluent helpers
$person = jsonld_person()
    ->name('John Doe')
    ->jobTitle('Developer')
    ->render();

$org = jsonld_organization()->name('Acme Corp')->render();
$article = jsonld_article()->headline('My Post')->datePublished('2026-04-09')->render();
$product = jsonld_product()->name('Product')->price(99.99)->render();
$website = jsonld_website()->name('Site')->url('https://example.com')->render();

// Factory helper
$person = jsonld_make('Person', ['name' => 'John']);
```

### In Blade Templates

```blade
<!-- Using Blade directive -->
@jsonld($person)

<!-- Using helper in expression -->
{{ $article->render() }}

<!-- Building inline -->
{{ JsonLd::person()->name('John')->render() }}
```

### Getting Different Output Formats

```php
$person = JsonLd::person()->name('John Doe');

// Render as HTML script tag (default)
echo $person->render();

// Get as JSON string
$json = $person->toJson();

// Get as PHP array
$array = $person->toArray();
```

## Entity Types

### Person

**Required fields**: `name`

**Common fields**:

- `name` - Full name
- `email` - Email address
- `jobTitle` - Job title
- `url` - Website URL
- `image` - Profile image URL
- `telephone` - Phone number
- `description` - Bio or description
- `affiliation` - Associated Organization
- `address` - Physical address

### Organization

**Required fields**: `name`

**Common fields**:

- `name` - Organization name
- `url` - Website URL
- `logo` - Logo image URL
- `description` - Organization description
- `email` - Contact email
- `telephone` - Contact phone
- `address` - Physical address
- `location` - Location information
- `sameAs` - Social media links array
- `contactPoint` - Contact point details

### Article

**Required fields**: `headline`, `datePublished`

**Common fields**:

- `headline` - Article title
- `description` - Article description/excerpt
- `image` - Featured image URL
- `author` - Person or Organization (see Person/Organization)
- `datePublished` - Publication date (ISO 8601)
- `dateModified` - Last modified date
- `url` - Article URL
- `articleBody` - Full article content
- `keywords` - Article tags
- `publisher` - Publishing Organization
- `articleSection` - Article category

### Product

**Required fields**: `name`

**Common fields**:

- `name` - Product name
- `description` - Product description
- `image` - Product image URL
- `brand` - Brand (Organization)
- `price` - Price value
- `priceCurrency` - Currency code (USD, EUR, etc.)
- `url` - Product URL
- `availability` - Availability status
- `rating` - Rating object
- `review` - Review object
- `manufacturer` - Manufacturer (Organization)
- `sku` - Stock keeping unit

### WebSite

**Required fields**: `name`, `url`

**Common fields**:

- `name` - Website name
- `url` - Website URL
- `description` - Website description
- `image` - Website image
- `logo` - Logo image URL
- `language` - Language code
- `potentialAction` - Actions (like SearchAction)
- `copyrightHolder` - Copyright holder
- `author` - Website author

## Validation

The package validates required fields in strict mode (enabled by default). Validation errors throw `ValidationException` with detailed field errors:

```php
use Asmi\JsonLd\Exceptions\ValidationException;

try {
    $person = JsonLd::person()->render(); // Missing required 'name'
} catch (ValidationException $e) {
    $errors = $e->getErrors();
    // ['name' => "Required field 'name' is missing."]
}
```

Disable strict validation:

```php
// In config/jsonld.php
'strict' => false,

// Or temporarily
config(['jsonld.strict' => false]);
$person = JsonLd::person()->render(); // Won't throw
```

## Output Example

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

With `pretty_print` enabled:

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

# With coverage
php vendor/bin/phpunit --coverage-html coverage
```

## Contributing

Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

## License

MIT License - see [LICENSE](LICENSE) file for details.
