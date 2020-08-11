<?php
    // goi den cong viec ma ham can thuc hien
    include_once '../lib/database.php';
    include_once '../helper/format.php';
?>
<?php
    class product {
        // khai báo biến
        private $db;
        private $fm;
        public function __construct(){
            // tao đối tượng nhưng chỉ dùng ở trong file này
            $this->db = new Database();
            $this->fm = new Format();
        }
        // $data tương ứng với $_POST, $files tương ứng với $_FILES
        public function insert_product($data,$files) {
            // kết nối tới cơ sở dữ liệu qua biến link trong hàm database()
            // tên biến name như nào thì viết trong data như vậy
            $productName = mysqli_real_escape_string($this->db->link, $data['productName']);
            $category = mysqli_real_escape_string($this->db->link, $data['category']);
            $brand = mysqli_real_escape_string($this->db->link, $data['brand']);
            $product_desc = mysqli_real_escape_string($this->db->link, $data['product_desc']);
            $price = mysqli_real_escape_string($this->db->link, $data['price']);
            $type = mysqli_real_escape_string($this->db->link, $data['type']);
            // CODE UPLOAD HÌNH ẢNH
            // kiểm tra hình 
            $permited = array('jpg','jpeg','png','gif');
            $file_name = $_FILES['image']['name'];
            $file_size = $_FILES['image']['size'];
            $file_temp = $_FILES['image']['tmp_name'];
            $div = explode('.',$file_name);
            $file_ext = strtolower(end($div));
            $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
            // và cho vào folder upload từ file lấy được từ unique_image
            $uploaded_image = "upload/".$unique_image;
            // file name tượng trưng trường hình ảnh không được rỗng 
            if($productName=="" || $category=="" || $brand=="" || $product_desc=="" || $price=="" || $type=="" || $file_name==""){
                $alert = "<span class='error'>This field not be to allow empty</span>";
                return $alert;
            }
            else {
                // lấy hình ảnh ở biến file tạm là file_temp xong nó sẽ upload vào qua uploaded
                move_uploaded_file($file_temp,$uploaded_image);
                // ghi câu truy vấn sql
                $query = "INSERT INTO  tbl_product(productName,catId,brandId,product_desc,price,type,image) VALUES ('$productName','$category','$brand','$product_desc','$price','$type','$unique_image')";
                // gọi function thực hiện trong database
                $result = $this->db->insert($query);
                // nếu true insert thành công => ...
                if($result){
                    $alert = "<span class='success'>Insert Successfull</span>";
                    return $alert;
                }
                else {
                    $alert = "<span class='error'>Insert Not Successfull</span>";
                    return $alert;
                }

            }
        }
        public function show_product() {
            // sắp xếp theo ID theo thứ tự desc (giảm dần)
            $query = "SELECT * FROM  tbl_product order by productId desc";
            // gọi function thực hiện trong database
            $result = $this->db->select($query);
            return $result;
        }

    }
?>