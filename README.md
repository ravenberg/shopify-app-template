# Laravel Shopify App Template

A modern Shopify app template built with Laravel and React, providing a solid foundation for developing Shopify applications with seamless full-stack experience and full Shopify CLI compatibility.

## 🚀 Quick Start with Shopify CLI and Laravel Herd

1. Navigate you your Laravel Herd site folder
2. Create a new Shopify app using this template
```bash
shopify app init --template="https://github.com/ravenberg/shopify-app-template"
```
3. Share the url through Herd
```bash
cd <name-of-app-directory> && herd share
```
4. In a separate terminal, start the dev server via shopify api
```bash
shopify app dev --tunnel-url=<herd-share-url>
```   

## 🛠️ Features

This template uses the official [Shopify API PHP package](https://github.com/Shopify/shopify-api-php) and includes:

- ✅ **Full Shopify CLI compatibility**
- 🔐 **OAuth authentication flow** (online and offline tokens)
- 🌐 **REST and GraphQL API support**
- 🪝 **Webhook handling and verification**
- 🎨 **Modern React frontend with TypeScript**
- ⚡ **Inertia.js for SPA-like experience**
- 🎯 **Tailwind CSS with Radix UI components**
- 🧪 **Pest PHP testing framework**
- 🔧 **Laravel Pint code formatting**
- 📦 **Vite for fast frontend builds**

## 📋 Prerequisites

- PHP 8.2+
- Node.js 18+
- Composer
- Shopify CLI 3.0+
- A Shopify Partner account

## 🏗️ Installation

```bash
# Create new app from this template
shopify app init --template="https://github.com/your-username/shopify-app-template"

# Navigate to your app directory
cd your-app-name

# Install dependencies
composer install
npm install

# Set up environment
cp .env.example .env
php artisan key:generate

# Run database migrations
php artisan migrate

# Start development server
shopify app dev
```


## 🏗️ Architecture

### Backend (Laravel)
- **Models**: `User`, `Shop` with Shopify integration
- **Controllers**: `ShopifyAuthController` for OAuth flow
- **Middleware**: `VerifyShopifyRequest` for security
- **Service Provider**: `ShopifyServiceProvider` for SDK configuration
- **Session Storage**: Custom `SessionStorageDriver` for database storage

### Frontend (React + TypeScript)
- **Framework**: React 19 with TypeScript
- **Routing**: Inertia.js for SPA-like experience
- **Styling**: Tailwind CSS 4.0
- **Components**: Radix UI + custom components
- **Build Tool**: Vite for fast development and builds

## 🚀 Development

### Available Scripts

```bash
# Laravel/PHP
composer dev          # Start all development servers
php artisan serve     # Start Laravel server only
php artisan test      # Run PHP tests
./vendor/bin/pint     # Format PHP code

# Frontend
npm run dev           # Start Vite development server
npm run build         # Build for production
npm run lint          # Lint JavaScript/TypeScript
npm run format        # Format frontend code

# Shopify CLI
shopify app dev       # Start development with Shopify CLI
shopify app deploy    # Deploy your app
shopify app generate  # Generate app extensions
```

### Database

The template includes migrations for:
- **Users table**: Extended with Shopify user data
- **Shops table**: Stores shop information and offline tokens

```bash
php artisan migrate              # Run migrations
php artisan migrate:fresh --seed # Fresh migration with seeders
```

## 🔐 Authentication Flow

1. **Installation**: User installs app from Shopify App Store
2. **OAuth**: App redirects to Shopify for authorization
3. **Callback**: Shopify redirects back with authorization code
4. **Token Exchange**: App exchanges code for access tokens
5. **Session Storage**: Tokens stored securely in database
6. **API Access**: App can now make authenticated requests

## 🪝 Webhooks

The template includes webhook handling for:
- **App Uninstalled**: Automatically cleanup when app is uninstalled

Webhooks are automatically configured via `shopify.app.toml`.

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test suites
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# Run with coverage
php artisan test --coverage
```

## 📚 Documentation

- [Shopify App Development](https://shopify.dev/docs/apps)
- [Shopify CLI](https://shopify.dev/docs/apps/tools/cli)
- [Laravel Documentation](https://laravel.com/docs)
- [Inertia.js Documentation](https://inertiajs.com/)

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests for new functionality
5. Run the test suite
6. Submit a pull request

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

- [Shopify Community](https://community.shopify.com/)
- [Laravel Community](https://laravel.com/community)
- [GitHub Issues](https://github.com/your-username/shopify-app-template/issues)
