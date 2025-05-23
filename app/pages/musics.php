<?php require page('includes/header')?>
   
            <section>
                <img class="back" src="<?=ROOT?>/assest/images/back.jpg">
            </section>

            <section class="content">
                <?php
                $rows = db_query("select * from songs order by id desc limit 16");
                ?>

                <?php if(!empty($rows)):?>
                    <?php foreach($rows as $row):?>
                        <?php include page('includes/song')?>
                        <?php endforeach;?>
                        <?php endif;?>

                        
            </section>




            <script src="<?=ROOT?>/assest/js/menu-popper.js"></script>
    </body>
    <?php require page('includes/footer')?>
</html>