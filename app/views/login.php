    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card" style="width: 400px;">
            <div class="card-header bg-primary text-white text-center">
                <h4>Login</h4>
            </div>
            <div class="card-body">
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <form action="?action=login" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Keep me logged in</label>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>
                <div class="mt-3 text-center">
                    <p>Don't have an account? <a href="?action=register">Register here</a></p>
                </div>
            </div>
        </div>
    </div>

<!-- <?php //if (isset($error)): ?>
    <p style="color:red;"><?php //echo $error; ?></p>
<?php //endif; ?>
<form action="/todo_app_auth/?action=login" method="POST">
    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" class="form-control" required>
    </div>
    <div class="form-check">
        <input type="checkbox" id="remember" name="remember" class="form-check-input">
        <label class="form-check-label" for="remember">Keep me logged in</label>
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
    <a class="page-link" href="?action=register">register</a>
</form> -->
