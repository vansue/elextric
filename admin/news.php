<?php
	include('header.php');
	include('../inc/mysqli_connect.php');
	include('first-sidebar.php');
?>

	<div id="main-content">
		<div class="title-content">
			<p>Bài viết</p>
		</div>

		<div class="product-box">
			<img src="../images/product_box_top.gif" alt="" class="top-prod-box" />
			<div class="cen-prod-box">
				<a href="#"><img src="../images/news.png" alt=""></a>
				<h4><a href="#">Danh mục sản phẩm</a></h4>
			</div>
			<img src="../images/product_box_bottom.gif" alt="" class="bot-prod-box" />
		</div><!--end .product-box-->

		<div class="product-box">
			<img src="../images/product_box_top.gif" alt="" class="top-prod-box" />
			<div class="cen-prod-box">
				<a href="#"><img src="../images/ab_pro.png" alt=""></a>
				<h4><a href="#">Danh sách sản phẩm</a></h4>
			</div>
			<img src="../images/product_box_bottom.gif" alt="" class="bot-prod-box" />
		</div><!--end .product-box-->

		<div class="product-box">
			<img src="../images/product_box_top.gif" alt="" class="top-prod-box" />
			<div class="cen-prod-box">
				<a href="#"><img src="../images/ab_ord.png" alt=""></a>
				<h4><a href="#">Quản lý đơn hàng</a></h4>
			</div>
			<img src="../images/product_box_bottom.gif" alt="" class="bot-prod-box" />
		</div><!--end .product-box-->
		<div class="product-box">
			<img src="../images/product_box_top.gif" alt="" class="top-prod-box" />
			<div class="cen-prod-box">
				<a href="add-n-categories.php"><img src="../images/ab_news_cat.png" alt=""></a>
				<h4><a href="add-n-categories.php">Danh mục bài viết</a></h4>
			</div>
			<img src="../images/product_box_bottom.gif" alt="" class="bot-prod-box" />
		</div><!--end .product-box-->

		<div class="product-box">
			<img src="../images/product_box_top.gif" alt="" class="top-prod-box" />
			<div class="cen-prod-box">
				<a href="#"><img src="../images/ab_news.png" alt=""></a>
				<h4><a href="#">Danh sách bài viết</a></h4>
			</div>
			<img src="../images/product_box_bottom.gif" alt="" class="bot-prod-box" />
		</div><!--end .product-box-->

		<div class="product-box">
			<img src="../images/product_box_top.gif" alt="" class="top-prod-box" />
			<div class="cen-prod-box">
				<a href="#"><img src="../images/ab_user.png" alt=""></a>
				<h4><a href="#">Quản lý thành viên</a></h4>
			</div>
			<img src="../images/product_box_bottom.gif" alt="" class="bot-prod-box" />
		</div><!--end .product-box-->

		<div class="product-box">
			<img src="../images/product_box_top.gif" alt="" class="top-prod-box" />
			<div class="cen-prod-box">
				<a href="#"><img src="../images/ab_comm.png" alt=""></a>
				<h4><a href="#">Quản lý bình luận</a></h4>
			</div>
			<img src="../images/product_box_bottom.gif" alt="" class="bot-prod-box" />
		</div><!--end .product-box-->

	</div><!--end #main-content-->
<?php
	include('second-sidebar.php');
	include('footer.php');
?>