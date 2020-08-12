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
        
    }
?>