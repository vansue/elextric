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
					$q = "SELECT cat_id, cat_name FROM n_categories ORDER BY position LIMIT 7";
					$r = mysqli_query($dbc, $q);
						confirm_query($r, $q);
					while($ncats = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
						echo "<li><a href='index.php?ncid=".$ncats['cat_id']."' id='nav-".$ncats['cat_id']."'>".$ncats['cat_name']."</a></li>";
						echo "<li><img src='images/menu_divider.gif' alt='menu-divider' /></li>";
					}
				?>
			</ul>
			<img src="images/menu_right.gif" alt="right-menu" />
		</div><!--end #nav-menu-->