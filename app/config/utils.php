<?php
function slugify($text) {
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $text)));
}

function escape($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}