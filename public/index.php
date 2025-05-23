<?php

session_start();

require "../app/core/init.php";
$URL = $_GET['url'] ?? "HOME";
$URL=explode("/",$URL);

$file = page(strtolower($URL[0]));

if(file_exists($file))
{
    require $file;
}
else
{
    require page("404");
}


