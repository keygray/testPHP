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
						<ul>
							<li><a href="productbycat.php">Mobile Phones</a></li>
						</ul>

					</div>
				</div>
			</div>
		</div>
		</div>
<?php 
	include 'inc/footer.php'
?>