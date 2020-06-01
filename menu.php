<?php
if($_POST['idioma'] == "english"){
	unset($_SESSION['lang']);
	$_SESSION['lang'] = "english";;	
}
elseif($_POST['idioma'] == "spanish"){
	unset($_SESSION['lang']);
	$_SESSION['lang'] = "spanish";
}
elseif($_POST['idioma'] == "portuguese"){
	unset($_SESSION['lang']);
	$_SESSION['lang'] = "portuguese";
}

if($_SESSION['MM_Username'] != ""){
	echo '
	<form action="" id="lang" method="POST">
		<select name="idioma" onchange="this.form.submit();">	
        	<option value="english">English</option>
            <option value="spanish">Spanish</option>
            <option value="portuguese">Portuguese</option>
        </select>
    </form>
    <ul>
    	<li><a href="index.php">Home</a></li>
    	<li><a href="faq.php">FAQ</a></li>
        <li><a href="support.php">Request Support</a></li>
        <li><a href="/forum/index.php">Forum</a></li>
    </ul>

    <strong>User Actions</strong>
	  <ul>
  		<li><a href="panel.php">Panel</a></li>
  		<li><a href="admfolders.php">Admin Folders</a></li>
        <li><a href="createfolder.php">Create Folder</a></li>
        <li><a href="#">Change Password</a></li>
        <li><a href="#">Change Email</a></li>
        <li><a href="logout.php">Logout</a></li>
      </ul>';	  
} else {
	echo '
	<form action="" id="lang" method="POST">
		<select name="idioma" onchange="this.form.submit();">	
        	<option selected="selected">English</option>
            <option>Spanish</option>
            <option>Portuguese</option>
        </select>
    </form>
    <ul>
    	<li><a href="index.php">Home</a></li>
    	<li><a href="faq.php">FAQ</a></li>
        <li><a href="support.php">Request Support</a></li>
        <li><a href="/forum/index.php">Forum</a></li>
    </ul>
    
    <strong>User Actions</strong>
     <ul>
    	<li><a href="login.php">Login</a></li>
    	<li><a href="register.php">Register</a></li>
   		<li><a href="recover.php">Forgot Your Password?</a></li>
    </ul>';
}
?>
