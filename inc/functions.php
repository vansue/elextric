<?php
	//Xác định hằng số cho địa chỉ tuyệt đối
	define('BASE_URL', 'http://localhost:8080/elextric/');

	//Kiểm tra xem kết quả trả về có đúng hay không
	function confirm_query($result, $query) {
		global $dbc;
		if (!$result) {
			die("Cau truy van: $query \n<br /> Loi MySQL: ".mysqli_error($dbc));
		}
	}

	//Kiểm tra xem người dùng đã đăng nhập hay chưa
	function is_logged_in() {
		if (!isset($_SESSION['uid'])) {
			redirect_to('login.php');
		}
	}

	//Tái định hướng người dùng về trang mặc định là elextric/index.php
	function redirect_to($page = 'index.php') {
		$url = BASE_URL.$page;
		header("Location: $url");
		exit();
	}

	//Hàm này để thông báo lỗi
	function report_error($mesg) {
		if(!empty($mesg)) {
			foreach ($mesg as $m) {
				echo $m;
			}
		}
	}

	//Hàm kiểm tra xem có phải admin hay không
	function is_admin() {
		return isset($_SESSION['user_level']) && ($_SESSION['user_level'] == 2);
	}

	//Kiểm tra xem người dùng có thể vào trang admin hay không
	function admin_success() {
		if(!is_admin()) {
			redirect_to();
		}
	}
