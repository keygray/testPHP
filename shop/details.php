<?php
	include 'inc/header.php';
?>
<?php
	// kiểm tra và lấy dữ liệu từ biến đã khai báo
	 if(!isset($_GET['proid']) || $_GET['proid'] == NULL){
        echo "<script>window.location = '404.php'</script>";
    }
    else{
        $id = $_GET['proid'];
	}
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
		// tạo biến số lượng
		$quantity = $_POST['quantity'];
		$AddtoCart = $ct->add_to_cart($quantity,$id) ;
   }
   $customer_id = Session::get('customer_Id');
   if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['compare'])) {
	// tạo biến số lượng
	$productId = $_POST['productid'];
	$insertCompare = $product->insertCompare($productId,$customer_id) ;
}
?>
		<div class="main">
			<div class="content">
				<div class="section group">

				<?php
					$get_product_details = $product->get_details($id);
					if($get_product_details){
						while($result = $get_product_details->fetch_assoc()){
				?>
					<div class="cont-desc span_1_of_2">
						<div class="grid images_3_of_2">
							<img src="admin/upload/<?php echo $result['image'];?>" alt="" />
						</div>
						<div class="desc span_3_of_2">
							<h2><?php echo $result['productName'];?></h2>
							<p><?php echo  $fm->textshorten($result['product_desc'], 150);?></p>
							<div class="price">
								<p>Price: <span><?php echo $result['price']." "."VND";?></span></p>
								<p>Category: <span><?php echo $result['catName'];?></span></p>
								<p>Brand:<span><?php echo $result['brandName'];?></span></p>
							</div>
							<div class="add-cart">
							<!-- gửi cart đến chính trang náy -->
								<form action="" method="post">
								<!-- nhỏ nhất = 1 để không bị âm số lượng min=1 -->
									<input type="number" class="buyfield" name="quantity" value="1" min="1" />
									<input type="submit" class="buysubmit" name="submit" value="Buy Now" />
								</form>
								<?php
										if(isset($AddtoCart)){
											echo $AddtoCart;
										}
								?>
							</div>
							<div class="add-cart">
										<form action="" method="POST">
										<!-- <a href="?likelist=<?php echo $result['productId'];?>" class="buysubmit">Lưu vào danh sách iu thích</a>
										<a href="?compare=<?php echo $result['productId'];?>" class="buysubmit">So sánh sản phẩm</a> -->
										<input type="hidden" name="productid" value="<?php echo $result['productId'];?>">
										<?php
											$login_check = Session::get('customer_login');
											if($login_check){
												echo '<input type="submit" class="buysubmit" name="compare" value="Compare" />';
												echo '<input type="submit" class="buysubmit" name="wishlist" value="Save to wishlist" />';
											}
											else {
												echo '';
											}
										?>
										<?php
											if(isset($insertCompare)){
												echo $insertCompare;
											}
										?>
										</form>
										
							</div>
						</div>
						<div class="product-desc">
							<h2>Product Details</h2>
							<p><?php echo $result['product_desc'];?></p>
						</div>
						<?php	
							}
						}
						?>
					</div>

					<div class="rightsidebar span_3_of_1">
						<h2>CATEGORIES</h2>
						<?php
							$getall_category = $cat->show_category_fe();
							if($getall_category){
								while($result_cat = $getall_category->fetch_assoc()){
						?>
						<ul>
							<li><a href="productbycat.php?catId=<?php echo $result_cat['catId'];?>"><?php echo $result_cat['catName'];?></a></li>
						</ul>
						<?php	
									}
								}
						?>
					</div>
				</div>
			</div>
		</div>
		</div>
<?php 
	include 'inc/footer.php'
?>