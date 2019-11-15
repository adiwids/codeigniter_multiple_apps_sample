var emptyTextUser, emptyTextPass;
$(document).ready(
	function()
	{
            inittopformlogin();
	}
);
    
function inittopformlogin()
{
    emptyTextUser = "Username...";
    emptyTextPass = "Password...";
    $("#top-username").val(emptyTextUser);
    $("#top-password").val(emptyTextPass);
    $("#top-username").bind("focus",function()
        {
            if($(this).val() == emptyTextUser)
            {
                $(this).val("");
            }
        }
    );
    $("#top-username").bind("blur",function()
        {
            if($(this).val().length == 0)
            {
                $(this).val(emptyTextUser);
            }
        }
    );
    $("#top-password").bind("focus",function()
        {
            if($(this).val() == emptyTextPass)
            {
                $(this).val("");
            }
        }
    );
    $("#top-password").bind("blur",function()
        {
            if($(this).val().length == 0)
            {
                $(this).val(emptyTextPass);
            }
        }
    );
    $("#top-btn-login").click(function(){ login("top"); });
    
    $("#bottom-username").val(emptyTextUser);
    $("#bottom-password").val(emptyTextPass);
    $("#bottom-username").bind("focus",function()
        {
            if($(this).val() == emptyTextUser)
            {
                $(this).val("");
            }
        }
    );
    $("#bottom-username").bind("blur",function()
        {
            if($(this).val().length == 0)
            {
                $(this).val(emptyTextUser);
            }
        }
    );
    $("#bottom-password").bind("focus",function()
        {
            if($(this).val() == emptyTextPass)
            {
                $(this).val("");
            }
        }
    );
    $("#bottom-password").bind("blur",function()
        {
            if($(this).val().length == 0)
            {
                $(this).val(emptyTextPass);
            }
        }
    );
    $("#bottom-btn-login").click(function(){ login("bottom"); });
}

function login(form)
{
    var valid = 1;
    if(form == "top")
    {
        if(($("#top-username").val().length == 0) || ($("#top-username").val() == emptyTextUser))
        {
            alert("Username belum diisi.");
            valid -= 1;
            return false;
        }
        
        if(($("#top-password").val().length == 0) || ($("#top-password").val() == emptyTextPass))
        {
            alert("Password belum diisi.");
            valid -= 1;
            return false;
        }
        
        if(valid == 1)
        {
            $("#top-form-login").submit();
            return true;
        }
    }
    else
    {
        if(($("#bottom-username").val().length == 0) || ($("#bottom-username").val() == emptyTextUser))
        {
            alert("Username belum diisi.");
            valid -= 1;
            return false;
        }
        
        if(($("#bottom-password").val().length == 0) || ($("#bottom-password").val() == emptyTextPass))
        {
            alert("Password belum diisi.");
            valid -= 1;
            return false;
        }
        
        if(valid == 1)
        {
            $("#bottom-form-login").submit();
            return true;
        }
    }
}