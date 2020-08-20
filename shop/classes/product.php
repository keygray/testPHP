<?php
     $filepath = realpath(dirname(__FILE__));
     // goi den cong viec ma ham can thuc hien
     include_once ($filepath.'/../lib/database.php');
     include_once ($filepath.'/../helper/format.php');
     // cần đổi thành once vì mai này khi làm file product add gọi lại sẽ bị undefid kết nối với DB
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
            // $query = "SELECT * FROM  tbl_product order by productId desc";
            // bình thường thì ta sẽ sử dụng câu lệnh truy vấn trên nhưng mà bài toán đặt ra là:
            // hiển thị catId , brandId trong bảng product khi hiển thị ra phải lấy được tên của chúng
            // CHÚ Ý ---------------------------------------------------------------------------------
            $query = "SELECT tbl_product.*,tbl_category.catName,tbl_brand.brandName
            FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId 
            INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId
            ORDER BY tbl_product.productId desc";
            // gọi function thực hiện trong database
            $result = $this->db->select($query);
            return $result;
        }
        public function getproductbyId($id){
            $query = "SELECT * FROM  tbl_product WHERE productId = '$id'";
            $result = $this->db->select($query);
            return $result;
        }



        public function update_product($data,$files,$id){
            $id = mysqli_real_escape_string($this->db->link, $id);
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
            //trong update phải kiểm tra file_name hình ảnh rỗng hay không theo kiểu khác
            if($productName=="" || $category=="" || $brand=="" || $product_desc=="" || $price=="" || $type==""){
                $alert = "<span class='error'>This field not be to allow empty</span>";
                return $alert;
            }
            else{
                if(!empty($file_name)){
                    //nếu người dùng chọn ảnh mới
                    if($file_size > 204800){
                        $alert = "<span class='error'>Image Size should be less then 2MB!</span>";
                        return $alert;
                    }
                    elseif(in_array($file_ext,$permited) === false){
                        $alert = "<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";
                        return $alert;
                    }

                    //di chuyển ảnh mới vô thư mục upload
                    move_uploaded_file($file_temp,$uploaded_image);
                    //update lại hoàn toàn
                    $query = "UPDATE tbl_product SET 
                    productName= '$productName',
                    catId= '$category',
                    brandId= '$brand',
                    product_desc= '$product_desc',
                    price= '$price',
                    type= '$type',
                    image= '$unique_image'
                    WHERE productId = '$id'";
                }
                else{
                    //nếu người dùng vẫn để ảnh cũ thì cho phép up các cái còn lại trừ ảnh
                    $query = "UPDATE tbl_product SET 
                    productName= '$productName',
                    catId= '$category',
                    brandId= '$brand',
                    product_desc= '$product_desc',
                    price= '$price',
                    type= '$type'
                    WHERE productId = '$id'";
                }
                // ra ngoài 2 câu lệnh đều thực hiện chung phần này nên cho ra ngoài
                $result = $this->db->update($query);
                // nếu true insert thành công => ...
                if($result){
                    $alert = "<span class='success'>Update Successfull</span>";
                    return $alert;
                }
                else {
                    $alert = "<span class='error'>Update Not Successfull</span>";
                    return $alert;
                }
            }
        }
        public function delete_product($id){
            $query = "DELETE FROM tbl_product where productId = '$id'";
            $result = $this->db->delete($query);
            if($result){
                $alert = "<span class='success'>Delete Successfull</span>";
                return $alert;
            }
            else {
                $alert = "<span class='error'>Delete Not Successfull</span>";
                return $alert;
            }
        }
        //END - BACKEND
        //-----------------------------------------------------------------------------------
        //START WITH FE
        //1.Hiển thị sản phẩm nổi bật
        public function getproduct_feathered(){
            //ta đã đặt cho 0 là favourite từ đầu
            $query = "SELECT * FROM  tbl_product WHERE type = '0'";
            $result = $this->db->select($query);
            return $result;
        }
        //2.Lay sp new ,giới hạn 4sp /hàng
        public function getproduct_new(){
            //ta đã đặt cho 0 là favourite từ đầu
            $query = "SELECT * FROM  tbl_product ORDER BY productId desc LIMIT 4";
            $result = $this->db->select($query);
            return $result;
        }
        //3.Details sản phẩm
        public function get_details($id){
            $query = "SELECT tbl_product.*,tbl_category.catName,tbl_brand.brandName
            FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId 
            INNER JOIN tbl_brand ON tbl_product.brandId = tbl_brand.brandId
            WHERE productId = '$id'";
            // gọi function thực hiện trong database
            $result = $this->db->select($query);
            return $result;
        }
        //4.lấy sản phẩm mới nhất của mỗi hãng
        public function getLastestIphone(){
            // brandid 6 là brand id của iphone
            $query = "SELECT * FROM  tbl_product WHERE brandId= '8' ORDER BY productId desc LIMIT 1";
            // gọi function thực hiện trong database
            $result = $this->db->select($query);
            return $result;
        }
        public function getLastestSam(){
            // brandid 6 là brand id của iphone
            $query = "SELECT * FROM  tbl_product WHERE brandId= '9' ORDER BY productId desc LIMIT 1";
            // gọi function thực hiện trong database
            $result = $this->db->select($query);
            return $result;
        }
        public function getLastestXiaomi(){
            // brandid 6 là brand id của iphone
            $query = "SELECT * FROM  tbl_product WHERE brandId= '10' ORDER BY productId desc LIMIT 1";
            // gọi function thực hiện trong database
            $result = $this->db->select($query);
            return $result;
        }
        public function getLastestDell(){
            // brandid 6 là brand id của iphone
            $query = "SELECT * FROM  tbl_product WHERE brandId= '11' ORDER BY productId desc LIMIT 1";
            // gọi function thực hiện trong database
            $result = $this->db->select($query);
            return $result;
        }

        // compare
        public function insertCompare($productId,$customer_id){
            $productId = mysqli_real_escape_string($this->db->link, $productId);
            $customer_id = mysqli_real_escape_string($this->db->link, $customer_id);
            $query = "SELECT * FROM tbl_product WHERE productId = '$productId'";
            $result = $this->db->select($query)->fetch_assoc();
            $image=$result['image'];
            $price=$result['price'];
            $productName=$result['productName'];
            $checkcompare = "SELECT * FROM tbl_compare WHERE productId = '$productId' AND customer_id= '$customer_id'";
            $check_compare = $this->db->select($checkcompare);
            // // nếu product id và sId bằng chính sản phâm rdoo người dùng đó thêm thì báo đã thêm
            // // còn lại thực hiện code thêm
            if($check_compare){
                 $msg = "Product already added";
                return $msg;
            }
            else{
                $query_insert = "INSERT INTO  tbl_compare(customer_id,productId,productName,price,image) 
                VALUES ('$customer_id','$productId','$productName','$price','$image')";
                 // gọi function thực hiện trong database
                $insert_compare = $this->db->insert($query_insert);
                 // nếu true insert thành công => ...
                 if($insert_compare){
                    $alert = "<span class='success'>Insert Successfull</span>";
                    return $alert;
                }
                else {
                    $alert = "<span class='error'>Insert Not Successfull</span>";
                    return $alert;
                }
            }
        }

        public function get_compare($customer_id){
            $customer_id = mysqli_real_escape_string($this->db->link, $customer_id);
            $query = "SELECT * FROM  tbl_compare WHERE customer_id = '$customer_id ' ORDER BY id desc";
            // gọi function thực hiện trong database
            $result = $this->db->select($query);
            return $result;
        }

        public function del_compare($id){
            $query = "DELETE FROM tbl_compare where id = '$id'";
            $result = $this->db->delete($query);
            return $result;
        }

        // add slider
        public function add_slider($data,$files){
             // kết nối tới cơ sở dữ liệu qua biến link trong hàm database()
            // tên biến name như nào thì viết trong data như vậy
            $sliderName = mysqli_real_escape_string($this->db->link, $data['sliderName']);
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
            if($sliderName=="" || $type=="" || $file_name==""){
                $alert = "<span class='error'>This field not be to allow empty</span>";
                return $alert;
            }
            else {
                // lấy hình ảnh ở biến file tạm là file_temp xong nó sẽ upload vào qua uploaded
                move_uploaded_file($file_temp,$uploaded_image);
                // ghi câu truy vấn sql
                $query = "INSERT INTO  tbl_slider(sliderName,type,sliderImage) VALUES ('$sliderName','$type','$unique_image')";
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
        // show slider
        public function show_slider(){
            $query = "SELECT * FROM  tbl_slider ORDER BY sliderId desc";
            // gọi function thực hiện trong database
            $result = $this->db->select($query);
            return $result;
        }

        public function del_slider($id){
            $query = "DELETE FROM tbl_slider where sliderId = '$id'";
            $result = $this->db->delete($query);
            return $result;
        }

        public function get_sliderbyid($id){
            $query = "SELECT * FROM  tbl_slider where sliderId = '$id' LIMIT 1";
            // gọi function thực hiện trong database
            $result = $this->db->select($query);
            return $result;
        }

        public function update_slider($data,$files,$id){
            $sliderName = mysqli_real_escape_string($this->db->link, $data['sliderName']);
            $type = mysqli_real_escape_string($this->db->link, $data['type']);
            $id = mysqli_real_escape_string($this->db->link, $id);
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
            //trong update phải kiểm tra file_name hình ảnh rỗng hay không theo kiểu khác
            if($sliderName=="" || $type==""){
                $alert = "<span class='error'>This field not be to allow empty</span>";
                return $alert;
            }
            else{
                if(!empty($file_name)){
                    //di chuyển ảnh mới vô thư mục upload
                    move_uploaded_file($file_temp,$uploaded_image);
                    //update lại hoàn toàn
                    $query = "UPDATE tbl_slider SET 
                    sliderName= '$sliderName',
                    sliderImage= '$unique_image',
                    type= '$type'
                    WHERE sliderId = '$id'";
                }
                else{
                    //nếu người dùng vẫn để ảnh cũ thì cho phép up các cái còn lại trừ ảnh
                    $query = "UPDATE tbl_slider SET 
                    sliderName= '$sliderName',
                    type= '$type'
                    WHERE sliderId = '$id'";
                }
                // ra ngoài 2 câu lệnh đều thực hiện chung phần này nên cho ra ngoài
                $result = $this->db->update($query);
                // nếu true insert thành công => ...
                if($result){
                    $alert = "<span class='success'>Update Successfull</span>";
                    return $alert;
                }
                else {
                    $alert = "<span class='error'>Update Not Successfull</span>";
                    return $alert;
                }
            }
        }

        public function show_slider_fe(){
            $query = "SELECT * FROM  tbl_slider WHERE type = '1' ORDER BY sliderId desc";
            // gọi function thực hiện trong database
            $result = $this->db->select($query);
            return $result;
        }

        // update only type 
        public function update_type_slider($typeid,$type){
            $type = mysqli_real_escape_string($this->db->link, $type);
            $query = "UPDATE tbl_slider SET type='$type' WHERE sliderId='$typeid'";
            $result = $this->db->update($query);
            return $result;
        }

        // search product
        public function search_product($tukhoa){
            $tukhoa = mysqli_real_escape_string($this->db->link, $tukhoa);
            $query = "SELECT * FROM  tbl_product WHERE productName like '%$tukhoa%'";
            $result = $this->db->select($query);
            return $result;
        }
    }
?>