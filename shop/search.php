<?php
	include 'inc/header.php';
?>
<?php
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_product'])) {
        $tukhoa = $_POST['tukhoa'];
        $search_product = $product->search_product($tukhoa);
	}
?>
<style type="text/css">
.images_1_of_4{
	margin-left: 2px;
    margin-right: 12px;
}
</style>
		<div class="main">
			<div class="content">
				<div class="content_top">
					<div class="heading">
						<h3>Hiển thị cho từ khóa tìm kiếm: <?php echo $tukhoa; ?></h3>
					</div>
					<?php
				?>
					<div class="clear"></div>
				</div>
				<div class="section group">
				<?php
					if($search_product){
						while($result = $search_product->fetch_assoc()){
				?>
					<div class="grid_1_of_4 images_1_of_4">
                    <a href="details.php?proid=<?php echo $result['productId'];?>"><img style=" height: 300px;object-fit: contain;" src="admin/upload/<?php echo $result['image'];?>" alt="" /></a>
				<h2 style=" font-weight: bold;font-style: italic;"><?php echo $result['productName'];?></h2>
				<h4 style="font-size: 1.2rem;font-weight: 400;color: var(--text-color);line-height: 1.5rem;height: 3rem;overflow: hidden;display: block;display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 2;" class="text_desc"><?php echo $result['product_desc'];?></h4>
				<p><span class="price"><?php echo $fm->money($result['price'])." "."VND";?></span></p>
				<!-- lấy ra details sản phẩm cũng truyền vô id giống với edit -->
				<div class="button"><span><a href="details.php?proid=<?php echo $result['productId'];?>" class="details">Details</a></span></div>
					</div>
				<?php
					
				}
			}else {
				echo "Opps! Sorry now this category dont have any product";
			}
				?>
				</div>



			</div>
		</div>
	</div>
<?php 
	include 'inc/footer.php'
?>		