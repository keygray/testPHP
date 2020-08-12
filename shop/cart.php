<?php
	include 'inc/header.php';
	include 'inc/slider.php';
?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
	// update số lượng sản phẩm
	$cartId= $_POST['cartId'];
	// tạo biến số lượng
	$quantity = $_POST['quantity'];
	$update_quantity_cart = $ct->update_quantity_cart($quantity,$cartId) ;
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
									while($result = $get_product_cart->fetch_assoc()){
							?>
							<tr>
								<td><?php echo $result['productName'];?></td>
								<td><img src="admin/upload/<?php echo $result['image'];?>" alt="" /></td>
								<td><?php echo $result['price']?></td>
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
								echo $total;
								?></td>
								<td><a href="">X</a></td>
							</tr>
							<?php
							// giá tổng tính
							$subtotal += $total;
								}
							}
							?>
						</table>
						<table style="float:right;text-align:left;" width="40%">
							<tr>
								<th>Sub Total : </th>
								<td>
									<?php
									echo $subtotal;
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
								echo $gtotal;
								?>
								</td>
							</tr>
						</table>
					</div>
					<div class="shopping">
						<div class="shopleft">
							<a href="index.html"> <img src="images/shop.png" alt="" /></a>
						</div>
						<div class="shopright">
							<a href="login.html"> <img src="images/check.png" alt="" /></a>
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