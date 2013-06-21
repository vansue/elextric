<?php
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
		$q .= " VALUES (1, $ncid, '{$page_name}', '{$content}', $position, NOW())";
		$r = mysqli_query($dbc, $q);
			confirm_query($r, $q);
		if (mysqli_affected_rows($dbc) == 1) {
			redirect_to('admin/view-news.php?ncid='.$ncid.'&msg=3');
		} else {
			$messages = "<p class='notice'>Không thể thêm bài viết vào CSDL do lỗi hệ thống.</p>";
		}
	} else {
		$messages = "<p class='notice'>Điền đầy đủ dữ liệu cho các trường.</p>";
	}
} //end if submit form
?>

<!--FORM-->
<div id="main-content">
	<div class="title-content">
		<p>Thêm mới bài viết</p>
	</div>
	<?php
		if (!empty($messages)) {
			echo $messages;
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
							echo "<p class='notice'>Điền tên bài viết.</p>";
						}
					?>
					</label>
					<input type="text" name="page-name" id="page-name" value="<?php if (isset($_POST['page-name']))	echo strip_tags($_POST['page-name']); ?>" size="20" maxlength="100" tabindex="1" />
				</div>

				<div>
					<label for="position">Vị trí: <span class="required">*</span>
						<?php
						if(isset($errors) && in_array('position', $errors)) {
							echo "<p class='notice'>Chọn vị trí bài viết.</p>";
						}
					?>
					</label>
					<select name="position">
						<?php
						$q = "SELECT count(page_id) AS count FROM pages WHERE cat_id={$ncid}";
						$r = mysqli_query($dbc, $q);
							confirm_query($r, $q);
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
							echo "<p class='notice'>Nhập nội dung bài viết.</p>";
						}
					?>
					</label>
					<textarea name="content" cols="50" rows="20"><?php if(isset($_POST['content'])) echo $_POST['content']; ?></textarea>
				</div>

				<p><input type="submit" name="submit" value="Thêm mới bài viết" /></p>
			</fieldset>
		</form>
	</div>

</div><!--end #main-content-->