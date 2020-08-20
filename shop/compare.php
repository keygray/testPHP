<?php
	include 'inc/header.php';
	// include 'inc/slider.php';
?>
<?php
	if(isset($_GET['delId'])){
		$id = $_GET['delId'];
		$del_compare = $product->del_compare($id);
	}
?>
		<div class="main">
			<div class="content">
				<div class="cartoption">
					<div class="cartpage">
						<h2>Compare</h2>
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
								<th width="20%">ID COMPARE</th>
								<th width="20%">Product Name</th>
								<th width="20%">Image</th>
								<th width="20%">Price</th>
								<th width="10%" colspan="2">Action</th>
							</tr>
							<?php
								$customer_id = Session::get('customer_Id');
								$get_compare = $product->get_compare($customer_id);
								if($get_compare){
									$i=0;
									while($result = $get_compare->fetch_assoc()){
										$i++;
							?>
							<tr>
								<td><?php echo $i;?></td>
								<td><?php echo $result['productName'];?></td>
								<td><img src="admin/upload/<?php echo $result['image'];?>" alt="" /></td>
								<td><?php echo $result['price']?></td>
								<td><a href="details.php?proid=<?php echo $result['productId'];?>">View</a></td>
								<td><a href="?delId=<?php echo $result['id'];?>">Remove</a></td>
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
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		</div>
<?php 
	include 'inc/footer.php'
?>