<?php
	session_start();
	ob_start();
	if (!isset($_SESSION['user_level']) or $_SESSION['user_level'] != 2) {
		header("Location: http://localhost/elextric/admin/login.php");
		exit();
	}
	require_once('../inc/functions.php');
	require_once('../inc/mysqli_connect.php');
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset='UTF-8' />

	<title><?php echo (isset($title)) ? $title : "Administration Site | Elextronic"; ?></title>

	<link rel="stylesheet" type="text/css" href="../css/style.css" />

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript" src='../js/tooltip.js'></script>
	<script type="text/javascript" src='../js/clock.js'></script>
	<script type="text/javascript" src="../js/tinymce/tiny_mce.js"></script>
	<script type="text/javascript">
	tinyMCE.init({
        mode : "textareas",
        theme : "advanced",
        plugins : "emotions,spellchecker,advhr,insertdatetime,preview",
        // Theme options - button# indicated the row# only
        theme_advanced_buttons1 : "newdocument,|,bold,italic,underline,|,justifyleft,justifycenter,justifyright,fontselect,fontsizeselect,formatselect",
        theme_advanced_buttons2 : "cut,copy,paste,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,anchor,image,|,code,preview,|,forecolor,backcolor",
        theme_advanced_buttons3 : "insertdate,inserttime,|,spellchecker,advhr,,removeformat,|,sub,sup,|,charmap,emotions",
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true
        });
	</script>

</head>

<body class="admin" onload="showTimeSec();">
	<div id="wrapper">
		<!--===== TOP =====-->
		<div id="top">
			<p><a href="index.php">Administration Site</a></p>
		</div><!--end #top-->

		<!--===== NAV MENU =====-->
		<div id="nav-menu" class="group">
			<img src="../images/menu_left.gif" alt="left-menu" />
			<ul>
				<li><a href="index.php" id="nav-home">Admin CP</a></li>
				<li><img src="../images/menu_divider.gif" alt="menu-divider" /></li>
				<li><a href="p-categories.php" id="nav-pro-cat">Danh mục sản phẩm</a></li>
				<li><img src="../images/menu_divider.gif" alt="menu-divider" /></li>
				<li><a href="products.php" id="nav-a-pro">Sản phẩm</a></li>
				<li><img src="../images/menu_divider.gif" alt="menu-divider" /></li>
				<li><a href="order.php" id="nav-ord">Đơn hàng</a></li>
				<li><img src="../images/menu_divider.gif" alt="menu-divider" /></li>
				<li><a href="n-categories.php" id="nav-new-cat">Danh mục bài viết</a></li>
				<li><img src="../images/menu_divider.gif" alt="menu-divider" /></li>
				<li><a href="news.php" id="nav-new">Bài viết</a></li>
				<li><img src="../images/menu_divider.gif" alt="menu-divider" /></li>
				<li><a href="users.php" id="nav-user">Thành viên</a></li>
			</ul>
			<img src="../images/menu_right.gif" alt="right-menu" />
		</div><!--end #nav-menu-->