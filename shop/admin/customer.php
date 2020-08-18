<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
	    $filepath = realpath(dirname(__FILE__));
		// goi den cong viec ma ham can thuc hien
		include_once ($filepath.'/../classes/customer.php');
?>
<?php
   $cs = new customer();
    // kiểm tra nếu không xuất hiện hoặc null thì trở về trang List còn không thì lấy biến id trên url
   if(!isset($_GET['customerId']) || $_GET['customerId'] == NULL){
    echo "<script>window.location = 'inbox.php'</script>";
   }
   else{
       $id = $_GET['customerId'];
   }

?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Edit New Category</h2>
               
               <div class="block copyblock"> 
                <?php
                    // tạo một đối tượng kết nối với function getcatbyid của đối tượng cat
                    $get_cs_name = $cs->show_customers($id);
                    // nếu tồn tại thì thực thi
                    if($get_cs_name){
                        // tạo biến result với giá trị lấy từ biến get_Cat_name
                        // lặp qua một lần lấy 1 giá trị
                        while ($result = $get_cs_name->fetch_assoc()) {
                            
                ?>
                <!-- chú ý : chỗ này action không được ghi với Edit vì nếu ta submit nó sẽ trả về chính trang này và không mang theo
                giá trị id mà chúng ta truyền cho nên nếu ghi vào là catedit.php sẽ không update đc -->
                 <form action="" method="post">
                    <table class="form">					
                        <tr>
                            <td>
                                Name:
                            </td>
                            <td>
                                <input type="text" value="<?php echo $result['name'] ?>" readonly="readonly" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                City:
                            </td>
                            <td>
                                <input type="text" value="<?php echo $result['city'] ?>" readonly="readonly" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Phone:
                            </td>
                            <td>
                                <input type="text" value="<?php echo $result['phone'] ?>" readonly="readonly" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Zipcode:
                            </td>
                            <td>
                                <input type="text" value="<?php echo $result['zipcode'] ?>" readonly="readonly" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Email:
                            </td>
                            <td>
                                <input type="text" value="<?php echo $result['email'] ?>" readonly="readonly" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Address:
                            </td>
                            <td>
                                <input type="text" value="<?php echo $result['address'] ?>" readonly="readonly" class="medium" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Country:
                            </td>
                            <td>
                                <input type="text" value="<?php echo $result['country'] ?>" readonly="readonly" class="medium" />
                            </td>
                        </tr>
						<tr> 
                            <td>
                                <a href="inbox.php" class="">Back</a>
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