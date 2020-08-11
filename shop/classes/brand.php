<?php
    // goi den cong viec ma ham can thuc hien
    include_once '../lib/database.php';
    include_once '../helper/format.php';
    // cần đổi thành once vì mai này khi làm file product add gọi lại sẽ bị undefid kết nối với DB
?>

<?php
    class brand {
        // khai báo biến
        private $db;
        private $fm;
        public function __construct(){
            // tao đối tượng nhưng chỉ dùng ở trong file này
            $this->db = new Database();
            $this->fm = new Format();
        }

        public function insert_brand($brandName) {
            // kiểm tra xem có phù hợp về chuỗi hay không (không khoảng cách...)
            $brandName = $this->fm->validation($brandName);
            // kết nối tới cơ sở dữ liệu qua biến link trong hàm database()
            $brandName = mysqli_real_escape_string($this->db->link, $brandName);
        
            if(empty($brandName)){
                $alert = "<span class='error'>Brand name is empty</span>";
                return $alert;
            }
            else {
                // ghi câu truy vấn sql
                $query = "INSERT INTO  tbl_brand(brandName) VALUES ('$brandName')";
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
        public function show_brand() {
            // sắp xếp theo ID theo thứ tự desc (giảm dần)
            $query = "SELECT * FROM  tbl_brand order by brandId desc";
            // gọi function thực hiện trong database
            $result = $this->db->select($query);
            return $result;
        }

        public function getbrandbyId($id){
            $query = "SELECT * FROM  tbl_brand WHERE brandId = '$id'";
            $result = $this->db->select($query);
            return $result;
        }

        public function update_brand($brandName,$id){
              // kiểm tra xem có phù hợp về chuỗi hay không (không khoảng cách...)
            $brandName = $this->fm->validation($brandName);
              // kết nối tới cơ sở dữ liệu qua biến link trong hàm database()
            $brandName = mysqli_real_escape_string($this->db->link, $brandName);
            $id = mysqli_real_escape_string($this->db->link, $id);
            if(empty($brandName)){
                $alert = "<span class='error'>Brand name is empty</span>";
                return $alert;
            }
            else {
                // ghi câu truy vấn sql
                $query = "UPDATE tbl_brand SET brandName= '$brandName' WHERE brandId = '$id'";
                // gọi function thực hiện trong database
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
        public function delete_brand($id){
            $query = "DELETE FROM tbl_brand where brandId = '$id'";
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
    }
?>