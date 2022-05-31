<?php
// if detect config.php, tell tell user dont install again
if (file_exists("config.php")) {
    echo "<script>alert('You have already installed WarmaCloudDrive, please delete config.php to continue.');</script>";
    echo "<script>window.location.href='index.php';</script>";
}
?>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>ProInstaller</title>
        <link rel="stylesheet" href="./dist/css/mdui.min.css"/>
        <script src="./dist/js/mdui.min.js"></script>
        <script src="./dist/js/jquery-3.6.0.js"></script>
    </head>
    <body>
        <form action="install.php"method="post">
        <!-- set background to skyblue -->
        <div class="mdui-container">
            <div class="mdui-typo">
                <h1>ProInstaller</h1>
                <h3>开源云盘系统安装程序</h3>
            </div>
            <div class="mdui-typo" id="i1">
                <ul class="mdui-list">
                    <li class="mdui-list-item mdui-ripple">
                    </li>
                </ul>
            </div>
        </div>
<!-- if user click the start button, then hide id i1 and show i2 -->
<div class="mdui-container" id="i2">
    <!-- let user configure the mysql -->
    <div class="mdui-typo">
        <h2>Step 1: Configure MySQL</h2>
        <h3>请输入MySQL的相关信息</h3>
    </div>
    <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">MySQL Host</label>
        <input class="mdui-textfield-input" type="text" id="host" name="host" value="localhost"/>
    </div>
    <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">MySQL Username</label>
        <input class="mdui-textfield-input" type="text" id="username" name="username" value="root"/>
    </div>
    <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">MySQL Password</label>
        <input class="mdui-textfield-input" type="password" id="password" name="password" value=""/>
    </div>
    <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">MySQL Database</label>
        <input class="mdui-textfield-input" type="text" id="database" name="database" value="procloud"/>
    </div>
    <div class="mdui-textfield mdui-textfield-floating-label">
        <input id="prefix" name="prefix" value="procloud_"style="display:none;" />
    </div>
    <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">MySQL Port</label>
        <input class="mdui-textfield-input" type="text" id="port" name="port" value="3306"/>
    </div>
<div class="mdui-container" id="i3">
    <!-- let user input the admin's information -->
    <div class="mdui-typo">
        <h2>Step 2: Configure Admin</h2>
        <h3>请输入管理员的相关信息</h3>
    </div>
    <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">Admin Username</label>
        <input class="mdui-textfield-input" type="text" id="admin_username" name="admin_username" value="admin"/>
    </div>
    <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">Admin Password</label>
        <input class="mdui-textfield-input" type="password" id="admin_password" name="admin_password" value=""/>
    </div>
    <div class="mdui-textfield mdui-textfield-floating-label">
        <label class="mdui-textfield-label">Admin Email</label>
        <input class="mdui-textfield-input" type="text" id="admin_email" name="admin_email" value=""/>
    </div>
    <!-- submit button if user click it,verify the data is not empty, if not empty submit the form-->
    <button class="mdui-btn mdui-color-theme-accent mdui-ripple" onclick="submit();">开始安装!</button>
</div>

</form>
</body>
</html>
<?php
// get the post data
$host = $_POST['host'];
$username = $_POST['username'];
$password = $_POST['password'];
$database = $_POST['database'];
$prefix = $_POST['prefix'];
$port = $_POST['port'];
$admin_username = $_POST['admin_username'];
$admin_password = $_POST['admin_password'];
$admin_email = $_POST['admin_email'];
// verify the data is not empty
if(empty($host) || empty($username) || empty($password) || empty($database) || empty($prefix) || empty($port) || empty($admin_username) || empty($admin_password) || empty($admin_email)){
    echo "<script>alert('请填写完整信息!');</script>";
    exit();
}
// connect to mysql
$conn = mysqli_connect($host,$username,$password);
// if connect failed, then show the error
if(!$conn){
    echo "<script>alert('连接失败!请检查MySQL的配置!');</script>";
    exit();
}
// create the database
$sql = "CREATE DATABASE $database";
if(!mysqli_query($conn,$sql)){
    echo "<script>alert('创建数据库失败!请检查MySQL的配置!');</script>";
    exit();
}
// close the connection
mysqli_close($conn);
// connect to mysql
$conn = mysqli_connect($host,$username,$password,$database);
// if connect failed, then show the error
if(!$conn){
    echo "<script>alert('验证错误!请检查MySQL的配置!');</script>";
    exit();
}
// if connect success, then write a config.php
$config = "<?php
\$dhost = '$host';
\$dusername = '$username';
\$dpassword = '$password';
\$ddatabase = '$database';
\$dprefix = '$prefix';
\$dport = '$port';
?>";
// write the config.php
$fp = fopen("./config.php","w");
fwrite($fp,$config);
fclose($fp);
// create the user table
$sql = "CREATE TABLE `".$prefix."user` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `group` int(11) NOT NULL,
    `status` int(11) NOT NULL,
    `last_login_time` int(11) NOT NULL,
    `last_login_ip` varchar(255) NOT NULL,
    `create_time` int(11) NOT NULL,
    `update_time` int(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
// execute the sql
$result = mysqli_query($conn,$sql);
// if execute failed, then show the error
if(!$result){
    echo "<script>alert('创建用户表失败!请检查数据库的配置!');</script>";
    exit();
}
// create the group table
$sql = "CREATE TABLE `".$prefix."group` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `status` int(11) NOT NULL,
    `create_time` int(11) NOT NULL,
    `update_time` int(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
// execute the sql
$result = mysqli_query($conn,$sql);
// if execute failed, then show the error
if(!$result){
    echo "<script>alert('创建用户组表失败!请检查数据库的配置!');</script>";
    exit();
}
// create the admin user and md5 the password
$admin_password = md5($admin_password);
// insert the admin user
$sql = "INSERT INTO `".$prefix."user` (`username`, `password`, `email`, `group`, `status`, `last_login_time`, `last_login_ip`, `create_time`, `update_time`) VALUES ('$admin_username', '$admin_password', '$admin_email', 1, 1, 0, '
', ".time().", ".time().");";
// execute the sql
$result = mysqli_query($conn,$sql);
// if execute failed, then show the error
if(!$result){
    echo "<script>alert('创建管理员用户失败!请检查数据库的配置!');</script>";
    exit();
}
// create the file table
$sql = "CREATE TABLE `".$prefix."file` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `size` int(11) NOT NULL,
    `type` varchar(255) NOT NULL,
    `path` varchar(255) NOT NULL,
    `status` int(11) NOT NULL,
    `create_time` int(11) NOT NULL,
    `update_time` int(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
// execute the sql
$result = mysqli_query($conn,$sql);
// if execute failed, then show the error
if(!$result){
    echo "<script>alert('创建文件表失败!请检查数据库的配置!');</script>";
    exit();
}
// show the success message
echo "<script>alert('安装成功!');</script>";
?>
<?php
// close the mysql
mysqli_close($conn);
?>