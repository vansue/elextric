<?php
	session_start();
	require_once('functions.php');
	require_once('mysqli_connect.php');
?>
<!DOCTYPE html>
<html>

<head>
	<meta charset='UTF-8' />

	<title><?php echo (isset($title)) ? $title : "Elextronic"; ?></title>

	<link rel="stylesheet" type="text/css" href="css/style.css" />

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript" src='js/tooltip.js'></script>
	<script type="text/javascript" src='js/check-ajax.js'></script>
	<script type="text/javascript" src='js/delete-comment.js'></script>
	<script type="text/javascript" src="js/tinymce/tiny_mce.js"></script>
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

<body>
	<div id="wrapper">
		<!--===== TOP =====-->
		<div id="top">
			<div id="right-header">
				<ul>
					<?php
					if (isset($_SESSION['user_level'])) {
						//Nếu có SESSION
						switch ($_SESSION['user_level']) {
							case 1://Khách hàng
								echo "
									<li><a href='edit-profile.php'>".$_SESSION['first_name']." ".$_SESSION['last_name']."</a></li>
									<li><a href='change-pass.php'>Đổi mật khẩu</a></li>
									<li><a href='logout.php'>Thoát</a></li>
								";
								break;

							case 2://Admin
								echo "
									<li><a href='edit-profile.php'> Xin chào ".$_SESSION['first_name']." ".$_SESSION['last_name']."</a></li>
									<li><a href='change-pass.php'>Đổi mật khẩu</a></li>
									<li><a href='logout.php'>Thoát</a></li>
									<li><a href='admin/index.php' target='bank'>Admin CP</a></li>
								";
								break;

							default:
								echo "
									<li><a href='register.php'>Đăng ký</a></li>
									<li><a href='login.php'>Đăng nhập</a></li>
								";
								break;
						}
					} else {
						//Nếu không có SESSION
						echo "
							<li><a href='register.php'>Đăng ký</a></li>
							<li><a href='login.php'>Đăng nhập</a></li>
						";
					}

					?>
				</ul>
			</div>
		</div><!--end #top-->
		<!--===== HEADER =====-->
		<div id="header">
			<h1 id="logo"><a href="index.php">Electronix</a></h1>

		</div><!--end #header-->

		<!--===== NAV MENU =====-->
		<div id="nav-menu" class="group">
			<img src="images/menu_left.gif" alt="left-menu" />
			<ul>
				<li><a href="index.php" id="nav-home">Trang chủ</a></li>
				<li><img src="images/menu_divider.gif" alt="menu-divider" /></li>
				<?php
					$q = "SELECT cat_id, cat_name FROM n_categories ORDER BY position LIMIT 6";
					$r = mysqli_query($dbc, $q);
						confirm_query($r, $q);
					while($ncats = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
						echo "<li><a href='index.php?ncid=".$ncats['cat_id']."' id='nav-".$ncats['cat_id']."'>".$ncats['cat_name']."</a></li>";
						echo "<li><img src='images/menu_divider.gif' alt='menu-divider' /></li>";
					}
				?>
				<li><a href="contact.php" id="nav-33">Liên hệ</a></li>
				<li><img src="images/menu_divider.gif" alt="menu-divider" /></li>
			</ul>
			<img src="images/menu_right.gif" alt="right-menu" />
		</div><!--end #nav-menu-->