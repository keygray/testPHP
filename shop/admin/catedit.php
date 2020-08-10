<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
    include '../classes/category.php';
?>
<?php
   $cat = new category();
    // kiểm tra nếu không xuất hiện hoặc null thì trở về trang List còn không thì lấy biến id trên url
   if(!isset($_GET['catId']) || $_GET['catId'] == NULL){
    echo "<script>window.location = 'catlist.php'</script>";
   }
   else{
       $id = $_GET['catId'];
   }
   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // từ form lấy dữ liệu 
    $catName = $_POST['catName'];
    // kiểm tra 2 biến này bằng function trong class adminlogin
    $updateCat = $cat->update_category($catName,$id) ;
}
?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Edit New Category</h2>
               
               <div class="block copyblock"> 
               <?php
                    if(isset($updateCat)){
                        echo $updateCat;
                    }
                ?>
                <?php
                    // tạo một đối tượng kết nối với function getcatbyid của đối tượng cat
                    $get_cat_name = $cat->getcatbyId($id);
                    // nếu tồn tại thì thực thi
                    if($get_cat_name){
                        // tạo biến result với giá trị lấy từ biến get_Cat_name
                        // lặp qua một lần lấy 1 giá trị
                        while ($result = $get_cat_name->fetch_assoc()) {
                            
                ?>
                <!-- chú ý : chỗ này action không được ghi với Edit vì nếu ta submit nó sẽ trả về chính trang này và không mang theo
                giá trị id mà chúng ta truyền cho nên nếu ghi vào là catedit.php sẽ không update đc -->
                 <form action="" method="post">
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text" value="<?php echo $result['catName'] ?>" name="catName" placeholder="Edit Category Name..." class="medium" />
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