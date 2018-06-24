# Assigment PHP socket web

## How to Install

Run Composer install because I'm use PSR-4
```bash
$ composer install
```

create mysql database script
```sql
CREATE TABLE `products` (
  `Id` int(11) NOT NULL,
  `Name` varchar(1000) NOT NULL,
  `Description` varchar(4000) NOT NULL,
  `Price` int(11) NOT NULL,
  `Stock` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `products` (`Id`, `Name`, `Description`, `Price`, `Stock`) VALUES
(1, 'Blue Shirt', 'Blue Shirt', 100, 10),
(2, 'shoe', 'red shoe', 350, 15),
(3, 'Product Name', 'A product description', 16, 2),
(4, 'Product Name 2', 'A product description 2', 15, 23);
````

## Running server

```bash
$ php server.php
```

## Access from browser
this assigment I use port 8080 with loop back ip 

```url
http://localhost:8080
```