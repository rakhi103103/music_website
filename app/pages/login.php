<?php

$errors = [];


if($_SERVER['REQUEST_METHOD'] == "POST")
{     
      $values=[];
       $values['email'] = trim($_POST['email']);
       $query = "select * from user where email = :email limit 1 ";
        $row = db_query_one($query,$values);
        if(!empty($row))
       { // insertion of user
        if(password_verify($_POST['password'], $row['password']))
        {
          authenticate($row);
          message("login sucessfully");
          error_log("redirecting to admin");
           redirect('admin/dashboard');
        }
        
       }
        
       message("wrong email or password");
}

?>

<?php require page('includes/header')?>
<section class="content">
 <div class="login-holder">

 <?php if(message()):?>
<div class="alert"><?=message('',true)?></div>
<?php endif;?>

  <form method="post">
    <input value="<?=set_value('email')?>" class="my-1 form-control" type="email" name="email" placeholder="email">
    <input value="<?=set_value('password')?>" class="my-1 form-control" type="password" name="password" placeholder="password">
    <button class="my-1 btn bg-blue">Login</button>
    </form>
  </div>
</section>

<?php require page('includes/admin-footer')?>