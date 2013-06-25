<!--===== CONTENT =====-->
<div id="content">
	<div id="first-sidebar">
		<div class="typical">
			<h3>Danh mục sản phẩm</h3>
			<ul>
				<?php
					$q = "SELECT cat_id, cat_name FROM p_categories";
					$r = mysqli_query($dbc, $q);
						confirm_query($r, $q);
						$i = 0;
					while($pcats = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
						$i++;
						if ($i%2 == 0) {
							echo "<li><a href='index.php?pcid=".$pcats['cat_id']."' class='old'>".$pcats['cat_name']."</a></li>";
						} else {
							echo "<li><a href='index.php?pcid=".$pcats['cat_id']."' class='even'>".$pcats['cat_name']."</a></li>";
						}
					}
				?>
			</ul>
		</div>

		<div class="banner-adds">
			<a href="#"><img src="images/bann1.jpg" alt="" /></a>
		</div>
	</div><!--end #first-sidebar-->