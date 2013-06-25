<?php
	ob_start();
	include('inc/header.php');
	require_once('inc/functions.php');
	require_once('inc/mysqli_connect.php');
	include('inc/first-sidebar.php');
?>
<div id="main-content">

<?php
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
		if(mysqli_num_rows($r) > 0) {
            //Nếu có post thì hiển thị ra trình duyệt
            $pages = mysqli_fetch_array($r, MYSQLI_ASSOC);
            echo "
            	<div class='title-content'>
					<p>{$pages['page_name']}</p>
				</div>
                <div class='p-post'>
                    <div>".$pages['content']."</div>
                    <p class='meta'><strong>Viết bởi:</strong> <a href='author.php?aid={$pages['user_id']}'> {$pages['name']}</a> | <strong>Ngày: </strong> {$pages['date']} </p>
                </div>
            ";

        } else {
            echo "<p class='notice'>Chưa có bài viết nào trong mục này</p>";
        }
    else :
    	redirect_to();
    endif;
?>
</div><!--end #main-content-->

<?php
	include('inc/second-sidebar.php');
	include('inc/footer.php');
?>