<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/product.php';?>
<?php
    $pd = new product();
    if(!isset($_GET['sliderId']) || $_GET['sliderId'] == NULL){
        echo "<script>window.location = 'sliderlist.php'</script>";
    }
    else{
        $id = $_GET['sliderId'];
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        // kiểm tra 2 biến này bằng function trong class adminlogin
        $update_slider = $pd->update_slider($_POST,$_FILES,$id) ;
    }
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Update New Slider</h2>
    <div class="block">         
        <?php
            if(isset($update_slider)){
                echo $update_slider;
            }
            ?>
            <?php
                $get_sliderbyid = $pd->get_sliderbyid($id);
                if($get_sliderbyid){
                    while($result = $get_sliderbyid->fetch_assoc()){
           ?>      
         <form action="" method="post" enctype="multipart/form-data">
            <table class="form">     
                <tr>
                    <td>
                        <label>Title</label>
                    </td>
                    <td>
                        <input type="text" name="sliderName" placeholder="Enter Slider Title..." class="medium" 
                        value="<?php echo $result['sliderName'];?>"/>
                    </td>
                </tr>           
    
                <tr>
                    <td>
                        <label>Upload Image</label>
                    </td>
                    <td>
                        <img src="upload/<?php echo $result['sliderImage'];?>" width="80"><br>
                        <input type="file" name="image"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Type</label>
                    </td>
                    <td>
                        <select name="type" id="">
                            <?php
                                if($result['type']==1){
                            ?>
                            <option value="1" selected>ON</option>
                            <option value="0">OFF</option>
                            <?php
                                }else{
                            ?>
                            <option value="1">ON</option>
                            <option value="0" selected>OFF</option>
                            <?php
                                }
                            ?>
                        </select>
                    </td>
                </tr>
				<tr>
                    <td></td>
                    <td>
                        <input type="submit" name="submit" Value="Save" />
                    </td>
                </tr>
            </table>
            </form>
            <?php
                            }
                        }
            ?>
        </div>
    </div>
</div>
<!-- Load TinyMCE -->
<script src="js/tiny-mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        setupTinyMCE();
        setDatePicker('date-picker');
        $('input[type="checkbox"]').fancybutton();
        $('input[type="radio"]').fancybutton();
    });
</script>
<!-- Load TinyMCE -->
<?php include 'inc/footer.php';?>