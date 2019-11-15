$(document).ready(
	function()
	{
                loadgridasset("");
                $("#_fname").keyup(function()
                    {
                        loadgridasset($(this).val());
                    }
                );
		$("#btn-submit-asset").click(function(){submitform();});
                $("#btn-delete-asset").click(function(){submitdeleteform();});
                $("#btn-reset-asset").click(function(){resetform();});
                if($(".readonly").length > 0)
                {
                    $(".readonly").each(
                        function()
                        {
                            $(this).attr("readonly", "readonly");
                        }
                    );
                }
	}
);

function submitform()
{
	if(validateform() == 1)
	{
		$("#asset-form").submit();
	}
	else
	{
		return false;
	}
}

function validateform()
{
	var valid = 1;
        if($("#_code").val().length == 0)
	{
		alert("Kode mesin tidak boleh kosong.");
		$("#_code").focus();
		valid -= 1;
	}
	if($("#_name").val().length == 0)
	{
		alert("Nama mesin tidak boleh kosong.");
		$("#_name").focus();
		valid -= 1;
	}
	
	return valid;
}

function loadgridasset(val)
{
    $.ajax(
        {
            url: base_url + 'backend.php/assets/getgridrecords',
            data: val.length > 0 ? 'name=' + val : '',
            type: 'get',
            dataType: 'html',
            timeout: 10000,
            success: function(html)
            {
                var nrow = $(".grids:visible > table tr.row-data").length;
                if(nrow > 0)
                {
                    $("tr.row-data").remove();
                }
                $(html).appendTo(".grids:visible > table");
            }
        }
    );
}

function loaddatafromgrid(id)
{
    $.ajax(
        {
            url: base_url + 'backend.php/assets/getrecord',
            data: '_assetid=' + id,
            type: 'get',
            dataType: 'json',
            success: function(record)
            {
                var d = new Date();
                $("#_assetid").val(record._assetid);
                $("#_code").val(record._code);
                $("#_name").val(record._name);
                $("#_imgphoto").attr("src", record._imgphoto + "?" + d.getTime());
            }
        }
    );
}

function submitdeleteform()
{
	if(validatedeleteform() == 1)
	{
		var id = $("#_assetid").val();
                var code = $("#_code").val();
                var name = $("#_name").val();
                var url = $("#_imgphoto").attr("src");
                
                $.ajax(
                    {
                        url: base_url + 'backend.php/assets/deletedata',
                        data: '_assetid=' + id + '&_code=' + code + '&_name=' + name + '&_imgphoto=' + url,
                        type: 'post',
                        dataType: 'html',
                        success: function(html)
                        {
                            $("#asset-form").fadeOut(300, function(){$("#asset-form").remove();});
                            $(".center-content").html(html);
                        }
                    }
                );
	}
	else
	{
		return false;
	}
}

function validatedeleteform()
{
	var valid = 1;
        if($("#_assetid").val().length == 0)
	{
		alert("Data baru tidak bisa dihapus.");
		$("#_assetid").focus();
		valid -= 1;
	}
        if($("#_code").val().length == 0)
	{
		alert("Kode mesin tidak boleh kosong.");
		$("#_code").focus();
		valid -= 1;
	}
	if($("#_name").val().length == 0)
	{
		alert("Nama mesin tidak boleh kosong.");
		$("#_name").focus();
		valid -= 1;
	}
	
	return valid;
}

function resetform()
{
    $("#asset-form").find("input[type='text']").each(function()
        {
            $(this).val("");
        }
    );
    $("#asset-form").find("input[type='file']").each(function()
        {
            $(this).val("");
        }
    );
    var d = new Date();
    $("#asset-form").find("img#_imgphoto").attr("src", "?" + d);
}
