$(document).ready(
	function()
	{
		$("#btn-submit-webinfo").click(function(){ submitform(); });
                $('textarea.wysiwyg-editor').tinymce(
                    {
			// Location of TinyMCE script
			script_url : base_url + 'assets/scripts/tiny_mce/tiny_mce.js',

			// General options
			theme : "advanced",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			// Example content CSS (should be your site CSS)
			content_css : base_url + "assets/ui/backend-layout.css",

			// Drop lists for link/image/media/template dialogs
			/*template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",*/

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
                    }
                );
	}
);

function submitform()
{
	if(validateform() == 1)
	{
		$("#websettings-form").submit();
	}
	else
	{
		return false;
	}
}

function validateform()
{
	var valid = 1;
	if($("#_title").val().length == 0)
	{
		alert("Judul Website tidak boleh kosong.");
		$("#_title").focus();
		valid -= 1;
	}
	
	if($("#_username").val().length == 0)
	{
		alert("Nama Pengguna tidak boleh kosong.");
		$("#_username").focus();
		valid -= 1;
	}
	
	if($("#_pass1").val().length != 0)
	{
		if(validatepassword() != 1)
		{
			alert("Password tidak sama.");
			$("#_pass2").focus();
			valid -= 1;
		}
	}
        else
        {
            alert("Password tidak boleh kosong.");
            $("#_pass1").focus();
            valid -= 1;
        }
	
	if($("#_email").val().length != 0)
	{
		if(validateemail() != 1)
		{
			alert("Format email salah.");
			$("#_email").focus();
			valid -= 1;
		}
	}
	
	return valid;
}

function validatepassword()
{
	var valid = 1;
	var p1 = $("#_pass1").val();
	var p2 = $("#_pass2").val();
	
	if(p2.length != p1.length)
	{
		valid -= 1;
	}
	else
	{
		if(p2 != p1)
		{
			valid -= 1;
		}
	}
	
	return valid;
}

function validateemail()
{
	var valid = 1;
	var EmailRegEx = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	if(!EmailRegEx.test($("#_email").val()))
	{
		valid -= 1;
	}
	
	return valid;
}
