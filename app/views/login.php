<?php if (isset($error)): ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>
<form action="/todo_app_auth/?action=login" method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
    <a class="page-link" href="?action=register">register</a>
</form>
