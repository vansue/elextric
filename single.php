<?php
	ob_start();
	require_once('inc/functions.php');
	require_once('inc/mysqli_connect.php');
?>


<?php
	$posts = array();
	//Hiển thị danh mục bài viết==========================================================================
	if (isset($_GET['pnid']) && filter_var($_GET['pnid'], FILTER_VALIDATE_INT, array('min_range'=>1))) :
		$pnid = $_GET['pnid'];
		$ppid = NULL;

		$q = "SELECT p.page_name, p.page_id, p.intro_img, p.content, ";
		$q .= " date_format(p.post_on, '%b %d, %y') AS date, ";
		$q .= " CONCAT_WS(' ', u.first_name, u.last_name) AS name, u.user_id ";
		$q .= " FROM pages AS p ";
		$q .= " INNER JOIN users AS u ";
		$q .= " USING (user_id) ";
		$q .= " WHERE p.page_id={$pnid} ";
		$q .= " LIMIT 1";
		$r = mysqli_query($dbc, $q);
			confirm_query($r, $q);
		if(mysqli_num_rows($r) == 1) {
            //Nếu có post thì hiển thị ra trình duyệt
            $pages = mysqli_fetch_array($r, MYSQLI_ASSOC);
            $title = $pages['page_name']." | Elextronic";
            $posts[] = array('user_id'=>$pages['user_id'], 'page_name'=>$pages['page_name'], 'content'=>$pages['content'], 'name'=>$pages['name'], 'date'=>$pages['date']);
        } else {
            echo "<p class='notice'>Bài viết không tồn tại.</p>";
        }

    //Hiển thị danh mục sản phẩm
    elseif(isset($_GET['ppid']) && filter_var($_GET['ppid'], FILTER_VALIDATE_INT, array('min_range'=>1))) :
    	$pnid = NULL;
		$ppid = $_GET['ppid'];

		$q = "SELECT * FROM products WHERE pro_id = {$ppid} LIMIT 1";
		$r = mysqli_query($dbc, $q); confirm_query($r, $q);
		if (mysqli_num_rows($r) == 1) :
			$products = mysqli_fetch_array($r, MYSQLI_ASSOC);
			$title = $products['pro_name']." | Elextronic";
			$posts[] = array('pro_name'=>$products['pro_name'], 'intro_img'=>$products['intro_img'], 'intro_text'=>$products['intro_text'], 'price'=>$products['price'], 'garantie'=>$products['garantie'], 'promotion'=>$products['promotion'], 'details'=>$products['details']);
		else:
			echo "<p class='notice'>Sản phẩm không tồn tại.</p>";
		endif;
    endif;
	include('inc/header.php');
	include('inc/first-sidebar.php');
?>

<div id="main-content">

<?php
	if (isset($pnid)) {
		foreach ($posts as $post) {
			echo "
        	<div class='title-content'>
				<p>{$post['page_name']}</p>
			</div>
            <div class='p-post'>
                <div>".$post['content']."</div>
                <p class='meta'><strong>Viết bởi:</strong>  {$post['name']} | <strong>Ngày: </strong> {$post['date']} </p>
            </div>
        ";
		}
?>
		<div class='title-content'>
			<p>Bình luận</p>
		</div>
<?php
		include('inc/comment_form.php');
	} elseif (isset($ppid)) {
		foreach ($posts as $post) {
?>
			<div class="title-content">
				<p><?php echo $post['pro_name']; ?></p>
			</div>

			<div class="product-box-big">
				<img src='images/details_box_top.gif' alt='' class='top-prod-box-big' />
				<div class='cen-prod-box-big'>
					<img src='images/products/<?php echo $post['intro_img']; ?>' alt='<?php echo $post['pro_name']; ?>'>
					<h4><?php echo $post['pro_name']; ?></h4>
					<div><strong>Mô tả: </strong><?php echo strip_tags($post['intro_text']); ?></div>
					<div><strong>Giá: </strong><?php echo number_format($post['price'],0,',','.'); ?> VNĐ</div>
					<div><strong>Bảo hành: </strong><?php echo $post['garantie']; ?> tháng</div>
					<div><strong>Khuyến mãi: </strong><?php echo strip_tags($post['promotion']); ?></div>

					<a href="cart.php?pid=<?php echo $ppid;?>" class='addtocard'>Add to card</a>
				</div>
				<img src='images/details_box_bottom.gif' alt='' class='bot-prod-box-big' />
			</div>

			<div class="title-content">
				<p>Thông số kỹ thuật</p>
			</div>

			<div class="product-box-big">
				<img src='images/details_box_top.gif' alt='' class='top-prod-box-big' />
				<div class='cen-prod-box-big'>
					<div class='details'>
					<?php echo $post['details']; ?>
					</div>
				</div>
				<img src='images/details_box_bottom.gif' alt='' class='bot-prod-box-big' />
			</div>
<?php
		}
	} else {
		redirect_to();
	}
?>
</div><!--end #main-content-->

<?php
	include('inc/second-sidebar.php');
	include('inc/footer.php');
?>