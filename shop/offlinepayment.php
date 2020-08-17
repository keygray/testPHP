<?php
	include 'inc/header.php';
?>
<?php
	// kiểm tra và lấy dữ liệu từ biến đã khai báo
	 if(isset($_GET['order_id']) && $_GET['order_id'] == 'order'){
		$customer_id = Session::get('customer_Id');
		$insertOrder = $ct->insertOrder($customer_id);

		// nếu mà insert thành công vô order rồi thì sẽ delete cart
		$delCart = $ct->del_all_cart_customer();
		header('Location: success.php');
    }
// 	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
// 		// tạo biến số lượng
// 		$quantity = $_POST['quantity'];
// 		$AddtoCart = $ct->add_to_cart($quantity,$id) ;
//    }
?>
<style text="text/css">
	.box-left{
		margin-bottom: 16px;
	}
	.box-right {
		border : 1px solid red;
		margin: 16px 0;
	}
	.order{
		text-align:center;
		display: block;
    margin: auto;
    width: 25%;
    height: 5%;
    font-size: 1.2rem;
    color: white;
    background-color: aqua;
    outline: none;
    border: none;
    border-radius: 4px;
	}
</style>
<form action="" method="POST">
		<div class="main">
			<div class="content">
				<div class="section group">
				<h3>Paymend Offline</h3>
				<div class="box-left">
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
									<th width="15%">Price</th>
									<th width="25%">Quantity</th>
									<th width="20%">Total Price</th>
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
									<td><?php echo $result['price']?></td>
									<td>
									<?php echo $result['quantity'];?>
									</td>
									<td><?php 
									// tổng giá bằng sô lượng nhân sản phẩm
									$total = $result['quantity'] * $result['price'];
									echo $total;
									?></td>
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
										echo $subtotal;
										Session::set('sum',$subtotal);
										Session::set('quantity',$quantity);
										?>
									</td>
								</tr>
								<tr>
									<th>VAT : </th>
									<td>10% =(<?php echo $vat = $subtotal * 0.1; ?>)</td>
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
							<?php
									}else{
										echo '<span style="color:red">empty</span>';
									}
							?>
						</div>
					</div>
				</div>
				<h4>Thông tin đặt hàng</h4>
				<div class="box-right">
					<table class="tblone">
                    <?php
                        $id = Session::get('customer_Id');
                        $get_customers = $cs->show_customers($id);
                        if($get_customers){
                            while($result = $get_customers->fetch_assoc()){
                    ?>
                    <tr>
                    <td>Name</td>
                    <td>:</td>
                    <td><?php echo $result['name'];?></td>
                    </tr>
                    <tr>
                    <td>Addess</td>
                    <td>:</td>
                    <td><?php echo $result['address'];?></td>
                    </tr>
                    <tr>
                    <td>City</td>
                    <td>:</td>
                    <td><?php echo $result['city'];?></td>
                    </tr>
                    <tr>
                    <td>Country</td>
                    <td>:</td>
                    <td><?php echo $result['country'];?></td>
                    </tr>
                    <tr>
                    <td>Zipcode</td>
                    <td>:</td>
                    <td><?php echo $result['zipcode'];?></td>
                    </tr>
                    <tr>
                    <td>Phone</td>
                    <td>:</td>
                    <td><?php echo $result['phone'];?></td>
                    </tr>
                    <tr>
                    <td>Email</td>
                    <td>:</td>
                    <td><?php echo $result['email'];?></td>
                    </tr>
                    <tr>
                        <td colspan="3" ><a href="editprofile.php">Update Profile<a></td>
                    </tr>
                    <?php
                           
                        }
                    }
                    ?>
                    </table>
				</div>
				
				</div>
			</div>
			<a href="?order_id=order" class="order">Order</a>
		</div>
				</form>
<?php 
	include 'inc/footer.php'
?>