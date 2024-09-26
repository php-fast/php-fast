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
8. [Creating a Model](#creating-a-model)
9. [Creating Middleware](#creating-middleware)
10. [Views and Templates](#views-and-templates)
    - Layouts and Components
    - Passing Data to Views
    - Rendering Components
11. [Database Integration](#database-integration)
    - Using Models
    - Query Builder
    - Database Drivers
12. [Caching](#caching)
    - Using Cache in Controllers
    - Cache Drivers
13. [Error Handling](#error-handling)
    - Custom Error Pages
    - Exception Handling
14. [Security](#security)
    - Data Sanitization
    - CSRF Protection
15. [Logging and Monitoring](#logging-and-monitoring)
    - Logger Usage
    - Performance Monitoring
16. [Testing](#testing)
    - Unit Testing
    - Integration Testing
17. [Deployment](#deployment)
    - Best Practices
    - Production Configuration
18. [Contributing](#contributing)
    - How to Contribute
    - Code of Conduct
19. [License](#license)

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
    $$$php
    <h1>Welcome to PHP-Fast</h1>
    <p>This is the home page.</p>
    $$$

### Using Layouts

A layout is a common template file (e.g., `header`, `footer`) used to wrap around the main content of your pages. You can store layouts in the `component/` directory. 

- Example `header.php` (located at `application/views/default/component/header.php`):
    $$$php
    <!DOCTYPE html>
    <html>
    <head>
        <title>PHP-Fast - <?= $pageTitle ?? 'Home' ?></title>
    </head>
    <body>
    <header>
        <h1>Header Component</h1>
    </header>
    $$$

- Example `footer.php` (located at `application/views/default/component/footer.php`):
    $$$php
    <footer>
        <p>&copy; 2024 PHP-Fast</p>
    </footer>
    </body>
    </html>
    $$$

### Passing Data to Views

You can pass data from a controller to a view using the `Render` library. Use the `setData()` method to set the data and the `render()` method to render the view.

- Example Controller:
    $$$php
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
    $$$

- Example View (`home/home.php`):
    $$$php
    <h1><?= $pageTitle ?></h1>
    <p><?= $message ?></p>
    $$$

### Rendering Components

Components are reusable parts of the view, like headers, footers, and sidebars. Use the `Render` library to include components in your views.

- Example (`home/home.php`):
    $$$php
    <?php $this->render('component/header'); ?>
    
    <h1><?= $pageTitle ?></h1>
    <p><?= $message ?></p>
    
    <?php $this->render('component/footer'); ?>
    $$$

### Example: Full Page Rendering

Here’s an example of a full page rendering using the `Render` library in a controller:

- Controller (`HomeController.php`):
    $$$php
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
    $$$

### Error Pages

Custom error pages can be created and placed in the `application/views/default/` directory. For example, a 404 error page can be defined in `404.php`.

- Example `404.php`:
    $$$php
    <h1>404 - Page Not Found</h1>
    <p>The page you are looking for does not exist.</p>
    $$$

You can then handle errors in your controller and render the error page when necessary:

- Example:
    $$$php
    if (!$pageFound) {
        $this->render('404');
    }
    $$$

### Conclusion

The view system in PHP-Fast allows you to build complex pages with ease. You can create layouts, include components, and pass data from controllers to views. This approach helps maintain a clean and modular codebase, making it easier to manage and extend your application.


