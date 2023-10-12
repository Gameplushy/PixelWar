# PixelWar

## Prerequisites

You'll need :
- Composer
- PHP (version used is 7.4.33)
- Wamp or something alike that contains PhPMyAdmin and MySQL

## How to begin

### Install the dependancy
Download the source code and put it in a folder with whatever name, in the www folder.
Then, using a terminal, access the folder and execute `composer install` to install the dependancy.

### Create the database
In PHPMyAdmin, create a database named "pixelwar".
Then, execute the following script to create the table :

```sql
CREATE TABLE `canvas` (
  `X` int NOT NULL,
  `Y` int NOT NULL,
  `Color` varchar(10) NOT NULL,
  PRIMARY KEY (`X`,`Y`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci 
```

### Turn on the webSocket server
In a terminal, access the folder and execute `php bin/server.php`. This will enable the webSockets.

## How to use
On your web browser, go to `localhost/WhateverYouCalledYourProject`. You will be greeted with a color button that you can change, as well as 2 input boxes. The first one corresponds to the X-axis, and the other to the Y-axis.
Placement starts at 1. The canvas has a dimension of 1000(width)x700(height). Press "Send pixel!" to create it. This will dynamically change the canvas on your page, but also on the other pages as well.
Moreover, when reloading the page, the already colored pixels will be kept, thanks to the database.