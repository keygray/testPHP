<?php
	include 'inc/header.php';
	include 'inc/slider.php';
?>
<div class="main">
	<!-- <?php
	// session id là mỗi giao dịch thì sẽ có giá trị riêng này, như mã số token 
		echo session_id();
	?> -->
	<div class="content">
		<div class="content_top">
			<div class="heading">
				<h3>Feature Products</h3>
			</div>
			<div class="clear"></div>
		</div>
		<div class="section group">
		<?php
			//lấy ra các sản phẩm được thịnh hành
			$product_feathered = $product->getproduct_feathered();
			if($product_feathered){
				while($result = $product_feathered->fetch_assoc()){
		?>
			<div class="grid_1_of_4 images_1_of_4">
				<a href="details.php"><img src="admin/upload/<?php echo $result['image'];?>" alt="" /></a>
				<h2><?php echo $result['productName'];?></h2>
				<p>h</p>
				<p><span class="price"><?php echo $result['price']." "."VND";?></span></p>
				<!-- lấy ra details sản phẩm cũng truyền vô id giống với edit -->
				<div class="button"><span><a href="details.php?proid=<?php echo $result['productId'];?>" class="details">Details</a></span></div>
			</div>
		<?php
					
				}
			}
		?>
		</div>
		<div class="content_bottom">
			<div class="heading">
				<h3>New Products</h3>
			</div>
			<div class="clear"></div>
		</div>
		<div class="section group">
		<?php
			//lấy ra các sản phẩm được thịnh hành
			$product_new = $product->getproduct_new();
			if($product_new){
				while($result_new = $product_new->fetch_assoc()){
		?>
			<div class="grid_1_of_4 images_1_of_4">
				<a href="details.php"><img src="admin/upload/<?php echo $result_new['image'];?>" alt="" /></a>
				<h2><?php echo $result_new['productName'];?> </h2>
				<p><span class="price"><?php echo $result_new['price']." "."VND";?></span></p>
				<div class="button"><span><a href="details.php?proid=<?php echo $result['productId'];?>" class="details">Details</a></span></div>
			</div>
		<?php
				}
			}
		?>
		</div>
	</div>
</div>
</div>
<?php 
	include 'inc/footer.php'
?>