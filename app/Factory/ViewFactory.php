<?php
namespace App\Factory;
class ViewFactory {
	public static function render($v, $d = []) {
		extract($d);
		include dirname(__DIR__) . '/includes/header.php';
		include dirname(__DIR__) . '/views/' . $v;
		include dirname(__DIR__) . '/includes/footer.php';
	}
}
?>