<?php
	include('header.php');
	include('../inc/functions.php');
	include('../inc/mysqli_connect.php');
	include('first-sidebar.php');
?>

<!-- VALIDATE BIẾN $_GET['ncid'] -->
<?php
	if (isset($_GET['ncid']) && filter_var($_GET['ncid'], FILTER_VALIDATE_INT, array('min_range'=>1))) {
		$ncid = $_GET['ncid'];
	} else {
		redirect_to('admin/index.php');
	}
?>

<!-- VALIDATE BIẾN $_GET[epid, dpid] -->
<?php
	if (isset($_GET['epid'])) :
		if(filter_var($_GET['epid'], FILTER_VALIDATE_INT, array('min_range'=>1))) :
			/**************************** EDIT DANH SÁCH BÀI VIẾT **********************************/
			$epid = $_GET['epid'];
			$dpid = NULL;
			//Lấy dữ liệu từ CSDL
			$q = "SELECT page_name, position, content FROM pages WHERE page_id = {$epid}";
			$r = mysqli_query($dbc, $q);
				confirm_query($r, $q);
			if (mysqli_num_rows($r) == 1) {//Nếu bài viết tồn tại trong CSDL, xuất dữ liệu ra ngoài trình duyệt
				list($epage_name, $eposition, $econtent) = mysqli_fetch_array($r, MYSQLI_NUM);
			} else {//Nếu epid không hợp lệ
				redirect_to('admin/add-news.php?ncid={$ncid}&msg=1');
			}

			if($_SERVER['REQUEST_METHOD'] == 'POST') {//Nếu đúng -> Form đã được submit -> xử lý form
				//Kiểm tra các trường của form
				$errors = array();//Biến bắt lỗi
				if(empty($_POST['page-name'])) {
					$errors[] = "page-name";
				} else {
					$page_name = mysqli_real_escape_string($dbc, strip_tags($_POST['page-name']));
				}

				if(isset($_POST['position']) && filter_var($_POST['position'], FILTER_VALIDATE_INT, array('min_range' => 1))) {//Kiểm tra giá trị nhập vào
					$position = $_POST['position'];
				} else {
					$errors[] = "position";
				}

				if(empty($_POST['content'])) {
					$errors[] = "content";
				} else {
					$content = mysqli_real_escape_string($dbc, $_POST['content']);
				}

				if(empty($errors)) { //Nếu không có lỗi xảy ra thì chèn vào CSDL
					$q = "UPDATE pages ";
					$q .= " SET page_name = '{$page_name}', position = $position, content = $content, cat_id = $ncid ";
					$q .= " WHERE page_id = {$epid}";

					$r = mysqli_query($dbc, $q);
						confirm_query($r, $q);
					if (mysqli_affected_rows($dbc) == 1) {
						redirect_to('admin/add-news.php?ncid={$ncid}&msg=2');
					} else {
						$messages = "<p class='notice'>Không thể thêm bài viết vào CSDL do lỗi hệ thống.</p>";
					}
				} else {
					$messages = "<p class='notice'>Điền đầy đủ dữ liệu cho các trường.</p>";
				}
			} //end if submit form
?>

			<div id="main-content">
				<div class="title-content">
					<p>Thêm mới bài viết</p>
				</div>
				<?php
					if (!empty($messages)) echo $messages;
				?>
				<div>
					<form id="add-news" action="" method="post" class="add-form">
						<fieldset>
							<legend>Thêm mới bài viết</legend>
							<div>
								<label for="page">Tên bài viết: <span class="required">*</span>
									<?php
									if(isset($errors) && in_array('page-name', $errors)) {
										echo "<p class='warning'>Điền tên bài viết.</p>";
									}
								?>
								</label>
								<input type="text" name="page-name" id="page-name" value="<?php if (isset($epage_name)) echo $epage_name; ?>" size="20" maxlength="100" tabindex="1" />
							</div>

							<div>
								<label for="position">Vị trí: <span class="required">*</span>
									<?php
									if(isset($errors) && in_array('position', $errors)) {
										echo "<p class='warning'>Chọn vị trí bài viết.</p>";
									}
								?>
								</label>
								<select name="position">
									<?php
									$q = "SELECT count(page_id) AS count FROM pages";
									$r = mysqli_query($dbc, $q) or die("Cau truy van: $q \n<br /> Loi MySQL: ".mysqli_error($dbc));
									if(mysqli_num_rows($r) == 1) {
										list($num) = mysqli_fetch_array($r, MYSQLI_NUM);
										for ($i=1; $i <= $num+1; $i++) {//Tạo vòng for để tạo ra option, cộng thêm một giá trị cho position
											echo "<option value='{$i}'";
												if(isset($eposition) && $eposition == $i) echo "selected='selected'";
											echo ">".$i."</option>";
										}
									}
								?>
								</select>
							</div>

							<div>
								<label for="page-content">Nội dung bài viết: <span class="required">*</span>
									<?php
									if(isset($errors) && in_array('content', $errors)) {
										echo "<p class='warning'>Nhap noi dung bai viet.</p>";
									}
								?>
								</label>
								<textarea name="content" cols="50" rows="20"></textarea>
							</div>

							<p><input type="submit" name="submit" value="Thêm mới bài viết" /></p>
						</fieldset>
					</form>
				</div>

			</div><!--end #main-content-->
<?php
		else :
			redirect_to('admin/index.php');
		endif;
	elseif(isset($_GET['dpid'])) :
		if(filter_var($_GET['dpid'], FILTER_VALIDATE_INT, array('min_range'=>1))) :
			/**************************** XÓA DANH MỤC BÀI VIẾT **********************************/
			$dpid = $_GET['dpid'];
			$epid = NULL;
			$q = "DELETE FROM pages WHERE page_id = {$dpid} LIMIT 1";
			$r = mysqli_query($dbc, $q);
				confirm_query($r, $q);
				if(mysqli_affected_rows($dbc) == 1) {
					redirect_to('admin/add-news.php?ncid={$ncid}&msg=3');
				} else {
					redirect_to('admin/add-news.php?ncid={$ncid}&msg=4');
				}
		else :
			redirect_to('admin/index.php');
		endif;
	else :
		/**************************** THÊM MỚI DANH MỤC BÀI VIẾT ****************************/
		$epid = null;
		$dpid = null;
		if($_SERVER['REQUEST_METHOD'] == 'POST') {//Nếu đúng -> Form đã được submit -> xử lý form
			//Kiểm tra các trường của form
			$errors = array();//Biến bắt lỗi
			if(empty($_POST['page-name'])) {
				$errors[] = "page-name";
			} else {
				$page_name = mysqli_real_escape_string($dbc, strip_tags($_POST['page-name']));
			}

			if(isset($_POST['n-category']) && filter_var($_POST['n-category'], FILTER_VALIDATE_INT, array('min_range' => 1))) {//Kiểm tra giá trị nhập vào
				$cat_id = $_POST['n-category'];
			} else {
				$errors[] = "category";
			}


			if(isset($_POST['position']) && filter_var($_POST['position'], FILTER_VALIDATE_INT, array('min_range' => 1))) {//Kiểm tra giá trị nhập vào
				$position = $_POST['position'];
			} else {
				$errors[] = "position";
			}

			if(empty($_POST['content'])) {
				$errors[] = "content";
			} else {
				$content = mysqli_real_escape_string($dbc, $_POST['content']);
			}

			if(empty($errors)) { //Nếu không có lỗi xảy ra thì chèn vào CSDL
				$q = "INSERT INTO pages (user_id, cat_id, page_name, content, position, post_on) ";
				$q .= " VALUES (1, parseInt({$ncid}), '{$page_name}', '{$content}', $position, now())";
				$r = mysqli_query($dbc, $q) or die("Cau truy van: $q \n<br /> Loi MySQL: ".mysqli_error($dbc));
				if (mysqli_affected_rows($dbc) == 1) {
					$messages = "<p class='notice'>Thêm mới bai viet thành công.</p>";
				} else {
					$messages = "<p class='notice'>Không thể thêm bai viet vào CSDL do lỗi hệ thống.</p>";
				}
			} else {
				$messages = "<p class='notice'>Điền đầy đủ dữ liệu cho các trường.</p>";
			}
		} //end if submit form
?>
		<div id="main-content">
			<div class="title-content">
				<p>Thêm mới bài viết</p>
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
				<form id="add-news" action="" method="post" class="add-form">
					<fieldset>
						<legend>Thêm mới bài viết</legend>
						<div>
							<label for="page">Tên bài viết: <span class="required">*</span>
								<?php
								if(isset($errors) && in_array('page-name', $errors)) {
									echo "<p class='warning'>Điền tên bai viet.</p>";
								}
							?>
							</label>
							<input type="text" name="page-name" id="page-name" value="<?php if (isset($_POST['page-name'])) {
								echo strip_tags($_POST['page-name']);
							} ?>" size="20" maxlength="100" tabindex="1" />
						</div>

						<div>
							<label for="position">Vị trí: <span class="required">*</span>
								<?php
								if(isset($errors) && in_array('position', $errors)) {
									echo "<p class='warning'>Chon vi tri bai viet.</p>";
								}
							?>
							</label>
							<select name="position">
								<?php
								$q = "SELECT count(page_id) AS count FROM pages";
								$r = mysqli_query($dbc, $q) or die("Cau truy van: $q \n<br /> Loi MySQL: ".mysqli_error($dbc));
								if(mysqli_num_rows($r) == 1) {
									list($num) = mysqli_fetch_array($r, MYSQLI_NUM);
									for ($i=1; $i <= $num+1; $i++) {//Tạo vòng for để tạo ra option, cộng thêm một giá trị cho position
										echo "<option value='{$i}'";
											if(isset($_POST['position']) && $_POST['position'] == $i) echo "selected='selected'";
										echo ">".$i."</option>";
									}
								}
							?>
							</select>
						</div>

						<div>
							<label for="page-content">Nội dung bài viết: <span class="required">*</span>
								<?php
								if(isset($errors) && in_array('content', $errors)) {
									echo "<p class='warning'>Nhap noi dung bai viet.</p>";
								}
							?>
							</label>
							<textarea name="content" cols="50" rows="20"></textarea>
						</div>

						<p><input type="submit" name="submit" value="Thêm mới bài viết" /></p>
					</fieldset>
				</form>
			</div>

		</div><!--end #main-content-->
<?php endif; ?>
<?php
	include('second-sidebar.php');
	include('footer.php');
?>