function loadLogin() {
    $('#wrapper').fadeOut('slow', function() {
        $("#wrapper").fadeIn('slow').load('login.php #loginDiv');
    });

}
function loadSignup() {

    $('#wrapper').fadeOut('slow', function() {
        $('#wrapper').fadeIn('slow').load('signup.php #signupDiv');
    });

}