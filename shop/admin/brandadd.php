<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
    include '../classes/brand.php';
?>
<?php
   $brand = new brand();
   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       // từ form lấy dữ liệu 
       $brandName = $_POST['brandName'];
       // kiểm tra 2 biến này bằng function trong class adminlogin
       $insertBrand = $brand->insert_brand($brandName) ;
}
?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Add New Branch</h2>
               
               <div class="block copyblock"> 
               <?php
                    if(isset($insertBrand)){
                        echo $insertBrand;
                    }
                ?>
                 <form action="brandadd.php" method="post">
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text" name="brandName" placeholder="Enter Brand Name..." class="medium" />
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