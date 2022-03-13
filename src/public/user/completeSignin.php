<?php
session_start();

// DB接続
$db['user_name'] = 'root';
$db['password'] = 'password';
$pdo = new PDO(
    'mysql:host=mysql; dbname=blog; charset=utf8',
    $db['user_name'],
    $db['password']
);


$email = filter_input(INPUT_POST, 'email');
$password = filter_input(INPUT_POST, 'password');


// Email取得
$sql = 'SELECT * FROM users WHERE email = :email';
$statement = $pdo->prepare($sql);
$statement->bindValue(':email', $email, PDO::PARAM_STR);
$statement->execute();
$users = $statement->fetch(PDO::FETCH_ASSOC);


// バリデーション
if (empty($email) || empty($password)) $_SESSION['errors'][] = '「Email」または「パスワード」を入力してください';

if (!password_verify($password, $users['password'])) $_SESSION['errors'][] = 'パスワードが違います';


// エラーなかったら実行
if (!empty($_SESSION['errors'])) {
    header('location: ./signin.php');
    exit();
} else {
    $statement->execute();
    // セッションにログイン情報を登録
    $_SESSION['id'] = $users['id'];
    $_SESSION['name'] = $users['name'];
    $_SESSION['email'] = $users['email'];

    header('location: ../index.php');
    exit();
}
?>
