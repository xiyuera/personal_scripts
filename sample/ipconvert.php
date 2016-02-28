<?php

/**
 * 百词斩的程序员喜欢研究各种算法。百词斩的Jerry自己做了一个简单的IP变换
 * 算法，将一个IP地址转化为字符串。比如IP地址1.1.1.129：
 * 第一步：转化为二进制：00000001000000010000000110000001
 * 第二步：替换（0用a表示，1用b表示）：aaaaaaabaaaaaaabaaaaaaabbaaaaaab
 * 第三步：将连续相同的字符合并：7a1b7a1b7a2b6a1b
 * 第四步：减少长度，将数字1去掉：7ab7ab7a2b6ab。
 * 现在给出一个Jerry的算法生成的字符串，请你来还原最初的IP地址。
**/

function jerrys_ip2str($ip) {
	$nums = split("\.", $ip);
	$str = "";
	foreach ($nums as $k => $n) {
		$str .= str_pad(decbin($n), 8, "0", STR_PAD_LEFT);
	}

	$str = str_replace(["0", "1"], ["a", "b"], $str);
	preg_match_all("/a+|b+/", $str, $arr);
	$str = "";

	foreach ($arr[0] as $k => $n) {
		$l = strlen($n);
		$str .= ($l > 1 ? $l : "") . substr($n, 0, 1);
	}

	return $str;
}

function jerry_str2ip($str) {
	preg_match_all("/\d*(a|b)/", $str, $arr);
	$str = "";
	foreach ($arr[0] as $k => $n) {
		$l = 1;
		if (strlen($n) > 1) {
			$l = substr($n, 0, -1);
		}
		$str .= str_repeat(substr($n, -1, 1), $l);
	}
	$str = str_replace(["a", "b"], ["0", "1"], $str);
	$arr = str_split($str, 8);

	foreach ($arr as $k => $n) {
		$arr[$k] = bindec($n);
	}

	return implode(".", $arr);
}

$str = jerrys_ip2str("255.1.136.255");
$ip = jerry_str2ip($str);

echo "ip: " . $ip . "\n" .
	"string: " . $str . "\n";

?>