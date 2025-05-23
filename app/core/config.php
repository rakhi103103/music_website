<?php

if($_SERVER['SERVER_NAME']=="localhost")
{
    //for local server
    define("ROOT","http://localhost/project/public");

    define("DBDRIVER", "mysql");
    define("DBHOST","localhost");
    define("DBUSER","root");
    define("DBPASS","admin@123");
    define("DBNAME","music_website");
}
else
{
    //for onine server
    define("ROOT","http://www.mywebsite.com");

    define("DBDRIVER", "mysql");
    define("DBHOST","localhost");
    define("DBUSER","root");
    define("DBPASS","");
    define("DBNAME","music_website");
}





