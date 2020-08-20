<?php
	include 'inc/header.php';
?>
<?php
// kiểm tra xem người dùng đăng nhập chưa nếu đăng nhajao rồi chuyển sang order
						$check_login = Session::get('customer_login');
						if($check_login){
							echo "<script>window.location = 'order.php'</script>";
						}
					?>
<?php
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
			// từ form lấy dữ liệu 
			
			// kiểm tra 2 biến này bằng function trong class adminlogin
			$insertcustomer = $cs->insert_customer($_POST) ;
		   //  $_POST khi mình lấy nhấn submit sẽ lấy tất cả dữ liệu
		   // $_FILE để upload ảnh
	   }
?>
<?php
		if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
			// từ form lấy dữ liệu 
			
			// kiểm tra 2 biến này bằng function trong class adminlogin
			$logincustomer = $cs->login_customer($_POST) ;
		   //  $_POST khi mình lấy nhấn submit sẽ lấy tất cả dữ liệu
		   // $_FILE để upload ảnh
	   }
?>
		<div class="main">
			<div class="content">
				<div class="login_panel">
					<h3>Existing Customers</h3>
					<p>Sign in with the form below.</p>
					<?php
					if(isset($logincustomer)){
						echo $logincustomer;
					}
				?>
					<form action="login.php" method="POST" id="member">
						<input type="text" name="emaillogin"  placeholder="Enter your email">
						<input type="password" name="passwordlogin"  placeholder="Enter your password" >
					
					<p class="note">If you forgot your passoword just enter your email and click <a href="#">here</a>
					</p>
					<div class="buttons">
						<div><button type="submit" class="grey" name="login" value="signin">Sign In</button></div>
					</div>
					</form>
				</div>
				<div class="register_account">
					<h3>Register New Account</h3>
					<?php
					if(isset($insertcustomer)){
						echo $insertcustomer;
					}
				?>
					<form action="" method="POST">
						<table>
							<tbody>
								<tr>
									<td>
										<div>
											<input type="text" name="name" placeholder="Enter your name">
										</div>

										<div>
											<input type="text" name="city" placeholder="Enter your city">
										</div>

										<div>
											<input type="text" name="zipcode" placeholder="Enter your ZipCode">
										</div>
										<div>
											<input type="text" name="email"  placeholder="Enter your email">
										</div>
									</td>
									<td>
										<div>
											<input type="text" name="address" placeholder="Enter your address">
										</div>
										<div>
											<select id="country" name="country" onchange="change_country(this.value)"
												class="frm-field required">
												<option value="null">Select a Country</option>
												<option value="AF">Afghanistan</option>
											</select>
										</div>

										<div>
											<input type="text" name="phone" placeholder="Enter your phone">
										</div>

										<div>
											<input type="text" name="password" placeholder="Enter your password">
										</div>
									</td>
								</tr>
							</tbody>
						</table>
						<div class="search">
							<div><button type="submit" name="submit" class="grey" value="Create Account">Create Account</button></div>
						</div>
						<p class="terms">By clicking 'Create Account' you agree to the <a href="#">Terms &amp;
								Conditions</a>.</p>
						<div class="clear"></div>
					</form>
				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div>
<?php 
	include 'inc/footer.php'
?>	