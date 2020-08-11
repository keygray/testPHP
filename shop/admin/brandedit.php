<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
    include '../classes/brand.php';
?>
<?php
   $brand = new brand();
   if(!isset($_GET['brandId']) || $_GET['brandId'] == NULL){
    echo "<script>window.location = 'brandlist.php'</script>";
   }
   else{
       $id = $_GET['brandId'];
   }
   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       // từ form lấy dữ liệu 
       $brandName = $_POST['brandName'];
       // kiểm tra 2 biến này bằng function trong class adminlogin
       $updateBrand = $brand->update_brand($brandName,$id) ;
}
?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Add New Branch</h2>
               
               <div class="block copyblock"> 
               <?php
                    if(isset($updateBrand)){
                        echo $updateBrand;
                    }
                ?>
                <?php
                    $get_brand_name = $brand->getbrandbyId($id);
                    if ($get_brand_name){
                        while($result = $get_brand_name->fetch_assoc()){
                ?>
                 <form action="" method="post">
                    <table class="form">					
                        <tr>
                            <td>
                                <input value="<?php echo $result['brandName'];?>" type="text" name="brandName" placeholder="Enter Brand Name..." class="medium" />
                            </td>
                        </tr>
						<tr> 
                            <td>
                                <input type="submit" name="submit" Value="Update" />
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
<?php include 'inc/footer.php';?>