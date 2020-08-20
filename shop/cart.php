<?php
	include 'inc/header.php';
?>
<?php
	if(isset($_GET['delId'])){
		$delid = $_GET['delId'];
		$deleteCart = $ct->delete_product_cart($delid);
	}
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
		// update số lượng sản phẩm
		$cartId= $_POST['cartId'];
		// tạo biến số lượng
		$quantity = $_POST['quantity'];
		$update_quantity_cart = $ct->update_quantity_cart($quantity,$cartId) ;
		// giả dụ không cho số lượng min = 1 thì ta có thể xử lý âm sẽ xóa đi như sau
		// if($quantity <= 0){
		// 	$deleteCart = $ct->delete_product_cart($cartId);
		// }
	}
	// nêu thêm sản phẩm id sẽ đc live và sẽ tự cập nhật vô giỏ hàng
	if(!isset($_GET['id'])){
		echo "<meta http-equiv='refesh' content='0;URL=?id=live'>";
	}

?> 
		<div class="main">
			<div class="content">
				<div class="cartoption">
					<div class="cartpage">
						<h2>Your Cart</h2>
						<?php
						if(isset($update_quantity_cart)){
							echo $update_quantity_cart;
						}
						?>
						<?php
						if(isset($deleteCart)){
							echo $deleteCart;
						}
						?>
						<table class="tblone">
							<tr>
								<th width="20%">Product Name</t>
								<th width="10%">Image</th>
								<th width="15%">Price</th>
								<th width="25%">Quantity</th>
								<th width="20%">Total Price</th>
								<th width="10%">Action</th>
							</tr>
							<?php
								$get_product_cart = $ct->get_product_cart();
								if($get_product_cart){
									// giá tổng
									$subtotal=0;
									$quantity=0;
									while($result = $get_product_cart->fetch_assoc()){
							?>
							<tr>
								<td><?php echo $result['productName'];?></td>
								<td><img src="admin/upload/<?php echo $result['image'];?>" alt="" /></td>
								<td><?php echo $fm->money($result['price'])?></td>
								<td>
									<form action="" method="post">
									<!-- cập nhật số lượng qua cartId -->
										<input type="hidden" name="cartId" value="<?php echo $result['cartId'];?>" />
										<input type="number" min="1" name="quantity" value="<?php echo $result['quantity'];?>" />
										<input type="submit" name="submit" value="Update" />
									</form>
								</td>
								<td><?php 
								// tổng giá bằng sô lượng nhân sản phẩm
								$total = $result['quantity'] * $result['price'];
								echo $fm->money($total);
								?></td>
								<td><a href="?delId=<?php echo $result['cartId'];?>">Xóa</a></td>
							</tr>
							<?php
							// giá tổng tính
							$subtotal += $total;
							$quantity += $result['quantity'];
								}
							}
							?>
						</table>
						<?php
						//kiểm tra xem giỏ hàng có hàng không để tránh bị lỗi giá nếu có thì mới hiển thị giá ko thì thôi
								$checkcart = $ct->checkcart();
								if($checkcart){
							?>
						<table style="float:right;text-align:left;" width="40%">
							<tr>
								<th>Sub Total : </th>
								<td>
									<?php
									// xử lý bài toán 
									echo $fm->money($subtotal);
									Session::set('sum',$subtotal);
									Session::set('quantity',$quantity);
									?>
								</td>
							</tr>
							<tr>
								<th>VAT : </th>
								<td>10%</td>
							</tr>
							<tr>
								<th>Grand Total :</th>
								<td>
								<?php
								$vat = $subtotal * 0.1;
								$gtotal = $subtotal + $vat;
								echo $fm->money($gtotal);
								?>
								</td>
							</tr>
						</table>
						<?php
								}else{
									echo '<span style="color:red">empty</span>';
								}
						?>
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