<!DOCTYPE html>
<html>

<head>
    <title>Register for Streaming Service</title>
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
        <h2>Register for Streaming Service</h2>
        <form>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="/login">Login now</a></p>
    </div>
</body>

</html>