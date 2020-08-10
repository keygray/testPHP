<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/category.php';?>
<?php
	$cat = new category();
	if(isset($_GET['delId'])){
		   $id = $_GET['delId'];
		   $deleteCat = $cat->delete_category($id);
	}
?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Category List</h2>
                <div class="block">     
				<?php
                    if(isset($deleteCat)){
                        echo $deleteCat;
                    }
                ?>
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>Serial No.</th>
							<th>Category Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$show_cat = $cat->show_category();
						// nếu có biến tức true
						if($show_cat){
							$i=0;
							// lấy kết quả lấy ra được từ show_Cat truyền vào biến result (biến này đặt tên tùy ý)
							while($result = $show_cat->fetch_assoc()){
								$i++;		
					?>
						<tr class="odd gradeX">
							<td><?php echo $i; ?></td>
							<!-- lấy biến từ database -->
							<td><?php echo $result['catName']; ?></td>
							<td><a href="catedit.php?catId=<?php echo $result['catId']; ?> ">Edit</a> || <a onclick="return confirm('Are you sure to delete ?')" href="?delId=<?php echo $result['catId']; ?> ">Delete</a></td>
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

