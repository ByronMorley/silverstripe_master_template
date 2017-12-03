<!-- Security Login Layout -->


<% if $CurrentMember %>
    <a href="$absoluteBaseURL\main-menu" class="button full">
        <span>Main menu</span>
    </a>
    <a href="$absoluteBaseURL\Security/lostpassword" class="button full">
        <span>Change Password</span>
    </a>
    <a href="$absoluteBaseURL\Security/logout" class="button full">
        <span>Logout</span>
    </a>
<% else %>
<div class="login_and_register_module box">

    <h2 class="title">$Title</h2>
    $Form
    <a href="" id="real-login-button" class="button full no-margin">
        <span>Login</span>
    </a>

</div>
<% end_if %>
<script>
    $(document).ready(function(){
        $('.title-section h1').text('Account');

        $('#real-login-button').on('click', function(e){
            e.preventDefault();
            $('#CustomMemberLoginForm_LoginForm').submit();
        });
    })
</script>