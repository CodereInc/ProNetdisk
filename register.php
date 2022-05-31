<html>
    <head>
        <meta charset="utf-8"/>
        <title>ProCloudDrive - Register</title>
        <link rel="stylesheet" href="./dist/css/mdui.min.css"/>
        <script src="./dist/js/mdui.min.js"></script>
        <script src="./dist/js/jquery-3.6.0.js"></script>
    </head>
    <body>
        <!-- 导航栏 -->
<header class="mdui-appbar">
    <div class="mdui-toolbar mdui-color-teal">
        <a href="javascript:;" class="mdui-btn mdui-btn-icon"mdui-drawer="{target: '#dw'}"><i class="mdui-icon material-icons">menu</i></a>
        <a href="javascript:;" class="mdui-typo-title">WarmaCloudDrive 用户管理系统 - 注册</a>
    </div>
</header>
<!-- 侧边栏 -->
<div class="mdui-drawer-close mdui-drawer" id="dw">
    <div class="mdui-list" mdui-collapse="{accordion: true}">
        <li class="mdui-list-item mdui-ripple">
            <i class="mdui-list-item-icon mdui-icon material-icons">home</i>
            <a href="#home" class="mdui-list-item-content">Home</a>
        </li>
        <li class="mdui-collapse-item">
            <div class="mdui-collapse-item-header mdui-list-item mdui-ripple">
                <i class="mdui-list-item-icon mdui-icon material-icons">account_circle</i>
                <a href="javascript:;" class="mdui-list-item-content">Account</a>
                <i class="mdui-collapse-item-arrow mdui-icon material-icons">keyboard_arrow_down</i>
            </div>
            <ul class="mdui-collapse-item-body mdui-list mdui-list-dense">
                <li class="mdui-list-item mdui-ripple"><a href="login.php" class="mdui-list-item-content">Login</a></li>
                <li class="mdui-list-item mdui-ripple"><a href="register.php" class="mdui-list-item-content">Register</a></li>
            </ul>
        </li>
        <li class="mdui-list-item mdui-ripple">
            <i class="mdui-list-item-icon mdui-icon material-icons">info</i>
            <a href="about.html" class="mdui-list-item-content">About</a>
        </li>
    </div>
</div>
<!-- 主内容区 -->
<div class="mdui-container">
    <div class="mdui-row">
        <div class="mdui-col-md-offset-3 mdui-col-md-6">
            <div class="mdui-card">
                <div class="mdui-card-primary">
                    <div class="mdui-card-primary-title">Register</div>
                </div>
                <div class="mdui-card-content">
                    <form action="register.php" method="post">
                        <div class="mdui-textfield mdui-textfield-floating-label">
                            <i class="mdui-icon material-icons">account_circle</i>
                            <label class="mdui-textfield-label">Username</label>
                            <input class="mdui-textfield-input" type="text" name="username" required/>
                        </div>
                        <div class="mdui-textfield mdui-textfield-floating-label">
                            <i class="mdui-icon material-icons">email</i>
                            <label class="mdui-textfield-label">Email</label>
                            <input class="mdui-textfield-input" type="email" name="email" required/>
                        </div>
                        <div class="mdui-textfield mdui-textfield-floating-label">
                            <i class="mdui-icon material-icons">lock</i>
                            <label class="mdui-textfield-label">Password</label>
                            <input class="mdui-textfield-input" type="password" name="password" required/>
                        </div>
                        <div class="mdui-textfield mdui-textfield-floating-label">
                            <i class="mdui-icon material-icons">lock</i>
                            <label class="mdui-textfield-label">Confirm Password</label>
                            <input class="mdui-textfield-input" type="password" name="password2" required/>
                        </div>
                        <!-- hcaptcha -->
                        <button class="mdui-btn mdui-color-theme-accent mdui-ripple" type="submit">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- 底部 -->
<footer class="mdui-color-theme-accent mdui-row">
    <div class="mdui-col-xs-12">
        <p>Copyright © 2022 WarmaCloudDrive</p>
    </div>
</footer>
    </body>
</html>
<?php
// if user click the submit button
if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password2'])) {
    // check if the password and confirm password are the same
    if ($_POST['password'] != $_POST['password2']) {
        //snackbar("Password and confirm password are not the same!");
        echo "<script>mdui.snackbar({message: '两次输入的密码不一致!', position: 'top'});</script>";
    } else {
        // link the config file
        require_once 'config.php';
        // connect to the database
        $conn = new mysqli($dhost, $dusername, $dpassword, $ddatabase);
        //get the post data
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $sql = "SELECT * FROM `$dprefix"."user` WHERE `username` = '$username'";
        $result = $conn->query($sql);
        // if the username is already in the database
        if ($result->num_rows > 0) {
            //snackbar("Username or email has been registered!");
            echo "<script>mdui.snackbar({message: '用户名或邮箱已经被注册!', position: 'top'});</script>";
        } else {
                // insert the data into the database
                $sql = "INSERT INTO `".$dprefix."user` (`username`, `password`, `email`, `group`, `status`, `last_login_time`, `last_login_ip`, `create_time`, `update_time`) VALUES ('$username', '$password', '$email', 1, 1, 0, '
', ".time().", ".time().");";
                if ($conn->query($sql) === TRUE) {
                    //snackbar("Register successfully!");
                    echo "<script>mdui.snackbar({message: '$result', position: 'top'});</script>";
                    echo $result;
                } else {
                    //snackbar("Error: " . $sql . "<br>" . $conn->error);
                    echo "Error:" . $sql . $conn->error;
                }
            }
        }
    }
?>