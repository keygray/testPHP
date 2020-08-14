<?php
	include 'inc/header.php';
?>
<?php
					$login_check = Session::get('customer_login');
					if($login_check == false){
						header('Location: login.php');
                    }
                    $id = Session::get('customer_Id');
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
                        // từ form lấy dữ liệu 
                        
                        // kiểm tra 2 biến này bằng function trong class adminlogin
                        $update_customer = $cs->update_customer($_POST,$id) ;
                    }
?>
		<div class="main">
			<div class="content">
				<div class="section group">
                    <h3>Profiles User</h3>
                    <?php
                    if(isset($update_customer)){
                        echo $update_customer;
                    }
                    ?>
                <form action="" method="POST">
                    <table class="tblone">
                  
                    <?php
                        $get_customers = $cs->show_customers($id);
                        if($get_customers){
                            while($result = $get_customers->fetch_assoc()){
                    ?>
                    <tr>
                    <td>Name</td>
                    <td>:</td>
                    <td><input name="name" type="text" value="<?php echo $result['name'];?>"></td>
                    </tr>
                    <tr>
                    <td>Addess</td>
                    <td>:</td>
                    <td><input type="text" name="address" value="<?php echo $result['address'];?>"></td>
                    </tr>
                    <tr>
                    <td>City</td>
                    <td>:</td>
                    <td><input type="text" name="city" value="<?php echo $result['city'];?>"></td>
                    </tr>
                    <tr>
                    <td>Country</td>
                    <td>:</td>
                    <td><input type="text" name="country" value="<?php echo $result['country'];?>"></td>
                    </tr>
                    <tr>
                    <td>Zipcode</td>
                    <td>:</td>
                    <td><input type="text" name="zipcode" value="<?php echo $result['zipcode'];?>"></td>
                    </tr>
                    <tr>
                    <td>Phone</td>
                    <td>:</td>
                    <td><input type="text" name="phone" value="<?php echo $result['phone'];?>"></td>
                    </tr>
                    <tr>
                    <td>Email</td>
                    <td>:</td>
                    <td><input type="text" name="email" value="<?php echo $result['email'];?>"></td>
                    </tr>
                    <tr>
                        <td colspan="3" ><button type="submit" class="grey" name="save" vale="updateprofile">Update Profile<a></td>
                    </tr>
                    <?php         
                        }
                    }
                    ?>
                    </table>
                </form>
				</div>
			</div>
		</div>
        </div>
<?php 
	include 'inc/footer.php'
?>