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
3. [Directory Structure](#directory-structure)
    - application/
    - public/
    - system/
    - vendor/
    - writeable/
4. [Configuration](#configuration)
    - Configuration Files
    - Environment Variables
5. [Command-Line Interface (`php init`)](#command-line-interface-php-init)
    - [Database Synchronization (`table`)](#database-synchronization-table)
    - [Create Controller (`controllers`)](#create-controller-controllers)
    - [Create Model (`models`)](#create-model-models)
6. [Routing](#routing)
    - Defining Routes
    - Dynamic Routing
    - Middleware in Routes
7. [Creating a Controller](#creating-a-controller)
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

PHP-Fast follows a well-organized directory structure to keep the application clean and modular. Here's a breakdown of each directory and its purpose:

### application/
Contains all the application-specific files, such as configurations, controllers, models, views, and routes.

- **config/**
  - `config.php`: Main configuration file for the application.

- **controllers/**
  - **Api/**: Directory for API-related controllers.
    - `UsersController.php`: Controller to handle user-related API endpoints.
  - `HomeController.php`: Main controller for handling web-based requests.

- **middlewares/**
  - `AuthMiddleware.php`: Middleware for handling authentication logic.
  - `PermissionMiddleware.php`: Middleware for handling user permissions.

- **models/**
  - `UsersModel.php`: Model to interact with the users' data in the database.

- **routes/**
  - `api.php`: Defines API routes for the application.
  - `web.php`: Defines web routes for the application.

- **views/**
  - **default/**: Default directory for views, structured to support components, pages, and layouts.
    - **component/**: Reusable components that can be included in multiple views.
      - `footer.php`: Footer component.
      - `header.php`: Header component.
    - **home/**: Directory corresponding to the `HomeController`.
      - `add_user.php`: View for adding a user.
      - `edit_user.php`: View for editing a user.
      - `home.php`: Homepage view.
      - `view_user.php`: View for displaying user details.
    - `404.php`: Custom 404 error page.
    - `themes.php`: Layout file for the application interface.

### public/
The document root of the application. This directory contains the front controller and other assets like stylesheets, JavaScript files, and images.

- `.htaccess`: Apache configuration file for URL rewriting.
- `index.php`: The entry point for all HTTP requests, bootstraps the framework.

### system/
Holds the core framework files, commands, drivers, helpers, and libraries.

- **commands/**: Contains command-line tools for the framework.
  - `ControllersCommand.php`: Command for creating controllers via CLI.
  - `ModelsCommand.php`: Command for creating models via CLI.
  - `TableCommand.php`: Command for synchronizing database tables.

- **core/**: Core system files of the framework.
  - `AppException.php`: Custom exception handler for the application.
  - `BaseController.php`: The base class that all controllers extend.
  - `BaseModel.php`: The base class that all models extend.
  - `Bootstrap.php`: Initializes the framework and handles routing.
  - `Middleware.php`: Base middleware class for creating custom middleware.
  - `Router.php`: Handles routing and directs requests to appropriate controllers.

- **drivers/**: Drivers for handling caching and database interactions.
  - **cache/**: Handles caching mechanisms.
    - `Cache.php`: Base cache class.
    - `FilesCache.php`: Cache implementation using file storage.
    - `RedisCache.php`: Cache implementation using Redis.
  - **database/**: Handles database queries and connections.
    - `Database.php`: Base database class.
    - `MysqlDriver.php`: MySQL-specific database driver.
    - `PostgresqlDriver.php`: PostgreSQL-specific database driver.

- **helpers/**: Contains helper functions to simplify common tasks.
  - `core_helper.php`: Core helper functions used throughout the framework.
  - `security_helper.php`: Functions for handling security and data sanitization.
  - `uri_helper.php`: Functions for handling URL manipulations.

- **libraries/**: Commonly used libraries within the system.
  - `Logger.php`: Handles logging functionality.
  - `Monitor.php`: Tracks application performance metrics.
  - `Render.php`: Handles view rendering and layouts.
  - `Security.php`: Manages security-related tasks.
  - `Session.php`: Manages user sessions.

### vendor/
Contains all the third-party libraries installed via Composer.

- **composer/**: Holds the Composer autoloader and dependency files.
  - `autoload.php`: Automatically loads classes and files from the `vendor/` directory.

### writeable/
A writable directory used for storing logs, file uploads, and other generated files.

- **logs/**
  - `logger.log`: Log file for recording application logs.

### Root Files
- `composer.json`: Composer file for managing dependencies.
- `init`: Command-line interface script for generating controllers, models, and database tables.

This structured organization allows developers to easily navigate through the framework, manage application logic, and customize components as needed.
