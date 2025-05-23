
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Admin Area</title>
        <link rel="icon" type="image/svg+xmlf" href="assest/images/logo.svg" />
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?=ROOT?>/assest/css/style.css?445">
    </head>
    <body>
    
        <header >
        <div class="logo-holder">
           <a href="<?=ROOT?>"> <img class="logo"src="<?=ROOT?>/assest/images/logo.svg"></a>
        </div>
        <div class="header-div"> 
        <div class="main-title">Admin Area </div>
        <div class="socials">

        </div>
        <div class="main-nav"> 
            <div class="nav-items"><a href="<?=ROOT?>/admin/dashboard">Dashboard</a></div>
            <div class="nav-items"><a href="<?=ROOT?>/admin/songs">Songs</a></div>
            <div class="nav-items"><a href="<?=ROOT?>/admin/user">User</a></div>
            <div class="nav-items dropdown"><a href="<?=ROOT?>/admin/category">Category</a></div>
            <div class="nav-items dropdown"><a href="<?=ROOT?>/admin/artist">Artist</a></div>
            <div class="nav-items dropdown">
                <a href="#">hi, <?=user('username')?></a>
                <div class="dropdown-list">
                    <div class="nav-items"><a href="<?=ROOT?>/profile">profile</a></div>
                    <div class="nav-items"><a href="<?=ROOT?>">website</a></div>
                    <div class="nav-items"><a href="<?=ROOT?>.logout">logout</a></div>
                </div>
            </div>
        </div>
        </div>
        </header>

        <?php if(message()):?>

            <div class="alert"><?=message('',true)?></div>
        
        <?php endif;?>