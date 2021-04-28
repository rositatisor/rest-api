# Gilded Rose API

## Getting started

Gilded Rose API (application Proframming Interface) allow users to get Gilded Rose categories and items.

### Methods

| Verb   | Discription                               |
| ------ | ----------------------------------------- |
| GET    | Used for resource or list of resources.   |
| POST   | Used for creating resources.              |
| PUT    | Used for replacing or updating resources. |
| DELETE | Used for deleting resource or resources.  |

## Description of usual server Responses:

- 200 `OK` - the request was successful;
- 400 `Bad Request` - the request could not be understood or was missing required parameters.
- 405 `Method Not Allowed` - requested method is not supported for resource.

## To start

You can run the application locally:

```
$ php bin/console server:run
```

## Category

Represents Category details. The API allows you to create, read, update, and delete your categories.

Category attributes:

1. id (number): unique identifier.
2. name (string): name of the category.

### Endpoints:

[**GET** `/api/categories`](#Retrieve-all-categories)

[**GET** `/api/categories/:id`](#Retrieve-specific-category)

[**POST** `/api/categories`](#Create-a-category)

[**PUT** `/api/categories/:id`](#Update-existing-category)

[**DELETE** `/api/categories/:id`](#Delete-existing-category)

### Create a category

```php
$ch = curl_init();
$url = 'http://127.0.0.1:8000/api/categories';
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, 'name=Write a name'); // specify name
$response = curl_exec($ch);
curl_close($ch);
```

### Retrieve all categories

```php
$ch = curl_init();
$url = 'http://127.0.0.1:8000/api/categories';
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
$response = curl_exec($ch);
curl_close($ch);
```

### Retrieve specific category

```php
$ch = curl_init();
$url = 'http://127.0.0.1:8000/api/categories/id'; // specify id number
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
$response = curl_exec($ch);
curl_close($ch);
```

### Update existing category

```php
$ch = curl_init();
$url = 'http://127.0.0.1:8000/api/categories/id'; //specify id number
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POSTFIELDS,'name=New name'); // specify new name
$response = curl_exec($ch);
curl_close($ch);
```

### Delete existing category

```php
$ch = curl_init();
$url = 'http://127.0.0.1:8000/api/categories/id'; //specify id
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
$response = curl_exec($ch);
curl_close($ch);
```

## Author

[Rosita](https://github.com/rositatisor)
