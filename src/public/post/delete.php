<?php
require_once __DIR__ . '/../../app/Lib/redirect.php';
require_once __DIR__ . '/../utils/deleteBlogs.php';

$id = filter_input(INPUT_GET, 'id');
deleteBlogs($id);
redirect('../myPage.php');
