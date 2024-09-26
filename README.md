# PHP-Fast Framework

PHP-Fast is a lightweight and efficient MVC framework designed for rapid web application development with PHP. It offers a clean, customizable structure, providing developers with a powerful foundation for building projects of any scale. The framework adheres to the Model-View-Controller (MVC) pattern, supporting modern features like Controller and Model generation, database synchronization via CLI, Middleware implementation, and flexible Cache management.

This framework includes all the essential functionalities required for web application development while still giving users the flexibility to customize parts of their applications as needed.

## Table of Contents
1. [Introduction](#1-introduction)
    - Overview
    - Features
    - Requirements
2. [Installation](#2-installation)
    - Using Github
    - Manual Installation
3. [Directory Structure](#3-directory-structure)
    - application/
    - public/
    - system/
    - vendor/
    - writeable/
4. [Configuration](#4-configuration)
    - Configuration Files
    - Environment Variables
5. [Command-Line Interface (`php init`)](#5-command-line)
    - [Database Synchronization (`table`)]
    - [Create Controller (`controllers`)]
    - [Create Model (`models`)]
6. [Routing](#6-routing)
    - Defining Routes
    - Dynamic Routing
    - Middleware in Routes
7. [Creating a Controller](#7-creating-a-controller)
8. [Creating a Model](#8-creating-a-model)
9. [Creating Middleware](#9-creating-middleware)
10. [Views and Templates](#10-views-and-templates)
    - Layouts and Components
    - Passing Data to Views
    - Rendering Components
11. [Database Integration](#11-database-integration)
    - Using Models
    - Query Builder
    - Database Drivers
12. [Caching](#12-caching)
    - Using Cache in Controllers
    - Cache Drivers
13. [Error Handling](#13-error-handling)
    - Custom Error Pages
    - Exception Handling
14. [Security](#14-security)
    - Data Sanitization
    - CSRF Protection
15. [Logging and Monitoring](#15-logging-and-monitoring)
    - Logger Usage
    - Performance Monitoring
16. [Testing](#16-testing)
    - Unit Testing
    - Integration Testing
17. [Deployment](#17-deployment)
    - Best Practices
    - Production Configuration
18. [Contributing](#18-contributing)
    - How to Contribute
    - Code of Conduct
19. [License](#19-license)

## 1. Introduction

### Overview
PHP-Fast is built to streamline the development process, providing an intuitive and robust structure. It empowers developers to focus on creating their applications rather than worrying about boilerplate code. PHP-Fast is modular, allowing you to use only the components you need while providing enough flexibility to extend or modify as your application grows.

### Features
- Lightweight and fast MVC framework.
- Built-in CLI tool for generating controllers, models, and synchronizing database tables.
- Flexible routing with support for middleware.
- Comprehensive cache management with multiple drivers.
- Modular structure with a focus on simplicity and extensibility.
- Integrated error handling and logging for streamlined debugging.

### Requirements
- PHP version 7.4 or higher.
- Composer (for managing dependencies).
- A web server (Apache, Nginx, etc.) with support for PHP.

## 2. Installation

You can install PHP-Fast in two ways: using Git to clone the repository or by manually downloading the source files.

### Using Git Clone

To install PHP-Fast using Git, follow these steps:

1. Open your terminal.
2. Run the following command to clone the repository:
    ```bash
    git clone https://github.com/php-fast/php-fast.git
    ```
3. Navigate to the directory of the cloned repository:
    ```bash
    cd php-fast
    ```
4. Install the necessary dependencies using Composer:
    ```bash
    composer install
    ```
5. Set the correct permissions for the `writeable/` directory:
    ```bash
    chmod -R 777 writeable/
    ```
6. Configure your web server to point to the `public/` directory as the root directory of your application.

### Manual Installation

1. Download the latest release from the [PHP-Fast GitHub repository](https://github.com/php-fast/php-fast).
2. Extract the downloaded files into your desired directory.
3. Open a terminal and navigate to the extracted directory:
    ```bash
    cd path/to/php-fast
    ```
4. Install the required dependencies using Composer:
    ```bash
    composer install
    ```
5. Set the correct permissions for the `writeable/` directory:
    ```bash
    chmod -R 777 writeable/
    ```
6. Set up your web server to use the `public/` directory as the document root.

After completing these steps, PHP-Fast is ready for development. You can now configure your application and start building your web project.


## 3. Directory Structure

PHP-Fast follows a well-organized directory structure to keep the application clean and modular. Here's a detailed breakdown of each directory and its purpose:
```php
ROOT
├── application/                  # Application-specific files
│   ├── config/                   # Configuration files
│   │   └── config.php            # Main configuration file
│   ├── controllers/              # Controllers for handling requests
│   │   ├── Api/                  # API-related controllers
│   │   │   └── UsersController.php # Controller for user-related API
│   │   └── HomeController.php    # Main controller for web requests
│   ├── middlewares/              # Custom middleware for request handling
│   │   ├── AuthMiddleware.php    # Handles authentication
│   │   └── PermissionMiddleware.php # Handles user permissions
│   ├── models/                   # Models for database interactions
│   │   └── UsersModel.php        # Model for interacting with the users' table
│   ├── routes/                   # Route definitions
│   │   ├── api.php               # API route definitions
│   │   └── web.php               # Web route definitions
│   └── views/                    # View files (HTML templates)
│       ├── default/              # Default view directory
│       │   ├── component/        # Reusable components (e.g., header, footer)
│       │   │   ├── footer.php    # Footer component
│       │   │   └── header.php    # Header component
│       │   ├── home/             # Views for the HomeController
│       │   │   ├── home.php      # Homepage controller file layout
│       │   ├── 404.php           # Custom 404 error page
│       │   └── themes.php        # Layout file for the application
│
├── public/                       # Publicly accessible directory (document root)
│   ├── .htaccess                 # Apache configuration for URL rewriting
│   └── index.php                 # Entry point for all HTTP requests
│
├── system/                       # Core framework files
│   ├── commands/                 # Command-line tools
│   │   ├── ControllersCommand.php # CLI command to create controllers
│   │   ├── ModelsCommand.php     # CLI command to create models
│   │   └── TableCommand.php      # CLI command to sync database tables
│   ├── core/                     # Core system files of the framework
│   │   ├── AppException.php      # Custom exception handler
│   │   ├── BaseController.php    # Base class for all controllers
│   │   ├── BaseModel.php         # Base class for all models
│   │   ├── Bootstrap.php         # Framework initialization and routing
│   │   ├── Middleware.php        # Base class for middleware
│   │   └── Router.php            # Handles routing and directs requests
│   ├── drivers/                  # Drivers for handling caching and databases
│   │   ├── cache/                # Cache handling
│   │   │   ├── Cache.php         # Base cache class
│   │   │   ├── FilesCache.php    # File-based caching implementation
│   │   │   └── RedisCache.php    # Redis-based caching implementation
│   │   ├── database/             # Database handling
│   │   │   ├── Database.php      # Base database class
│   │   │   ├── MysqlDriver.php   # MySQL-specific database driver
│   │   │   └── PostgresqlDriver.php # PostgreSQL-specific database driver
│   ├── helpers/                  # Helper functions for various tasks
│   │   ├── core_helper.php       # Core helper functions
│   │   ├── security_helper.php   # Security-related helper functions
│   │   └── uri_helper.php        # URL-related helper functions
│   └── libraries/                # Common system libraries
│       ├── Logger.php            # Logging utility
│       ├── Monitor.php           # Performance monitoring utility
│       ├── Render.php            # View rendering and layout handling
│       ├── Security.php          # Security functions
│       └── Session.php           # Session management
│
├── vendor/                       # Composer-installed third-party libraries
│   ├── composer/
│   │   └── autoload.php          # Composer autoloader
│
├── writeable/                    # Writable directory for logs, uploads, etc.
│   ├── logs/
│   │   └── logger.log            # Log file for application logs
│
├── composer.json                 # Composer file for managing dependencies
└── init                          # Command-line interface script
```

This directory structure provides a clear overview of where different types of files and functionalities are located in the PHP-Fast framework.

## 4. Configuration

PHP-Fast uses a simple and flexible configuration system. The main configuration file is located in the `application/config/config.php`. This file contains various settings for your application, including app settings, database, email, caching, and themes.

### Basic Configuration

Here is a breakdown of the key configuration options available in `config.php`:

#### Application Settings
- `debug`: Set to `true` for development, `false` for production.
- `environment`: Specify the application environment (`development`, `production`, etc.).
- `app_url`: The base URL of your application.
- `app_name`: The name of your application.
- `app_timezone`: Set the timezone for your application.

```php
'app' => [
    'debug' => true,
    'environment' => 'development',
    'app_url' => 'https://phpfast.net/code/',
    'app_name' => 'phpfast',
    'app_timezone' => 'UTC'
]
```

#### Security Settings
- `app_id`: A unique identifier for your application.
- `app_secret`: A secret key for securing your application.

#### Database Configuration
- `db_driver`: Database driver to use (mysql, pgsql, etc.).
- `db_host`, `db_port`: Hostname and port for the database server.
- `db_username`, `db_password`: Credentials for connecting to the database.
- `db_database`: The name of the database.
- `db_charset`: Character set for database communication.

#### Cache Settings
- `cache_driver`: Cache driver to use (redis, file, etc.).
- `cache_host`, `cache_port`: Host and port for the cache server.
- `cache_username`, `cache_password`: Credentials for the cache server (if required).
- `cache_database`: Cache database index (used in Redis).

#### Theme Settings
- `theme_path`: Path to the theme directory.
- `theme_name`: Name of the active theme.

### Modifying Configuration
To change these settings, open `application/config/config.php` and update the corresponding values based on your environment and requirements.

## 5. Command-Line

PHP-Fast includes a built-in command-line interface (CLI) to simplify the creation of controllers, models, and database synchronization. The CLI tool allows you to quickly scaffold various components of your application and perform essential tasks without manual coding.

### Usage

To use the command-line interface, open your terminal, navigate to the root directory of your project, and run:

php init <command> <name>

### 1. Database Synchronization (table)
Synchronizes the database table based on the model's schema. This command reads the schema defined in the model's _schema() method and applies the changes to the database.
Command: `php init table <name>`

### 2. Create Controller (controllers)
Generates a new controller file in the application/controllers directory. The command creates a basic controller template, helping you quickly set up new features for your application.
Command: `php init controllers <name>`

### 3. Create Model (models)
Creates a new model file in the application/models directory. The command provides a default model template, including the _schema() method for defining the database table's structure and CRUD functions.
Command: `php init models <name>`

## 6. Routing

PHP-Fast provides a flexible routing system that maps HTTP requests to specific controllers and methods within your application. Routing definitions are located in the `application/routes` directory and are typically separated into files such as `web.php` for web routes and `api.php` for API routes.

### Defining Routes

Routes in PHP-Fast are defined using the `$routes` object in the respective route files. The syntax for defining routes is simple and allows for various HTTP methods such as `GET`, `POST`, `PUT`, `DELETE`, etc.

### Basic Routing in `web.php`

### Supported Parameter Types and Regular Expression Conversion

The `convertToRegex` function in PHP-Fast supports various parameter types in routes, similar to CodeIgniter. These parameters are converted into regular expressions to match segments in the URL. Below are the supported parameter types and their corresponding regex patterns:

- `(:any)`: Matches any characters except for a forward slash (`/`). Converts to `(.+)`.
- `(:segment)`: Matches any segment of the URL, excluding slashes. Converts to `([^/]+)`.
- `(:num)`: Matches only numeric values. Converts to `(\d+)`.
- `(:alpha)`: Matches alphabetic characters (both uppercase and lowercase). Converts to `([a-zA-Z]+)`.
- `(:alphadash)`: Matches alphabetic characters and dashes (`-`). Converts to `([a-zA-Z\-]+)`.
- `(:alphanum)`: Matches alphanumeric characters. Converts to `([a-zA-Z0-9]+)`.
- `(:alphanumdash)`: Matches alphanumeric characters and dashes (`-`). Converts to `([a-zA-Z0-9\-]+)`.

Here is how these parameters can be used in route definitions and how they are processed by the `convertToRegex` function:

### Examples

```php

// Routes with Method: GET/POST/PUT/DELETE
$routes->get('user/(:num)', 'UsersController::view:$1');
$routes->post('user/create', 'UsersController::create');
$routes->put('user/edit/(:num)', 'UsersController::edit:$1');
$routes->delete('user/delete/(:num)', 'UsersController::delete:$1');

// Matches any URL with a single segment (any characters)
$routes->get('blog/(:any)', 'BlogController::show:$1');
// Example URL: blog/my-awesome-post
// Converted to regex: #^blog/(.+)$#

// Matches a URL segment with any characters except slashes
$routes->get('category/(:segment)', 'CategoryController::list:$1');
// Example URL: category/electronics
// Converted to regex: #^category/([^/]+)$#

// Matches a URL segment with Action Function Rounter
$routes->get('news/(:any)', 'CategoryController::$1');
// Example URL: news/index => call to NewsController()->index(); news/home => call to NewsController()->home()

// Matches a numeric segment
$routes->get('product/(:num)', 'ProductController::details:$1');
// Example URL: product/123
// Converted to regex: #^product/(\d+)$#

// Matches a URL segment containing only alphabetic characters
$routes->get('user/(:alpha)', 'UserController::profile:$1');
// Example URL: user/johndoe
// Converted to regex: #^user/([a-zA-Z]+)$#

// Matches a URL segment containing alphabetic characters and dashes
$routes->get('slug/(:alphadash)', 'PageController::show:$1');
// Example URL: slug/welcome-to-phpfast
// Converted to regex: #^slug/([a-zA-Z\-]+)$#

// Matches a URL segment containing alphanumeric characters
$routes->get('code/(:alphanum)', 'CodeController::execute:$1');
// Example URL: code/abc123
// Converted to regex: #^code/([a-zA-Z0-9]+)$#

// Matches a URL segment containing alphanumeric characters and dashes
$routes->get('article/(:alphanumdash)', 'ArticleController::read:$1');
// Example URL: article/phpfast-101
// Converted to regex: #^article/([a-zA-Z0-9\-]+)$#

//Middleware in Routes
You can apply middleware to routes to handle specific logic before a request reaches the controller. Here's an example of applying middleware:

// Applying middleware to a single route
$routes->get('admin', 'AdminController::index', [\App\Middlewares\AuthMiddleware::class]);

// Applying middleware to multiple routes
$routes->group('admin', function($routes) {
    $routes->get('dashboard', 'AdminController::dashboard');
    $routes->post('settings', 'AdminController::saveSettings');
}, [\App\Middlewares\AuthMiddleware::class]);

```

## 7. Creating a Controller

Controllers in PHP-Fast are responsible for handling HTTP requests and returning responses. They act as a bridge between models, views, and other application components. All controllers are stored in the `application/controllers` directory.

### Creating a New Controller

To create a new controller manually, follow these steps:

1. Navigate to the `application/controllers` directory.
2. Create a new file with the name of your controller, e.g., `ProductsController.php`.
3. Define the controller class by extending `System\Core\BaseController`.

Here is a basic example:

```php
<?php

namespace App\Controllers;

use System\Core\BaseController;

class ProductsController extends BaseController
{
    public function index()
    {
        // Code to fetch and display a list of products
        echo "Welcome to the Products Page!";
    }

    public function show($id)
    {
        // Code to fetch and display a single product by ID
        echo "Product ID: " . $id;
    }
}
```

### Using the Command-Line Interface
You can also use the built-in command-line tool to create a new controller:
```bash
php init controllers <controller-name>
```
Example:
php init controllers Welcome

This will create a `ProductsController.php` file in the `application/controllers` directory with a basic structure.

#### Basic Structure of a Controller
A controller in PHP-Fast typically consists of several methods, each corresponding to a specific action or HTTP request (e.g., viewing a list, creating a new item, updating, or deleting). Here's an example structure:

```php
<?php

namespace App\Controllers;

use System\Core\BaseController;

class UsersController extends BaseController
{
    public function index()
    {
        // This method handles displaying the list of users
    }

    public function create()
    {
        // This method handles displaying a form for creating a new user
    }

    public function store()
    {
        // This method handles storing the new user data
    }

    public function edit($id)
    {
        // This method handles displaying a form for editing an existing user
    }

    public function update($id)
    {
        // This method handles updating an existing user
    }

    public function delete($id)
    {
        // This method handles deleting a user
    }
}
```

#### Routing to a Controller
To route HTTP requests to a controller, define your routes in application/routes/web.php or application/routes/api.php. Here is an example:

```php
$routes->get('products', 'ProductsController::index');
$routes->get('products/(:num)', 'ProductsController::show:$1');
```

In the above example:
```php
ProductsController::index is called when the /products URL is accessed.
ProductsController::show:$1 is called when /products/{id} is accessed, where {id} is a dynamic parameter.
```

### Using Middleware in a Controller
Controllers can also use middleware to handle tasks like authentication and permission checks. Here's how to apply middleware in a controller:
```php
$routes->get('admin/products', 'ProductsController::index', [\App\Middlewares\AuthMiddleware::class]);
```

### Accessing Models in a Controller
Controllers can access models to interact with the database. Here's an example of loading a model and using it in a controller:

```php
<?php

namespace App\Controllers;

use System\Core\BaseController;
use App\Models\ProductsModel;

class ProductsController extends BaseController
{
    protected $productsModel;

    public function __construct()
    {
        $this->productsModel = new ProductsModel();
    }

    public function index()
    {
        $products = $this->productsModel->getAllProducts();
        // Pass the products to a view
        $this->render('products/index', ['products' => $products]);
    }
}
```

### Render Views & Assest Data to Views
```php
$this->data('title', 'Đây Là Trang Chủ');
$this->data('users', $users['data']);
$header = Render::component('component/header', ['title' => $this->data('title')]);
$footer = Render::component('component/footer');
$this->data('header', $header);
$this->data('footer', $footer);
echo $this->render('themes', 'home/home');
```

## 8. Creating a Model

Models in PHP-Fast are responsible for interacting with the database. They contain methods for querying, inserting, updating, and deleting data in the database. PHP-Fast provides a base model (`BaseModel`) that your models can extend to use common database operations easily.

### Using Command to Create Models

To quickly generate a new model, you can use the command-line tool:

```bash
php init models <model-name>

This command will create a new model file in the application/models directory.
```bash
php init models users
```

### Example of a Model

Below is an example of a model in PHP-Fast. This model (UsersModel) defines a table schema and includes basic CRUD (Create, Read, Update, Delete) operations.

```php
<?php
namespace App\Models;
use System\Core\BaseModel;

class UsersModel extends BaseModel {

    protected $table = 'users';

    // Columns that are allowed to be added or updated
    protected $fillable = ['name', 'email', 'password', 'age'];

    // Columns that are protected and not allowed to be updated
    protected $guarded = ['id', 'created_at'];

    /**
     * Define the table schema using the schema builder
     * 
     * @return array Table schema
     */
    public function _schema() {
        return [
            'id' => [
                'type' => 'int unsigned',
                'auto_increment' => true,
                'key' => 'primary',
                'null' => false
            ],
            'name' => [
                'type' => 'varchar(150)',
                'key' => 'unique',
                'null' => false,
                'default' => ''
            ],
            'email' => [
                'type' => 'varchar(150)',
                'key'   =>  'unique',
                'null' => false,
                'default' => ''
            ],
            'password' => [
                'type' => 'varchar(100)',
                'null' => true,
                'default' => '1234567890123456789012345678932'
            ],
            'age' => [
                'type' => 'int',
                'key'   =>  'unique',
                'unsigned' => true,
                'null' => true,
                'default' => '18'
            ],
            'created_at' => [
                'type' => 'timestamp',
                'null' => true,
                'default' => '2020-01-01 01:01:01',
                'on_update' => 'CURRENT_TIMESTAMP'
            ],
            'updated_at' => [
                'type' => 'timestamp',
                'null' => true,
                'default' => '2020-01-01 01:01:01',
                'on_update' => 'CURRENT_TIMESTAMP'
            ]
        ];
    }

    /**
     * Get all users
     * 
     * @param string|null $where Optional query condition
     * @param array $params Array of values for the condition
     * @param string|null $orderBy Column to sort by
     * @param int|null $limit Limit the number of results
     * @param int|null $offset Offset for the results
     * @return array List of users
     */
    public function getUsers($where = '', $params = [], $orderBy = 'id DESC', $limit = null, $offset = null) {
        return $this->list($this->table, $where, $params, $orderBy, $limit, $offset);
    }
}
```

### Synchronizing Model into Database
After creating or modifying a model's schema, you can use the following command to synchronize the model's schema with the database:

```bash
php init table <model-name>
```

This command reads the schema defined in the model's _schema() method and synchronizes it with the database. Example:
```bash
php init table users
```

This will use the schema defined in UsersModel to create or update the users table in the database.

### Important Notes
The fillable property defines which columns can be mass-assigned, while the guarded property lists columns that should not be modified directly.
The _schema() method in the model defines the structure of the table and is used for database synchronization.
Use the built-in methods in BaseModel (e.g., list, row, add, set, del) to simplify database operations in your models.

## 9. Creating Middleware

Middleware in PHP-Fast allows you to filter HTTP requests entering your application. This can be useful for tasks such as user authentication, input validation, and permission checks before the request reaches the controller.

### Creating a Middleware

To create a new middleware, follow these steps:

1. Navigate to the `application/middlewares` directory.
2. Create a new file, for example, `AuthMiddleware.php`.
3. Define your middleware logic in the new file. Here's an example of a basic authentication middleware:

```php
<?php

namespace App\Middlewares;

class AuthMiddleware {
    public function handle($request, $next) {
        // Authentication logic
        if (!isset($_SESSION['user'])) {
            echo "Unauthorized access!";
            exit;
        }
        return $next($request);
    }
}
```

## 9. Creating Middleware

Middleware in PHP-Fast provides a convenient mechanism for filtering HTTP requests entering your application. You can use middleware for various tasks, such as verifying if a user is authenticated, logging requests, or managing permissions. This section will guide you through the creation and usage of middleware in PHP-Fast.

### Adding Middleware

All middleware classes should be placed in the `application/middlewares` directory. A middleware class contains a `handle` method, which will be executed when the middleware is applied to a route or controller.

### Example: Creating an Authentication Middleware

Let's create a simple `AuthMiddleware` that checks if a user is logged in before allowing access to certain routes.

1. Navigate to `application/middlewares/` and create a new file named `AuthMiddleware.php`.

2. Add the following code to `AuthMiddleware.php`:

    ```php
    <?php
    namespace App\Middlewares;

    class AuthMiddleware {
        public function handle($request, $next) {
            // Authentication logic
            if (!isset($_SESSION['user'])) {
                echo "Unauthorized access!";
                exit;
            }
            return $next($request);
        }
    }
    ```

### Applying Middleware to Routes

To apply middleware to a route, pass the middleware class name as an array in the route definition within `application/routes/web.php` or `application/routes/api.php`.

Example: Applying `AuthMiddleware` to a route in `web.php`:

    ```php
    $routes->get('admin', 'AdminController::index', [\App\Middlewares\AuthMiddleware::class]);
    ```

In this example, when the user accesses the `admin` route, the `AuthMiddleware`'s `handle` method is executed before the `AdminController`'s `index` method.

### Creating a Permission Middleware

Similarly, you can create a `PermissionMiddleware` to manage access control for different parts of your application.

1. Create a new file in `application/middlewares/` named `PermissionMiddleware.php`.

2. Add the following code:

    ```php
    <?php
    namespace App\Middlewares;

    class PermissionMiddleware {
        public function handle($request, $next, $permissions = []) {
            // Check if the user has the required permissions
            $userPermissions = $_SESSION['user_permissions'] ?? [];

            foreach ($permissions as $permission) {
                if (!in_array($permission, $userPermissions)) {
                    echo "Access denied!";
                    exit;
                }
            }

            return $next($request);
        }
    }
    ```

3. Apply this middleware to a route and pass the necessary permissions:

    ```php
    $routes->get('admin/settings', 'AdminController::settings', [
        [\App\Middlewares\PermissionMiddleware::class, ['manage_settings']]
    ]);
    ```

### Using Middleware in Controllers

You can also use middleware in controllers to filter access to specific methods.

1. In your controller (e.g., `AdminController.php`), call the middleware within the method:

    ```php
    namespace App\Controllers;

    use System\Core\BaseController;
    use App\Middlewares\AuthMiddleware;

    class AdminController extends BaseController {
        public function index() {
            // Call the middleware
            (new AuthMiddleware())->handle(request(), function() {
                // Code for the index method
                echo "Welcome to the Admin Dashboard!";
            });
        }
    }
    ```

### Conclusion

Middleware provides a clean and reusable way to handle common tasks, such as authentication and permission checks, in your application. By creating and applying middleware to routes or within controllers, you can enforce consistent behavior and security across your web application.

## 10. Views and Templates

PHP-Fast provides a flexible view rendering system to help you create dynamic web pages. The views are stored in the `application/views/` directory and support layouts, components, and data passing.

### Directory Structure

By default, the views are organized as follows:

```php
application/ 
── views/ 
──────default/ 
────────admin/ 
────────component/ 
────────────footer.php 
────────────header.php
────────home/ 
────────────add_user.php 
────────────edit_user.php 
────────────home.php 
────────404.php
────────themes.php
```


### Creating a View

1. Navigate to the `application/views/` directory.
2. Create a new `.php` file in the desired directory (e.g., `home/home.php`).
3. Add your HTML and PHP content to the file:
    ```php
    <h1>Welcome to PHP-Fast</h1>
    <p>This is the home page.</p>
    ```

### Using Layouts

A layout is a common template file (e.g., `header`, `footer`) used to wrap around the main content of your pages. You can store layouts in the `component/` directory. 

- Example `header.php` (located at `application/views/default/component/header.php`):
    ```php
    <!DOCTYPE html>
    <html>
    <head>
        <title>PHP-Fast - <?= $pageTitle ?? 'Home' ?></title>
    </head>
    <body>
    <header>
        <h1>Header Component</h1>
    </header>
    ```

- Example `footer.php` (located at `application/views/default/component/footer.php`):
    ```php
    <footer>
        <p>&copy; 2024 PHP-Fast</p>
    </footer>
    </body>
    </html>
    ```

### Passing Data to Views

You can pass data from a controller to a view using the `Render` library. Use the `setData()` method to set the data and the `render()` method to render the view.

- Example Controller:
    ```php
    <?php

    namespace App\Controllers;

    use System\Core\BaseController;

    class HomeController extends BaseController {
        public function index() {
            $data = [
                'pageTitle' => 'Welcome to PHP-Fast',
                'message' => 'This is the home page.'
            ];
            
            // Set data and render view
            $this->setData($data);
            $this->render('home/home');
        }
    }
    ```

- Example View (`home/home.php`):
    ```php
    <h1><?= $pageTitle ?></h1>
    <p><?= $message ?></p>
    ```

### Rendering Components

Components are reusable parts of the view, like headers, footers, and sidebars. Use the `Render` library to include components in your views.

- Example (`home/home.php`):
    ```php
    <?php $this->render('component/header'); ?>
    
    <h1><?= $pageTitle ?></h1>
    <p><?= $message ?></p>
    
    <?php $this->render('component/footer'); ?>
    ```

### Example: Full Page Rendering

Here’s an example of a full page rendering using the `Render` library in a controller:

- Controller (`HomeController.php`):
    ```php
    <?php

    namespace App\Controllers;

    use System\Core\BaseController;

    class HomeController extends BaseController {
        public function index() {
            $data = [
                'pageTitle' => 'Welcome to PHP-Fast',
                'message' => 'This is the home page.'
            ];
            
            // Set data and render the full page with layout components
            $this->setData($data);
            $this->render('component/header');
            $this->render('home/home');
            $this->render('component/footer');
        }
    }
    ```

### Error Pages

Custom error pages can be created and placed in the `application/views/default/` directory. For example, a 404 error page can be defined in `404.php`.

- Example `404.php`:
    ```php
    <h1>404 - Page Not Found</h1>
    <p>The page you are looking for does not exist.</p>
    ```

You can then handle errors in your controller and render the error page when necessary:

- Example:
    ```php
    if (!$pageFound) {
        $this->render('404');
    }
    ```

### Conclusion

The view system in PHP-Fast allows you to build complex pages with ease. You can create layouts, include components, and pass data from controllers to views. This approach helps maintain a clean and modular codebase, making it easier to manage and extend your application.


## 11. Database Integration

PHP-Fast provides built-in support for integrating with databases. It includes a Database class and drivers to help you interact with your database using models and a query builder. The default configuration for the database is set in the `application/config/config.php` file, allowing you to easily manage different database connections.

### Using Models

Models are classes that allow you to interact with your database. Each model represents a table in your database and contains methods to query and manipulate data. By default, models are located in the `application/models` directory.

#### Creating a Model

You can create a new model manually or use the command-line tool to generate it:

**Manually:**
1. Navigate to `application/models`.
2. Create a new file, e.g., `UsersModel.php`.
3. Define the model class:

```php
<?php
namespace App\Models;

use System\Core\BaseModel;

class UsersModel extends BaseModel {
    protected $table = 'users';
    protected $fillable = ['username', 'email'];
    protected $guarded = ['id', 'created_at'];

    public function _schema() {
        return [
            'id' => ['type' => 'int unsigned', 'auto_increment' => true, 'key' => 'primary', 'null' => false],
            'username' => ['type' => 'varchar(100)', 'null' => false],
            'email' => ['type' => 'varchar(150)', 'null' => false]
        ];
    }

    // Additional methods for custom queries
}
```

#### Interacting with the Database

After creating your model, you can use it in your controllers to interact with the database.

**Example: Fetching all users:**

```php
<?php
use App\Models\UsersModel;

class UsersController extends BaseController {
    public function index() {
        $usersModel = new UsersModel();
        $users = $usersModel->getAll(); // Fetch all users
        $this->render('users/index', ['users' => $users]);
    }
}
```

### Query Builder

PHP-Fast includes a basic query builder to construct SQL queries programmatically. The query builder provides a fluent interface to perform database operations.

**Example: Basic Select Query:**

```php
$usersModel = new UsersModel();
$users = $usersModel->select('id, username')
                    ->where('status', 'active')
                    ->orderBy('created_at', 'DESC')
                    ->get();
```

**Example: Inserting Data:**

```php
$usersModel = new UsersModel();
$data = [
    'username' => 'john_doe',
    'email' => 'john@example.com'
];
$usersModel->insert($data);
```

### Database Drivers

PHP-Fast supports multiple database drivers. The available drivers are set up in the `system/drivers/database` directory. By default, the framework supports `MysqlDriver` and `PostgresqlDriver`.

#### Switching Database Drivers

To change the database driver, update the `db_driver` setting in `application/config/config.php`:

```php
'db' => [
    'db_driver' => 'postgresql', // Change to 'mysql' or 'postgresql'
    'db_host' => '127.0.0.1',
    'db_port' => 5432,
    'db_username' => 'postgres',
    'db_password' => '',
    'db_database' => 'phpfast',
    'db_charset'  => 'utf8'
],
```

The framework will automatically use the appropriate driver based on the configuration.

### Custom Queries

While the query builder is flexible for common use cases, you may need to run custom SQL queries in some scenarios. The model provides a method to execute raw queries:

**Example: Running a Raw Query:**

```php
$usersModel = new UsersModel();
$query = "SELECT * FROM users WHERE status = :status";
$params = ['status' => 'active'];
$activeUsers = $usersModel->query($query, $params);
```

### Schema Management

The `_schema` method in your model defines the structure of the table associated with the model. You can use the command-line interface (`php init table <name>`) to synchronize your database tables with the defined schema.

**Example: Synchronizing a Table:**

Run the following command in your terminal to synchronize the table schema for the `UsersModel`:

```bash
php init table users
```

This command will use the `_schema` method in `UsersModel` to create or update the `users` table in your database.

### Notes
- Always define the `$table` property in your model to specify which table the model interacts with.
- Use `$fillable` to list the columns that can be mass-assigned during insert or update operations.
- Use `$guarded` to list the columns that should not be mass-assigned.

With these tools and methods, you can efficiently integrate your PHP-Fast application with various databases and perform robust data operations.


## 12. Caching

PHP-Fast offers a flexible caching mechanism that allows you to store and retrieve data efficiently. The framework includes a `RedisCache` class for caching, which provides methods like `set()`, `get()`, and `delete()` to interact with the Redis server. Caching can help improve performance, especially when dealing with data that doesn't change frequently.

### Basic Usage

To utilize caching in your controllers, use the `RedisCache` class provided by the framework. The cache configuration is defined in `application/config/config.php`.

#### Example: Using Caching in `HomeController`

Here’s how you can use caching in the `HomeController`. Uncomment the caching-related lines to enable caching functionality:

```php
<?php
namespace App\Controllers;

use System\Core\BaseController;
use System\Libraries\Render;
use App\Models\UsersModel;
use System\Drivers\Cache\RedisCache;

class HomeController extends BaseController {

    protected $usersModel;
    protected $cache;

    public function __construct() {
        $config = config('cache'); // Get cache configuration from config.php
        $this->cache = new RedisCache($config);
        $this->usersModel = new UsersModel(); // Initialize Users model
    }

    /**
     * Home page, displays a list of users
     */
    public function index() {
        $cacheKey = 'home_page';

        // Check if cache exists
        $cacheContent = $this->cache->get($cacheKey);
        if ($cacheContent) {
            echo $cacheContent;
            echo 'Loaded from cache.<br />';
            return;
        }

        // Fetch user list if not cached
        $users = $this->usersModel->getUsersPaging(10, 1); // Get 10 users, page 1

        // Set data for the view
        $this->data('title', 'This is the Home Page');
        $this->data('users', $users['data']);

        // Render individual components
        $header = Render::component('component/header', ['title' => $this->data('title')]);
        $footer = Render::component('component/footer');

        // Set data for main layout
        $this->data('header', $header);
        $this->data('footer', $footer);

        // Render layout and view
        $content = $this->render('themes', 'home/home');

        // Store the rendered content in cache
        $this->cache->set($cacheKey, $content, 600); // Cache for 10 minutes (600 seconds)

        // Display the content
        echo $content;
    }
}
```

### Steps to Enable Caching in Your Application

1. **Configure Cache**: Set up your cache configuration in `application/config/config.php`:
    ```php
    'cache' => [
        'cache_driver' => 'redis',
        'cache_host' => '127.0.0.1',
        'cache_port' => 6379,
        'cache_username' => '',
        'cache_password' => '',
        'cache_database' => 0,
    ],
    ```

2. **Initialize Cache in Controller**: In your controller, initialize the `RedisCache` class with the cache configuration.

3. **Set and Retrieve Cache**:
    - Use `$this->cache->set($key, $value, $ttl)` to store data in the cache.
    - Use `$this->cache->get($key)` to retrieve data from the cache.

4. **Clear Cache**: You can delete specific cache entries using `$this->cache->delete($key)` or clear the entire cache with `$this->cache->clear()`.

### Notes
- Caching is particularly useful for content that doesn't change frequently, like homepage data or user lists.
- Always set an appropriate expiration time for cached data to prevent stale content.
- Modify the cache implementation as needed to suit your application's requirements.

By leveraging the caching capabilities provided by PHP-Fast, you can improve the performance and scalability of your web applications.


## 13. Error Handling

Error handling in PHP-Fast is managed through the `AppException` class located in the `system/core/AppException.php` file. This class extends the built-in PHP `Exception` class and provides mechanisms for logging errors, rendering error pages, and displaying error details based on the application's debug mode.

### AppException Overview

The `AppException` class is responsible for handling exceptions that occur in the application. It includes the following features:

- Customizable error messages.
- Logging of error details using the `Logger` library.
- Displaying error information to the user.
- Rendering specific error pages based on the status code (e.g., 404 Not Found).

### Handling Errors

To handle errors using `AppException`, you can throw an exception in your application as follows:

```php
throw new \System\Core\AppException('An error occurred!', 0, null, 500);
```

After throwing an exception, use the `handle()` method to process it:

```php
try {
    // Code that may throw an exception
} catch (\System\Core\AppException $e) {
    $e->handle();
}
```

### Custom Error Pages

The `AppException` class has built-in support for rendering custom error pages based on the status code. For a `404` error, it will call the `render404()` method, which attempts to load the `404` view from the themes directory using the `Render` library.

### Logging Errors

Errors are logged using the `Logger` class. When an exception is handled, the `handle()` method automatically calls `Logger::error()` to record the error message, file, and line number.

### Debug Mode

- When the application is in **debug mode** (`config('app')['debug']` is `true`), detailed error information, including the message, file, line number, and stack trace, is displayed to help with debugging.
- When **debug mode** is disabled, a generic error message is shown to the user, preventing sensitive information from being exposed.

### Conclusion

The `AppException` class in PHP-Fast provides a flexible and robust mechanism for handling exceptions and errors. By utilizing built-in logging and rendering mechanisms, developers can quickly diagnose issues while maintaining a user-friendly experience for application end-users.

### Example Usage in a Controller

Here's an example of how to use `AppException` in a controller to handle errors:

```php
<?php
namespace App\Controllers;

use System\Core\BaseController;
use System\Core\AppException;

class UserController extends BaseController {

    public function index() {
        try {
            // Simulate an error (e.g., user not found)
            $user = $this->findUserById(1);
            if (!$user) {
                throw new AppException('User not found!', 0, null, 404);
            }

            // Render the user data
            $this->render('user/profile', ['user' => $user]);

        } catch (AppException $e) {
            // Handle the exception
            $e->handle();
        }
    }

    private function findUserById($id) {
        // Sample method to simulate user fetching; returns null to simulate "user not found"
        return null;
    }
}
```

### Explanation

1. **Throwing an Exception:**  
   In the `index()` method, we simulate a user-fetching process using the `findUserById()` method. If the user is not found (returns `null`), an `AppException` is thrown with a custom error message and a `404` status code.

2. **Handling the Exception:**  
   The exception is caught in the `catch` block, where the `handle()` method of the `AppException` class is called. This method logs the error and renders the appropriate error page based on the application's debug mode.

This approach ensures that errors are handled gracefully, logging the issue while providing feedback to the user without exposing sensitive information.


## 14. Security

Security is a crucial aspect of any web application. PHP-Fast provides various built-in mechanisms to help you secure your application against common security threats. This section will guide you through the available security features and how to use them effectively.

### Data Sanitization

Data sanitization is a process of cleaning input data to prevent malicious code, such as cross-site scripting (XSS) or SQL injection, from being executed in your application. PHP-Fast includes a helper to sanitize data in HTTP requests.

#### Using `Security.php` Libraries

The `security_helper.php` provides functions to clean and validate user input data. Here is how you can use it:
xss_clean, clean_input, uri_security, url_slug, redirect, base_url
1. Load the helper in your controller:
    ```php

    // Sanitize user input
    $clean_input = clean_input($input_data);
    ```

2. The clean_input function will automatically strip out potentially harmful code from the input data, making it safer to use within your application.

### Cross-Site Request Forgery (CSRF) Protection

PHP-Fast has built-in support for CSRF protection, helping to prevent unauthorized commands from being transmitted via your authenticated sessions. The framework can generate and verify CSRF tokens for forms.

#### Enabling CSRF Protection

1. Open the `config.php` file in the `application/config` directory.
2. Add or update the `security` configuration to include CSRF settings:
    ```php
    'security' => [
        'csrf_protection' => true,
        'csrf_token_name' => 'csrf_token',
        'csrf_header_name' => 'X-CSRF-TOKEN',
        'csrf_expiration' => 7200, // Token expiration in seconds
    ],
    ```


### Password Hashing

PHP-Fast recommends using PHP's built-in `Security::hashPassword` and `Security::verifyPassword` functions for securely hashing and verifying passwords. This helps to store user passwords securely in the database.

#### Example of Password Hashing
use System\Libraries\Security;
1. To hash a password before saving it to the database:
    ```php
    $hashed_password = Security::hashPassword($user_password, PASSWORD_DEFAULT);
    ```

2. To verify a password during login:
    ```php
    if (Security::verifyPassword($input_password, $hashed_password_from_db)) {
        // Password is correct
    } else {
        // Invalid password
    }
    ```

### Additional Security Tips

- **Always sanitize user input**: Clean all input data using the available helper functions to prevent XSS and SQL injection attacks.
- **Use HTTPS**: Ensure your application runs over HTTPS to protect data in transit.
- **Set secure cookie flags**: Use the `HttpOnly` and `Secure` flags for cookies to prevent unauthorized access.
- **Limit file uploads**: Validate file uploads to prevent malicious files from being uploaded to your server.
- **Update your framework**: Regularly update PHP-Fast to the latest version to apply security patches.

By following these security guidelines and using the built-in features provided by PHP-Fast, you can help secure your web application against many common threats.


## 15. Logging and Monitoring

Effective logging and performance monitoring are crucial aspects of any web application. PHP-Fast provides a built-in `Logger` class for writing log messages and a `Monitor` class for measuring execution time, memory usage, and CPU load during requests.

### Logging

The `Logger` library allows you to log information, warnings, and errors into a specified log file. Logs are saved in the `writeable/logs/logger.log` file.

### Using the Logger

- **Info Log**: 
    ```php
    Logger::info('This is an informational message.');
    ```

- **Warning Log**:
    ```php
    Logger::warning('This is a warning message.');
    ```

- **Error Log**:
    ```php
    Logger::error('This is an error message.');
    ```

The `Logger` class also supports optional parameters for file name and line number, which can be used for more precise debugging.

### Monitoring

The `Monitor` library in PHP-Fast provides utilities for measuring the execution time, memory usage, and CPU load of a request from the moment the framework initializes.

### Using the Monitor

- **End Framework Monitoring**:
    ```php
    $metrics = Monitor::endFramework();
    echo 'Execution Time: ' . $metrics['execution_time'] . ' seconds';
    echo 'Memory Used: ' . Monitor::formatMemorySize($metrics['memory_used']);
    echo 'CPU Usage: ' . $metrics['cpu_usage'];
    ```

The `Monitor::endFramework()` method returns an array containing the execution time, memory used, and CPU load for the current request. You can use this data for performance monitoring and optimization.

### Conclusion

The `Logger` and `Monitor` libraries in PHP-Fast provide essential tools for logging and performance monitoring, helping developers keep track of application behavior, troubleshoot issues, and optimize performance.

## 16. Testing

PHP-Fast provides a simple way to test different components of your application. Testing ensures that your application behaves as expected and helps catch potential bugs before deployment. This section covers basic unit and integration testing.

### 16.1 Unit Testing

Unit testing is the practice of testing individual units of code, such as functions or classes, to verify that they work as intended. With PHP-Fast, you can use PHPUnit, a popular testing framework for PHP.

#### Setting Up PHPUnit

1. First, install PHPUnit using Composer:
    ```bash
    composer require --dev phpunit/phpunit
    ```

2. After installation, you can run PHPUnit with:
    ```bash
    ./vendor/bin/phpunit
    ```

#### Writing Unit Tests

Create a directory called `tests` in the root of your project if it does not already exist. Inside the `tests` directory, you can organize your test files. Here is an example of a simple unit test for a model:

1. Create a test file inside the `tests` directory, e.g., `tests/Models/UsersModelTest.php`.
2. Add the following code to the test file:

    ```php
    <?php

    use PHPUnit\Framework\TestCase;
    use App\Models\UsersModel;

    class UsersModelTest extends TestCase
    {
        protected $model;

        protected function setUp(): void
        {
            // Initialize the model before each test
            $this->model = new UsersModel();
        }

        public function testAddUser()
        {
            $data = [
                'username' => 'testuser',
                'email' => 'testuser@example.com',
            ];
            
            $result = $this->model->addUser($data);

            // Assert that the result is true (user added successfully)
            $this->assertTrue($result);
        }

        protected function tearDown(): void
        {
            // Clean up after each test
            $this->model = null;
        }
    }
    ```

#### Running Unit Tests

To run the unit tests, execute the following command in the terminal:
    
    ```bash
    ./vendor/bin/phpunit tests
    ```

This command will execute all test files located in the `tests` directory. You can also specify a single test file to run:
    
    ```bash
    ./vendor/bin/phpunit tests/Models/UsersModelTest.php
    ```

### 16.2 Integration Testing

Integration testing involves testing the interaction between different components of the application, such as models and controllers. With PHP-Fast, you can create integration tests to verify that various parts of your application work together seamlessly.

#### Writing Integration Tests

Here’s an example of an integration test for a controller method that uses a model:

1. Create a new test file, e.g., `tests/Controllers/UsersControllerTest.php`.
2. Add the following code to the file:

    ```php
    <?php

    use PHPUnit\Framework\TestCase;
    use App\Controllers\UsersController;

    class UsersControllerTest extends TestCase
    {
        protected $controller;

        protected function setUp(): void
        {
            // Initialize the controller before each test
            $this->controller = new UsersController();
        }

        public function testIndex()
        {
            // Simulate a request to the index method
            $response = $this->controller->index();

            // Assert that the response is not empty
            $this->assertNotEmpty($response);

            // Optionally, you can further assert the expected output or status code
            $this->assertStringContainsString('Users List', $response);
        }

        protected function tearDown(): void
        {
            // Clean up after each test
            $this->controller = null;
        }
    }
    ```

#### Running Integration Tests

Run the integration tests using the same PHPUnit command:

    ```bash
    ./vendor/bin/phpunit tests
    ```

### 16.3 Testing Best Practices

- **Set up a dedicated testing database**: To prevent tests from modifying production data, use a separate database for testing.
- **Isolate tests**: Each test should be independent of others. Use the `setUp` and `tearDown` methods to initialize and clean up resources.
- **Mock dependencies**: Use mocks and stubs for external services or dependencies that are not the focus of the test. PHPUnit provides built-in methods to create mock objects.
- **Automate testing**: Incorporate your tests into a continuous integration (CI) pipeline to ensure that every code change is automatically tested.

By implementing unit and integration tests in your PHP-Fast application, you can enhance the reliability and maintainability of your codebase.


## 17. Deployment

Deploying your PHP-Fast application to a production environment involves several steps to ensure that your application runs smoothly and securely. This section covers best practices and configurations for deploying your application.

### Best Practices

1. **Set Environment to Production**
    - In `application/config/config.php`, set the `environment` key to `production`. This disables debugging and activates production-specific configurations.
    ```php
    'app' => [
        'debug' => false,
        'environment' => 'production',
        'app_url' => 'https://your-production-url.com',
        'app_name' => 'phpfast',
        'app_timezone' => 'UTC'
    ],
    ```

2. **Hide Error Messages**
    - Make sure to hide error messages on your live site to prevent exposing sensitive information. Set the `debug` option to `false` in `config.php`.

3. **Use HTTPS**
    - Make sure your application is accessible over HTTPS. This can be configured at the server level (Apache, Nginx) and in your `app_url` configuration.

4. **Database Security**
    - Use strong passwords for database access.
    - Restrict database access to only necessary IP addresses.

5. **File Permissions**
    - Ensure the correct file permissions for security. The `writeable/` directory should be writable by the web server:
    ```bash
    chmod -R 755 writeable/
    ```
    - Ensure other files are set to read-only (`644`) to prevent unauthorized modifications.

6. **Environment Variables**
    - Use environment variables to store sensitive data such as database credentials, cache settings, etc. This helps to keep them out of version control.

### Production Configuration

Here are some key points to configure your application for production:

#### 1. Web Server Configuration

- **Apache**: Set up a virtual host for your application, pointing the `DocumentRoot` to the `public/` directory.
    ```apache
    <VirtualHost *:80>
        ServerName phpfast.net
        DocumentRoot /home/phpfast.net/public_html/public

        <Directory /home/phpfast.net/public_html/public>
            AllowOverride All
            Require all granted
        </Directory>

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined
    </VirtualHost>
    ```

.htaccess
	```apache
	RewriteEngine On
	RewriteCond %{REQUEST_FILENAME} !-f
	RewriteCond %{REQUEST_FILENAME} !-d
	RewriteRule ^(.*)$ index.php/$1 [L]
	```

- **Nginx**: Set up a server block for your application, pointing `root` to the `public/` directory.
    ```nginx
    server {
        listen 80;
        server_name phpfast.net;
        root /home/phpfast.net/public_html/public;

        index index.php index.html index.htm;

        location / {
            try_files $uri $uri/ /index.php?$query_string;
        }

        location ~ \.php$ {
            include snippets/fastcgi-php.conf;
            fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            include fastcgi_params;
        }

        location ~ /\.ht {
            deny all;
        }
    }
    ```

- **Nginx**: Or you can upload all script into /home/phpfast.net/ and public into `public_html` directory. And change root into this:
    ```nginx
    root /home/phpfast.net/public_html;
    ```


#### 2. Optimizing Performance

- **Enable Caching**: Make sure to use a cache driver (e.g., Redis) to speed up your application. In `config.php`, set the `cache_driver` to `redis` or other caching methods:
    ```php
    'cache' => [
        'cache_driver' => 'redis',
        'cache_host' => '127.0.0.1',
        'cache_port' => 6379,
        'cache_database' => 0,
    ],
    ```

- **Use a PHP Accelerator**: Install and enable `Opcache` on your production server to cache the compiled PHP code and improve performance.

- **Minify Assets**: Minify your CSS, JavaScript, and HTML files to reduce page load times.

- **Optimize Database**: Use indexes, optimize queries, and configure your database for production use.

#### 3. Logging and Monitoring

- Make sure the logs are being written to the `writeable/logs` directory. Adjust the logging level to `ERROR` in production to avoid excessive log output.

- Set up server monitoring to keep an eye on the performance and health of your application.

### Conclusion

Deploying PHP-Fast requires some configuration and security practices to ensure your application runs smoothly in a production environment. Follow the best practices outlined here, configure your web server appropriately, and make use of environment variables to keep your application secure.
