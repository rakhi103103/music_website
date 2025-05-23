<?php

require "config.php";
require "functions.php";


/*
//for mysql table
$con = db_connect();

 to create songs table

$sql = "CREATE TABLE songs(id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY ,
user_id INT NOT NULL, artist_id int NOT NULL,image VARCHAR(1024) NOT NULL,file VARCHAR(1024) NOT NULL,
 category_id INT NOT NULL,Date DATETIME DEFAULT CURRENT_TIMESTAMP,
 views INT NOT NULL,INDEX (user_id),INDEX (artist_id),INDEX (category_id), INDEX (Date), INDEX(views))" ;

 

creating categories table

$sql = "CREATE TABLE categories(id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY ,
category VARCHAR(30) NOT NULL,
 disabled   TINYINT(1) NOT NULL DEFAULT 0,
 INDEX (category), INDEX (disabled))" ;

 

 // creating artist table

 $sql = "CREATE TABLE artist(id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY ,
name VARCHAR(50) NOT NULL,
 bio TEXT NOT NULL,user_id INT NOT NULL,
 INDEX (name), INDEX (user_id))" ;

//EXECUTE QUERY

if(db_execute($sql))
{
    message("Table 'songs' created sucessfully");
}
else{
    message("Error creating table");
}
?> 

*/