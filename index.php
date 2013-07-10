<?php
	ob_start();
	require_once('inc/functions.php');
	require_once('inc/mysqli_connect.php');

	$cats = array();

	if (isset($_GET['ncid']) && filter_var($_GET['ncid'], FILTER_VALIDATE_INT, array('min_range'=>1))) :
		$ncid = $_GET['ncid'];
		$pcid = NULL;
		$query = "SELECT cat_name FROM n_categories WHERE cat_id = {$ncid}";
		$result = mysqli_query($dbc, $query);
			confirm_query($result, $query);
		if (mysqli_num_rows($result) == 1) {
			list($ncat_name) = mysqli_fetch_array($result, MYSQLI_NUM);
			$title = $ncat_name." | Elextronic";
			$cats[] = array('ncat_name'=>$ncat_name);
		} else {
			//Không có danh mục tin, quay về trang chủ
            redirect_to();
		}
    elseif(isset($_GET['pcid']) && filter_var($_GET['pcid'], FILTER_VALIDATE_INT, array('min_range'=>1))) :
		$pcid = $_GET['pcid'];
		$ncid = NULL;
		$query = "SELECT cat_name FROM p_categories WHERE cat_id = {$pcid}";
		$result = mysqli_query($dbc, $query);
			confirm_query($result, $query);
		if (mysqli_num_rows($result) == 1) {
			list($pcat_name) = mysqli_fetch_array($result, MYSQLI_NUM);
			$title = $pcat_name." | Elextronic";
			$cats[] = array('pcat_name'=>$pcat_name);
		} else {
			//Không có danh mục tin, quay về trang chủ
            redirect_to();
		}
	else :
		$pcid = NULL;
		$ncid = NULL;
	endif;
	include('inc/header.php');
	include('inc/first-sidebar.php');
?>
<div id="main-content">
<?php
	if (isset($ncid)) :
	//Hiển thị danh mục bài viết==========================================================================
		foreach ($cats as $cat) {
			echo "
				<div class='title-content'>
					<p>{$cat['ncat_name']}</p>
				</div>
			";
		}
		//Phân trang danh mục bài viết
		//Đặt số trang muốn hiển thị ra trình duyệt
		$display = 3;
		//Xác định vị trí bắt đầu
		$start = (isset($_GET['s']) && filter_var($_GET['s'], FILTER_VALIDATE_INT, array('min_range' => 1))) ? $_GET['s'] : 0;

		$q = "SELECT p.page_name, p.page_id, p.intro_img, p.content, ";
		$q .= " date_format(p.post_on, '%b %d, %y') AS date, ";
		$q .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, u.user_id ";
		$q .= " FROM pages AS p ";
		$q .= " INNER JOIN users AS u ";
		$q .= " USING (user_id) ";
		$q .= " WHERE p.cat_id={$ncid} ";
		$q .= " ORDER BY post_on DESC LIMIT {$start}, {$display}";
		$r = mysqli_query($dbc, $q);
			confirm_query($r, $q);
		if(mysqli_num_rows($r) > 0) {
            //Nếu có post thì hiển thị ra trình duyệt
            while($pages = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
                echo "
                    <div class='post'>
                    	<img src='images/news/{$pages['intro_img']}' alt='' />
                        <h2><a href='single.php?pnid={$pages['page_id']}'>{$pages['page_name']}</a></h2>
                        <div>".the_excerpt($pages['content'])." ... <a href='single.php?pnid={$pages['page_id']}'>Xem tiếp</a></div>
                        <p class='meta'><strong>Viết bởi:</strong>  {$pages['name']} | <strong>Ngày: </strong> {$pages['date']} </p>
                    </div>
                ";
            } //end while loop

        } else {
            echo "<p class='notice'>Chưa có bài viết nào trong mục này</p>";
        }

        pagination($ncid, $display);

    elseif (isset($pcid)) :
    //Hiển thị danh mục sản phẩm===========================================================================
		foreach ($cats as $cat) {
			echo "
				<div class='title-content'>
					<p>{$cat['pcat_name']}</p>
				</div>
			";
		}

		//Phân trang danh mục bài viết
		//Đặt số trang muốn hiển thị ra trình duyệt
		$display = 6;
		//Xác định vị trí bắt đầu
		$start = (isset($_GET['s']) && filter_var($_GET['s'], FILTER_VALIDATE_INT, array('min_range' => 1))) ? $_GET['s'] : 0;

		$q = "SELECT * FROM products WHERE cat_id = {$pcid} ORDER BY post_on DESC LIMIT {$start}, {$display}";
		$r = mysqli_query($dbc, $q); confirm_query($r, $q);
		if (mysqli_num_rows($r) > 0) {
			while ($products = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
				echo "
					<div class='product-box'>
						<img src='images/product_box_top.gif' alt='' class='top-prod-box' />
						<div class='cen-prod-box'>
							<h4><a href='single.php?ppid={$products['pro_id']}'>{$products['pro_name']}</a></h4>
							<a href='single.php?ppid={$products['pro_id']}'><img src='images/products/{$products['intro_img']}' alt='{$products['pro_name']}'></a>
							<p class='price'>".number_format($products['price'],0,',','.')." VNĐ</p>
						</div>
						<img src='images/product_box_bottom.gif' alt='' class='bot-prod-box' />
						<div class='prod-detail-tab group'>
							<a href='cart.php?pid={$products['pro_id']}' data-tooltip='Add to cart' class='tool'><img src='images/cart.gif' alt='' /></a>
							<a href='' data-tooltip='Khuyến mãi: ".strip_tags($products['promotion'])."' class='tool'><img src='images/favs.gif' alt='' /></a>
							<a href='' data-tooltip='Bảo hành: {$products['garantie']} tháng' class='tool'><img src='images/favorites.gif' alt='' /></a>
							<a href='single.php?ppid={$products['pro_id']}' class='detail-a'>Chi tiết</a>
						</div>
					</div>
				";
			}
		} else {
	        echo "<p class='notice'>Chưa có sản phẩm nào trong mục này</p>";
	    }
	    pagination($pcid, $display, 'index.php', 'pcid', 'pro_id', 'products');

	//Trang chủ=====================================================================================================
	else :
?>
		<div class="title-content">
			<p>Sản phẩm mới</p>
		</div>
<?php
		$q = "SELECT * FROM products ORDER BY post_on DESC LIMIT 6";
		$r = mysqli_query($dbc, $q); confirm_query($r, $q);
		if (mysqli_num_rows($r) > 0) {
			while ($products = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
				echo "
					<div class='product-box'>
						<img src='images/product_box_top.gif' alt='' class='top-prod-box' />
						<div class='cen-prod-box'>
							<h4><a href='single.php?ppid={$products['pro_id']}'>{$products['pro_name']}</a></h4>
							<a href='single.php?ppid={$products['pro_id']}'><img src='images/products/{$products['intro_img']}' alt='{$products['pro_name']}'></a>
							<p class='price'>".number_format($products['price'],0,',','.')." VNĐ</p>
						</div>
						<img src='images/product_box_bottom.gif' alt='' class='bot-prod-box' />
						<div class='prod-detail-tab group'>
							<a href='cart.php?pid={$products['pro_id']}' data-tooltip='Add to cart' class='tool'><img src='images/cart.gif' alt='' /></a>
							<a href='' data-tooltip='Khuyến mãi: ".strip_tags($products['promotion'])."' class='tool'><img src='images/favs.gif' alt='' /></a>
							<a href='' data-tooltip='Bảo hành: {$products['garantie']} tháng' class='tool'><img src='images/favorites.gif' alt='' /></a>
							<a href='single.php?ppid={$products['pro_id']}' class='detail-a'>Chi tiết</a>
						</div>
					</div>
				";
			}
		}
?>
		<div class="title-content">
			<p>Thông tin khuyến mãi</p>
		</div>
<?php
		$q = "SELECT p.page_name, p.page_id, p.intro_img, p.content, ";
		$q .= " date_format(p.post_on, '%b %d, %y') AS date, ";
		$q .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, u.user_id ";
		$q .= " FROM pages AS p ";
		$q .= " INNER JOIN users AS u ";
		$q .= " USING (user_id) ";
		$q .= " WHERE p.cat_id=5 ";
		$q .= " ORDER BY post_on DESC LIMIT 1";
		$r = mysqli_query($dbc, $q);
			confirm_query($r, $q);
		if(mysqli_num_rows($r) > 0) {
	        //Nếu có post thì hiển thị ra trình duyệt
	        while($pages = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	            echo "
	                <div class='post'>
	                	<img src='images/news/{$pages['intro_img']}' alt='' />
	                    <h2><a href='single.php?pnid={$pages['page_id']}'>{$pages['page_name']}</a></h2>
	                    <div>".the_excerpt($pages['content'])." ... <a href='single.php?pnid={$pages['page_id']}'>Xem tiếp</a></div>
	                    <p class='meta'><strong>Viết bởi:</strong> <a href='author.php?aid={$pages['user_id']}'> {$pages['name']}</a> | <strong>Ngày: </strong> {$pages['date']} </p>
	                </div>
	            ";
	        } //end while loop

	    } else {
	        echo "<p class='notice block'>Chưa có bài viết nào trong mục này</p>";
	    }
?>

<?php endif; ?>
</div><!--end #main-content-->

<?php
	include('inc/second-sidebar.php');
	include('inc/footer.php');
?>