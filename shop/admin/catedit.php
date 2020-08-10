<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
    include '../classes/category.php';
?>
<?php
   $cat = new category();
?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Edit New Category</h2>
               
               <div class="block copyblock"> 
               <?php
                    if(isset($insertCat)){
                        echo $insertCat;
                    }
                ?>
                 <form action="catadd.php" method="post">
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text" name="catName" placeholder="Edit Category Name..." class="medium" />
                            </td>
                        </tr>
						<tr> 
                            <td>
                                <input type="submit" name="submit" Value="Save" />
                            </td>
                        </tr>
                    </table>
                    </form>
                </div>
            </div>
        </div>
<?php include 'inc/footer.php';?>