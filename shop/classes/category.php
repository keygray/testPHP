<?php
    $filepath = realpath(dirname(__FILE__));
    // goi den cong viec ma ham can thuc hien
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helper/format.php');
    // cần đổi thành once vì mai này khi làm file product add gọi lại sẽ bị undefid kết nối với DB
?>

<?php
    class category {
        // khai báo biến
        private $db;
        private $fm;
        public function __construct(){
            // tao đối tượng nhưng chỉ dùng ở trong file này
            $this->db = new Database();
            $this->fm = new Format();
        }

        public function insert_category($catName) {
            // kiểm tra xem có phù hợp về chuỗi hay không (không khoảng cách...)
            $catName = $this->fm->validation($catName);
            // kết nối tới cơ sở dữ liệu qua biến link trong hàm database()
            $catName = mysqli_real_escape_string($this->db->link, $catName);
        
            if(empty($catName)){
                $alert = "<span class='error'>Category name is empty</span>";
                return $alert;
            }
            else {
                // ghi câu truy vấn sql
                $query = "INSERT INTO  tbl_category(catName) VALUES ('$catName')";
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
        public function show_category() {
            // sắp xếp theo ID theo thứ tự desc (giảm dần)
            $query = "SELECT * FROM  tbl_category order by catId desc";
            // gọi function thực hiện trong database
            $result = $this->db->select($query);
            return $result;
        }

        public function getcatbyId($id){
            $query = "SELECT * FROM  tbl_category WHERE catId = '$id'";
            $result = $this->db->select($query);
            return $result;
        }

        public function update_category($catName,$id){
              // kiểm tra xem có phù hợp về chuỗi hay không (không khoảng cách...)
            $catName = $this->fm->validation($catName);
              // kết nối tới cơ sở dữ liệu qua biến link trong hàm database()
            $catName = mysqli_real_escape_string($this->db->link, $catName);
            $id = mysqli_real_escape_string($this->db->link, $id);
            if(empty($catName)){
                $alert = "<span class='error'>Category name is empty</span>";
                return $alert;
            }
            else {
                // ghi câu truy vấn sql
                $query = "UPDATE tbl_category SET catName= '$catName' WHERE catId = '$id'";
                // gọi function thực hiện trong database
                $result = $this->db->update($query);
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
        public function delete_category($id){
            $query = "DELETE FROM tbl_category where catId = '$id'";
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


        // frontend
        public function show_category_fe() {
            // sắp xếp theo ID theo thứ tự desc (giảm dần)
            $query = "SELECT * FROM  tbl_category order by catId desc";
            // gọi function thực hiện trong database
            $result = $this->db->select($query);
            return $result;
        }

        public function getproductbycat($id){
            $query = "SELECT * FROM  tbl_product WHERE catId = '$id' ORDER BY catId desc";
            $result = $this->db->select($query);
            return $result;
        }

        public function getcatName($id) {
            $query = "SELECT tbl_product.*,tbl_category.catName
            FROM tbl_product INNER JOIN tbl_category ON tbl_product.catId = tbl_category.catId 
            WHERE tbl_product.catId = '$id' LIMIT 1";
            // hoặc có thể sử dụng như sau
            // cách truy vấn 2:
            // $query = "SELECT tbl_product.*,tbl_category.catName,tbl_category.catId FROM tbl_product, tbl_category
            // WHERE tbl_product.catId = tbl_category.catId  AND tbl_product.catID= '$id' LIMIT 1";
            $result = $this->db->select($query);
            return $result;
        }
    }
?>