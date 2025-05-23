<?php 
if($action == 'add')

{


$errors = [];


if($_SERVER['REQUEST_METHOD'] == "POST")
{
      
        
        //data validation
        // for artist
        if(empty($_POST['name']))
        {
                $errors['name'] = "An artist is required";
        }
        elseif(!preg_match("/^[a-zA-Z \&\-]+$/" , $_POST['name'] ))
        {
                $errors['name'] = "A artist can ony have letter and spaces";
        }
        // image validation
        if(!empty($_FILES['image']['name']))
        {
            $folder = "uploads/";
            if(!file_exists($folder))
            {                                              //making folder
                mkdir($folder,0777,true);
                file_put_contents($folder."index.php","");
            }
            $allowed = ['image/jpeg','image/png','image.jfif'];
            if($_FILES['image']['error'] == 0 && in_array($_FILES['image']['type'],$allowed))
            {
                $destination = $folder.$_FILES['image']['name'];

                move_uploaded_file($_FILES['image']['tmp_name'],$destination);   //uploding file
            }else{
                $errors['name'] = " Image is invalid. Allowed types are ".implode(",",$allowed);
            }
           
        }else{
            $errors['name'] = "An image is required";
        }

         if(empty($errors))
       { // insertion of artist
        $values=[];
        $values['name'] = trim($_POST['name']);
        $values['image'] = $destination;
        $values['user_id'] = user('ID');
       
        $query = "insert into artist (name,image,user_id) values (:name,:image,:user_id)";
        db_query($query,$values);
        message("artist created sucessfully");
        redirect('admin/artist');
       }
        
}
}    //wdit to save
else  
if($action == 'edit')   //edit to save
{
        
        $query =" select * from artist  where id = :id limit 1";
        $row = db_query_one($query,['id'=>$id]);
       

$errors = [];


if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
{
       
        
        
        if(empty($_POST['name']))
        {
                $errors['name'] = "A artist is required";
        }
        elseif(!preg_match("/^[a-zA-Z \&\-]+$/" , $_POST['name'] ))
        {
                $errors['name'] = "A artist can ony have letter with no spaces";
        }

        if(!empty($_FILES['image']['name']))
        {
            $folder = "uploads/";
            if(!file_exists($folder))
            {                                              //making folder
                mkdir($folder,0777,true);
                file_put_contents($folder."index.php","");
            }
            $allowed = ['image/jpeg','image/png','image.jfif'];
            if($_FILES['image']['error'] == 0 && in_array($_FILES['image']['type'],$allowed))
            {
                $destination = $folder.$_FILES['image']['name'];

                move_uploaded_file($_FILES['image']['tmp_name'],$destination);   //uploding file
                //delete an old file   delete an old file
                if(file_exists($row['image']))
                {
                    unlink($row['image']);
                }
            }else{
                $errors['name'] = " Image is invalid. Allowed types are ".implode(",",$allowed);
            }
           
        }      
        //image validation ends here

       if(empty($errors))
       { // insertion of artist
        $values=[];
        $values['name'] = trim($_POST['name']);
        $values['user_id'] = user('ID');
        $values['id'] = $id;

        $query = "update artist set  name = :name,user_id = :user_id where id = :id limit 1";

        if(!empty($destination)){
        $query = "update artist set  name = :name,user_id = :user_id, image = :image where id = :id limit 1";
        $values['image'] = $destination;
        }

        db_query($query,$values);
        message("artist edited sucessfully");
        redirect('admin/artist');
       }
        
}
}else
if($action == 'delete')   //for delete
{
        
        $query =" select * from artist  where id = :id limit 1";
        $row = db_query_one($query,['id'=>$id]);
       

$errors = [];


if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
{
       
       if(empty($errors))
       { 
        
        
        // insertion of artist
        $values=[];
        $values['id'] = $id;

        $query = "delete from artist where id = :id limit 1";
        db_query($query,$values);
         //delete an old file   delete an old file
         if(file_exists($row['image']))
         {
             unlink($row['image']);
         }
         
        message("artist deleted sucessfully");
        redirect('admin/artist');
       }
        
}
}    //end delete
?>

<?php require page('includes/admin-header') ?>

        <section class="admin-content" style="width:1250px; min-height:200px;">

        <?php if($action == 'add'):?>        <!--adding artist add adda-->

            <div style="max-width:500px; margin:auto;">

                <form method="post" enctype="multipart/form-data" > <!--post of add-->

                        <h3>Add New Artist</h3>
                        <input class="form-control my-1" value="<?=set_value('name')?>" type="text" name="name" placeholder="Categorn Name">
                        <?php if(!empty($errors['name'])):?>
                        <small class="error"><?=$errors['name']?></small>
                        <?php endif;?>

                        <input class="form-control my-1" type="file" name="image">
                         <?php if(!empty($errors['image'])):?>
                        <small class="error"><?=$errors['image']?></small>
                        <?php endif;?>

                        <button class="btn bg-orange">Create</button>
                        <a href="<?=ROOT?>/admin/artist">
                            <button type="button" class="float-end btn">Back</button>
                        </a>
                </form>
            </div>   <!--end add-->
        
        <?php elseif($action == 'edit'):?>   <!---edit artist     edit edit-->
               
                <div style="max-width:500px; margin:auto;">
                <form method="post" enctype="multipart/form-data">
                        <h3>Edit artist</h3>

                        <?php if(!empty($row)):?>

                        <input class="form-control my-1" value="<?=set_value('name',$row['name'])?>" type="text" name="name" placeholder="artist">
                        <?php if(!empty($errors['name'])):?>
                        <small class="error"><?=$errors['name']?></small>
                        <?php endif;?>

                        <img src="" alt="<?=ROOT?>/<?=$row['image']?>" style="width:100px;height:100px;object-fit:cover;">

                        <input class="form-control my-1" type="file" name="image">

                        </select><button class="btn bg-orange">Save</button>
                        <a href="<?=ROOT?>/admin/artist">
                            <button type="button" class="float-end btn">Back</button>
                        </a>
                        <?php else:?>
                        <div class="alert">That record was not found</div>
                        <a href="<?=ROOT?>/admin/artist">
                            <button type="button" class="float-end btn">Back</button>
                        </a>
                        <?php endif;?>
                </form>
            </div>

        <?php elseif($action == 'delete'):?> <!--to delete the artist or admin-->
               
                <div style="max-width:500px; margin:auto;">
                <form method="post" >
                        <h3>Delete artist</h3>

                        <?php if(!empty($row)):?>

                        <div class="form-control my-1" ><?=set_value('artist',$row['name'])?></div>
                        <?php if(!empty($errors['name'])):?>
                        <small class="error"><?=$errors['name']?></small>
                        <?php endif;?>


                         <button class="btn bg-redd">Delete</button>
                        <a href="<?=ROOT?>/admin/artist">
                            <button type="button" class="float-end btn">Back</button>
                        </a>
                        <?php else:?>
                        <div class="alert">That record was not found</div>
                        <a href="<?=ROOT?>/admin/artist">
                            <button type="button" class="float-end btn">Back</button>
                        </a>
                        <?php endif;?>
                </form>
            </div>

        <?php else:?>  
                
<!--displaying artist-->
                <?php
                $query = "select * from artist order by id desc limit 20";
                $rows = db_query($query);
                ?>

                <h3>Artist 
                        <a href="<?=ROOT?>/admin/artist/add">
                        <button class="float-end btn bg-purple">Add New</button>
                        </a>
                </h3>

                <table class="table">
                        <tr>
                                <th>ID</th>
                                <th>Artist</th>
                                <th>Image</th>
                                <th>Action</th>

                                
                        </tr>
                        <?php if(!empty($rows)):?>
                                <?php foreach($rows as $row):?>
                         <tr>
                                <td><?=$row['id']?></td>
                                <td><?=$row['name']?></td>
                                <td><img src="<?=ROOT?>/<?=$row['image']?>"  style="width:100px;height:100px;object-fit:cover;"></td>
                                
                                
                                <td>
                                        <a href="<?=ROOT?>/admin/artist/edit/<?=$row['id']?>">
                                        <img class="bi" src="<?=ROOT?>/assest/icons/pencil.svg">     
                                        </a>
                                        <a href="<?=ROOT?>/admin/artist/delete/<?=$row['id']?>">
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