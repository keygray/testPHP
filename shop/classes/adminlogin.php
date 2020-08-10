<?php
    include '../lib/session.php';
    // goi den cong viec ma ham can thuc hien
    Session::checkLogin();
    include '../lib/database.php';
    include '../helper/format.php';
?>

<?php
    class adminlogin {
        // khai báo biến
        private $db;
        private $fm;
        public function __construct(){
            // tao đối tượng nhưng chỉ dùng ở trong file này
            $this->db = new Database();
            $this->fm = new Format();
        }

        public function login_admin($adminUser,$adminPass) {
            // kiểm tra xem có phù hợp về chuỗi hay không (không khoảng cách...)
            $adminUser = $this->fm->validation($adminUser);
            $adminPass = $this->fm->validation($adminPass);
            // kết nối tới cơ sở dữ liệu qua biến link trong hàm database()
            $adminUser = mysqli_real_escape_string($this->db->link, $adminUser);
            $adminPass = mysqli_real_escape_string($this->db->link, $adminPass);
        
            if(empty($adminUser) || empty($adminPass)){
                $alert = "User and Pass empty";
                return $alert;
            }
            else {
                // ghi câu truy vấn sql
                $query = "SELECT * FROM tbl_admin WHERE adminUser = '$adminUser' AND adminPass = '$adminPass' LIMIT 1";
                // gọi function thực hiện trong database
                $result = $this->db->select($query);
                if($result != false){
                    // fetch_assoc && fetch_array 
                    // lấy kết quả biến result truyền cho biến value
                    $value = $result->fetch_assoc();
                    // set cho biến này bằng true nếu đúng có tài khoản
                    Session::set('adminlogin',true);
                    // lấy giá trị từ value của database truyền cho biến adminId,....
                    // biến phía trước có thể đặt tên tùy ý nhưng nên đặt giống db => đỡ nhầm
                    Session::set('adminId',$value['adminId']);
                    Session::set('adminUser',$value['adminUser']);
                    Session::set('adminName',$value['adminName']);
                    // các biến trên có tác dụng sử dụng sau này như kiểu khi ddanwg nhập vào xin chào tên người đo
                    // nhập đúng hết rồi thì quay về trang chính
                    header('Location:index.php');
                }
                else {
                    $alert = "User or Pass not match";
                    return $alert;
                }

            }
        }
    }
?>