$(document).ready(function(){
    $("#registerButton").click(function(){
        var $registerFieldsCont = $("#registerFieldsCont");
        if ("none"==$registerFieldsCont.css("display")) {
          $("#registerFieldsCont").slideDown();
        } else {
          $("#registerFieldsCont").slideUp();
        }
    });

    // add login click event listener
    $("#submitButton").click(function() {
        var login_user= $("#login_user");
        var password_user = $("#login_password");
        var login_user_val= $("#login_user").val();
        var password_user_val = $("#login_password").val();
        // console.log(login_user_val);
        // console.log(password_user_val);

        var $warning1 = $("<div>").addClass("registerWarnings").html("Fill in your name");
        var $warning2 = $("<div>").addClass("registerWarnings").html("Fill in your password");
        var $warning3 = $("<div>").addClass("registerWarnings").html("Wrong user name");
        var $warning4 = $("<div>").addClass("registerWarnings").html("Wrong password");
        // delete previous warnings
        $(".registerWarnings").remove();

        if (0 == login_user_val.length ) {
            $warning1.insertAfter(login_user);
            return;
        }

        if (0 == password_user_val.length ) {
            $warning2.insertAfter(password_user);
            return;
        }

        $.post("includes/loginpre_inc.php", {uidUsers:login_user_val, pwdUsers: password_user_val},
        function(data){
            // console.log(data);
            if(data=="nouser"){
                $warning3.insertAfter(login_user);
                return;
            }
            else if(data=="wrongpwd"){
                $warning4.insertAfter(password_user);
                return;
            }
            else{
                $("#loginSubmitBtn").click();
            }
         }); 

    }); 

    // add sign up click event listener
    $("#signupButton").click(function() {
        var $warning1 = $("<div>").addClass("registerWarnings").html("Fill in your name");
        var $warning2 = $("<div>").addClass("registerWarnings").html("Fill in your password");
        var $warning3 = $("<div>").addClass("registerWarnings").html("Fill in your repeated password");
        var $warning4 = $("<div>").addClass("registerWarnings").html("Fill in your email adress");
        var $warning5 = $("<div>").addClass("registerWarnings").html("Choose a location");
        var $warning6 = $("<div>").addClass("registerWarnings").html("Invalid Email");
        var $warning7 = $("<div>").addClass("registerWarnings").html("Passwords don't match");
        var $warning8 = $("<div>").addClass("registerWarnings").html("Taken user name");
        var $warning9 = $("<div>").addClass("registerWarnings").html("Taken email address");


        var register_user = $("#register_user");
        var register_email = $("#register_email");
        var register_password =$("#register_password");
        var register_password_repeat = $("#register_password_repeat");

        // delete previous warnings
        $(".registerWarnings").remove();

        if (0 == register_user.val().length ) {
            $warning1.insertAfter(register_user);
            return;
        }

        if (0 == register_email.val().length ) {
            $warning4.insertAfter(register_email);
            return;
        }

        if (0 == register_password.val().length ) {
            $warning2.insertAfter(register_password);
            return;
        }

        if (0 == register_password_repeat.val().length ) {
            $warning3.insertAfter(register_password_repeat);
            return;
        }

        if (0 == $("#user_location").val().length ) {
            $warning5.insertAfter("#user_location");
            return;
        }
        var register_user_val = $("#register_user").val();
        var register_email_val = $("#register_email").val();
        var register_password_val =$("#register_password").val();
        var register_password_repeat_val = $("#register_password_repeat").val();

        $.post("includes/signuppre_inc.php", {uidUsers:register_user_val, 
            emailUsers:register_email_val, pwdUsers: register_password_val, repwdUsers:register_password_repeat_val},
        function(data){
            console.log(data);
            if('invalidemail'==data){
                $warning6.insertAfter(register_email);
                return;
            }
            else if('notmatchingpw'==data){
                $warning7.insertAfter(register_password_repeat);
                return;
            }
            else if('takenname'==data){
                $warning8.insertAfter(register_user);
                return;
            }
            else if('takenemail'==data){
                $warning9.insertAfter(register_email);
                return;
            }
            else{
                $("#signupSubmitBtn").click();
            }
         }); 
    
        });
    // add logout click event listener
    $("#logoutButton").click(function() {
        // simulate click on the sign up button
        $("#logoutSubmitBtn").click();
        console.log("signup clicked");
    }); 

    // add start click event listener
    $("#startButton").click(function() {
        // simulate click on the sign up button
        $("#startSubmitBtn").click();
        console.log("signup clicked");
    }); 


});
