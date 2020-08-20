<style type="text/css">
.flexslider .slides img {
    width: 100%;
    display: block;
    max-height: 310px;
}
.productName{
	font-weight: bold;
	font-style: italic;	
}
.object--fit{
	object-fit: contain;
}

</style>
<div class="header_bottom">
	<div class="header_bottom_left">
		<div class="section group">
		<?php
			$getLastestIphone = $product->getLastestIphone();
			if($getLastestIphone){
				while($result_iphone = $getLastestIphone->fetch_assoc()){
		?>
			<div class="listview_1_of_2 images_1_of_2">
				<div class="listimg listimg_2_of_1">
					<a href="details.php?proid=<?php echo $result_iphone['productId'];?>"> <img class="object--fit" src="admin/upload/<?php echo $result_iphone['image'];?>" alt="" /></a>
				</div>
				<div class="text list_2_of_1">
					<h2>Nike</h2>
					<p class="productName"><?php echo $result_iphone['productName'];?></p>
					<div class="button"><span><a href="details.php?proid=<?php echo $result_iphone['productId'];?>">Add to cart</a></span></div>
				</div>
			</div>
			<?php
				}
			}
			?>
			<?php
			$getLastestSam = $product->getLastestSam();
			if($getLastestSam){
				while($result_sam = $getLastestSam->fetch_assoc()){
			?>
			<div class="listview_1_of_2 images_1_of_2">
			<div class="listimg listimg_2_of_1">
					<a href="details.php?proid=<?php echo $result_sam['productId'];?>"> <img class="object--fit" src="admin/upload/<?php echo $result_sam['image'];?>" alt="" /></a>
				</div>
				<div class="text list_2_of_1">
					<h2>Bmai VN</h2>
					<p class="productName"><?php echo $result_sam['productName'];?></p>
					<div class="button"><span><a href="details.php?proid=<?php echo $result_sam['productId'];?>">Add to cart</a></span></div>
				</div>
			</div>
			<?php
				}
			}
			?>
		</div>
		<div class="section group">
		<?php
			$getLastestXiaomi = $product->getLastestXiaomi();
			if($getLastestXiaomi){
				while($result_xiaomi = $getLastestXiaomi->fetch_assoc()){
		?>
			<div class="listview_1_of_2 images_1_of_2">
				<div class="listimg listimg_2_of_1">
					<a href="details.php?proid=<?php echo $result_xiaomi['productId'];?>"> <img class="object--fit" src="admin/upload/<?php echo $result_xiaomi['image'];?>" alt="" /></a>
				</div>
				<div class="text list_2_of_1">
					<h2>Converse</h2>
					<p class="productName"><?php echo $result_xiaomi['productName'];?></p>
					<div class="button"><span><a href="details.php?proid=<?php echo $result_xiaomi['productId'];?>">Add to cart</a></span></div>
				</div>
			</div>
			<?php
				}
			}
			?>
			<?php
			$getLastestDell = $product->getLastestDell();
			if($getLastestDell){
				while($result_dell = $getLastestDell->fetch_assoc()){
			?>
			<div class="listview_1_of_2 images_1_of_2">
			<div class="listimg listimg_2_of_1">
					<a href="details.php?proid=<?php echo $result_dell['productId'];?>"> <img class="object--fit" src="admin/upload/<?php echo $result_dell['image'];?>" alt="" /></a>
				</div>
				<div class="text list_2_of_1">
					<h2>Puma</h2>
					<p class="productName"><?php echo $result_dell['productName'];?></p>
					<div class="button"><span><a href="details.php?proid=<?php echo $result_dell['productId'];?>">Add to cart</a></span></div>
				</div>
			</div>
			<?php
				}
			}
			?>
		</div>
		<div class="clear"></div>
	</div>
	<div class="header_bottom_right_images">
		<!-- FlexSlider -->

		<section class="slider">
			<div class="flexslider">
				<ul class="slides">
					<?php
						$show_slider = $product->show_slider_fe();
							if($show_slider){
								while($result_slider = $show_slider->fetch_assoc()){
						
					?>
					<li><img src="admin/upload/<?php echo $result_slider['sliderImage'];?>" alt="" /></li>
					<?php
						
					}
				}
					?>
				</ul>
			</div>
		</section>
		<!-- FlexSlider -->
	</div>
	<div class="clear"></div>
</div>