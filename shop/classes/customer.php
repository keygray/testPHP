<?php
    $filepath = realpath(dirname(__FILE__));
    // goi den cong viec ma ham can thuc hien
    include_once ($filepath.'/../lib/database.php');
    include_once ($filepath.'/../helper/format.php');
    // cần đổi thành once vì mai này khi làm file product add gọi lại sẽ bị undefid kết nối với DB
?>
<?php
    class customer {
        // khai báo biến
        private $db;
        private $fm;
        public function __construct(){
            // tao đối tượng nhưng chỉ dùng ở trong file này
            $this->db = new Database();
            $this->fm = new Format();
        }
        public function insert_customer($data){
            $password = $this->fm->validation($data['password']);
            $name = mysqli_real_escape_string($this->db->link, $data['name']);
            $city = mysqli_real_escape_string($this->db->link, $data['city']);
            $zipcode = mysqli_real_escape_string($this->db->link, $data['zipcode']);
            $email = mysqli_real_escape_string($this->db->link, $data['email']);
            $address = mysqli_real_escape_string($this->db->link, $data['address']);
            $country = mysqli_real_escape_string($this->db->link, $data['country']);
            $phone = mysqli_real_escape_string($this->db->link, $data['phone']);
            $password = mysqli_real_escape_string($this->db->link, md5($data['password']));

            if($name=="" || $city=="" || $zipcode=="" || $email=="" || $address=="" || $country=="" || $phone=="" || $password==""){
                $alert = "<span class='error'>This field not be to allow empty</span>";
                return $alert;
            }
            else {
                // kiểm tra mỗi email chỉ đc tạo 1 tài khoản
                $check_email = "SELECT * FROM tbl_customer WHERE email='$email' LIMIT 1";
                $result_email =  $this->db->select($check_email);
                if($result_email){
                    $msg = "<span class='error'>This email already existed</span>";
                    return $msg;
                }
                else{
                    $query = "INSERT INTO  tbl_customer(name,address,city,country,zipcode,phone,email,password) VALUES ('$name','$address','$city','$country','$zipcode','$phone','$email','$password')";
                    $result = $this->db->insert($query);
                    if($result){
                        $alert = "<span class='success'>Res Successfull</span>";
                        return $alert;
                    }
                    else {
                        $alert = "<span class='error'>Res Not Successfull</span>";
                        return $alert;
                    }
                }
            }
        }
        
        public function login_customer($data) {
            // kiểm tra xem có phù hợp về chuỗi hay không (không khoảng cách...)
            $email = $this->fm->validation($data['emaillogin']);
            $password = $this->fm->validation($data['passwordlogin']);
            // kết nối tới cơ sở dữ liệu qua biến link trong hàm database()
            $email = mysqli_real_escape_string($this->db->link, $data['emaillogin']);
            $password = mysqli_real_escape_string($this->db->link, md5($data['passwordlogin']));

        
            if(empty($email) || empty($password)){
                $alert = "User and Pass empty";
                return $alert;
            }
            else {
                // ghi câu truy vấn sql
                $query = "SELECT * FROM tbl_customer WHERE email = '$email' AND password = '$password' LIMIT 1";
                // gọi function thực hiện trong database
                $result = $this->db->select($query);
                if($result != false){
                    // fetch_assoc && fetch_array 
                    // lấy kết quả biến result truyền cho biến value
                    $value = $result->fetch_assoc();
                    // set cho biến này bằng true nếu đúng có tài khoản
                    Session::set('customer_login',true);
                    // lấy giá trị từ value của database truyền cho biến adminId,....
                    // biến phía trước có thể đặt tên tùy ý nhưng nên đặt giống db => đỡ nhầm
                    Session::set('customer_Id',$value['id']);
                    Session::set('customerName',$value['name']);
                    Session::set('customerEmail',$value['email']);
                    // các biến trên có tác dụng sử dụng sau này như kiểu khi ddanwg nhập vào xin chào tên người đo
                    // nhập đúng hết rồi thì quay về trang chính
                    header('Location:order.php');
                }
                else {
                    $alert = "User or Pass not match";
                    return $alert;
                }

            }
        }
        
    }
?>