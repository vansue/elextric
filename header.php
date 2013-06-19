<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
	<meta charset='UTF-8' />

	<title><?php echo (isset($title)) ? $title : "Elextronic"; ?></title>

	<link rel="stylesheet" type="text/css" href="css/style.css" />

	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
	<script type="text/javascript" src='js/tooltip.js'></script>
	<script type="text/javascript" src='js/check-ajax.js'></script>
</head>

<body>
	<div id="wrapper">
		<!--===== TOP =====-->
		<div id="top">
			<div id="language">
				<h3>Languages: </h3>
				<a href="#"><img src="images/vi.gif" alt="VI" /></a>
				<a href="#"><img src="images/en.png" alt="EN" /></a>
			</div>

			<div id="search">
				<a href="#">Advanced Search</a>
				<form action="search.html" method="post" name="fsearch" id="fsearch">
					<input type="text" name="txtSearch" id="txtSearch" />
					<input type="image" src="images/search.gif" name="imgSearch" id="imgSearch" alt="imgSearch" />
				</form>
			</div>
		</div><!--end #top-->

		<!--===== HEADER =====-->
		<div id="header">
			<h1 id="logo"><a href="index.php">Electronix</a></h1>
			<div id="slider">
				<img src="images/slide_divider.png" alt="" class="slide-divider" />
				<div id="slide-content">
					<img src="images/laptop.png" alt="" />

					<div id="slide-detail">
						<h3><a href="#">Samsung GX 2004 LM</a></h3>
						<p>
							Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do iusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim eniam, quis nostrud exercitation ullamco
						</p>
						<a href="#" id="detail">Xem tiếp</a>
					</div>

					<div class="group"></div>
					<div id="pagination">
						<a href="#" class="active">1</a>
						<a href="#">2</a>
						<a href="#">3</a>
						<a href="#">4</a>
						<a href="#">5</a>
					</div>
				</div><!--slide-content-->
				<img src="images/slide_divider.png" alt="" class="slide-divider" />
			</div><!--end #slider-->
		</div><!--end #header-->

		<!--===== NAV MENU =====-->
		<div id="nav-menu" class="group">
			<img src="images/menu_left.gif" alt="left-menu" />
			<ul>
				<li><a href="index.php" id="nav-home">Trang chủ</a></li>
				<li><img src="images/menu_divider.gif" alt="menu-divider" /></li>
				<li><a href="#" id="nav-pro">Sản phẩm</a></li>
				<li><img src="images/menu_divider.gif" alt="menu-divider" /></li>
				<li><a href="#" id="nav-spe">Specials</a></li>
				<li><img src="images/menu_divider.gif" alt="menu-divider" /></li>
				<li><a href="register.php" id="nav-acc">Đăng ký</a></li>
				<li><img src="images/menu_divider.gif" alt="menu-divider" /></li>
				<li><a href="login.php" id="nav-sig">Đăng nhập</a></li>
				<li><img src="images/menu_divider.gif" alt="menu-divider" /></li>
				<li><a href="#" id="nav-shipping">Shipping</a></li>
				<li><img src="images/menu_divider.gif" alt="menu-divider" /></li>
				<li><a href="contact.html" id="nav-con">Liên hệ</a></li>
				<li><img src="images/menu_divider.gif" alt="menu-divider" /></li>
				<li id="nav-cur">Currencies
					<form>
						<select>
							<option>US Dollar</option>
							<option>VN Đồng</option>
						</select>
					</form>
				</li>
			</ul>
			<img src="images/menu_right.gif" alt="right-menu" />
		</div><!--end #nav-menu-->

		<!--===== NAVIGATION =====-->
		<div id="navigation">
			Navigation: <a href="#" class="current">Home</a>
		</div>