<?php
session_start();
include("./db/db.php");

if (isset($_POST["login"])) {
    $user = filter_input(INPUT_POST, "user", FILTER_SANITIZE_SPECIAL_CHARS);
    $pass = filter_input(INPUT_POST, "pass", FILTER_SANITIZE_SPECIAL_CHARS);

    $sql = "SELECT * FROM users WHERE username='$user' LIMIT 1";
    $res = mysqli_query($conn, $sql);

    if ($res && $res->num_rows > 0) {
        $row = mysqli_fetch_assoc($res);

        // Simple plain-text password comparison
        if ($pass === $row['password']) {
            $_SESSION['username'] = $user;
            header("Location: ./index.php");
            exit;
        }
    } else {
        echo "<script>alert('Username not found!'); window.location.href='./login.php';</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="./style/output.css" />
</head>

<body>
    <div class="grid grid-cols-2 place-items-center">
        <div class="flex flex-col gap-4 justify-center items-center h-screen w-full">
            <div class="size-30 rounded-full shadow grid place-items-center">
                <img src="./image/logo.png" alt="logo">
            </div>
            <h1 class="font-black text-5xl mb-8">WELCOME BACK!</h1>

            <?php if (isset($_GET['error']) && $_GET['error'] == 'invalid'): ?>
                <p class="text-red-500 font-semibold">Invalid username or password!</p>
            <?php endif; ?>

            <form action="./login.php" method="post" class="flex flex-col gap-4 justify-center items-center w-3/4">
                <label class="input validator input-lg rounded-full w-3/4">
                    <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                            <circle cx="12" cy="8" r="5" />
                            <path d="M20 21a8 8 0 0 0-16 0" />
                        </g>
                    </svg>
                    <input
                        type="text"
                        required
                        placeholder="Username"
                        pattern="[A-Za-z][A-Za-z0-9\-]*"
                        minlength="3"
                        maxlength="30"
                        title="Only letters, numbers or dash"
                        name="user"
                    />
                </label>

                <label class="input validator input-lg rounded-full w-3/4">
                    <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                            <path d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"></path>
                            <circle cx="16.5" cy="7.5" r=".5" fill="currentColor"></circle>
                        </g>
                    </svg>
                    <input
                        type="password"
                        required
                        placeholder="Password"
                        minlength="8"
                        name="pass"
                    />
                </label>

                <label class="flex items-center gap-2 w-3/4">
                    <input type="checkbox" checked="checked" class="checkbox" />
                    <h1>Remember Me</h1>
                </label>

                <input type="submit" class="btn rounded-full w-3/4 btn-lg border text-[20px]" name="login" value="LOGIN">
            </form>

            <a href="./register.php" class="hover:underline">Don't Have an Account? Register</a>
        </div>
        <div></div>
    </div>
</body>

</html>
