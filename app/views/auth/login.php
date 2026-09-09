<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login — Product CRUD</title>
    <style>
        body { font-family: system-ui, sans-serif; background: #f4f5f7; display: flex; height: 100vh; align-items: center; justify-content: center; margin: 0; }
        .card { background: #fff; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,.08); width: 320px; }
        h1 { font-size: 1.25rem; margin-bottom: 1rem; }
        input { width: 100%; padding: .6rem; margin-bottom: .8rem; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { width: 100%; padding: .6rem; background: #2563eb; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
        .error { color: #b91c1c; font-size: .9rem; margin-bottom: .8rem; }
        .link { text-align: center; margin-top: 1rem; font-size: .9rem; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Sign in</h1>

        <?php if (!empty($error)): ?>
            <p class="error"><?= html_escape($error) ?></p>
        <?php endif; ?>

        <form action="<?= site_url('login') ?>" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <p class="link">No account yet? <a href="<?= site_url('register') ?>">Register</a></p>
    </div>
</body>
</html>