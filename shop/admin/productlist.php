<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/category.php';?>
<?php include '../classes/brand.php';?>
<?php include '../classes/product.php'?>
<!-- gọi format để dùng hàm text-shorten để giới hạn chữ 1 dòng -->
<?php include_once '../helper/format.php'?>
<?php
	$pd = new product();
	$fm = new Format();
	if(isset($_GET['delId'])){
		$id = $_GET['delId'];
		$deleteProduct = $pd->delete_product($id);
 	}
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Product List</h2>
        <div class="block">  
            <table class="data display datatable" id="example">
			<thead>
				<tr>
					<th>ID</th>
					<th>Product Name</th>
					<th>Product Price</th>
					<th>Product Image</th>
					<th>Category</th>
					<th>Brand</th>
					<th>Description</th>
					<th>Type</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$pd_list = $pd->show_product();
					if($pd_list){
						$i=0;
						while($result = $pd_list->fetch_assoc()){
							$i++;
				?>
				<tr class="odd gradeX">
					<td><?php echo $i;?></td>
					<td><?php echo $result['productName']?></td>
					<td><?php echo $result['price']?></td>
					<!-- lấy ra phần ảnh từ folder upload dẫn đến link-->
					<td><img src="upload/<?php echo $result['image']; ?>" width="80"></td>
					<td><?php echo $result['catName']?></td>
					<td><?php echo $result['brandName']?></td>
					<!-- text-shortten có 2 biến 1 là text 2 là số lượng kí tự muốn giới han -->
					<td><?php echo $fm->textShorten($result['product_desc'], 50);?></td>
					<td>
					<?php
					// vì ta set value cho type truyền vào chỉ là 0 và 1 trong csdl nên ta lấy ra chữ với lệnh như sau
						if($result['type']=="0"){
							echo 'Favourite';
						}
						else {
							echo 'Nonfavourite';
						}
					?>
					</td>
					<td><a href="productedit.php?productId=<?php echo $result['productId']; ?>">Edit</a> || <a onclick="return confirm('Are you sure to delete ?')" href="?delId=<?php echo $result['productId']; ?>">Delete</a></td>
				</tr>
				<?php
						}
					}
				?>
			</tbody>
		</table>

       </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();
        $('.datatable').dataTable();
		setSidebarHeight();
    });
</script>
<?php include 'inc/footer.php';?>
