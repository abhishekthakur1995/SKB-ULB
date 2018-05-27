<?php
  require('languages/hi/lang.hi.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.0/css/mdb.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.0/umd/popper.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.5.0/js/mdb.min.js"></script>
</head>
<body>

<nav class="mb-1 navbar navbar-expand-lg navbar-dark info-color header-height">
    <a class="navbar-brand header-font-size" href="<?php echo BASE_URL; ?>/dashboard.php">
        <span><?php echo $lang['company']; ?></span>
        <span class="full-width fs4 fleft"><?php echo $lang['header_title']; ?></span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
        <ul class="navbar-nav ml-auto">
            <?php if(!isset($_SESSION['username'])) { ?>
                <li class="nav-item">
                    <a class="nav-link waves-effect waves-light" href="index.php">
                        <i class="fa fa-sign-in"></i> <?php echo $lang['login']; ?></a>
                </li>
            <?php } ?>

            <?php if(isset($_SESSION['username'])) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-light fs4" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user"></i> <?php echo $_SESSION['username']; ?> </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-info" aria-labelledby="navbarDropdownMenuLink-4">
                        <a class="dropdown-item waves-effect waves-light" href="<?php echo BASE_URL; ?>/dashboard.php"><?php echo $lang['dashboard']; ?></a>
                        <a class="dropdown-item waves-effect waves-light" href="<?php echo BASE_URL; ?>/reset_password.php"><?php echo $lang['reset_password']; ?></a>
                        <a class="dropdown-item waves-effect waves-light" href="<?php echo BASE_URL; ?>/logout.php"><?php echo $lang['logout']; ?></a>
                    </div>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>
</body>
</html>
