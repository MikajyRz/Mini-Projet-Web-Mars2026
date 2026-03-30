<?php
require '../config/auth.php';

logout_user();
header('Location: /?page=login');
exit;
