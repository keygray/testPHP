<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/category.php';?>
<?php include '../classes/brand.php';?>
<?php include '../classes/product.php';?>
<?php
    $pd = new product();
    if(!isset($_GET['productId']) || $_GET['productId'] == NULL){
        echo "<script>window.location = 'productlist.php'</script>";
    }
    else{
        $id = $_GET['productId'];
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
        // kiểm tra 2 biến này bằng function trong class adminlogin
        $updateProduct = $pd->update_category($_POST,$_FILES,$id) ;
    }
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Sửa New Product</h2>
        <div class="block">    
        <?php
            if(isset($updateProduct)){
                echo $updateProduct;
            }
        ?> 
        <?php
            $get_product_by_id = $pd->getproductbyId($id);
            if($get_product_by_id){
                while($result_product = $get_product_by_id->fetch_assoc()){
        ?>
         <!--Khi mà thêm hình ảnh thì bắt buộc phải có enctype  -->
         <form action="" method="post" enctype="multipart/form-data">
            <table class="form">
               
                <tr>
                    <td>
                        <label>Name</label>
                    </td>
                    <td>
                        <input type="text" name="productName" value="<?php echo $result_product['productName'];?>" placeholder="Enter Product Name..." class="medium" />
                    </td>
                </tr>
				<tr>
                    <td>
                        <label>Category</label>
                    </td>
                    <td>
                        <select id="select" name="category">
                            <option>Select Category</option>
                            <?php
                                $cat = new category();
                                $catlist = $cat->show_category();
                                if($catlist){
                                    while($result = $catlist->fetch_assoc()){
                            ?>
                            <!-- Thêm vào bảng là Id nhưng hiển thị là name-->
                            <option
                            <?php
                                //CHÚ Ý ------------------------------------------THIS
                                // lấy ra phần tử được chọn 
                                // nếu phần tử trong biến result bằng biến id lấy trong sp result_product thì cho selected cái đó
                                if($result['catId']==$result_product['catId']){
                                    echo 'selected';
                                }
                            ?>
                             value="<?php echo $result['catId']?>"><?php echo $result['catName']?></option>
                            <?php
                                 }
                                }
                            ?>
                        </select>
                    </td>
                </tr>
				<tr>
                    <td>
                        <label>Brand</label>
                    </td>
                    <td>
                        <select id="select" name="brand">
                            <option>Select Brand</option>
                            <?php
                                $brand = new brand();
                                $brandlist = $brand->show_brand();
                                if($brandlist){
                                    while($result = $brandlist->fetch_assoc()){
                            ?>
                            <option
                            <?php
                                //CHÚ Ý ------------------------------------------THIS
                                // lấy ra phần tử được chọn 
                                // nếu phần tử trong biến result bằng biến id lấy trong sp result_product thì cho selected cái đó
                                if($result['brandId']==$result_product['brandId']){
                                    echo 'selected';
                                }
                            ?>
                             value="<?php echo $result['brandId']?>"><?php echo $result['brandName']?></option>
                            <?php
                                    }
                                }
                            ?>
                        </select>
                    </td>
                </tr>
				
				 <tr>
                    <td style="vertical-align: top; padding-top: 9px;">
                        <label>Description</label>
                    </td>
                    <td>
                        <textarea name="product_desc" class="tinymce"><?php echo $result_product['product_desc'];?></textarea>
                    </td>
                </tr>
				<tr>
                    <td>
                        <label>Price</label>
                    </td>
                    <td>
                        <input type="text" name="price" value="<?php echo $result_product['price'];?>" placeholder="Enter Price..." class="medium" />
                    </td>
                </tr>
            
                <tr>
                    <td>
                        <label>Upload Image</label>
                    </td>
                    <td>
                        <img src="upload/<?php echo $result_product['image']; ?>" width="80"><br>
                        <input type="file" name="image"/>
                    </td>
                </tr>
				
				<tr>
                    <td>
                        <label>Product Type</label>
                    </td>
                    <td>
                        <select id="select" name="type">
                            <option>Select Type</option>
                            <!-- đặt value giá trị nổi bật là 1 không nổi bật là 0 -->
                            <?php
                                if($result_product['type']==0){
                            ?>
                            <option selected value="1">Featured</option>
                            <option value="0">Non-Featured</option>
                            <?php
                                }else{
                            ?>
                            <option  value="1">Featured</option>
                            <option selected value="0">Non-Featured</option>
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


