<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client | Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
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
    </header>
    <div class="container">
        <div class="box signin">
            <h2>Already Have an account?</h2>
            <button class="signinBtn">Login</button>
        </div>

        <div class="box signup">
            <h2>Don't Have an account?</h2>
            <button class="signupBtn">Register</button>
        </div>

        <div class="formBx">
            <div class="form signinform">
                <form action="">
                    <h3>Sign In</h3>
                    <input type="text" placeholder="Username">
                    <input type="password" placeholder="Password">
                    <input type="submit" value="Login">
                    <a href="#" class="forgot">Forgot Password</a>
                </form>
            </div>

            <div class="form signupform">
                <form action="">
                    <h3>Sign Up</h3>
                    <input type="text" placeholder="First Name">
                    <input type="text" placeholder="Last Name">
                    <input type="email" placeholder="Email">
                    <input type="text" placeholder="Phone">
                    <input type="text" placeholder="Gender">
                    <input type="text" placeholder="Location">
                    <input type="text" placeholder="Age">
                    <input type="password" placeholder="Password">
                    <input type="password" placeholder="Confirm Password">
                    <input type="submit" value="Register">
                    
                </form>
            </div>
        </div>
    </div>
    <script>
        let signinBtn = document.querySelector('.signinBtn');
        let signupBtn = document.querySelector('.signupBtn');
        let body = document.querySelector('body');

        signupBtn.onclick = function(){
            body.classlist.add('slide'); 
        }

        signinBtn.onclick = function(){
            body.classlist.remove('slide'); 
        }
    </script>

    <footer>
        <p>&copy; 2024 KibokoBodyBuilders . All rights reserved.</p>
    </footer>
</body>
</html>