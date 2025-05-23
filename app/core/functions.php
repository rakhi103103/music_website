<?php

function show($stuff)
{
    echo "<pre>";
    print_r($stuff);
    echo "</pre>";
}

function page($file){
     return  "../app/pages/".$file.".php";
}

function db_connect()
{
    $string = DBDRIVER .":hostname=".DBHOST.";dbname=".DBNAME;

    try{
        $con = new PDO($string, DBUSER, DBPASS); //pdo constructor

        $con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);//set error mode exceptiion

    }

    catch(PDOException $e)
    {
        die("connection failed: " . $e->getMessage()); 
    }
    return $con;
}

function db_query($query, $data = array()) 
{
    $con = db_connect();

    $stm = $con->prepare($query);
    if($stm)
    {
        $check = $stm->execute($data);
        if($check)
        {
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);

            if(is_array($result) && count($result) > 0)
            {
                return $result;
            }
        }
    }
    return false;
}

function db_query_one($query, $data = array()) 
{
    $con = db_connect();

    $stm = $con->prepare($query);
    if($stm)
    {
        $check = $stm->execute($data);
        if($check)
        {
            $result = $stm->fetchAll(PDO::FETCH_ASSOC);

            if(is_array($result) && count($result) > 0)
            {
                return $result[0];
            }
        }
    }
    return false;
}

function db_execute($query, $data = array())
{
    $con = db_connect(); //connect to create database
    $stm = $con->prepare($query); //prepare the sql statement
    if($stm)
    {
        $check = $stm->execute($data);
        if($check)
        {
            return true;//return true if the query execure sucessfully
        }
    }
    return false;
}

function message($message = '', $clear = false)
{
    if(session_status() == PHP_SESSION_NONE)
    {
        session_start();
    }

    if(!empty($message))
    {
        $_SESSION['message'] = $message;
    }
    else{
        $msg = false;
        if(array_key_exists('message', $_SESSION))
        {
            $msg = $_SESSION['message'];
        }
        if($clear)
        {
            unset($_SESSION['message']);
        }
        return $msg;
    }
    return false;
    
}

function redirect($page)
{
    header("Location: ".ROOT."/".$page);
    die;
}

function set_value($key, $dafault = '')
{
    if(!empty($_POST[$key]))
    {
       return $_POST[$key];   
    }
    else{
        return $dafault;
    }
    
    return '';
}

function set_select($key, $value, $default = '')
{
    if(!empty($_POST[$key]))
    {
        if($_POST[$key] == $value)
       {
        return " selected "; 
       }  
    }
    else{
        if($default == $value)
       {
        return " selected "; 
       } 
    }
    
    return '';
}

function get_date($date)
{
    return date("jS M,Y",strtotime($date));
}

function logged_in()
{
    if(!empty($_SESSION['user']) && is_array($_SESSION['user'])){
         return true ;
}

    return false;
}

function is_admin()
{
    if(!empty($_SESSION['USER']['role']) && $_SESSION['USER']['role'] == 'admin'){ 
        return true ;
}

    return false;
}

function user($column)
{
    if(!empty($_SESSION['USER'][$column]))
    { 
        return $_SESSION['USER'][$column];
    }
    return 'unknown';
}

function authenticate($row)
{
    
    
         $_SESSION['USER'] = $row;
    
}

function str_to_url($url)
{
    $url = str_replace("'", "",$url);
    $url = preg_replace('~[\\pL0-9_]+~u','-',$url);
    $url = trim($url,"-");
    $url = iconv("utf-8","us-ascii//TRANSLIT",$url);
    $url = strtolower($url);
    $url = preg_replace('~[^-a-z0-9_]+~', '',$url);
    return $url;
}

function get_category($id)
{
    $query = "select category from category where id = :id limit 1";
    $row = db_query_one($query,['id'=>$id]);

    if(!empty($row['category']))
    {
        return $row['category'];
    }
    return "Unknown";
}

function get_artist($id)
{
    $query = "select name from artist where id = :id limit 1";
    $row = db_query_one($query,['id'=>$id]);

    if(!empty($row['name']))
    {
        return $row['name'];
    }
    return "Unknown";
}
function esc($str)
{
    return htmlspecialchars($str);
}

