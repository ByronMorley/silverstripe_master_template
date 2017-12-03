<div class="content-container typography>">
    <div class="contents">
        $Content
        <div class="login_and_register_module box">
            <h2 class="title"><%t MemberProfiles.LOGINHEADER "Log in" %></h2>
            <p class="login-text"><%t MemberProfiles.LOGIN "If you already have an account, you can log in here" loginLink=$LoginLink %></p>
            <a href="$LoginLink" class="button full no-margin">
                <span>Login</span>
            </a>
        </div>
        <div class="login_and_register_module box">
            <h2 class="title"><%t MemberProfiles.REGISTER "Register" %></h2>
            $Form
            <a href="#" id="real-register-button" class="button full no-margin">
                <span>Register</span>
            </a>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){

        $('#real-register-button').on('click', function(){
            $('#Form_RegisterForm_action_register').submit();
        });
    });
</script>