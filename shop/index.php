<?php
	include 'inc/header.php';
	include 'inc/slider.php';
?>
<style type="text/css">
.images_1_of_4{
	margin-left: 2px;
    margin-right: 12px;
}
</style>
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
				<a href="details.php"><img style=" height: 300px;object-fit: contain;" src="admin/upload/<?php echo $result['image'];?>" alt="" /></a>
				<h2 style=" font-weight: bold;font-style: italic;"><?php echo $result['productName'];?></h2>
				<h4 style="font-size: 1.2rem;font-weight: 400;color: var(--text-color);line-height: 1.5rem;height: 3rem;overflow: hidden;display: block;display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 2;" class="text_desc"><?php echo $result['product_desc'];?></h4>
				<p><span class="price"><?php echo $fm->money($result['price'])." "."VND";?></span></p>
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
			<a href="details.php"><img style=" height: 300px;object-fit: contain;" src="admin/upload/<?php echo $result_new['image'];?>" alt="" /></a>
				<h2 style=" font-weight: bold;font-style: italic;"><?php echo $result_new['productName'];?></h2>
				<h4 style="font-size: 1.2rem;font-weight: 400;color: var(--text-color);line-height: 1.5rem;height: 3rem;overflow: hidden;display: block;display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 2;" class="text_desc"><?php echo $result_new['product_desc'];?></h4>
				<p><span class="price"><?php echo $fm->money($result_new['price'])." "."VND";?></span></p>
				<!-- lấy ra details sản phẩm cũng truyền vô id giống với edit -->
				<div class="button"><span><a href="details.php?proid=<?php echo $result_new['productId'];?>" class="details">Details</a></span></div>
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