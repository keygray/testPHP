<?php
	include 'inc/header.php';
?>
<?php
					$login_check = Session::get('customer_login');
					if($login_check == false){
						echo "<script>window.location = 'login.php'</script>";
					}
					$checkcart = $ct->checkcart();
						if($checkcart==false){
							echo "<script>window.location = 'cart.php'</script>";
						}
?>
		<div class="main">
			<div class="content">
				<div class="section group">

                    <h3>Paymend Method</h3>
                    <h3>Choose method</h3>
                    <a href="offlinepayment.php" class="">Offline payment</a>
                    <a href="onlinepayment.php" class="">Online payment</a>
                    <a href="cart.php" class=""> << Back</a>
				</div>
			</div>
		</div>
        </div>
<?php 
	include 'inc/footer.php'
?>