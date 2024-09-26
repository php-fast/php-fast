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
