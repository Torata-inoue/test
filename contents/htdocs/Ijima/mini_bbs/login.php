<?php
session_start();
require('dbconnect.php');

/**
 * @param string $email
 * @param string $password
 * @param string|null $save
 * @param PDO $db
 * @throws Exception
 */
function login(string $email, string $password, ?string $save, PDO $db)
{
    if (!$email || !$password) {
        throw new Exception('* メールアドレスとパスワードをご記入ください');
    }

    $login = $db->prepare('SELECT * FROM members WHERE email=? AND password=?');
    $login->execute(array(
        $email,
        sha1($password)
    ));
    $member = $login->fetch();

    if (!$member) {
        throw new Exception('* ログインに失敗しました。正しくご記入ください');
    }

    $_SESSION['id'] = $member['id'];
    $_SESSION['time'] = time();

    if ($save  === 'on') {
        setcookie('email', $email, time() + 60 * 60 * 24 * 14);
    }
}

$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;
$save = $_POST['save'] ?? null;

if ($email && $password) {
    try {
        login($email, $password, $save, $db);
        header('Location: index.php');
        exit();
    } catch (\Exception $e) {
        $res = $e->getMessage();
    }
}

if (!$email) {
    $email = $_COOKIE['email'] ?? null;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<title>ログインする</title>
</head>

<body>
<div id="wrap">
  <div id="head">
    <h1>ログインする</h1>
  </div>
  <div id="content">
    <div id="lead">
      <p>メールアドレスとパスワードを記入してログインしてください。</p>
      <p>入会手続きがまだの方はこちらからどうぞ。</p>
      <p>&raquo;<a href="join/">入会手続きをする</a></p>
    </div>
    <form action="" method="post">
      <dl>
        <dt>メールアドレス</dt>
        <dd>
          <input type="text" name="email" size="35" maxlength="255" value="<?= $email ? htmlspecialchars($email, ENT_QUOTES) : ''; ?>" />
            <?php if (isset($res)): ?>
                <p class="error"><?= $res; ?></p>
            <?php endif; ?>
        </dd>
        <dt>パスワード</dt>
        <dd>
          <input type="password" name="password" size="35" maxlength="255" value="<?= $password ? htmlspecialchars($password, ENT_QUOTES) : ''; ?>" />
        </dd>
        <dt>ログイン情報の記録</dt>
        <dd>
          <input id="save" type="checkbox" name="save" value="on">
          <label for="save">次回からは自動的にログインする</label>
        </dd>
      </dl>
      <div>
        <input type="submit" value="ログインする" />
      </div>
    </form>
  </div>
  <div id="foot">
    <p><img src="images/txt_copyright.png" width="136" height="15" alt="(C) H2O Space. MYCOM" /></p>
  </div>
</div>
</body>
</html>
