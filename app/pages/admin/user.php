<?php 
if($action == 'add')
{


$errors = [];


if($_SERVER['REQUEST_METHOD'] == "POST")
{
       
        
        //data validation
        // for username
        if(empty($_POST['username']))
        {
                $errors['username'] = "A username is requuired";
        }
        elseif(!preg_match("/^[a-zA-Z]+$/" , $_POST['username'] ))
        {
                $errors['username'] = "A username can ony have letter with no spaces";
        }

        //for email
        if(empty($_POST['email']))
        {
                $errors['email'] = "A email is requuired";
        }
        elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {
                $errors['email'] = "email not valid ";
        }

        //for password
        if(empty($_POST['password']))
        {
                $errors['password'] = "A password is required";
        }
        elseif($_POST['password'] != $_POST['retype_password'])
        {
                $errors['password'] = "password do not match ";
        }
        elseif(strlen($_POST['password']) < 8)
        {
                $errors['password'] = "password must be greater than 8 character ";
        }

        //for role
        if(empty($_POST['role']))
        {
                $errors['role'] = "A role is required";
        }

         if(empty($errors))
       { // insertion of user
        $values=[];
        $values['username'] = trim($_POST['username']);
        $values['email'] = trim($_POST['email']);
        $values['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT) ;
        $values['role'] = trim($_POST['role']);
        $values['date'] = date("Y-m-d H:i:s");
       
        $query = 'insert into user (username,email,password,role,date) values (:username,:email,:password,:role,:date)';
        db_query($query,$values);
        message("user created sucessfully");
        redirect('admin/user');
       }
        
}
}    //edit to save
else  
if($action == 'edit')   //edit to save
{
        
        $query =" select * from user  where id = :id limit 1";
        $row = db_query_one($query,['id'=>$id]);
       

$errors = [];


if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
{
       
        
        
        if(empty($_POST['username']))
        {
                $errors['username'] = "A username is required";
        }
        elseif(!preg_match("/^[a-zA-Z]+$/" , $_POST['username'] ))
        {
                $errors['username'] = "A username can ony have letter with no spaces";
        }

        //for email
        if(empty($_POST['email']))
        {
                $errors['email'] = "A email is requuired";
        }
        elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {
                $errors['email'] = "email not valid ";
        }

        //for password
         if(!empty($_POST['password']))
        {
                
        if($_POST['password'] != $_POST['retype_password'])
        {
                $errors['password'] = "password do not match ";
        }
        elseif(strlen($_POST['password']) < 8)
        {
                $errors['password'] = "password must be greater than 8 character ";
        }
        }

        //for role
        if(empty($_POST['role']))
        {
                $errors['role'] = "A role is required";
        }

       if(empty($errors))
       { // insertion of user
        $values=[];
        $values['username'] = trim($_POST['username']);
        $values['email'] = trim($_POST['email']);
        $values['id'] = $id;

        $query = "update user set email = :email, username = :username, role = :role where id = :id limit 1";
              
        if(!empty($_POST['password'])){
                $query = "update user set email = :email, password = :password, username = :username, role = :role where id = :id limit 1";
                $values['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT) ;
        }
        $values['role'] = trim($_POST['role']);
        db_query($query,$values);
        message("user edited sucessfully");
        redirect('admin/user');
       }
        
}
}else
if($action == 'delete')   //for delete
{
        
        $query =" select * from user  where id = :id limit 1";
        $row = db_query_one($query,['id'=>$id]);
       

$errors = [];


if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
{
       if($row['id'] ==1)
       {
        $errors['username'] = "The main admin cannot be deleted";
       }
       if(empty($errors))
       { // insertion of user
        $values=[];
        $values['id'] = $id;

        $query = "delete from user where id = :id limit 1";
              
       
       
        db_query($query,$values);
        message("user deleted sucessfully");
        redirect('admin/user');
       }
        
}
}    //end delete
?>

<?php require page('includes/admin-header') ?>

        <section class="admin-content" style="width:1250px; min-height:200px;">

        <?php if($action == 'add'):?>        <!--adding user-->

            <div style="max-width:500px; margin:auto;">
                <form method="post" >
                        <h3>Add New User</h3>
                        <input class="form-control my-1" value="<?=set_value('username')?>" type="text" name="username" placeholder="username">
                        <?php if(!empty($errors['username'])):?>
                        <small class="error"><?=$errors['username']?></small>
                        <?php endif;?>

                        <input class="form-control my-1" value="<?=set_value('email')?>" type="email" name="email" placeholder="email">
                        <?php if(!empty($errors['email'])):?>
                        <small class="error"><?=$errors['email']?></small>
                        <?php endif;?>

                        <select name="role" class="form-control my-1">
                                <option value="">--Select Role--</option>
                                <option <?=set_select('role','user')?> value="user">User</option>
                                <option <?=set_select('role','admin')?> value="admin">Admin</option>
                        </select>
                         <?php if(!empty($errors['role'])):?>
                        <small class="error"><?=$errors['role']?></small>
                        <?php endif;?>

                        <input class="form-control my-1" value="<?=set_value('password')?>" type="password" name="password" placeholder="Password">
                        <?php if(!empty($errors['password'])):?>
                        <small class="error"><?=$errors['password']?></small>
                        <?php endif;?>
                        
                        <input class="form-control my-1" value="<?=set_value('retype_password')?>" type="password" name="retype_password" placeholder="retypepassword">
                        <button class="btn bg-orange">Create</button>
                        <a href="<?=ROOT?>/admin/user">
                            <button type="button" class="float-end btn">Back</button>
                        </a>
                </form>
            </div>   <!--end add-->
        
        <?php elseif($action == 'edit'):?>   <!---edit user-->
               
                <div style="max-width:500px; margin:auto;">
                <form method="post" >
                        <h3>Edit User</h3>

                        <?php if(!empty($row)):?>

                        <input class="form-control my-1" value="<?=set_value('username',$row['username'])?>" type="text" name="username" placeholder="username">
                        <?php if(!empty($errors['username'])):?>
                        <small class="error"><?=$errors['username']?></small>
                        <?php endif;?>

                        <input class="form-control my-1" value="<?=set_value('email',$row['email'])?>" type="email" name="email" placeholder="email">
                        <?php if(!empty($errors['email'])):?>
                        <small class="error"><?=$errors['email']?></small>
                        <?php endif;?>

                        <select name="role" class="form-control my-1">
                                <option value="">--Select Role--</option>
                                <option <?=set_select('role','user',$row['role'])?> value="user">User</option>
                                <option <?=set_select('role','admin',$row['role'])?> value="admin">Admin</option>
                        </select>
                         <?php if(!empty($errors['role'])):?>
                        <small class="error"><?=$errors['role']?></small>
                        <?php endif;?>

                        <input class="form-control my-1" value="<?=set_value('password')?>" type="password" name="password" placeholder="Password (leave empty to keep old one)">
                        <?php if(!empty($errors['password'])):?>
                        <small class="error"><?=$errors['password']?></small>
                        <?php endif;?>
                        
                        <input class="form-control my-1" value="<?=set_value('retype_password')?>" type="password" name="retype_password" placeholder="retypepassword">
                        <button class="btn bg-orange">Save</button>
                        <a href="<?=ROOT?>/admin/user">
                            <button type="button" class="float-end btn">Back</button>
                        </a>
                        <?php else:?>
                        <div class="alert">That record was not found</div>
                        <a href="<?=ROOT?>/admin/user">
                            <button type="button" class="float-end btn">Back</button>
                        </a>
                        <?php endif;?>
                </form>
            </div>

        <?php elseif($action == 'delete'):?> <!--to delete the user or admin-->
               
                <div style="max-width:500px; margin:auto;">
                <form method="post" >
                        <h3>Delete User</h3>

                        <?php if(!empty($row)):?>

                        <div class="form-control my-1" ><?=set_value('username',$row['username'])?></div>
                        <?php if(!empty($errors['username'])):?>
                        <small class="error"><?=$errors['username']?></small>
                        <?php endif;?>

                        <div class="form-control my-1" ><?=set_value('email',$row['email'])?></div>
                        <div class="form-control my-1" ><?=set_value('role',$row['role'])?></div>

                         <button class="btn bg-redd">Delete</button>
                        <a href="<?=ROOT?>/admin/user">
                            <button type="button" class="float-end btn">Back</button>
                        </a>
                        <?php else:?>
                        <div class="alert">That record was not found</div>
                        <a href="<?=ROOT?>/admin/user">
                            <button type="button" class="float-end btn">Back</button>
                        </a>
                        <?php endif;?>
                </form>
            </div>

        <?php else:?>  
                
<!--displaying user-->
                <?php
                $query = "select * from user order by id desc limit 20";
                $rows = db_query($query);
                ?>

                <h3>User 
                        <a href="<?=ROOT?>/admin/user/add">
                        <button class="float-end btn bg-purple">Add New</button>
                        </a>
                </h3>

                <table class="table">
                        <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Date</th>
                                <th>Action</th>
                        </tr>
                        <?php if(!empty($rows)):?>
                                <?php foreach($rows as $row):?>
                         <tr>
                                <td><?=$row['ID']?></td>
                                <td><?=$row['username']?></td>
                                <td><?=$row['email']?></td>
                                <td><?=$row['role']?></td>
                                <td><?=get_date($row['date'])?></td>
                                <td>
                                        <a href="<?=ROOT?>/admin/user/edit/<?=$row['ID']?>">
                                        <img class="bi" src="<?=ROOT?>/assest/icons/pencil.svg">     
                                        </a>
                                        <a href="<?=ROOT?>/admin/user/delete/<?=$row['ID']?>">
                                        <img class="bi" src="<?=ROOT?>/assest/icons/trash.svg">  
                                        </a>
                                </td>
                        </tr>
                        <?php endforeach;?>
                        <?php endif;?>
                </table>

        <?php endif;?>


        </section>
   
        <?php require page('includes/admin-footer')?>