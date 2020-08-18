<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
	    $filepath = realpath(dirname(__FILE__));
		// goi den cong viec ma ham can thuc hien
		include_once ($filepath.'/../classes/cart.php');
		// include_once ($filepath.'/../helper/format.php'); 
		// theo phân tích thì không cần icl file format ở đây vì chính trong file cart đã được include format rồi
?>
<?php
	$ct = new cart();
	if(isset($_GET['shiftId'])){
		$id=$_GET['shiftId'];
		$time = $_GET['time'];
		$price = $_GET['price'];
		$shifted = $ct->shifted($id,$time,$price);
	}
	if(isset($_GET['delId'])){
		$delid=$_GET['delId'];
		$time = $_GET['time'];
		$price = $_GET['price'];
		$del_order = $ct->del_order($delid,$time,$price);
	}
?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Inbox</h2>
                <div class="block">        
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>No.</th>
							<th>Order Time</th>
							<th>Product</th>
							<th>Quantity</th>
							<th>Price</th>
							<th>Address</th>
							<th>Action</th>
						</tr>

					</thead>
					<tbody>
					<?php
						$fm = new format();
						$ct = new cart();
						$get_inbox_cart = $ct->get_inbox_cart();
						if($get_inbox_cart){
							$i=0;
							while($result = $get_inbox_cart->fetch_assoc()){
								$i++;
					?>
						<tr class="odd gradeX">
							<td><?php echo $i;?></td>
							<td><?php echo $fm->formatDate($result['date_order']);?></td>
							<td><?php echo $result['productName'];?></td>
							<td><?php echo $result['quantity'];?></td>
							<td><?php echo $result['price'];?></td>
							<td><a href="customer.php?customerId=<?php echo $result['customer_id']; ?>" class="">View Details Cus</a></td>
							<td>
								<?php
								if($result['status'] == 0){
								?>
								<a href="?shiftId=<?php echo $result['id'];?>&price=<?php echo $result['price'];?>&time=<?php echo $result['date_order'];?> " class="">Chờ xử lý</a>
								<?php
								} elseif($result['status'] == 1) {
									echo '<p>Đang vận chuyển...Và chờ khách hàng xác nhận</p>';
								}else{
								?>
								<a href="?delId=<?php echo $result['id'];?>&price=<?php echo $result['price'];?>&time=<?php echo $result['date_order'];?>" class="" style="color:red;">Xóa</a>
								<?php
								}
								?>
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
