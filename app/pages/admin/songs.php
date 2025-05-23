<?php 
if($action == 'add')

{

$errors = [];


if($_SERVER['REQUEST_METHOD'] == "POST")
{
      
        
        //data validation
        // for songs
        if(empty($_POST['title']))
        {
                $errors['title'] = "An Song title is required";
        }
        elseif(!preg_match("/^[a-zA-Z0-9 \.\&\-]+$/" , $_POST['title'] ))
        {
                $errors['title'] = "A song title can ony have letter and spaces";
        }

        //category validation
        if(empty($_POST['category_id']))   
        {
                $errors['category_id'] = "A category is required";
        }

         //artist validation
         if(empty($_POST['artist_id']))   
         {
                 $errors['artist_id'] = "An artist is required";
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
                $destination_image = $folder.$_FILES['image']['name'];

                move_uploaded_file($_FILES['image']['tmp_name'],$destination_image);   //uploding file
            }else{
                $errors['image'] = " Image is invalid. Allowed types are ".implode(",",$allowed);
            }
           
        }else{
            $errors['image'] = "An image is required";
        }   //image validation ends



        //audio validations starts hereeeeeeeee
        if(!empty($_FILES['file']['name']))
        {
            $folder = "uploads/";
            if(!file_exists($folder))
            {                                              //making folder
                mkdir($folder,0777,true);
                file_put_contents($folder."index.php","");
            }
            $allowed = ['audio/mpeg'];
            if($_FILES['file']['error'] == 0 && in_array($_FILES['file']['type'],$allowed))
            {
                $destination_file = $folder.$_FILES['file']['name'];

                move_uploaded_file($_FILES['file']['tmp_name'],$destination_file);   //uploding file
            }else{
                $errors['file'] = " file is invalid. Allowed types are ".implode(",",$allowed);
            }
           
        }else{
            $errors['file'] = "An audio is required";
        }   
        //// audio validation ends here

         if(empty($errors))
       { // insertion of songs
        $values=[];
        $values['title'] = trim($_POST['title']);
        $values['category_id'] = trim($_POST['category_id']);
        $values['artist_id'] = trim($_POST['artist_id']);
        $values['image'] = $destination_image;
        $values['file'] = $destination_file;
        $values['user_id'] = user('ID');
        $values['date'] = date("Y-m-d H:i:s");
        $values['views'] = 0;
        $values['slug'] = str_to_url($values['title']);
       
        $query = "insert into songs (title,image,file,user_id,category_id,artist_id,date,views,slug) values (:title,:image,:file,:user_id,:category_id,:artist_id,:date,:views,:slug)";
        db_query($query,$values);
        message("songs created sucessfully");
        redirect('admin/songs');
       }
        
}
}    //wdit to save
else  
if($action == 'edit')   //edit to save
{
        
        $query =" select * from songs  where id = :id limit 1";
        $row = db_query_one($query,['id'=>$id]);
       

$errors = [];


if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
{
       
      //data validation
        // for songs
        if(empty($_POST['title']))
        {
                $errors['title'] = "An Song title is required";
        }
        elseif(!preg_match("/^[a-zA-Z0-9 \.\&\-]+$/" , $_POST['title'] ))
        {
                $errors['title'] = "A song title can ony have letter and spaces";
        }

        //category validation
        if(empty($_POST['category_id']))   
        {
                $errors['category_id'] = "A category is required";
        }

         //artist validation
         if(empty($_POST['artist_id']))   
         {
                 $errors['artist_id'] = "An artist is required";
         }

        //image validation
        if(!empty($_FILES['image']['name']))
        {
            $folder = "uploads/";
            if(!file_exists($folder))
            {                                              //making folder
                mkdir($folder,0777,true);                                         //edit section
                file_put_contents($folder."index.php","");
            }
            $allowed = ['image/jpeg','image/png','image.jfif'];
            if($_FILES['image']['error'] == 0 && in_array($_FILES['image']['type'],$allowed))
            {
                $destination_image = $folder.$_FILES['image']['name'];

                move_uploaded_file($_FILES['image']['tmp_name'],$destination_image);   //uploding file
                //delete an old imagefile   delete an old file
                if(file_exists($row['image']))
                {
                    unlink($row['image']);
                }

                //delete an old audio file   delete an old file
                if(file_exists($row['file']))
                {
                    unlink($row['file']);
                }

            }else{
                $errors['name'] = " Image is invalid. Allowed types are ".implode(",",$allowed);
            }
           
        }      
        //image validation ends here
      
        //audio validation
        if(!empty($_FILES['file']['name']))
        {
            $folder = "uploads/";
            if(!file_exists($folder))
            {                                              //making folder
                mkdir($folder,0777,true);                                         //edit section
                file_put_contents($folder."index.php","");
            }
            $allowed = ['audio/mpeg'];
            if($_FILES['image']['error'] == 0 && in_array($_FILES['file']['type'],$allowed))
            {
                $destination_file = $folder.$_FILES['file']['name'];

                move_uploaded_file($_FILES['file']['tmp_name'],$destination_file);   //uploding file
               

                //delete an old audio file   delete an old file
                if(file_exists($row['file']))
                {
                    unlink($row['file']);
                }

            }else{
                $errors['name'] = " file is invalid. Allowed types are ".implode(",",$allowed);
            }
           
        }  

       if(empty($errors))
       { // insertion of songs
        $values=[];
        $values['title'] = trim($_POST['title']);
        $values['category_id'] = trim($_POST['category_id']);
        $values['artist_id'] = trim($_POST['artist_id']);
        $values['user_id'] = user('ID');
        $values['id'] = $id;

        $query = "update songs set  title = :title , user_id = :user_id, category_id = :category_id, artist_id = :artist_id";

        if(!empty($destination_image)){
        $query .= ", image = :image";
        $values['image'] = $destination_image;
        }

        if(!empty($destination_file)){
            $query .= ", file = :file";
            $values['file'] = $destination_filee;
            }

        $query .= " where id = :id limit 1";
        db_query($query,$values);
        message("songs edited sucessfully");
        redirect('admin/songs');
       }
        
}
}else
if($action == 'delete')   //for delete
{
        
        $query =" select * from songs  where id = :id limit 1";
        $row = db_query_one($query,['id'=>$id]);
       

$errors = [];


if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
{
       
       if(empty($errors))
       { 
        
        
        // insertion of songs
        $values=[];
        $values['id'] = $id;

        $query = "delete from songs where id = :id limit 1";
        db_query($query,$values);
         //delete an old  image file   delete an old file
         if(file_exists($row['image']))
         {
             unlink($row['image']);
         }
        //delete audio files
         if(file_exists($row['file']))
         {
             unlink($row['file']);
         }
         
        message("songs deleted sucessfully");
        redirect('admin/songs');
       }
        
}
}    //end delete
?>

<?php require page('includes/admin-header') ?>

        <section class="admin-content" style="width:1250px; min-height:200px;">

        <?php if($action == 'add'):?>        <!--adding songs add adda-->

            <div style="max-width:500px; margin:auto;">

                <form method="post" enctype="multipart/form-data" > <!--post of add-->

                        <h3>Add New Song</h3>
                        <input class="form-control my-1" value="<?=set_value('title')?>" type="text" name="title" placeholder="Song title">
                        <?php if(!empty($errors['title'])):?>
                        <small class="error"><?=$errors['title']?></small>
                        <?php endif;?>

                        <?php                 //query for category is hereeeeeeeeeeeeeee
                        $query = "select * from category order by category asc";
                        $category = db_query($query);
                        ?>
                        <select name="category_id" class="form-control my-1">    <!--category id is here----->
                        <option value="">--Select Category--</option>

                         <?php if(!empty($category)):?>
                            <?php foreach($category as $cat):?>   <!----using foreach to display category ----->
                             <option <?=set_select('category_id',$cat['id'])?> value="<?=$cat['id']?>"><?=$cat['category']?></option>
                            <?php endforeach;?>
                         <?php endif;?>
                        </select>
                         <?php if(!empty($errors['category_id'])):?>
                        <small class="error"><?=$errors['category_id']?></small>
                        <?php endif;?>

                        <?php                 //query for artist is hereeeeeeeeeeeeeee
                        $query = "select * from artist order by name asc";
                        $artist = db_query($query);
                        ?>
                        <select name="artist_id" class="form-control my-1">  <!-----artist is here------>
                            <option value="">--Select Artist--</option>
                         <?php if(!empty($artist)):?>
                            <?php foreach($artist as $cat):?>   <!----using foreach to display artisty ----->
                             <option <?=set_select('artist_id',$cat['id'])?> value="<?=$cat['id']?>"><?=$cat['name']?></option>
                            <?php endforeach;?>
                         <?php endif;?>
                        </select>
                         <?php if(!empty($errors['artist_id'])):?>
                        <small class="error"><?=$errors['artist_id']?></small>
                        <?php endif;?>

                        <div class="form-control my-1">
                        <div>Image:</div>
                        <input class="form-control my-1" type="file" name="image">
                       
                        <?php if(!empty($errors['image'])):?>             <!--fimagesssssss errors audio-->
                        <small class="error"><?=$errors['image']?></small>
                        <?php endif;?>

                        </div>

                        <div class="form-control my-1">
                        <div>Audio file:</div>
                        <input class="form-control my-1" type="file" name="file">

                        <?php if(!empty($errors['file'])):?>     <!--file/audio errors audio-->
                        <small class="error"><?=$errors['file']?></small>
                        <?php endif;?>

                        </div>

                        
                        <button class="btn bg-orange">Create</button>
                        <a href="<?=ROOT?>/admin/songs">
                            <button type="button" class="float-end btn">Back</button>
                        </a>
                </form>
            </div>   <!--end add-->
        
        <?php elseif($action == 'edit'):?>   <!---edit songs     edit edit-->
               
                <div style="max-width:500px; margin:auto;">
                <form method="post" enctype="multipart/form-data">
                        <h3>Edit songs</h3>

                        <?php if(!empty($row)):?>

                            <input class="form-control my-1" value="<?=set_value('title',$row['title'])?>" type="text" name="title" placeholder="Song title">
                        <?php if(!empty($errors['title'])):?>
                        <small class="error"><?=$errors['title']?></small>
                        <?php endif;?>

                        <?php                 //query for category is hereeeeeeeeeeeeeee
                        $query = "select * from category order by category asc";
                        $category = db_query($query);
                        ?>
                        <select name="category_id" class="form-control my-1">    <!--category id is here----->
                        <option value="">--Select Category--</option>

                         <?php if(!empty($category)):?>
                            <?php foreach($category as $cat):?>   <!----using foreach to display category ----->
                             <option <?=set_select('category_id',$cat['id'],$row['category_id'])?> value="<?=$cat['id']?>"><?=$cat['category']?></option>
                            <?php endforeach;?>
                         <?php endif;?>
                        </select>
                         <?php if(!empty($errors['category_id'])):?>
                        <small class="error"><?=$errors['category_id']?></small>
                        <?php endif;?>

                        <?php                 //query for artist is hereeeeeeeeeeeeeee
                        $query = "select * from artist order by name asc";
                        $artist = db_query($query);
                        ?>
                        <select name="artist_id" class="form-control my-1">  <!-----artist is here------>
                            <option value="">--Select Artist--</option>
                         <?php if(!empty($artist)):?>
                            <?php foreach($artist as $cat):?>   <!----using foreach to display artisty ----->
                             <option <?=set_select('cartist_id',$cat['id'],$row['artist_id'])?> value="<?=$cat['id']?>"><?=$cat['name']?></option>
                            <?php endforeach;?>
                         <?php endif;?>
                        </select>
                         <?php if(!empty($errors['artist_id'])):?>
                        <small class="error"><?=$errors['artist_id']?></small>
                        <?php endif;?>

                        <div class="form-control my-1">
                        <div>Image:</div>   
                        <img src="<?=ROOT?>/<?=$row['image']?>" alt="" style="width:100px;height:100px;object-fit:cover;">
                        <input class="form-control my-1" type="file" name="image">
                       
                        <?php if(!empty($errors['image'])):?>             <!--fimagesssssss errors audio-->
                        <small class="error"><?=$errors['image']?></small>
                        <?php endif;?>

                        </div>
                            <!-----audio file--->
                        <div class="form-control my-1">
                        <div>Audio file:</div>
                        <div><?=$row['file']?></div>
                        <input class="form-control my-1" type="file" name="file">

                        <?php if(!empty($errors['file'])):?>     <!--file/audio errors audio-->
                        <small class="error"><?=$errors['file']?></small>
                        <?php endif;?>

                        </div>

                        </select><button class="btn bg-orange">Save</button>
                        <a href="<?=ROOT?>/admin/songs">
                            <button type="button" class="float-end btn">Back</button>
                        </a>
                        <?php else:?>
                        <div class="alert">That record was not found</div>
                        <a href="<?=ROOT?>/admin/songs">
                            <button type="button" class="float-end btn">Back</button>
                        </a>
                        <?php endif;?>
                </form>
            </div>

        <?php elseif($action == 'delete'):?> <!--to delete the songs or admin-->
               
                <div style="max-width:500px; margin:auto;">
                <form method="post" >
                        <h3>Delete songs</h3>

                        <?php if(!empty($row)):?>

                        <div class="form-control my-1" ><?=set_value('title',$row['title'])?></div>
                        <?php if(!empty($errors['title'])):?>
                        <small class="error"><?=$errors['title']?></small>
                        <?php endif;?>


                         <button class="btn bg-redd">Delete</button>
                        <a href="<?=ROOT?>/admin/songs">
                            <button type="button" class="float-end btn">Back</button>
                        </a>
                        <?php else:?>
                        <div class="alert">That record was not found</div>
                        <a href="<?=ROOT?>/admin/songs">
                            <button type="button" class="float-end btn">Back</button>
                        </a>
                        <?php endif;?>
                </form>
            </div>

        <?php else:?>  
                
<!--displaying songs-->
                <?php
                $query = "select * from songs order by id desc limit 20";
                $rows = db_query($query);
                ?>

                <h3>songs 
                        <a href="<?=ROOT?>/admin/songs/add">
                        <button class="float-end btn bg-purple">Add New</button>
                        </a>
                </h3>

                <table class="table">
                        <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Category</th>
                                <th>Artist</th>
                                <th>Audio</th>
                                <th>Action</th>

                                
                        </tr>
                        <?php if(!empty($rows)):?>
                                <?php foreach($rows as $row):?>
                         <tr>
                                <td><?=$row['id']?></td>
                                <td><?=$row['title']?></td>
                                <td><img src="<?=ROOT?>/<?=$row['image']?>"  style="width:100px;height:100px;object-fit:cover;"></td>
                                <td><?=get_category($row['category_id'])?></td>
                                <td><?=get_artist($row['artist_id'])?></td>
                                <td>
                                    <audio controls>
                                        <source src="<?=ROOT?>/<?=$row['file']?>" type="audio/mpeg">
                                    </audio>
                                </td>
                                <td>
                                        <a href="<?=ROOT?>/admin/songs/edit/<?=$row['id']?>">
                                        <img class="bi" src="<?=ROOT?>/assest/icons/pencil.svg">     
                                        </a>
                                        <a href="<?=ROOT?>/admin/songs/delete/<?=$row['id']?>">
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