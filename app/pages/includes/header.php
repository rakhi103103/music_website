<!DOCTYPE html>
<html lang="en">
    <head>
        <title>music website</title>
        <link rel="icon" type="image/svg+xmlf" href="assest/images/logo.svg" />
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="<?=ROOT?>/assest/css/style.css">
    </head>
    <body>
    
        <header>
        <div class="logo-holder">
           <a href="<?=ROOT?>"> <img class="logo"src="<?=ROOT?>/assest/images/logo.svg"></a>
        </div>
        <div class="header-div"> 
        <div class="main-title">MUSIC WEBSITE </div>
        <div class="main-nav"> 
            <div class="nav-items"><a href="<?=ROOT?>/Home/">Home</a></div>
            <div class="nav-items"><a href="<?=ROOT?>/musics">Music</a></div>
            <div class="nav-items"><a href="<?=ROOT?>/Artist">Artst</a></div>
            <div class="nav-items dropdown">
                <a href="#">Category</a>
                <div class="dropdown-list">
                    <div class="nav-items"><a href="">pop</a></div>
                    <div class="nav-items"><a href="">pop</a></div>
                    <div class="nav-items"><a href="">pop</a></div>
                </div>
            </div>
            <div class="nav-items"><a href="<?=ROOT?>/ABOUT US">ABOUT US</a></div>
            
            <div class="nav-items dropdown">
                <a href="#">hi, <?=user('username')?></a>
                <div class="dropdown-list">
                    <div class="nav-items"><a href="<?=ROOT?>/profile">profile</a></div>
                    <div class="nav-items"><a href="<?=ROOT?>/admin/">admin</a></div>
                    <div class="nav-items"><a href="<?=ROOT?>/logout">logout</a></div>
                </div>
            </div>
            
        </div>
        </div>
        </header>
</body>