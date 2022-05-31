<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- MDUI CSS -->
    <link rel="stylesheet" href="./dist/css/mdui.min.css">
    <!-- MDUI JS -->
    <script src="./dist/js/mdui.min.js"></script>
    <!-- JQUERY -->
    <script src="./dist/js/jquery-3.6.0.js"></script>
<title>ProCloudDrive - Login</title>
</head>
<body>
<!-- 导航栏 -->
<header class="mdui-appbar">
    <div class="mdui-toolbar mdui-color-teal">
        <a href="javascript:;" class="mdui-btn mdui-btn-icon"mdui-drawer="{target: '#dw'}"><i class="mdui-icon material-icons">menu</i></a>
        <a href="javascript:;" class="mdui-typo-title">WarmaCloudDrive 用户管理系统 - 登录</a>
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
<!-- 主内容 -->
<div class="mdui-container">
    <div class="mdui-row">
        <div class="mdui-col-md-offset-3 mdui-col-md-6">
            <div class="mdui-card">
                <div class="mdui-card-primary">
                    <div class="mdui-card-primary-title">Register</div>
                </div>
                <div class="mdui-card-content">
                    <form action="login.php" method="post">
                        <div class="mdui-textfield mdui-textfield-floating-label">
                            <i class="mdui-icon material-icons">account_circle</i>
                            <label class="mdui-textfield-label">Username</label>
                            <input class="mdui-textfield-input" type="text" name="username" required/>
                        </div>
                        <div class="mdui-textfield mdui-textfield-floating-label">
                            <i class="mdui-icon material-icons">lock</i>
                            <label class="mdui-textfield-label">Password</label>
                            <input class="mdui-textfield-input" type="password" name="password" required/>
                        </div>
                        <button class="mdui-btn mdui-color-theme-accent mdui-ripple" type="submit">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</html>
<?php
//check if the user is submit the form
if(isset($_POST['username']) && isset($_POST['password'])){
    //connect to the database
    // link the config file
    require_once 'config.php';
    // connect to the database
    $conn = new mysqli($dhost, $dusername, $dpassword, $ddatabase);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    //md5 the password
    $username= $_POST['username'];
    $password = md5($_POST['password']);
    //检查数据库中是否有此用户
    $sql = "SELECT * FROM user WHERE username='$username'";
    $result = $conn->query($sql);
    //如果有，检查密码是否正确，如果没有，显示snackbar
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if($row['password'] == $password){
            //登录成功，设置cookie
            setcookie("username", $username, time()+3600*24*7);
            setcookie("password", $password, time()+3600*24*7);
            //跳转到主页
            header("Location: index.php");
        }else{
            //密码错误，显示snackbar
            echo '<script>mdui.snackbar({
                message: "鉴定故障",
                position: "top"
            });</script>';
        }
    } else {
        //没有此用户，显示snackbar
        echo '<script>mdui.snackbar({
            message: "鉴定故障",
            position: "top"
        });</script>';
    }
    $conn->close();
}
?>