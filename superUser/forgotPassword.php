<?php

if($_SESSION['user_role'] == 'SUPERUSER') {
	session_start();

	require('config.php');
	require('languages/hi/lang.hi.php');

	if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
	    header("location: index.php");
	    exit;
	} else {
	    if (time()-$_SESSION['timestamp'] > IDLE_TIME) {
	        header("location: logout.php");
	    }   else{
	        $_SESSION['timestamp']=time();
	    }
	}

	if($_SERVER["REQUEST_METHOD"] == "POST"){

	}
}