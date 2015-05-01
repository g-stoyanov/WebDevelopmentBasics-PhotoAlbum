<!DOCTYPE html>
<html>
    <head>
        <?php
        $root_path = DX_ROOT_PATH;
            echo "<link rel='stylesheet' href='/{$root_path}content/styles/styles.css' />"
        ?>
        <title>
            Dream Albums
        </title>
    </head>
    <body>
        <header>
            <?php
            $root_path = DX_ROOT_PATH;
            echo "<img src='/{$root_path}content/images/logo.png'>"
            ?>
            <h1>DREAM Albums</h1>
        </header>
        <div id="container">
            <?php
                $root_path = DX_ROOT_PATH;
                if( ! empty( $this->logged_user ) ) {
                    echo "<div id='loginbar'> Hello, {$this->logged_user['username']}! <a href='/{$root_path}home/logout'>Logout</a> </div>";
                }else{
                    echo "<div id='loginbar'> Hello, guest! <a href='/{$root_path}home/register'>Register</a> <a href='/{$root_path}home/login'>Login</a> </div>";
                }
            ?>
            <div id="main">