<?php
// +----------------------------------------------------------------------
// | Perfect Is Shit
// +----------------------------------------------------------------------
// | Function_Reference/Other_Services/cURL
// +----------------------------------------------------------------------
// | Author: alexander <gt199899@gmail.com>
// +----------------------------------------------------------------------
// | Datetime: 2016-08-12 14:31:19
// +----------------------------------------------------------------------
// | Copyright: Perfect Is Shit
// +----------------------------------------------------------------------

// 创建一个新cURL资源
$curl = curl_init();

// 设置URL和相应的选项
curl_setopt($curl, CURLOPT_URL, "http://root.webghome.com/sys/curl.php");

// 设置为true将curl_exec()获取的信息以字符串返回，而不是直接输出。
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// CURLOPT_BINARYTRANSFER 设为 TRUE ，将在启用 CURLOPT_RETURNTRANSFER 时，返回原生的（Raw）输出。
// 从 PHP 5.1.3 开始，此选项不再有效果：使用 CURLOPT_RETURNTRANSFER 后总是会返回原生的（Raw）内容。
#curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);

// 当 HTTP 状态码大于等于 400，TRUE 将将显示错误详情(curl_error显示)。 默认情况下将返回页面，忽略 HTTP 代码。
curl_setopt($curl, CURLOPT_FAILONERROR, true);

$http_header = array(
    'Content-type: text/plain;charset=\"utf-8\"',
    'Accept: text/plain',
);
// 设置 HTTP 头字段的数组。格式： array('Content-type: text/plain', 'Content-length: 100')
curl_setopt($curl, CURLOPT_HTTPHEADER, $http_header);

// 启用时会将头文件的信息作为数据流输出。
curl_setopt($curl, CURLOPT_HEADER, false);

// TRUE 时会发送 POST 请求，类型为：application/x-www-form-urlencoded，是 HTML 表单提交时最常见的一种。
curl_setopt($curl, CURLOPT_POST, true);

$post_data = array(
    'key1'  =>  'value1',
    'key2'  =>  'value2',
    'key3'  =>  'value3',
);
$post_data = http_build_query($post_data);
// 全部数据使用HTTP协议中的 "POST" 操作来发送。
curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

// 允许执行最长秒数
curl_setopt($curl, CURLOPT_TIMEOUT, 5);

// 抓取URL并把它传递给浏览器
$result = curl_exec($curl);


if($result !== false){
    dump($result);
}
else{
    dump(curl_error($curl));
    dump(curl_errno($curl));
    dump(curl_strerror(curl_errno($curl)));
}



// 关闭cURL资源，并且释放系统资源
curl_close($curl);