<?php
include 'header.php';
?>
<div id="wrapper" >
<div id='loginDiv' name='logindiv' class='loginForm' >
    <img src='resources/img/logo1.png' class="logo" title='Logo'  alt='This was the Logo' /> 
    <form id="submitForm" action='functions/doLogin.php' method="post" > <br/>
        <p> <input type='text'  name='username' maxlength='15' autocomplete='off' placeholder='Username' /></p>
        <p> <input type='password'  name='password' maxlength='20' placeholder='Password' /></p>
        Guest Login <input type='checkbox' name='isGuest' value='guest' />
        <input type='submit' name='loginButton' class='loginButton' value='Login' /> <br/><br/>
        <div class="signup">
            <a id="signupBtn" href="#" onclick="loadSignup();">Signup</a>
        </div>
    </form>
</div>
</div>

<?php
include 'footer.php';
?>