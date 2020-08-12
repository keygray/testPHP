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
            $query_insert = "INSERT INTO  tbl_cart(productId,quantity,sId,image,price,productName) 
            VALUES ('$id','$quantity','$sId','$image','$price','$productName')";
             // gọi function thực hiện trong database
            $insert_cart = $this->db->insert($query_insert);
             // nếu true insert thành công => ...
            if($result){
                //nếu thêm thành công thì nhảy sang tab giỏ hàng bên ngoài
                header('Location:cart.php');
            }
            else {
                header('Location:404.php');
            }
        }
        
    }
?>