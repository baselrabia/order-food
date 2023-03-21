# Restaurant Inventory Management System

## Introduction

The Restaurant Inventory Management System is a web application for managing the inventory of a restaurant. The application allows the restaurant staff to add and update products and ingredients, manage orders, and track the stock levels of each ingredient.

## Technology Used

- Laravel, a web application framework written in PHP.
- Repository Pattern
    - Abstracts the data access layer from the rest of the application and provides a clean separation of concerns.
    - A repository is created for each model (Product, Ingredient, Order) which are responsible for fetching and updating the data.
    - Allows for easy switching of data sources or updating the data access logic without affecting the rest of the application.
- Caching
    - Implemented caching for the Ingredient model.
    - Created an IngredientCachedRepository that implements the IngredientRepositoryInterface.
    - Fetches the data from the cache if available, otherwise, it fetches the data from the database and stores it in the cache.
    - Reduces the number of database queries and improves the application's performance.
- Observer Pattern
    - Used to send email notifications when an ingredient's stock level reaches 50%.
    - Created an IngredientObserver that listens to the Ingredient model's updated event.
    - When an ingredient is updated, the observer checks if the new stock level is below 50% and sends an email notification to the merchant.
- Decorator Pattern
    - Used to add caching to the Ingredient repository.
    - Created an IngredientCachedRepository that implements the IngredientRepositoryInterface.
    - Adds caching to the IngredientRepository by fetching the data from the cache if available.
    - promotes a more loosely coupled design, where decorators can be added or removed as required, providing a simple and effective way to modify the behavior of an object at runtime.
- Queue
  - Used to process jobs in the background.
  - Allows for the execution of long-running tasks outside of the request-response cycle, improving the application's performance and responsiveness.
  - Configured to use a Database Driver or Redis server for job management.
  - Email notifications are sent using the `Mail` facade and queued using the `database` driver.

## Installation and Usage

### Running the Test Cases

1. Clone the repository to your local machine using `git clone`.
2. Install the required dependencies by running `composer install`.
3. Create a copy of the `.env.example` file and name it `.env`.
4. Create a test database and update the `DB_DATABASE` value in the `.env` file.
5. Run the migrations and seed the database using `php artisan migrate --seed`.
6. Run the test cases using `php artisan test`.

### Running the Project

1. Clone the repository to your local machine using `git clone`.
2. Install the required dependencies by running `composer install`.
3. Create a copy of the `.env.example` file and name it `.env`.
4. Update the `DB_DATABASE` value in the `.env` file to point to your database.
5. Run the migrations and seed the database using `php artisan migrate --seed`.
6. Start the local development server using `php artisan serve`.

# API Documentation

## Order Endpoint

### POST ```/api/orders```

Creates a new order in the system.

**Request Body:**

```json
{
    "products": [
        {
            "product_id": 1,
            "quantity": 2
        }
    ]
}
