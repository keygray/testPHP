<?php
	include 'inc/header.php';
	// include 'inc/slider.php';
?>
<?php
// kiểm tra xem người dùng đăng nhập chưa
						$check_login = Session::get('customer_login');
						if($check_login == false){
							header('Location: login.php');
						}
					?>
<?php
	if(isset($_GET['confirmId'])){
		$confirmId=$_GET['confirmId'];
		$time = $_GET['time'];
		$price = $_GET['price'];
		$confirm_shifted = $ct->confirm_shifted($confirmId,$time,$price);
	}
?>
		<div class="main">
			<div class="content">
				<div class="cartoption">
					<div class="cartpage">
						<h2>Your Details</h2>
						<!-- <?php
						if(isset($update_quantity_cart)){
							echo $update_quantity_cart;
						}
						?>
						<?php
						if(isset($deleteCart)){
							echo $deleteCart;
						}
						?> -->
						<table class="tblone">
							<tr>
								<th width="20%">Product Name</t>
								<th width="10%">Image</th>
								<th width="15%">Price</th>
								<th width="15%">Quantity</th>
                                <th width="10%">Status</th>
                                <th width="10%">Status</th>
								<th width="10%">Action</th>
							</tr>
							<?php
                                $customer_id = Session::get('customer_Id');
								$get_cat_order = $ct->get_cat_order($customer_id);
								if($get_cat_order){
									// sl
									$quantity=0;
									while($result = $get_cat_order->fetch_assoc()){
							?>
							<tr>
								<td><?php echo $result['productName'];?></td>
								<td><img src="admin/upload/<?php echo $result['image'];?>" alt="" /></td>
								<td><?php echo $result['price']?></td>
								<td>
	
										
								<?php echo $result['quantity'];?>
										
									
								</td>
                                <td><?php echo $fm->formatDate($result['date_order']);?></td>
                                <td>
                                <?php
                                    if($result['status'] == 0){
                                        echo "Chờ xử lý";
									}
									elseif($result['status'] == 1){
										echo "Đang vận chuyển";
                                    } 
                                    else {
                                        echo "Đã xác nhận lấy hàng";
                                    }
                                ?>
                                </td>
                                <!-- nếu chưa xử lý thì cho xóa còn ko thì N/A -->
                                <?php
                                if($result['status'] == 0){
                                    echo "<td>N/A</td>";
                                }
                                elseif($result['status'] == 1) { 
                                ?>
								<td><a href="?confirmId=<?php echo $result['id'];?>&price=<?php echo $result['price'];?>&time=<?php echo $result['date_order'];?> " class="" style="color:green;">Bấm vào đây để xác nhận đã nhận hàng</a></td>
								<?php
								}else{
									echo "<td>Đã nhận hàng</td>";
                                }
                                ?>
							</tr>
                            <?php
								}
							}
							?>
						</table>
						
					</div>
					<div class="shopping">
						<div class="shopleft">
							<a href="index.php"> <img src="images/shop.png" alt="" /></a>
						</div>
						<div class="shopright">
							<a href="payment.php"> <img src="images/check.png" alt="" /></a>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		</div>
<?php 
	include 'inc/footer.php'
?>