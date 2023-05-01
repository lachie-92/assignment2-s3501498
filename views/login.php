<!DOCTYPE html>
<html>

<head>
    <title>Login to Streaming Service</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="header">
        <a href="/">
            <div class="logo">Music Streaming</div>
        </a>
        <div>
            <button onclick="location.href='/login'">Login</button>
            <button onclick="location.href='/register'">Register</button>
        </div>
    </div>
    <div class="form">
        <h2>Login to Streaming Service</h2>
        <form method="POST" action="/login">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <?php if (isset($error_message)): ?>
            <p style="color: red;"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <?php if (isset($success_message)): ?>
            <p style="color: green;"><?php echo $success_message; ?></p>
        <?php endif; ?>
        <p>Don't have an account yet? <a href="/register">Register now</a></p>
    </div>
</body>

</html>