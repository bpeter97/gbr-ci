<script>
    function validate_password()
    {
        var password = $('#password').val();
        var password_verify = $('#password_verify').val();

        // Check if password fields are empty
        if( $.trim(password) == '' | $.trim(password_verify) == '' )
        {
            $('#password, #password_verify').addClass("is-invalid").removeClass('is-valid');
            $('#password_req').replaceWith('<small id="password_req" class="form-text pl-1 text-danger">One of the password fields are empty.</small>');
            $('#password_verify_req').replaceWith('<small id="password_verify_req" class="form-text pl-1 text-danger">One of the password fields are empty.</small>');
        }
        else
        {
            // Check if password fields match
            if( $.trim(password) != $.trim(password_verify) )
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

    // Checking the strength of the password
    function password_strength(field)
    {
        $pass = $('#' + field).val();
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

    function update_popovers(id, password)
    {
        // validate password lengths
        if( password.length >= 6 )
        {
            $('#' + id + '-chars-text').removeClass('text-danger').addClass('text-success');
            $('#' + id + '-chars-x').addClass('d-none');
            $('#' + id + '-chars-check').removeClass('d-none');
            $('#' + id).popover('show');
        }
        else
        {
            $('#' + id + '-chars-text').removeClass('text-success').addClass('text-danger');
            $('#' + id + '-chars-check').addClass('d-none');
            $('#' + id + '-chars-x').removeClass('d-none');
            $('#' + id).popover('show');
        }

        // check if password contains a letter
        if ( password.match(/[A-z]/) ) 
        {
            $('#' + id + '-letter-text').removeClass('text-danger').addClass('text-success');
            $('#' + id + '-letter-x').addClass('d-none');
            $('#' + id + '-letter-check').removeClass('d-none');
            $('#' + id).popover('show');
        } 
        else
        {
            $('#' + id + '-letter-text').removeClass('text-success').addClass('text-danger');
            $('#' + id + '-letter-check').addClass('d-none');
            $('#' + id + '-letter-x').removeClass('d-none');
            $('#' + id).popover('show');
        }

        // check if password contains a capital letter
        if ( password.match(/[A-Z]/) ) 
        {
            $('#' + id + '-capital-text').removeClass('text-danger').addClass('text-success');
            $('#' + id + '-capital-x').addClass('d-none');
            $('#' + id + '-capital-check').removeClass('d-none');
            $('#' + id).popover('show');
        } 
        else
        {
            $('#' + id + '-capital-text').removeClass('text-success').addClass('text-danger');
            $('#' + id + '-capital-check').addClass('d-none');
            $('#' + id + '-capital-x').removeClass('d-none');
            $('#' + id).popover('show');
        }

        // check if password contains a number
        if ( password.match(/\d/) ) 
        {
            $('#' + id + '-number-text').removeClass('text-danger').addClass('text-success');
            $('#' + id + '-number-x').addClass('d-none');
            $('#' + id + '-number-check').removeClass('d-none');
            $('#' + id).popover('show');
        } 
        else
        {
            $('#' + id + '-number-text').removeClass('text-success').addClass('text-danger');
            $('#' + id + '-number-check').addClass('d-none');
            $('#' + id + '-number-x').removeClass('d-none');
            $('#' + id).popover('show');
        }
    }

    $(document).ready(function () {

        //run checks
        validate_password();
        check_inputs();
        verify_type();

        $('input[type="text"]').change(check_inputs);
        $('#type').change(verify_type);
        // on password focus / select / de focus / deselect, show popover if password strength is not good enough else hide it if it is good enough.

        $('input[type="password"]').keyup(function() {

            validate_password();

            var id = $(this).attr('id');

            if(id == 'password')
            {
                var password = $('#password').val();
                update_popovers(id, password);
            }
            else if(id == 'password_verify')
            {
                var password_verify = $('#password_verify').val();
                update_popovers(id, password_verify);
            }
            
        })
        .focus(function() {
            var side = "top";
            var id = $(this).attr('id');
            
            if ( $(window).width() < 960 ) 
            {
                side = 'top';
            }
            else 
            {
                if(id == 'password')
                {
                    side = 'left';
                }
                else if(id == 'password_verify')
                {
                    side='right';
                }
            }
           
            // Create the popover
            $(this).popover({
                title: "Password Requirements:",
                content: function() {
                    return $('#popover-content-' + id).html();
                },
                html: true,
                placement: side,
                animation: true
            });
        })
        .blur(function () {
            $(this).popover('hide');
        });

    });
</script>

<div id="popover-content-password" class="d-none">
    <p id="password-letter-text" class="py-0 my-0 text-danger">
        <i class="fa fa-check d-none" id="password-letter-check" aria-hidden="true"></i><i class="fa fa-times" id="password-letter-x" aria-hidden="true"></i>
        At least one letter.
    </p>
    <p id="password-capital-text" class="py-0 my-0 text-danger">
        <i class="fa fa-check d-none" id="password-capital-check" aria-hidden="true"></i><i class="fa fa-times" id="password-capital-x" aria-hidden="true"></i>
        At least one capital letter.
    </p>
    <p id="password-number-text" class="py-0 my-0 text-danger">
        <i class="fa fa-check d-none" id="password-number-check" aria-hidden="true"></i><i class="fa fa-times" id="password-number-x" aria-hidden="true"></i>
        At least one number.
    </p>
    <p id="password-chars-text" class="py-0 my-0 text-danger">
        <i class="fa fa-check d-none" id="password-chars-check" aria-hidden="true"></i><i class="fa fa-times" id="password-chars-x" aria-hidden="true"></i>
        Be at least 6 characters.
    </p>
</div>

<div id="popover-content-password_verify" class="d-none">
    <p id="password_verify-letter-text" class="py-0 my-0 text-danger">
        <i class="fa fa-check d-none" id="password_verify-letter-check" aria-hidden="true"></i><i class="fa fa-times" id="password_verify-letter-x" aria-hidden="true"></i>
        At least one letter.
    </p>
    <p id="password_verify-capital-text" class="py-0 my-0 text-danger">
        <i class="fa fa-check d-none" id="password_verify-capital-check" aria-hidden="true"></i><i class="fa fa-times" id="password_verify-capital-x" aria-hidden="true"></i>
        At least one capital letter.
    </p>
    <p id="password_verify-number-text" class="py-0 my-0 text-danger">
        <i class="fa fa-check d-none" id="password_verify-number-check" aria-hidden="true"></i><i class="fa fa-times" id="password_verify-number-x" aria-hidden="true"></i>
        At least one number.
    </p>
    <p id="password_verify-chars-text" class="py-0 my-0 text-danger">
        <i class="fa fa-check d-none" id="password_verify-chars-check" aria-hidden="true"></i><i class="fa fa-times" id="password_verify-chars-x" aria-hidden="true"></i>
        Be at least 6 characters.
    </p>
</div>