<?php
session_start();
session_unset();
session_destroy();
header("Location: littlebakery.php"); // กลับไปหน้า index.php หลังจากลบ Session
exit();
