<?php
	session_start();
	require_once('../inc/functions.php');
	if (isset($_SESSION['user_level']) && $_SESSION['user_level'] == 2) :
		//Nếu có thông tin người dùng và đã đăng nhập sẽ logout người dùng
		$_SESSION = array(); //Xóa hết mọi SESSION
		session_destroy(); // Destroy session đã tạo
		setcookie(session_name(),'', time()-36000);//Xóa cookie của trình duyệt
		redirect_to('admin/login.php');
	else:
		//Nếu người dùng chưa đăng nhập và không có thông tin trong hệ thống
		redirect_to();
	endif;

?>