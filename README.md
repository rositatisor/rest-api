# Gilded Rose API

## Getting started

Gilded Rose API (Application Programming Interface) allow users to get Gilded Rose categories and items.

### HTTPs requests

| Verb   | Discription                               |
| ------ | ----------------------------------------- |
| GET    | Used for resource or list of resources.   |
| POST   | Used for creating resources.              |
| PUT    | Used for replacing or updating resources. |
| DELETE | Used for deleting resource or resources.  |

## Description of usual server Responses:

- 200 `OK` - the request was successful.
- 400 `Bad Request` - the request could not be understood or was missing required parameters.
- 405 `Method Not Allowed` - requested method is not supported for resource.

## **Where to start?**

You can run the application locally:

```
$ php bin/console server:run
```

## **How to use?**

## I. Category

Represents Category details. The API allows you to create, read, update, and delete your categories.

### 1) Category attributes:

- id (number): unique identifier.
- name (string): name of the category.

### 2) Endpoints and how to use:

### Create a category

**POST** `/api/categories`

```php
$ch = curl_init();
$url = 'http://127.0.0.1:8000/api/categories';
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, 'name=Name'); // specify name
$response = curl_exec($ch);
curl_close($ch);
```

### Retrieve all categories

**GET** `/api/categories`

```php
$ch = curl_init();
$url = 'http://127.0.0.1:8000/api/categories';
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
$response = curl_exec($ch);
curl_close($ch);
```

### Retrieve specific category with all items

**GET** `/api/categories/:id`

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

**PUT** `/api/categories/:id`

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

**DELETE** `/api/categories/:id`

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

## II. Item

Represents Item details. The API allows you to create, read, update, and delete your items.

### 1) Item attributes:

- id (number): unique identifier.
- name (string): name of the item.
- value (float): value of the item.
- quality (integer): quality of the item.
- category (object): id of the related Category.

### 2) Endpoints and how to use:

### Create a item

**POST** `/api/items`

```php
$ch = curl_init();
$url = 'http://127.0.0.1:8000/api/items';
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
// specify parameters: name, value, quality and categoryId
$params = 'name=Name_item&value=X&quality=X&id=id';
curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
$response = curl_exec($ch);
curl_close($ch);
```

### Retrieve all items

**GET** `/api/items`

```php
$ch = curl_init();
$url = 'http://127.0.0.1:8000/api/items';
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
$response = curl_exec($ch);
curl_close($ch);
```

### Retrieve specific item

**GET** `/api/items/:id`

```php
$ch = curl_init();
$url = 'http://127.0.0.1:8000/api/items/id'; // specify id number
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
$response = curl_exec($ch);
curl_close($ch);
```

### Update existing item

**PUT** `/api/items/:id`

```php
$ch = curl_init();
$url = 'http://127.0.0.1:8000/api/items/id'; //specify id number
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
// specify new parameters: name, value, quality and categoryId
$params = 'name=Name_item&value=X&quality=X&id=20';
curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
curl_close($ch);
```

### Delete existing item

**DELETE** `/api/items/:id`

```php
$ch = curl_init();
$url = 'http://127.0.0.1:8000/api/items/id'; //specify id
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
$response = curl_exec($ch);
curl_close($ch);
```

### Delete all items based on category

**DELETE** `/api/items/category/:id`

```php
$ch = curl_init();
$url = 'http://127.0.0.1:8000/api/items/category/id'; //specify id
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
$response = curl_exec($ch);
curl_close($ch);
```

## Author

[Rosita](https://github.com/rositatisor)
