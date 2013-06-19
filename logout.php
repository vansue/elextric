<?php
	ob_start();
	include('header.php');
	include('inc/functions.php');
	include('inc/mysqli_connect.php');
	include('first-sidebar.php');
?>

<?php
	if (!isset($_SESSION['last_name'])) :
		//Nếu người dùng chưa đăng nhập và không có thông tin trong hệ thống
		redirect_to();
	else :
		//Nếu có thông tin người dùng và đã đăng nhập sẽ logout người dùng
		$_SESSION = array(); //Xóa hết mọi SESSION
		session_destroy(); // Destroy session đã tạo
		setcookie(session_name(),'', time()-36000);//Xóa cookie của trình duyệt

?>

<div id="main-content">
    <div class="title-content">
        <p>Đăng xuất</p>
    </div>
    <p class='notice success'>Bạn đã đăng xuất thành công. Trở về <a href="index.php">trang chủ</a></p>
</div><!--end #main-content-->
<?php endif; ?>
<?php
	include('second-sidebar.php');
	include('footer.php');
?>