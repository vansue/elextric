<?Php
	if (isset($_GET['pnid']) && filter_var($_GET['pnid'], FILTER_VALIDATE_INT, array('min_range'=>1))) {
		$pid = $_GET['pnid'];
	} elseif (isset($_GET['ppid']) && filter_var($_GET['ppid'], FILTER_VALIDATE_INT, array('min_range'=>1))) {
		$pid = $_GET['ppid'];
	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$errors = array();
		//Validate name
		if (!empty($_POST['name'])) {
			$name = mysqli_real_escape_string($dbc, strip_tags($_POST['name']));
		} else {
			$errors[] = "name";
		}

		//Validate email
		if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$e = mysqli_real_escape_string($dbc, strip_tags($_POST['email']));
		} else {
			$errors[] = "email";
		}

		//Validate comment
		if (!empty($_POST['comment'])) {
			$comment = mysqli_real_escape_string($dbc, $_POST['comment']);
		} else {
			$errors[] = "comment";
		}

		//Validate captcha question
		if (isset($_POST['captcha']) && trim($_POST['captcha']) != 5) {
			$errors[] = "wrong";
		}

		if (empty($errors)) {
			$q = "INSERT INTO comments (page_id, author, email, comment, comment_date) VALUES ({$pid}, '{$name}', '{$e}', '{$comment}', NOW())";
			$r = mysqli_query($dbc, $q); confirm_query($r, $q);
			if (mysqli_affected_rows($dbc) == 1) {
				//thành công
				$messages = "<p class='notice success'>Cảm ơn bạn đã bình luận.</p>";
			} else {
				$mesages = "<p class='notice'>Bình luận của bạn không thể đăng do lỗi hệ thống.</p>";
			}
		} else {
			$mesages = "<p class='notice'>Điền đầy đủ các trường.</p>";
		}
	}
?>
<div>
<form id="comment-form" action="" method="post" class="add-form">
	<fieldset>
		<legend>Bình luận</legend>
		<div>
			<label for="name">Tên: <span class="required">*</span>
			<?php if(isset($errors) && in_array('name', $errors)) echo "<p class='notice'>Điền tên của bạn.</p>"; ?>
			</label>
			<input type="text" name="name" id="name" value="<?php if(isset($_POST['name'])) echo htmlentities($_POST['name'], ENT_COMPAT, 'UTF-8'); ?>" size="20" maxlength="80" tabindex="1" />
		</div>
		<div>
			<label for="email">Email: <span class="required">*</span>
			<?php if(isset($errors) && in_array('email', $errors)) echo "<p class='notice'>Điền email của bạn.</p>"; ?>
			</label>
			<input type="text" name="email" id="email" value="<?php if(isset($_POST['email'])) echo htmlentities($_POST['email']); ?>" size="20" maxlength="80" tabindex="2" />
		</div>
		<div>
			<label for="comment">Bình luận: <span class="required">*</span>
			<?php if(isset($errors) && in_array('comment', $errors)) echo "<p class='notice'> Viết bình luận của bạn.</p>"; ?>
			</label>
			<div id="comment"><textarea name="comment" rows="20" cols="50" tabindex="3"><?php if(isset($_POST['comment'])) echo htmlentities($_POST['comment']); ?></textarea></div>
		</div>
		<div>
			<label>Trả lời câu hỏi: một cộng bốn <span class="required">*</span>
			<?php if(isset($errors) && in_array('wrong', $errors)) echo "<p class='notice'>Trả lời câu hỏi.</p>"; ?>
			</label>
			<input type="text" name="captcha" id="captcha" value="" size="20" maxlength="5" tabindex="4" />
		</div>
		<div><input type="submit" name="submit" value="Đăng bình luận" /></div>
	</fieldset>

</form>
</div>