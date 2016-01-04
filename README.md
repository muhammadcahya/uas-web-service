# UAS Web Service

Web applications & APIs to providing a core structure that enables requests to the API 
to be properly <i>routed</i> - i.e. sent on to the correct handler that additional capabilities such as high level database access.

## Getting Started

Define a database configuration in `index.php` :

```php
define('DB_HOST', 'host');
define('DB_NAME', 'name');
define('DB_USER', 'user');
define('DB_PASS', 'pass');
```

This application use Slim registerAutoloader and register it's with PSR-0 autoloader , if you are prefer and choose Composer, you can change and require to the composer autoloader

## Trying it Out

With the above minimal amount of effort, you have already finished your task of use the RESTful APIs for accessing the database. The APIs you have created include:

### Part

* `GET /part`: list all part (optional : `expand` query parameter `?expand=all`, `?expand=laptop`, `?expand=part-category`)
* `GET /part/:id`: return the details of the part (optional : `expand` query parameter `?expand=all`, `?expand=laptop`, `?expand=part-category`)
* `GET /part/by-laptop`: list all part grouping by laptop
* `GET /part/by-laptop/:id`: return part grouping by laptop with specific :id
* `GET /part/by-category`: list all part grouping by part category
* `GET /part/by-category/:id`: return part grouping by part category with specific :id
* `GET /part/find`: find list of all part (parameter : `?id=:id&laptop_id=:laptop_id&part_category=:part_category&part_number=:part_number&description=:description`)
* `POST /part`: create a new part
* `PATCH /part/:id` and `PUT /part/:id`: update the part with :id
* `DELETE /part/:id`: delete the part with :id

### Laptop

* `GET /laptop`: list all laptop
* `GET /laptop/:id`: return the details of the laptop
* `GET /laptop/find`: find list of all laptop
* `POST /laptop`: create a new laptop
* `PATCH /laptop/:id` and `PUT /laptop/:id`: update laptop with :id
* `DELETE /laptop/:id`: delete laptop with :id

### Part Category

* `GET /part-category`: list all part category
* `GET /part-category/:id`: return the details of the part category
* `GET /part-category/find`: find list of all part category
* `POST /part-category`: create a new part category
* `PATCH /part-category/:id` and `PUT /part-category/:id`: update part category with :id
* `DELETE /part-category/:id`: delete part category with :id

## Example

As you can see, in the response headers, there are information about the list off all function. 

For example, `http://localhost/uas-web-service/part` would give you :
```json
[
  {
    "id": 1,
    "laptop_id": 1,
    "part_category": 1,
    "part_number": 11001,
    "description": "Part keyboard for laptop"
  },

]
```

To expand relation use `expand` parameter with option : `all`,`laptop`, or `part-category`. 

For example, `http://localhost/uas-web-service/part?expand=laptop` would give you :
```json
[
  {
    "part_number": 11001,
    "description": "Part keyboard for laptop",
    "laptop": {
      "id": 1,
      "brand": "Asus",
      "model": "X200",
      "release_year": 2014
    }
  },

]
```

For example, `http://localhost/uas-web-service/part?expand=part-category` would give you :
```json
[
  {
    "part_number": 11001,
    "description": "Part keyboard for laptop",
    "part_category": {
      "id": 1,
      "name": "keyboard"
    }
  },

]
```

For example, `http://localhost/uas-web-service/part?expand=all` would give you :
```json
[
  {
    "part_number": 11001,
    "description": "Part keyboard for laptop",
    "laptop": {
      "id": 1,
      "brand": "Asus",
      "model": "X200",
      "release_year": 2014
    },
    "part_category": {
      "id": 1,
      "name": "keyboard"
    }
  },

]
```

For example, `http://localhost/uas-web-service/part/by-laptop/1` would give you :
```json
{
  "Asus - X200 (2014)": [
    {
      "part_number": 11001,
      "name": "keyboard",
      "description": "Part keyboard for laptop"
    },
    {
      "part_number": 11002,
      "name": "lcd protector",
      "description": "Part LCD Protector for laptop"
    },
    {
      "part_number": 11003,
      "name": "mouse pad",
      "description": "Part MousePad for laptop"
    },
    {
      "part_number": 11004,
      "name": "usb port",
      "description": "Part USB Port for laptop"
    }
  ]
}
```

For example, `http://localhost/uas-web-service/part/by-category/1` would give you :
```json
{
  "keyboard": [
    {
      "brand": "Asus",
      "model": "X200",
      "release_year": 2014
    },
    {
      "brand": "Asus",
      "model": "S200E",
      "release_year": 2015
    }
  ]
}
```
