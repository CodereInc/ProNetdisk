<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- MDUI CSS -->
    <link rel="stylesheet" href="./dist/css/mdui.min.css">
    <!-- MDUI JS -->
    <script src="./dist/js/mdui.min.js"></script>
    <!-- JQUERY -->
    <script src="./dist/js/jquery-3.6.0.js"></script>
<title>ProNetdisk</title>
</head>
<body>
<!-- 导航栏 -->
<header class="mdui-appbar">
    <div class="mdui-toolbar mdui-color-deep-orange">
        <a href="javascript:;" class="mdui-btn mdui-btn-icon"mdui-drawer="{target: '#dw'}"><i class="mdui-icon material-icons">menu</i></a>
        <a href="javascript:;" class="mdui-typo-title">WarmaCloudDrive</a>
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
<!-- MDUI content -->
<div class="mdui-container">
    <div class="mdui-typo">
        <h1>ProNetdisk</h1>
        <h3>开源云盘系统</h3>
    </div>
    <div class="mdui-typo">
        <ul class="mdui-list">
            <a href="login.php">
            <li class="mdui-list-item mdui-ripple">
                <div class="mdui-list-item-content">
                    <div class="mdui-list-item-title">Login</div>
                    <div class="mdui-list-item-text">Login with your account.</div>
                    </a>
                </div>
            </li>
            </a>
            <a href="register.php">
            <li class="mdui-list-item mdui-ripple">
                <div class="mdui-list-item-content">
                    
                    <div class="mdui-list-item-title">Register</div>
                    <div class="mdui-list-item-text">Register a new account.</div>
                    
                </div>
            </li>
            </a>
            <a href="about.html">
            <li class="mdui-list-item mdui-ripple">
                <div class="mdui-list-item-content">
                    <div class="mdui-list-item-title">About</div>
                    <div class="mdui-list-item-text">About this project.</div>
                </div>
            </li>
            </a>
        </ul>
    </div>
</div>
<div style="height:100px"></div>
<!-- MDUI footer -->
<footer class="mdui-container">
    <div class="mdui-typo">
        <p>Copyright © 2022 WarmaCloudDrive. All Rights Reserved.</p>
        <p>Powered By ProNetdisk Core 0.1b0;</p>
        <p>This Project is Opensource with GPLv3 license.</p>
        <p>Opensource Project: <a href="https://github.com/CodereInc/ProNetdisk">ProNetdisk </a></p>
        <p>0431-88540315</p>
    </div>
</footer>
</body>
</html>