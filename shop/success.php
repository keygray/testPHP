<?php
	include 'inc/header.php';
?>
<?php
	// kiểm tra và lấy dữ liệu từ biến đã khai báo
	if(isset($_GET['orderid']) && $_GET['orderid'] == 'order'){
		$customer_id = Session::get('customer_Id');
		$insertOrder = $ct->insertOrder($customer_id);

		// nếu mà insert thành công vô order rồi thì sẽ delete cart
		$delCart = $ct->del_all_cart_customer();
		header('Location: success.php');
    }
// 	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
// 		// tạo biến số lượng
// 		$quantity = $_POST['quantity'];
// 		$AddtoCart = $ct->add_to_cart($quantity,$id) ;
//    }
?>
<style text="text/css">
	.box-left{
		margin-bottom: 16px;
	}
	.box-right {
		border : 1px solid red;
		margin: 16px 0;
	}
	.order{
		text-align:center;
		display: block;
    margin: auto;
    width: 25%;
    height: 5%;
    font-size: 1.2rem;
    color: white;
    background-color: aqua;
    outline: none;
    border: none;
    border-radius: 4px;
	}
</style>
<form action="" method="POST">
		<div class="main">
			<div class="content">
				<div class="section group">
                    <h2>Success order</h2>
                    <?php
                        $customer_id = Session::get('customer_Id');
                        $get_amount = $ct->get_amount_order($customer_id);
                        if($get_amount){
                            $amount=0;
                            while($result = $get_amount->fetch_assoc()){
                                $amount += $result['price'];

                    ?>
                    <p>Total : <?php $vat = $amount * 0.1;
								$gtotal = $amount + $vat;
								echo $gtotal; ?></p>
                    <?php
                        }
                    }
                    ?>
                    <p>Click here to view details <a href="orderdetails.php">Details</a></p>
				</div>
			</div>
		</div>
				</form>
<?php 
	include 'inc/footer.php'
?>