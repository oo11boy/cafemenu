<?php
// URL مقصد
$url = "./mainpage";

// ریدایرکت کردن به URL
header("Location: $url");

// اتمام اجرای اسکریپت برای اطمینان از عدم اجرای ادامه کد
exit();
?>
