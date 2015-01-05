<?php
//include 'header.php';
?>
<div id="wrapper" class='loginForm'>
    <div id="signupDiv" class='loginForm'>
        <form id='signupForm' name='signupForm' class='signupForm' action='functions/doSignup.php' method='post'>
            Register<br/><br/>
            <input type='text' name='username' id='username' maxlength="50" placeholder="UserName*" required/><br/>
            <input type='password' name='password' id='password' maxlength="50" placeholder="Password*" required/><br/>
            <input type='password' name='confpassword' id='confpassword' maxlength="50" placeholder="Retype Password*" required/><br/>
            <input type='email' name='email' id='email' maxlength="50" placeholder="Email Address*" required/><br/><br/>
            <!--<label for='gender' > Gender</label>
            <input type="radio" name="gender" value="male">Male
            <input type="radio" name="gender" value="female">Female<br/>-->

            <input type='submit' name='Submit' class='sendButton' value='Submit' />
            <div class="signup">
                <a id="backBtn" href="#"  onclick=" loadLogin();">Back</a><br/><br/>
            </div>
        </form></div>
</div>
<?php
//include 'footer.php';
?>

