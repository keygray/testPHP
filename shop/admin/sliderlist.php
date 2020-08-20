<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php include '../classes/product.php';?>
<?php
	$product = new product();
	if(isset($_GET['delId'])){
		$id = $_GET['delId'];
		$del_slider = $product->del_slider($id);
	}
	// cập nhật type
	if(isset($_GET['typeId']) && isset($_GET['type'])){
		$typeid = $_GET['typeId'];
		$type= $_GET['type'];
		$update_type_slider = $product->update_type_slider($typeid,$type);
	}
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Slider List</h2>
        <div class="block">  
            <table class="data display datatable" id="example">
			<thead>
				<tr>
					<th>No.</th>
					<th>Slider Title</th>
					<th>Slider Image</th>
					<th>Trạng thái</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$show_slider = $product->show_slider();
					if($show_slider){
						$i=0;
						while($result = $show_slider->fetch_assoc()){
							$i++;
				?>
				<tr class="odd gradeX">
					<td><?php echo $i;?></td>
					<td><?php echo $result['sliderName'];?></td>
					<td><img src="upload/<?php echo $result['sliderImage'];?>" height="40px" width="60px"/></td>
					<!-- cài thêm giá trị ngược với type để khi update sẽ ra giá trị muốn update
						ví dụ đang OFF là 0, ON là 1
						thì ta truyền thêm type cho OFF là 1 để khi nhấn vào sẽ update type trong DB thành 1 => ON
						và ngược lại -->
					<td><?php if($result['type'] == 0){?>
						<a href="?typeId=<?php echo $result['sliderId'];?>&type=1" style="color:red;">OFF</a>
					<?php
					}else {
					?>
					<a href="?typeId=<?php echo $result['sliderId'];?>&type=0" style="color:green;">ON</a>
					<?php
						}
					?>
					</td>				
					<td>
						<a href="slideredit.php?sliderId=<?php echo $result['sliderId'];?>">Edit</a> || 
						<a href="?delId=<?php echo $result['sliderId'];?>" onclick="return confirm('Are you sure to Delete!');" >Delete</a> 
					</td>
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
