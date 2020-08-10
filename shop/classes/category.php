<?php
    // goi den cong viec ma ham can thuc hien
    include '../lib/database.php';
    include '../helper/format.php';
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
    }
?>