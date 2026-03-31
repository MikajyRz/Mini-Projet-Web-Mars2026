<?php
require '../config/db.php';

$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'home': require '../frontOffice/home.php'; break;
    case 'article': require '../frontOffice/article.php'; break;
    case 'dashboard': require '../backOffice/dashboard.php'; break;
    case 'login': require '../backOffice/login.php'; break;
    case 'logout': require '../backOffice/logout.php'; break;
    case 'add': require '../backOffice/article_add.php'; break;
    case 'edit': require '../backOffice/article_edit.php'; break;
    case 'delete': require '../backOffice/article_delete.php'; break;
    case 'save': require '../backOffice/save_article.php'; break;
    case 'upload': require '../backOffice/upload.php'; break;
    case 'categories': require '../backOffice/category_list.php'; break;
    case 'category_add': require '../backOffice/category_add.php'; break;
    case 'category_edit': require '../backOffice/category_edit.php'; break;
    case 'category_delete': require '../backOffice/category_delete.php'; break;
    case 'save_category': require '../backOffice/save_category.php'; break;
    default: echo "<h1>404 - Page non trouvée</h1>";
}