<?php
    include 'lib/session.php';
	// hàm khởi tạo 1 session mới
	//vì các trang đều có header này nên mỗi file sẽ được khởi tạo session mới
    Session::init();
?>
<?php
    // goi den cong viec ma ham can thuc hien
    include 'lib/database.php';
	include 'helper/format.php';
	// hàm tự động load file trong class
	spl_autoload_register(function ($class) {
		include_once 'classes/' . $class . '.php';
	});
	$db = new Database();
	$fm = new Format();
	$ct = new cart();
	$us = new user();
	$cat = new category();
	$product = new product();
	$cs = new customer();
?>
<?php
  header("Cache-Control: no-cache, must-revalidate");
  header("Pragma: no-cache"); 
  header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
  header("Cache-Control: max-age=2592000");
?>

<!DOCTYPE HTML>

<head>
	<title>Store Website</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
	<link href="css/menu.css" rel="stylesheet" type="text/css" media="all" />
	<script src="js/jquerymain.js"></script>
	<script src="js/script.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="js/nav.js"></script>
	<script type="text/javascript" src="js/move-top.js"></script>
	<script type="text/javascript" src="js/easing.js"></script>
	<script type="text/javascript" src="js/nav-hover.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Monda' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Doppio+One' rel='stylesheet' type='text/css'>
	<script type="text/javascript">
		$(document).ready(function ($) {
			$('#dc_mega-menu-orange').dcMegaMenu({
				rowItems: '4',
				speed: 'fast',
				effect: 'fade'
			});
		});
	</script>
</head>

<body>
	<div class="wrap">
		<div class="header_top">
			<div class="logo">
				<a href="index.php"><img src="images/logo.png" alt="" /></a>
			</div>
			<div class="header_top_right">
				<div class="search_box">
					<form>
						<input type="text" value="Search for Products" onfocus="this.value = '';"
							onblur="if (this.value == '') {this.value = 'Search for Products';}"><input type="submit"
							value="SEARCH">
					</form>
				</div>
				<div class="shopping_cart">
					<div class="cart">
						<a href="#" title="View my shopping cart" rel="nofollow">
							<span class="cart_title">Cart</span>
							<span class="no_product">
							<?php
								$checkcart = $ct->checkcart();
								if($checkcart){
								$sum= Session::get("sum");
								$quantity= Session::get("quantity");
								echo $sum." "."vnđ"."-"."SLSP: $quantity";
								}
								else
								{
									echo "empty";
								}
							?>
							</span>
						</a>
					</div>
				</div>
				<div class="login">
					<?php
					if(isset($_GET['customer_id'])){
						// xử lý việc đăng xuất ra mà vẫn còn cart
						$delCart = $ct->del_all_cart_customer();
						Session::destroy();
					}
					?>
					<!-- nếu kiểm tra đăng nhập rồi thì hiển thị logout chưa thì login -->
					<?php
						$check_login = Session::get('customer_login');
						if($check_login == false){
							echo '<a href="login.php">Login</a></div>';
						}
						else {
							// hủy phiên làm việc của người dùng đó
							echo '<a href="?customer_id='.Session::get('customer_Id').'">Logout</a></div>';
						}
					?>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
		<div class="menu">
			<ul id="dc_mega-menu-orange" class="dc_mm-orange">
				<li><a href="index.php">Home</a></li>
				<li><a href="products.php">Products</a> </li>
				<li><a href="topbrands.php">Top Brands</a></li>
				<?php
				$checkcart = $ct->checkcart();
				if($checkcart==true){
					echo '<li><a href="cart.php">Cart</a></li>';
				}
				else {
					echo '';
				}
				?>
				<?php
				$customer_id = Session::get('customer_Id');
				$checkorder = $ct->checkorder($customer_id);
				if($checkorder==true){
					echo '<li><a href="orderdetails.php">Ordered</a></li>';
				}
				else {
					echo '';
				}
				?>
				<?php
					$login_check = Session::get('customer_login');
					if($login_check == false){
						echo '';
					}
					else {
						echo '<li><a href="profile.php">Profile</a></>';
					}
				?>
				<li><a href="contact.php">Contact</a> </li>
				<div class="clear"></div>
			</ul>
		</div>