<?php
    $filepath = realpath(dirname(__FILE__));
    // goi den cong viec ma ham can thuc hien
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helper/format.php');
    // cần đổi thành once vì mai này khi làm file product add gọi lại sẽ bị undefid kết nối với DB
?>
<?php
    class cart {
        // khai báo biến
        private $db;
        private $fm;
        public function __construct(){
            // tao đối tượng nhưng chỉ dùng ở trong file này
            $this->db = new Database();
            $this->fm = new Format();
        }
        public function add_to_cart($quantity,$id){
            $quantity = $this->fm->validation($quantity);
            $quantity = mysqli_real_escape_string($this->db->link, $quantity);
            $id = mysqli_real_escape_string($this->db->link, $id);
            // tạo biến lấy session_id mỗi phiên giao dịch 
            $sId= session_id();

            $query = "SELECT * FROM tbl_product WHERE productId = '$id'";
            // kết hợp lấy dữ liệu ra luôn
            $result = $this->db->select($query)->fetch_assoc();
                    // echo '<pre>';
                    // // nếu muốn thử dùng echo , nhưng đây là lấy ra dạng chuỗi array nên phải print_r()
                    // echo print_r($result);
                    // echo '</pre>';
            // oki đoạn trên ta đã lấy ra được dữ liệu của bảng product bây giờ sẽ truyền dữ liệu đấy vào cart
             // ghi câu truy vấn sql
            //gọi biến lấy dữ liệu từ bảng product
            $image=$result['image'];
            $price=$result['price'];
            $productName=$result['productName'];

            // // XỬ LÝ BÀI TOÁN ĐẶT RA LÀ NGƯỜI DÙNG ĐÃ ADD VÔ CART RỒI XONG LẠI ADD LẠI LẦN NỮA
            // //HÀM KIỂM TRA TRÁNH BÀI TOÁN TRÊN
            $checkcart = "SELECT * FROM tbl_cart WHERE productId = '$id' AND sId = '$sId'";
            $check_cart = $this->db->select($checkcart);
            // // nếu product id và sId bằng chính sản phâm rdoo người dùng đó thêm thì báo đã thêm
            // // còn lại thực hiện code thêm
            if($check_cart){
                 $msg = "Product already added";
                return $msg;
            }
            else{
                $query_insert = "INSERT INTO  tbl_cart(productId,quantity,sId,image,price,productName) 
                VALUES ('$id','$quantity','$sId','$image','$price','$productName')";
                 // gọi function thực hiện trong database
                $insert_cart = $this->db->insert($query_insert);
                 // nếu true insert thành công => ...
                if($result){
                    //nếu thêm thành công thì nhảy sang tab giỏ hàng bên ngoài
                    echo "<script>window.location = 'cart.php'</script>";
                }
                else {
                    header('Location:404.php');
                }
            }
        }

        public function get_product_cart(){
             // sắp xếp theo ID theo thứ tự desc (giảm dần)
             $sId= session_id();
            //  gọi ra bài toán cart là phải chung phiên làm việc session thì hiển thị ra
             $query = "SELECT * FROM  tbl_cart WHERE sId='$sId'";
             $result = $this->db->select($query);
             return $result;
        }
        public function update_quantity_cart($quantity,$cartId){
            $quantity = $this->fm->validation($quantity);
            $quantity = mysqli_real_escape_string($this->db->link, $quantity);
            $cartId = mysqli_real_escape_string($this->db->link, $cartId);
            $query = "UPDATE tbl_cart SET 
                    quantity= '$quantity'
                    WHERE cartId = '$cartId'";
            $result = $this->db->update($query);
            if($result){
                // update xong trả về đúng trang này để phần giỏ hàng trên header cũng đc cập nhật
                echo "<script>window.location = 'cart.php'</script>";
            }
            else{
                $msg="Fail to quantity";
                return $msg;
            }
        }

        public function delete_product_cart($delid){
            $query = "DELETE FROM tbl_cart where cartId = '$delid'";
            $result = $this->db->delete($query);
            if($result){
                echo "<script type='text/javascript'>window.location.href = 'cart.php'</script>"; 
            }
            else {
                $alert = "<span class='error'>Delete Not Successfull</span>";
                return $alert;
            }
        }
        public function checkcart(){
            //kiểm tra xem tại session đó có  hàng được thêm không
            $sId= session_id();
            $query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
            $result = $this->db->select($query);
            return $result;
        }

        public function del_all_cart_customer(){
            $sId= session_id();
            $query = "DELETE FROM tbl_cart WHERE sId = '$sId'";
            $result = $this->db->delete($query);
        }

        
        public function insertOrder($customer_id){
            // layas ra được các đồ có trong giỏ hàng tại phiên làm việc đó
            $sId = session_id();
            $query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
            $get_product = $this->db->select($query);
            // ở đây càn dùng vòng vì mỗi lên thêm từ giỏ hàng vào order thì sẽ có nhiều sản phẩm cần thêm vào
            if($get_product){
                while($result = $get_product->fetch_assoc()){
                    $productId = $result['productId'];
                    $productName = $result['productName'];
                    $quantity = $result['quantity'];
                    // giá bằng tiền nhân số lượng
                    $price = $result['price']*$quantity;
                    $image = $result['image'];
                    $customer_id = $customer_id;
                    $query_insert = "INSERT INTO  tbl_order(productId,productName,quantity,price,image,customer_id) 
                    VALUES ('$productId','$productName','$quantity','$price','$image','$customer_id')";
                     // gọi function thực hiện trong database
                    $insert_order = $this->db->insert($query_insert);
                     // nếu true insert thành công => ...
                }
            }
        }
          // lấy tổng giá tiền tổng
        public function get_amount_order($customer_id){
            $query = "SELECT price FROM tbl_order WHERE customer_id = '$customer_id' AND date_order = now()";
            $get_amount = $this->db->select($query);
            return $get_amount;
        }

        //order details
        public function get_cat_order($customer_id){
            $query = "SELECT * FROM tbl_order WHERE customer_id = '$customer_id'";
            $get_cat_order = $this->db->select($query);
            return $get_cat_order;
        }

        //check order
        public function checkorder($customer_id){
            //kiểm tra xem tại session đó có  hàng được thêm không
            $query = "SELECT * FROM tbl_order WHERE customer_id = '$customer_id'";
            $result = $this->db->select($query);
            return $result;
        }


        // admin inbox
        public function get_inbox_cart(){
            $query = "SELECT * FROM tbl_order ORDER BY date_order";
            $result = $this->db->select($query);
            return $result;
        }

        public function shifted($id,$time,$price){
            $id = mysqli_real_escape_string($this->db->link,$id);
            $time = mysqli_real_escape_string($this->db->link,$time);
            $price = mysqli_real_escape_string($this->db->link,$price);
            $query = "UPDATE tbl_order SET 
            status = '1'
            WHERE id = '$id' AND date_order='$time' AND price = '$price'";
            $result = $this->db->update($query);
            return $result;
        }

        public function del_order($delid,$time,$price){
            $delid = mysqli_real_escape_string($this->db->link,$delid);
            $time = mysqli_real_escape_string($this->db->link,$time);
            $price = mysqli_real_escape_string($this->db->link,$price);
            $query = "DELETE FROM tbl_order
            WHERE id = '$delid' AND date_order='$time' AND price = '$price'";
            $result = $this->db->delete($query);
            return $result;
        }

        // xác nhận đã nhận hàng bên order details
        // quy chuẩn : status 0 là chưa xử lý 1 là đang vận chuyển 2 là đã nhận
        public function confirm_shifted($confirmId,$time,$price){
            $confirmId = mysqli_real_escape_string($this->db->link,$confirmId);
            $time = mysqli_real_escape_string($this->db->link,$time);
            $price = mysqli_real_escape_string($this->db->link,$price);
            $query = "UPDATE tbl_order SET 
            status = '2'
            WHERE id = '$confirmId' AND date_order='$time' AND price = '$price'";
            $result = $this->db->update($query);
            return $result;
        }
    }
?>