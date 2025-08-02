# Shopify App Template - Developer Guidelines

## 🚀 Project Overview

This is a modern Shopify app template built with Laravel and React, providing a solid foundation for developing Shopify applications with a seamless full-stack experience.

### Tech Stack
- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: React 19 + TypeScript
- **Bridge**: Inertia.js v2 (SPA-like experience)
- **Styling**: Tailwind CSS 4.0
- **UI Components**: Radix UI + Headless UI
- **Build Tool**: Vite
- **Testing**: Pest PHP
- **Code Quality**: ESLint + Prettier + Laravel Pint
- **Shopify Integration**: Official Shopify API PHP package

## 📁 Project Structure

```
├── app/
│   ├── Http/           # Controllers, Middleware, Requests
│   ├── Models/         # Eloquent Models (User, Shop)
│   ├── Providers/      # Service Providers (including ShopifyServiceProvider)
│   └── Shopify/        # Custom Shopify integration classes
├── config/             # Configuration files (including shopify.php)
├── database/
│   ├── migrations/     # Database migrations
│   ├── factories/      # Model factories
│   └── seeders/        # Database seeders
├── resources/
│   ├── css/           # Stylesheets
│   ├── js/            # React components and TypeScript files
│   └── views/         # Blade templates
├── routes/            # Route definitions
├── tests/
│   ├── Feature/       # Feature tests
│   └── Unit/          # Unit tests
└── public/            # Public assets
```

## 🛠️ Development Setup

### Prerequisites
- PHP 8.3+
- Node.js 22+
- Composer
- npm

### Environment Setup
1. Copy environment file: `cp .env.example .env`
2. Set Shopify environment variables:
   ```
   SHOPIFY_API_KEY=your_api_key
   SHOPIFY_API_SECRET=your_api_secret
   SHOPIFY_API_SCOPES=your_scopes
   SHOPIFY_HOST_NAME=your_host
   ```
3. Generate app key: `php artisan key:generate`
4. Install dependencies:
   ```bash
   composer install
   npm install
   ```

### Development Commands

#### Start Development Server
The PHP development server is managed by the host machine through Laravel Herd.

Front-end assets are arranged by the vite dev server
```bash
npm run dev
```

#### Database
```bash
php artisan migrate              # Run migrations
php artisan migrate:fresh --seed # Fresh migration with seeders
php artisan db:seed             # Run seeders only
```

## 🧪 Testing

### Running Tests
```bash
php artisan test

# Specific test types
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# With coverage
php artisan test --coverage
```

### Test Structure
- **Feature Tests**: End-to-end functionality testing
- **Unit Tests**: Individual component testing
- **Pest PHP**: Modern testing framework with expressive syntax

## 🎨 Frontend Development

### Available Scripts
```bash
npm run dev           # Development server
npm run build         # Production build
npm run build:ssr     # SSR build
npm run lint          # ESLint check and fix
npm run format        # Prettier formatting
npm run format:check  # Check formatting
npm run types         # TypeScript type checking
```

### Component Guidelines
- Use TypeScript for all components
- Follow React 19 best practices
- Utilize Radix UI for accessible components
- Apply Tailwind CSS for styling
- Use Inertia.js for page components

## 🔧 Code Quality

### PHP Standards
- **Laravel Pint**: Automatic code formatting
- **Pest**: Testing framework
- Follow PSR-12 coding standards
- Use type hints and return types

### Frontend Standards
- **ESLint**: Code linting with React rules
- **Prettier**: Code formatting with Tailwind plugin
- **TypeScript**: Strict type checking
- Use functional components with hooks

### Commands
```bash
# PHP formatting
./vendor/bin/pint

# Frontend linting and formatting
npm run lint
npm run format
```

## 🛡️ Best Practices

### Laravel/PHP
- Use service providers for third-party integrations
- Implement proper error handling and logging
- Use Eloquent relationships effectively
- Follow repository pattern for complex queries
- Validate all inputs using Form Requests

### React/Frontend
- Keep components small and focused
- Use custom hooks for shared logic
- Implement proper error boundaries
- Optimize bundle size with code splitting
- Use TypeScript interfaces for props

### Shopify Integration
- This template must be compatible with Shopify CLI
- Store session data properly using SessionStorageDriver
- Handle webhook verification securely
- Implement proper OAuth flow
- Use GraphQL for efficient data fetching
- Follow Shopify's rate limiting guidelines

## 🤝 Contributing

1. Follow the established code style
2. Write tests for new features
3. Update documentation as needed
4. Use meaningful commit messages
5. Create feature branches for new work

---

For questions or issues, refer to the project documentation or reach out to the development team.
