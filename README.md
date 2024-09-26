# PHP-Fast Framework

PHP-Fast is a lightweight and efficient PHP MVC framework designed for fast web application development. This documentation provides an overview of the framework's structure, commands, and guides for building various components within a project.

## Table of Contents
1. [Framework Structure and Meaning](#framework-structure-and-meaning)
2. [Command-Line Interface (`php init`)](#command-line-interface-php-init)
    - [Database Synchronization (`table`)](#database-synchronization-table)
    - [Create Controller (`controllers`)](#create-controller-controllers)
    - [Create Model (`models`)](#create-model-models)
3. [Creating a Controller](#creating-a-controller)
4. [Creating a Model](#creating-a-model)
5. [Creating Middleware](#creating-middleware)
6. [Defining Routes](#defining-routes)

## 1. Framework Structure and Meaning

The framework follows an MVC (Model-View-Controller) pattern, organized as follows:


### Key Folders and Files
- **application/**: This directory contains user-defined files for application-specific logic (controllers, models, views, routes).
- **public/**: This is the public directory, and `index.php` is the entry point for all HTTP requests.
- **system/**: Contains the core framework files, such as the base classes, command-line tools, and libraries.

## 2. Command-Line Interface (`php init`)

The command-line tool (`php init`) is used to create controllers, models, and synchronize database tables. Here's how to use the command:

### Usage:

php init <command> <name>


### Available Commands:
1. **`table <name>`**: Synchronizes the database table based on the model's schema.
    - Example: `php init table users`
2. **`controllers <name>`**: Creates a new controller in the `application/controllers` directory.
    - Example: `php init controllers movies`
3. **`models <name>`**: Creates a new model in the `application/models` directory.
    - Example: `php init models movies`

### 2.1 Database Synchronization (`table`)
- Command: `php init table <name>`
- This command synchronizes the schema of the specified database table with the schema defined in the model (`_schema()` method).
- Example:
    ```bash
    php init table users
    ```
    This will use the `UsersModel` to create or update the `users` table in the database.

### 2.2 Create Controller (`controllers`)
- Command: `php init controllers <name>`
- This command generates a new controller file in the `application/controllers` directory.
- Example:
    ```bash
    php init controllers movies
    ```
    This will create `MoviesController.php` with basic functions like `index()`. You will be prompted to create an associated model.

### 2.3 Create Model (`models`)
- Command: `php init models <name>`
- This command generates a new model file in the `application/models` directory.
- Example:
    ```bash
    php init models movies
    ```
    This will create `MoviesModel.php` with a default schema and CRUD functions (`getMovies`, `addMovies`, `setMovies`, `delMovies`).

## 3. Creating a Controller

To create a new controller manually:

1. Navigate to the `application/controllers` directory.
2. Create a new file, e.g., `MoviesController.php`.
3. Add the basic structure:
    ```php
    <?php
    namespace App\Controllers;

    use System\Core\BaseController;

    class MoviesController extends BaseController {
        public function index() {
            // Your code here
        }

        // Additional methods
    }
    ```
4. Alternatively, use the command: `php init controllers movies`.

## 4. Creating a Model

To create a new model manually:

1. Navigate to the `application/models` directory.
2. Create a new file, e.g., `MoviesModel.php`.
3. Add the basic structure:
    ```php
    <?php
    namespace App\Models;
    use System\Core\BaseModel;

    class MoviesModel extends BaseModel {
        protected $table = 'movies';
        protected $fillable = ['name', 'genre'];
        protected $guarded = ['id', 'created_at'];

        public function _schema() {
            return [
                'id' => ['type' => 'int unsigned', 'auto_increment' => true, 'key' => 'primary', 'null' => false],
                'name' => ['type' => 'varchar(150)', 'null' => false, 'default' => ''],
                'genre' => ['type' => 'varchar(100)', 'null' => true, 'default' => '']
            ];
        }

        // Additional methods
    }
    ```
4. Alternatively, use the command: `php init models movies`.

## 5. Creating Middleware

1. Navigate to `application/middleware/` and create a new file, e.g., `AuthMiddleware.php`.
2. Add the middleware logic:
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
3. In `routes/web.php`, apply the middleware to routes:
    ```php
    $routes->get('admin', 'AdminController::index', [\App\Middlewares\AuthMiddleware::class]);
    ```

## 6. Defining Routes

Routes are defined in the `application/routes/web.php` and `application/routes/api.php` files. Use `$routes` to register routes:

- **Example: Basic Route**
    ```php
    $routes->get('/', 'HomeController::index');
    ```

- **Example: Dynamic Route with Parameters**
    ```php
    $routes->get('product/(:num)/(:string)', 'ProductController::show::$1::$2');
    ```

- **Example: Route with Middleware**
    ```php
    $routes->get('admin', 'AdminController::index', [\App\Middlewares\AuthMiddleware::class]);
    ```

## Conclusion

PHP-Fast is designed to be a simple and efficient MVC framework, giving developers the flexibility to create robust web applications with minimal overhead. Use the built-in commands to quickly set up controllers, models, and synchronize database tables, and leverage its routing and middleware system for building well-structured applications.

For any issues or contributions, please visit the [GitHub repository](https://github.com/php-fast/php-fast) and feel free to open an issue or pull request. Happy coding! 🎉