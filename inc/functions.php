<?php
	//Xác định hằng số cho địa chỉ tuyệt đối
	define('BASE_URL', 'http://localhost/elextric/');

	//Kiểm tra xem kết quả trả về có đúng hay không
	function confirm_query($result, $query) {
		global $dbc;
		if (!$result) {
			die("Cau truy van: $query \n<br /> Loi MySQL: ".mysqli_error($dbc));
		}
	}

	//Kiểm tra xem người dùng đã đăng nhập hay chưa
	function is_logged_in() {
		if (!isset($_SESSION['uid'])) {
			redirect_to('login.php');
		}
	}

	//Tái định hướng người dùng về trang mặc định là elextric/index.php
	function redirect_to($page = 'index.php') {
		$url = BASE_URL.$page;
		header("Location: $url");
		exit();
	}

	//Hàm này để thông báo lỗi
	function report_error($mesg) {
		if(!empty($mesg)) {
			foreach ($mesg as $m) {
				echo $m;
			}
		}
	}

	// Cắt chữ để hiển thị thành đoạn văn ngắn
    function the_excerpt($text, $string = 400) {
        $sanitized = strip_tags($text);
        if(strlen($sanitized) > $string) {
            $cutString = substr($sanitized,0,$string);
            $words = substr($sanitized, 0, strrpos($cutString, ' '));
            return $words;
        } else {
            return $sanitized;
        }
    } // End the_excerpt

	//Hàm kiểm tra xem có phải admin hay không
	function is_admin() {
		return isset($_SESSION['user_level']) && ($_SESSION['user_level'] == 2);
	}

	//Kiểm tra xem người dùng có thể vào trang admin hay không
	function admin_success() {
		if(!is_admin()) {
			redirect_to('admin/login.php');
		}
	}

	//Hàm dùng để truy xuất dữ liệu của người dùng theo id
	function fetch_user($user_id) {
		global $dbc;
		$q = "SELECT * FROM users WHERE user_id = {$user_id}";
		$r = mysqli_query($dbc, $q);
			confirm_query($r, $q);
		if (mysqli_num_rows($r) > 0) {
			//Nếu có kết quả trả về
			return $result_set = mysqli_fetch_array($r, MYSQLI_ASSOC);
		} else {
			//Nếu không có kết quả trả về
			return FALSE;
		}
	} //end fetch_user

	//Hàm dùng để truy xuất dữ liệu của người dùng được sắp xếp
	function fetch_users($order) {
		global $dbc;
		$q = "SELECT *, CONCAT_WS(' ', first_name, last_name) AS name FROM users ORDER BY {$order} ASC";
		$r = mysqli_query($dbc, $q);
    		confirm_query($r, $q);
    	if(mysqli_num_rows($r) > 1) {
    		$users = array();
    		while ($results = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
    			$users[] = $results;
    		}
    	return $users;
    	} else {
    		return FALSE; //Nếu không có thông tin người dùng trong CSDL
    	}
	}

	function captcha() {
		$qna = array(
			1 => array('question' => 'một cộng một', 'answer' => 2),
			2 => array('question' => 'ba trừ hai', 'answer' => 1),
			3 => array('question' => 'ba nhân năm', 'answer' => 15),
			4 => array('question' => 'sáu chia hai', 'answer' => 3),
			5 => array('question' => 'nàng bạch tuyết và ... chú lùn', 'answer' => 7),
			6 => array('question' => 'Alibaba và ... tên cướp', 'answer' => 40),
			7 => array('question' => '... con giáp', 'answer' => 12),
			8 => array('question' => 'chiến thắng Điện Biên Phủ năm ...', 'answer' => 1954),
			);
		$rand_key = array_rand($qna); //Lấy ngẫu nhiên một trong các array 1,2,4,...
		$_SESSION['q'] = $qna[$rand_key];
		return $question = $qna[$rand_key]['question'];
	}

	function pagination($ncid, $display = 5, $url = 'index.php', $link = 'ncid', $id = 'page_id', $tbl = 'pages') {
		global $dbc; global $start;
		if (isset($_GET['p']) && filter_var($_GET['p'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
			$page = $_GET['p'];
		} else {
			//Nếu biến p không có, sẽ truy vấn CSDL để tìm xem có bao nhiêu page để hiển thị
			$q = "SELECT COUNT({$id}) FROM {$tbl} WHERE cat_id = {$ncid}";
			$r = mysqli_query($dbc, $q); confirm_query($r, $q);
			list($record) = mysqli_fetch_array($r, MYSQLI_NUM);

			//Tìm số trang bằng cách chia dữ liệu cho $display
			if ($record > $display) {
				$page = ceil($record/$display);//$start bắt đầu từ 0 -> start = 5 ở trang 2
			} else {
				$page = 1;
			}
		}

		echo "<ul class='pagination'>";
			if($page >1) {
				$current_page = ($start/$display + 1);

				//Nếu không phải ở trang đầu (hoặc 1) thì sẽ hiển thị Trang trước
				if($current_page != 1) {
					echo "<li><a href='{$url}?{$link}={$ncid}&s=".($start - $display)."&p={$page}'>Trang trước</a></li>";
				}

				//Hiển thị phần số còn lại của trang
				for ($i=1; $i <=$page ; $i++) {
					if ($i != $current_page) {
						echo "<li><a href='{$url}?{$link}={$ncid}&s=".($display*($i-1))."&p={$page}'>{$i}</a></li>";
					} else {
						echo "<li class='current'>{$i}</li>";
					}
				}

				//Nếu không phải trang cuối thì hiển thị trang kế
				if ($current_page != $page) {
					echo "<li><a href='{$url}?{$link}={$ncid}&s=".($start + $display)."&p={$page}'>Trang sau</a></li>";
				}
			}
		echo "</ul>";

	}

	function show_time($time) {
	    $s = strtotime("now") - strtotime($time);
	    if ($s <= 60) { // if < 60 seconds
	        return 'Khoảng 1 phút trước';
	    } else {
	        $t = intval($s / 60);
	        if ($t >= 60) {
	            $t = intval($t / 60);
	            if ($t >= 24) {
	                $t = intval($t / 24);
	                if ($t >= 30) {
	                    $t = intval($t / 30);
	                    if ($t >= 12) {
	                        $t = intval($t / 12);
	                        return $t . ' năm trước';
	                    } else {
	                        return $t . ' tháng trước';
	                    }
	                } else {
	                    return $t . ' ngày trước';
	                }
	            } else {
	                return $t . ' giờ trước';
	            }
	        } else {
	            return $t . ' phút trước';
	        }
	    }
	}