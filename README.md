
# To-do List Documentation

## Tech Stack

- PHP (Backend Language)
- Laravel (PHP Framework)
- MySQL (Database)
- InertiaJS [React] (Frontend)

## Requirements

- PHP
- MySQL
- Composer

## Installation

1. Clone the repository
2. In your terminal, `cd` inside the project folder and run `cp .env.example .env`.
3. Open the `.env` file and fill-out your database credentials.
4. Run the ff. command below:

```
composer install
php artisan key:generate
php artisan migrate
```

## Running the application
Run the command `php artisan serve`

Then you can visit http://127.0.0.1:8000 on your local browser.

# API Endpoints
### List
* GET `/todo-items` - Get ALL Todo Items

**Response**
    data - Array of Todo Items

### Create
* POST `/todo-items` - Add Todo Item

**Parameters**
    description - (Required) Description text of todo item

**Response**
    data - Todo Item inserted

### Delete
* DELETE `/todo-items/{id}` - Delete Todo Item

**Response**
    status - (boolean) Is the Todo Item successfully deleted

### Toggle Completed
* POST `/todo-items/{id}/toggle-completed` - Toggle Completed of a specific Todo Item

**Response**
    data - Updated Todo Item

## Other Tech Implementations

1. Repository Pattern
2. Laravel API Resource
3. Model Factory
4. phpunit