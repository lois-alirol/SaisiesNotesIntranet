<!DOCTYPE html>
<html lang="fr">
    <head>
        <title>Se Connecter</title>
        <link rel="stylesheet" href="/public/css/login.css">
        <link rel="stylesheet" href="/public/css/style.css">
    </head>
    <body>
        <div class="login-container">
            <img src="/public/images/uca-logo.png" width="256px" class="uca-logo" alt="UCA Logo">
            <?php if (isset($error)): ?>
                <p class="error">
                    <?= $error ?>
                </p>
            <?php endif; ?>
            <h1 class="form-title">Connexion au Front Office</h1>
            <form class="login-form" method="post" action="/login">
                <label for="email">Email</label>
                <input id="email" type="email" name="email">

                <label for="password">Mot de Passe</label>
                <input id="password" type="password" name="password">

                <button type="submit">Se Connecter</button>
            </form>
        </div>
    </body>
</html>