<script>
    function verify_password()
    {
        var password = $('#password').val();
        var password_verify = $('#password_verify').val();

        if(password == '' | password_verify == '')
        {
            $('#password, #password_verify').addClass("is-invalid").removeClass('is-valid');
            $('#password_req').replaceWith('<small id="password_req" class="form-text pl-1 text-danger">One of the password fields are empty.</small>');
            $('#password_verify_req').replaceWith('<small id="password_verify_req" class="form-text pl-1 text-danger">One of the password fields are empty.</small>');
        }
        else
        {
            if(password != password_verify)
            {
                // passwords do not match
                $('#password, #password_verify').addClass("is-invalid").removeClass('is-valid');
                $('#password_req').replaceWith('<small id="password_req" class="form-text pl-1 text-danger">Password fields do not match.</small>');
                $('#password_verify_req').replaceWith('<small id="password_verify_req" class="form-text pl-1 text-danger">Password fields do not match.</small>');
            }
            else
            {
                // passwords match
                $('#password, #password_verify').addClass("is-valid").removeClass('is-invalid');
                $('#password_req').replaceWith('<small id="password_req" class="form-text pl-1 text-success">Password fields match.</small>');
                $('#password_verify_req').replaceWith('<small id="password_verify_req" class="form-text pl-1 text-success">Password fields match.</small>');
            }
        }

    }

    function verify_type()
    {
        var type = $('#type').val();

        if( type == 'User Type (Choose One)' )
        {
            $('#type').addClass("is-invalid").removeClass('is-valid');
            $('#type_req').replaceWith('<small id="type_req" class="form-text pl-1 text-danger">Dont forget to select a user type!</small>');
        }
        else
        {
            $('#type').addClass("is-valid").removeClass('is-invalid');
            $('#type_req').replaceWith("<small id='type_req' class='form-text pl-1'></small>");
        }
    }

    function check_inputs()
    {
        $('input[type="text"]').each(function() {
            if($.trim($(this).val()) != '') {
                $(this).removeClass('is-invalid').addClass('is-valid');
            }
            else
            {
                $(this).addClass('is-invalid').removeClass('is-valid');
            }
        });
    }

    $(document).ready(function () {
        $('#password, #password_verify').keyup(verify_password);
    });

    $(document).ready(function () {
        verify_password();
        check_inputs();
        verify_type();

        $('input[type="text"]').change(check_inputs);
        $('#type').change(verify_type);
    });
</script>