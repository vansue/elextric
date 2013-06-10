<!--===== CONTENT =====-->
<div id="content">
	<div id="first-sidebar">
		<div class="typical">
			<h3>Main Menu</h3>
			<ul>
				<?php
				$q = "SELECT cat_name FROM n_categories ORDER BY position ASC";
				$r = mysqli_query($dbc, $q) or die("Cau truy van: $q \n<br /> Loi MySQL: ".mysqli_error($dbc));
				$i=0;
				while ($cats = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
					$i++;
					if ($i%2 == 1) {
						echo "<li><a href='#' class='old'>".$cats['cat_name']."</a></li>";
					} else {
						echo "<li><a href='#' class='even'>".$cats['cat_name']."</a></li>";
					}
				}
				?>
			</ul>
		</div>

		<div class="typical">
			<h3><a href="#">Thời gian</a></h3>
			<div class="box">
				<img src="../images/alarm.png" alt="alarm">
				<span id="tm"></span>
			</div>
		</div>

		<div class="typical">
			<h3>Quick link</h3>
			<div class="box">
				<img src="../images/quick_link.png" alt="quick link">
			</div>
		</div>

	</div><!--end #first-sidebar-->