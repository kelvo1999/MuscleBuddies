<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client | Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<!-- <header>
        <nav>
            <div class="logo">Kiboko Body Builders</div>
            <ul>
                <li>
                    <a href="../index.html">Home</a>
                </li>
                <li>
                    <a href="instructor.php">Instructor</a>
                </li>
                <li>
                    <a href="client.php">Client</a>
                </li>
                <li>
                    <a href="admin.php">Admin</a>
                </li>
                <li>
                    <a href="#contact">Contact</a>
                </li>
            </ul>
        </nav>
    </header> -->
    <div class="container">
        <div class="box signin">
            <h2>Already Have an account?</h2>
            <button class="signinBtn">Login</button>
        </div>

        <div class="box signup">
            <h2>Don't Have an account?</h2>
            <button class="signupBtn">Register</button>
        </div>

        <div class="formBx"></div>
    </div>
    <script>
        let signinBtn = document.querySelector('.signinBtn');
        let signupBtn = document.querySelector('.signupBtn');
        let body = document.querySelector('body');

        signupBtn.onclick = function(){
            body.classlist.add('slide');
        }
    </script>

    <footer>
        <p>&copy; 2024 KibokoBodyBuilders . All rights reserved.</p>
    </footer>
</body>
</html>