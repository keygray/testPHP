<?php
	include 'inc/header.php';
	include 'inc/slider.php';
?>
<?php
// kiểm tra xem người dùng đăng nhập chưa
						$check_login = Session::get('customer_login');
						if($check_login == false){
							header('Location: login.php');
						}
					?>
		<div class="main">
			<div class="content">
				<div class="cartoption">
					<div class="cartpage">
					<div class="not_found">
						<h3 style="text-align:center;color:red;font-size:1.4rem">WELCOME TO KEYGRAY</h3>
					</div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		</div>
<?php 
	include 'inc/footer.php'
?>