<?php
/**
 * Created by www.chat.io.
 * User: ariel.zusman
 * Date: 05/10/2015
 * Time: 16:42
 */
require_once '../chatApp/init.php';

$app = new App;

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>

<form class="js-form" action="" method="post">
    <p>Register new user</p>
    <label for="username">User Name:</label>
    <input class="js-username" type="text" name="username" id="username" value="">
    <input class="js-token" type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input class="js-submit" type="submit" value="submit">
    <p class="error"></p>
</form>
<?php var_dump($_SESSION);?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="js/jquery-2.1.4.min.js"><\/script>')</script>
<script src="js/main.js"></script>
</body>
</html>
