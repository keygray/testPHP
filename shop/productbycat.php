<?php
	include 'inc/header.php';
?>
<?php
	if(!isset($_GET['catId']) || $_GET['catId'] == NULL){
		echo "<script>window.location = '404.php'</script>";
	}
	else {
		$id = $_GET['catId'];
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
				<?php
					$getcatName = $cat->getcatName($id);
					if($getcatName){
						while($resultcatName = $getcatName->fetch_assoc()){
				?>
					<div class="heading">
						<h3>Category: <?php echo $resultcatName['catName']; ?></h3>
					</div>
					<?php
					
				}
			}
				?>
					<div class="clear"></div>
				</div>
				<div class="section group">
				<?php
					$productbycat = $cat->getproductbycat($id);
					if($productbycat){
						while($getproductbycat = $productbycat->fetch_assoc()){
				?>
					<div class="grid_1_of_4 images_1_of_4">
						<a href="details.php?proid=<?php echo $getproductbycat['productId'];?>"><img style=" height: 300px;object-fit: contain;" src="admin/upload/<?php echo $getproductbycat['image']?>" alt="" /></a>
						<h2><?php echo $getproductbycat['productName']?></h2>
						<p><?php echo $fm->textshorten($getproductbycat['product_desc'], 150);?></p>
						<p><span class="price"><?php echo $getproductbycat['price']." "."VND";?></span></p>
						<div class="button"><span><a href="details.php?proid=<?php echo $getproductbycat['productId'];?>" class="details">Details</a></span></div>
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