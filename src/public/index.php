<?php
// session_start();
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Chat</title>
	<link rel="stylesheet" href="css/main.css">
</head>
<body>
	<main class="main clearfix">
        <nav class="nav">
            <a href="#" class="btn btn--login">green</a>
            <a href="#" class="btn btn--newUser">green</a>
            <a href="#" class="btn btn--logout">green</a>
        </nav>
        <ul class="users">
           <!-- <li class="user__item userID-5 has-newMessage">Dani</li> -->
        </ul>
        <div class="conversation">
            <div class="message-wrap">
                <div class="message message--me">hi there</div>
            </div>
            <div class="message-wrap">
                <div class="message message--other">whats up</div>
            </div>
            <div class="message-wrap">
                <div class="message message--me">hi there</div>
            </div>
            <div class="message-wrap">
                <div class="message message--other">whats up</div>
            </div>
            <div class="message-wrap">
                <div class="message message--me">hi there</div>
            </div>
            <div class="message-wrap">
                <div class="message message--other">whats up</div>
            </div>
            <div class="message-wrap">
                <div class="message message--me">hi there</div>
            </div>
            <div class="message-wrap">
                <div class="message message--other">whats up</div>
            </div>
            <div class="message-wrap">
                <div class="message message--me">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam aut consectetur, debitis dignissimos ducimus est facere facilis ipsa iusto minima neque nulla obcaecati perferendis quis quisquam soluta temporibus velit, voluptatem!</div>
            </div>
            <div class="message-wrap">
                <div class="message message--other">whats up</div>
            </div>

        </div>

        <form action="" method="post" class="loginForm">
            <label for="username">Enter username:</label>
            <input type="text" name="username" value="" id="username">
            <input class="btn btn--login" type="submit" value="Login">
        </form>

        <form action="" method="post" class="sendMsg">
            <label for="message"></label>
            <input type="text" name="message" value="" id="message">
            <input class="btn btn--login" type="submit" value="send">
        </form>



    </main>

	<script src="js/jquery-2.1.4.min.js"></script>
	<script src="js/main.js"></script>
</body>
</html>
