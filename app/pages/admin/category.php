<?php 
if($action == 'add')

{


$errors = [];


if($_SERVER['REQUEST_METHOD'] == "POST")
{
       
        
        //data validation
        // for category
        if(empty($_POST['category']))
        {
                $errors['category'] = "A category is requuired";
        }
        elseif(!preg_match("/^[a-zA-Z \&\-]+$/" , $_POST['category'] ))
        {
                $errors['category'] = "A category can ony have letter and spaces";
        }


         if(empty($errors))
       { // insertion of category
        $values=[];
        $values['category'] = trim($_POST['category']);
        $values['disabled'] = trim($_POST['disabled']);
       
        $query = "insert into category (category,disabled) values (:category,:disabled)";
        db_query($query,$values);
        message("category created sucessfully");
        redirect('admin/category');
       }
        
}
}    //wdit to save
else  
if($action == 'edit')   //edit to save
{
        
        $query =" select * from category  where id = :id limit 1";
        $row = db_query_one($query,['id'=>$id]);
       

$errors = [];


if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
{
       
        
        
        if(empty($_POST['category']))
        {
                $errors['category'] = "A category is required";
        }
        elseif(!preg_match("/^[a-zA-Z \&\-]+$/" , $_POST['category'] ))
        {
                $errors['category'] = "A category can ony have letter with no spaces";
        }

        

       if(empty($errors))
       { // insertion of category
        $values=[];
        $values['category'] = trim($_POST['category']);
        $values['disabled'] = trim($_POST['disabled']);
        $values['id'] = $id;

        $query = "update category set  category = :category, disabled = :disabled where id = :id limit 1";
        db_query($query,$values);
        message("category edited sucessfully");
        redirect('admin/category');
       }
        
}
}else
if($action == 'delete')   //for delete
{
        
        $query =" select * from category  where id = :id limit 1";
        $row = db_query_one($query,['id'=>$id]);
       

$errors = [];


if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
{
       
       if(empty($errors))
       { // insertion of category
        $values=[];
        $values['id'] = $id;

        $query = "delete from category where id = :id limit 1";
              
       
       
        db_query($query,$values);
        message("category deleted sucessfully");
        redirect('admin/category');
       }
        
}
}    //end delete
?>

<?php require page('includes/admin-header') ?>

        <section class="admin-content" style="width:1250px; min-height:200px;">

        <?php if($action == 'add'):?>        <!--adding category add adda-->

            <div style="max-width:500px; margin:auto;">
                <form method="post" >
                        <h3>Add New Category</h3>
                        <input class="form-control my-1" value="<?=set_value('category')?>" type="text" name="category" placeholder="Categorn Name">
                        <?php if(!empty($errors['category'])):?>
                        <small class="error"><?=$errors['category']?></small>
                        <?php endif;?>

                        <select name="disabled" class="form-control my-1">
                                <option value="">--Select Active--</option>
                                <option <?=set_select('disabled','1')?> value="1">Yes</option>
                                <option <?=set_select('disabled','0')?> value="0">No</option>
                        </select>
                         <?php if(!empty($errors['disabled'])):?>
                        <small class="error"><?=$errors['disabled']?></small>
                        <?php endif;?>

                        <button class="btn bg-orange">Create</button>
                        <a href="<?=ROOT?>/admin/category">
                            <button type="button" class="float-end btn">Back</button>
                        </a>
                </form>
            </div>   <!--end add-->
        
        <?php elseif($action == 'edit'):?>   <!---edit category     edit edit-->
               
                <div style="max-width:500px; margin:auto;">
                <form method="post" >
                        <h3>Edit category</h3>

                        <?php if(!empty($row)):?>

                        <input class="form-control my-1" value="<?=set_value('category',$row['category'])?>" type="text" name="category" placeholder="category">
                        <?php if(!empty($errors['category'])):?>
                        <small class="error"><?=$errors['category']?></small>
                        <?php endif;?>

                        <select name="disabled" class="form-control my-1">
                                <option value="">--Select Active--</option>
                                <option <?=set_select('disabled','1',$row['disabled'])?> value="1">Yes</option>
                                <option <?=set_select('disabled','0',$row['disabled'])?> value="0">No</option>
                        </select><button class="btn bg-orange">Save</button>
                        <a href="<?=ROOT?>/admin/category">
                            <button type="button" class="float-end btn">Back</button>
                        </a>
                        <?php else:?>
                        <div class="alert">That record was not found</div>
                        <a href="<?=ROOT?>/admin/category">
                            <button type="button" class="float-end btn">Back</button>
                        </a>
                        <?php endif;?>
                </form>
            </div>

        <?php elseif($action == 'delete'):?> <!--to delete the category or admin-->
               
                <div style="max-width:500px; margin:auto;">
                <form method="post" >
                        <h3>Delete category</h3>

                        <?php if(!empty($row)):?>

                        <div class="form-control my-1" ><?=set_value('category',$row['category'])?></div>
                        <?php if(!empty($errors['category'])):?>
                        <small class="error"><?=$errors['category']?></small>
                        <?php endif;?>


                         <button class="btn bg-redd">Delete</button>
                        <a href="<?=ROOT?>/admin/category">
                            <button type="button" class="float-end btn">Back</button>
                        </a>
                        <?php else:?>
                        <div class="alert">That record was not found</div>
                        <a href="<?=ROOT?>/admin/category">
                            <button type="button" class="float-end btn">Back</button>
                        </a>
                        <?php endif;?>
                </form>
            </div>

        <?php else:?>  
                
<!--displaying category-->
                <?php
                $query = "select * from category order by id desc limit 20";
                $rows = db_query($query);
                ?>

                <h3>category 
                        <a href="<?=ROOT?>/admin/category/add">
                        <button class="float-end btn bg-purple">Add New</button>
                        </a>
                </h3>

                <table class="table">
                        <tr>
                                <th>ID</th>
                                <th>Category</th>
                                <th>Active</th>
                                <th>Action</th>

                                
                        </tr>
                        <?php if(!empty($rows)):?>
                                <?php foreach($rows as $row):?>
                         <tr>
                                <td><?=$row['id']?></td>
                                <td><?=$row['category']?></td>
                                <td><?=$row['disabled']? 'No':'Yes'?></td>
                                
                                <td>
                                        <a href="<?=ROOT?>/admin/category/edit/<?=$row['id']?>">
                                        <img class="bi" src="<?=ROOT?>/assest/icons/pencil.svg">     
                                        </a>
                                        <a href="<?=ROOT?>/admin/category/delete/<?=$row['id']?>">
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