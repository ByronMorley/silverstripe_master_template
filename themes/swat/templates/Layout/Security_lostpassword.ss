<!-- Security Lost Password Layout -->


<div class="login_and_register_module box">

    <h2 class="title">$Title</h2>
    $Form
    <a href="" id="real-logout" class="button full no-margin">
        <span>Reset Link</span>
    </a>
</div>


<script>
    $(document).ready(function () {
        $('#real-login-button').on('click', function(e){
            e.preventDefault();
            $('#CustomMemberLoginForm_LostPasswordForm').submit();
        });
    })
</script>