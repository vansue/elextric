<?php
	ob_start();
	include('header.php');
	include('../inc/functions.php');
	include('../inc/mysqli_connect.php');
	include('first-sidebar.php');
?>

<!-- VALIDATE BIẾN $_GET -->
<?php
	if (isset($_GET['epid'])) :
		if(filter_var($_GET['epid'], FILTER_VALIDATE_INT, array('min_range'=>1))) :
			/**************************** EDIT DANH SÁCH BÀI VIẾT **********************************/
			$epid = $_GET['epid'];
			$dpid = NULL;
			//Lấy dữ liệu từ CSDL
			$q = "SELECT page_name, position FROM n_categories WHERE cat_id = {$ecid}";
			$r = mysqli_query($dbc, $q);
				confirm_query($r, $q);
			if (mysqli_num_rows($r) == 1) {//Nếu category tồn tại trong CSDL, xuất dữ liệu ra ngoài trình duyệt
				list($ecat_name, $eposition) = mysqli_fetch_array($r, MYSQLI_NUM);
			} else {//Nếu ecid không hợp lệ
				redirect_to('admin/add-n-categories.php?msg=1');
			}
			/* VALIDATE FORM */
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {//Nếu đúng -> Form đã được submit -> xử lý form
				//Kiểm tra các trường của form
				$errors = array();//Biến bắt lỗi
				if (empty($_POST['n-category'])) {
					$errors[] = "category";
				} else {
					$n_cat_name = mysqli_real_escape_string($dbc, strip_tags($_POST['n-category']));
				}

				if (isset($_POST['position']) && filter_var($_POST['position'], FILTER_VALIDATE_INT, array('min_range' => 1))) {//Kiểm tra giá trị nhập vào
					$position = $_POST['position'];
				} else {
					$errors[] = "position";
				}

				if(empty($errors)) { //Nếu không có lỗi xảy ra thì chèn vào CSDL
					//Cập nhật
					$q = "UPDATE n_categories ";
					$q .= " SET cat_name = '{$n_cat_name}', position = $position ";
					$q .= " WHERE cat_id = {$ecid}";
					$r = mysqli_query($dbc, $q);
						confirm_query($r, $q);
					if (mysqli_affected_rows($dbc) == 1) {
						redirect_to('admin/add-n-categories.php?msg=2');
					} else {
						$messages = "<p class='notice'>Không thể sửa danh mục do lỗi hệ thống.</p>";
					}
				} else {
					$messages = "<p class='notice'>Điền đầy đủ dữ liệu cho các trường.</p>";
				}
			}//end if submit form
?>
			<!--FORM-->
			<div id="main-content">
				<div class="title-content">
					<p>Thêm mới, chỉnh sửa thông tin danh mục bài viết</p>
				</div>
				<?php
					if (!empty($messages)) echo $messages;
				?>
				<div>
					<form action="" method="POST" id="add-n-cat" class="add-form">
						<fieldset>
							<legend>Thêm mới, chỉnh sửa thông tin danh mục bài viết</legend>
							<label for="n-category">Tên danh mục: <span class="required">*</span>
								<?php
									if(isset($errors) && in_array('category', $errors)) {
										echo "<p class='warning'>Điền tên danh mục.</p>";
									}
								?>
							</label>
							<input type="text" name="n-category" id="n-category" value="<?php if(isset($ecat_name)) echo $ecat_name; ?>" size="20" maxlength="100" tabindex="1" />
							<label for="position">Vị trí: <span class="required">*</span>
								<?php
									if(isset($errors) && in_array('position', $errors)) {
										echo "<p class='warning'>Chọn vị trí danh mục.</p>";
									}
								?>
							</label>
							<select name="position" tabindex="2">
								<!--================ Lấy dữ liệu trong CSDL để hiển thị ==================-->
								<?php
									$q = "SELECT count(cat_id) AS count FROM n_categories";
									$r = mysqli_query($dbc, $q);
										confirm_query($r, $q);
									if(mysqli_num_rows($r) == 1) {
										list($num) = mysqli_fetch_array($r, MYSQLI_NUM);
										for ($i=1; $i <= $num+1; $i++) {//Tạo vòng for để tạo ra option, cộng thêm một giá trị cho position
											echo "<option value='{$i}'";
												if(isset($eposition) && $eposition == $i) {
													echo "selected='selected'";
												}
											echo ">".$i."</option>";
										}
									}
								?>
							</select>
							<p><input type="submit" name="submit" value="Cập nhật" /></p>
						</fieldset>
					</form>
				</div>
<?php
		else :
			redirect_to('admin/index.php');
		endif;
	elseif(isset($_GET['dcid'])) :
		if(filter_var($_GET['dcid'], FILTER_VALIDATE_INT, array('min_range'=>1))) :
			/**************************** XÓA DANH MỤC BÀI VIẾT **********************************/
			$dcid = $_GET['dcid'];
			$ecid = NULL;
			$q = "DELETE FROM n_categories WHERE cat_id = {$dcid} LIMIT 1";
			$r = mysqli_query($dbc, $q);
				confirm_query($r, $q);
				if(mysqli_affected_rows($dbc) == 1) {
					redirect_to('admin/add-n-categories.php?msg=3');
				} else {
					redirect_to('admin/add-n-categories.php?msg=4');
				}
?>
			<!--FORM-->
			<div id="main-content">
				<div class="title-content">
					<p>Thêm mới, chỉnh sửa thông tin danh mục bài viết</p>
				</div>
				<?php
					if (!empty($messages)) echo $messages;
				?>
				<div>
					<form action="" method="POST" id="add-n-cat" class="add-form">
						<fieldset>
							<legend>Thêm mới, chỉnh sửa thông tin danh mục bài viết</legend>
							<label for="n-category">Tên danh mục: <span class="required">*</span>
								<?php
									if(isset($errors) && in_array('category', $errors)) {
										echo "<p class='warning'>Điền tên danh mục.</p>";
									}
								?>
							</label>
							<input type="text" name="n-category" id="n-category" value="<?php if(isset($_POST['n-category'])) echo strip_tags($_POST['n-category']); ?>" size="20" maxlength="100" tabindex="1" />
							<label for="position">Vị trí: <span class="required">*</span>
								<?php
									if(isset($errors) && in_array('position', $errors)) {
										echo "<p class='warning'>Chọn vị trí danh mục.</p>";
									}
								?>
							</label>
							<select name="position" tabindex="2">
								<!--================ Lấy dữ liệu trong CSDL để hiển thị ==================-->
								<?php
									$q = "SELECT count(cat_id) AS count FROM n_categories";
									$r = mysqli_query($dbc, $q);
										confirm_query($r, $q);
									if(mysqli_num_rows($r) == 1) {
										list($num) = mysqli_fetch_array($r, MYSQLI_NUM);
										for ($i=1; $i <= $num+1; $i++) {//Tạo vòng for để tạo ra option, cộng thêm một giá trị cho position
											echo "<option value='{$i}'";
												if(isset($_POST['position']) && $_POST['position'] == $i) {
													echo "selected='selected'";
												}
											echo ">".$i."</option>";
										}
									}
								?>
							</select>
							<p><input type="submit" name="submit" value="Thêm mới" /></p>
						</fieldset>
					</form>
				</div>
<?php
		else :
			redirect_to('admin/index.php');
		endif;
	else :
		/**************************** THÊM MỚI DANH MỤC BÀI VIẾT ****************************/
		$ecid = null;
		$dcid = null;
		/* VALIDATE FORM */
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {//Nếu đúng -> Form đã được submit -> xử lý form
			//Kiểm tra các trường của form
			$errors = array();//Biến bắt lỗi
			if (empty($_POST['n-category'])) {
				$errors[] = "category";
			} else {
				$n_cat_name = mysqli_real_escape_string($dbc, strip_tags($_POST['n-category']));
			}

			if (isset($_POST['position']) && filter_var($_POST['position'], FILTER_VALIDATE_INT, array('min_range' => 1))) {//Kiểm tra giá trị nhập vào
				$position = $_POST['position'];
			} else {
				$errors[] = "position";
			}

			if(empty($errors)) { //Nếu không có lỗi xảy ra thì chèn vào CSDL
				//Thêm mới
				$q = "INSERT INTO n_categories (user_id, cat_name, position) ";
				$q .= " VALUES (1, '{$n_cat_name}', $position)";
				$r = mysqli_query($dbc, $q);
					confirm_query($r, $q);
				if (mysqli_affected_rows($dbc) == 1) {
					$messages = "<p class='notice'>Thêm mới danh mục thành công.</p>";
				} else {
					$messages = "<p class='notice'>Không thể thêm danh mục vào CSDL do lỗi hệ thống.</p>";
				}
			} else {
				$messages = "<p class='notice'>Điền đầy đủ dữ liệu cho các trường.</p>";
			}
		} //end if submit form
?>
		<!--FORM-->
		<div id="main-content">
			<div class="title-content">
				<p>Thêm mới, chỉnh sửa thông tin danh mục bài viết</p>
			</div>
			<?php
				if (!empty($messages)) {
					echo $messages;
				} else {
					if(isset($_GET['msg'])) {
						$msg = $_GET['msg'];
						switch ($msg) {
							case '1':
								echo "<p class='notice'>Danh mục không tồn tại.</p>";
								break;
							case '2':
								echo "<p class='notice'>Sửa danh mục thành công.</p>";
								break;
							case '3':
								echo "<p class='notice'>Xóa danh mục thành công.</p>";
								break;
							case '4':
								echo "<p class='notice'>Danh mục không tồn tại.</p>";
								break;
							default:
								redirect_to('admin/index.php');
								break;
						}
					}
				}
			?>
			<div>
				<form action="" method="POST" id="add-n-cat" class="add-form">
					<fieldset>
						<legend>Thêm mới, chỉnh sửa thông tin danh mục bài viết</legend>
						<label for="n-category">Tên danh mục: <span class="required">*</span>
							<?php
								if(isset($errors) && in_array('category', $errors)) {
									echo "<p class='warning'>Điền tên danh mục.</p>";
								}
							?>
						</label>
						<input type="text" name="n-category" id="n-category" value="<?php if(isset($_POST['n-category'])) echo strip_tags($_POST['n-category']); ?>" size="20" maxlength="100" tabindex="1" />
						<label for="position">Vị trí: <span class="required">*</span>
							<?php
								if(isset($errors) && in_array('position', $errors)) {
									echo "<p class='warning'>Chọn vị trí danh mục.</p>";
								}
							?>
						</label>
						<select name="position" tabindex="2">
							<!--================ Lấy dữ liệu trong CSDL để hiển thị ==================-->
							<?php
								$q = "SELECT count(cat_id) AS count FROM n_categories";
								$r = mysqli_query($dbc, $q);
									confirm_query($r, $q);
								if(mysqli_num_rows($r) == 1) {
									list($num) = mysqli_fetch_array($r, MYSQLI_NUM);
									for ($i=1; $i <= $num+1; $i++) {//Tạo vòng for để tạo ra option, cộng thêm một giá trị cho position
										echo "<option value='{$i}'";
											if(isset($_POST['position']) && $_POST['position'] == $i) {
												echo "selected='selected'";
											}
										echo ">".$i."</option>";
									}
								}
							?>
						</select>
						<p><input type="submit" name="submit" value="Thêm mới" /></p>
					</fieldset>
				</form>
			</div>
<?php
	endif;
?>
<!--+++++++++++++++++++++++++++++ HIỂN THỊ DANH SÁCH BÀI VIẾT ++++++++++++++++++++++++++++-->
	<div class="title-content">
		<p>Danh sách bài viết</p>
	</div>
	<table>
    	<thead>
    		<tr>
    			<th><a href="add-news.php?sort=page">Tên bài viết</a></th>
    			<th><a href="add-news.php?sort=date">Ngày tạo</th>
    			<th><a href="add-news.php?sort=by">Người tạo</th>
                <th>Edit</th>
                <th>Delete</th>
    		</tr>
    	</thead>
    	<tbody>
    	<?php
    		//Sắp xếp theo thứ tự của table head
    		if (isset($_GET['sort'])) {
    			switch ($_GET['sort']) {
    				case 'page':
    					$order_by = 'page_name';
    					break;
    				case 'date':
    					$order_by = 'post_on';
    					break;
    				case 'by':
    					$order_by = 'name';
    					break;
    				default:
    					$order_by = 'post_on';
    					break;
    			}
    		} else {
    			$order_by = 'post_on';
    		}
    		//Truy xuất CSDL để hiển thị pages
    		$q = "SELECT p.page_id, p.page_name, p.post_on, p.cat_id, p.user_id, CONCAT_WS(' ', first_name, last_name) AS name ";
    		$q .= " FROM pages AS p ";
    		$q .= " JOIN users AS u USING(user_id) ";
    		$q .= " WHERE p.cat_id = $ncid"
    		$q .= " ORDER BY {$order_by} ASC";
    		$r = mysqli_query($dbc, $q);
    			confirm_query($r, $q);
    		while ($pages = mysqli_fetch_array($r, MYSQLI_ASSOC)) :
    	?>
            <tr>
                <td><?php echo $pages['page_name']; ?></td>
                <td><?php echo $pages['post_on']; ?></td>
                <td><?php echo $pages['name']; ?></td>
                <td class='edit'><a href="add-n-categories.php?epid=<?php echo $pages['page_id']; ?>"><img src="../images/b_edit.png" alt="edit"></a></td>
                <td class='delete'><a href="add-n-categories.php?dpid=<?php echo $pages['page_id']; ?>"><img src="../images/b_drop.png" alt="drop"></a></td>
            </tr>
        <?php endwhile; ?>
    	</tbody>
    </table>
</div><!--end #main-content-->
<?php
	include('second-sidebar.php');
	include('footer.php');
?>