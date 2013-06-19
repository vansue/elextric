<?php
	ob_start();
	include('header.php');
	include('../inc/functions.php');
	include('../inc/mysqli_connect.php');
	include('first-sidebar.php');

	/*** VALIDATE BIẾN $_GET['ncid'] ***/

	if (isset($_GET['ncid']) && filter_var($_GET['ncid'], FILTER_VALIDATE_INT, array('min_range'=>1))) {
		$ncid = $_GET['ncid'];
		$q = "SELECT cat_id FROM n_categories";
		$r = mysqli_query($dbc, $q);
			confirm_query($r, $q);
		while ($cats = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
			if($cats['cat_id'] == $ncid) {
				$flag = TRUE;
				break;
			}
		}
		if(!isset($flag)) {redirect_to('admin/index.php');}
	} else {
		redirect_to('admin/index.php');
	}

	/*** VALIDATE BIẾN $_GET[epid, dpid] ***/

	if (isset($_GET['epid'])) {
		if(filter_var($_GET['epid'], FILTER_VALIDATE_INT, array('min_range'=>1))) {
			include('../inc/edit-news.php');
		} else {
			redirect_to('admin/index.php');
		}
	} elseif(isset($_GET['dpid'])) {
		if(filter_var($_GET['dpid'], FILTER_VALIDATE_INT, array('min_range'=>1))) {
			include('../inc/delete-news.php');
		} else {
			redirect_to('admin/index.php');
		}
	} else {
		include('../inc/add-news.php');
	}

	include('second-sidebar.php');
	include('footer.php');
?>