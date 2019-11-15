$(document).ready(
    function()
    {
        $("#btn-submit-login").click(function(){ submitform(); });
        if($("#err-msg-box"))
        {
            setTimeout(function()
                {
                    $("#err-msg-box").fadeOut(300);
                },5000
            );
        }
    }
);
    
function submitform()
{
    if(validateform() == 1)
    {
        $("#login-form").submit();
    }
    else
    {
        return false;
    }
}

function validateform()
{
    var valid = 1;
    if($("#_username").val().length == 0)
    {
        alert("Nama pengguna tidak boleh kosong.");
        $("#_username").focus();
        valid -= 1;
        exit;
    }
    
    if($("#_password").val().length == 0)
    {
        alert("Password tidak boleh kosong.");
        $("#_password").focus();
        valid -= 1;
        exit;
    }
    
    if($("#_captchacode").val().length == 0)
    {
        alert("Captcha tidak boleh kosong.");
        $("#_captchacode").focus();
        valid -= 1;
        exit;
    }
    
    return valid;
}