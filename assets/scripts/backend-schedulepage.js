var d = new Date();
var _date = d.getDate(),_month=d.getMonth()+1,_year = d.getYear() < 1900 ? d.getYear() + 1900 : d.getYear();
var _assetid;
var _type;
var months = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
var days = ["Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu"];

$(document).ready(
	function()
	{
                loadgridschedule("");
                $("#_fname").keyup(function()
                    {
                        loadgridschedule($(this).val());
                    }
                );
		$("#btn-submit-schedule").click(function(){submitform();});
                $("#btn-delete-schedule").click(function(){submitdeleteform();});
                $("#btn-reset-schedule").click(function(){resetform();});
                if($(".readonly").length > 0)
                {
                    $(".readonly").each(
                        function()
                        {
                            $(this).attr("readonly", "readonly");
                        }
                    );
                }
                createdatepickerschedule();
                createcomboasset();
                $("#_type").bind("change click", function(){
                        _type = $(this).val();
                    }
                );
                _type = $("#_type").find("option:selected").val();
	}
);

function submitform()
{
        if($("#_scheddate").val().length > 0)
        {
            $("#_scheddate").val("");
        }
        $("#_scheddate").val(_year+"-"+_month+"-"+_date);
        
	if(validateform() == 1)
	{
		$("#schedule-form").submit();
	}
	else
	{
		return false;
	}
}

function validateform()
{
	var valid = 1;
        if($("#_assetid").val() === undefined || _assetid === undefined)
        {
            alert("Mesin belum dipilih.");
            $("#_assetid").focus();
            valid -= 1;
        }
        
        if($("#_scheddate").val() == "" || _date === undefined || _month === undefined || _year === undefined)
        {
            alert("Waktu belum dipilih.");
            $("#_date").focus();
            valid -= 1;
        }
        
        if(_type === undefined)
        {
            alert("Tipe pemeliharaan belum dipilih.");
            $("#_type").focus();
            valid -= 1;
        }
	
	return valid;
}

function loadgridschedule(val)
{
    $.ajax(
        {
            url: base_url + 'backend.php/schedule/getgridrecords',
            data: val.length > 0 ? 'name=' + val + '&notes=' + val : '',
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
            url: base_url + 'backend.php/schedule/getrecord',
            data: '_scheduleid=' + id,
            type: 'get',
            dataType: 'json',
            success: function(record)
            {
                var d = new Date();
                $("#_schedid").val(record._scheduleid);
                $("#_assetid").val(record._asset);
                _assetid = record._assetid;
                $("#_notes").val(record._notes);
                $("#_type").find("option").each(function()
                    {
                        if($(this).val() == parseInt(record._type))
                        {
                            $(this).attr("selected","selected");
                        }
                    }
                );
                _type = record._type;
                $("#_scheddate").val(record._schedule_date);
                var _scheddate = record._schedule_date.split("-");
                _date = _scheddate[2];
                _month = _scheddate[1];
                _year = _scheddate[0];
                $("#_date").find("option").each(function()
                    {
                        if($(this).val() == parseInt(_date))
                        {
                            $(this).attr("selected","selected");
                        }
                    }
                );
                $("#_month").find("option").each(function()
                    {
                        if($(this).val() == parseInt(_month))
                        {
                            $(this).attr("selected","selected");
                        }
                    }
                );
                $("#_year").find("option").each(function()
                    {
                        if($(this).val() == parseInt(_year))
                        {
                            $(this).attr("selected","selected");
                        }
                    }
                );
                var _url = record._file_url === null ? "" : record._file_url.toString();
                $("#_txtattachment").text(_url);
            }
        }
    );
}

function submitdeleteform()
{
	if(validatedeleteform() == 1)
	{
		var id = $("#_schedid").val();
                var url = $("#_txtattachment").text();
                
                $.ajax(
                    {
                        url: base_url + 'backend.php/schedule/deletedata',
                        data: '_scheduleid=' + id + "&_attachment=" + url,
                        type: 'post',
                        dataType: 'html',
                        success: function(html)
                        {
                            $("#schedule-form").fadeOut(300, function(){$("#schedule-form").remove();});
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
        if($("#_schedid").val().length == 0)
	{
		alert("Data baru tidak bisa dihapus.");
		$("#_schedid").focus();
		valid -= 1;
	}
        if($("#_assetid").val() === undefined || _assetid === undefined)
        {
            alert("Mesin belum dipilih.");
            $("#_assetid").focus();
            valid -= 1;
        }
        
        if($("#_scheddate").val() == "" || _date === undefined || _month === undefined || _year === undefined)
        {
            alert("Waktu belum dipilih.");
            $("#_date").focus();
            valid -= 1;
        }
        
        if(_type === undefined)
        {
            alert("Tipe pemeliharaan belum dipilih.");
            $("#_type").focus();
            valid -= 1;
        }
	
	return valid;
}

function resetform()
{
    $("#schedule-form").find("input[type='text']").each(function()
        {
            $(this).val("");
        }
    );
    $("#schedule-form").find("input[type='file']").each(function()
        {
            $(this).val("");
        }
    );
    $("#schedule-form").find("select").each(function()
        {
            
        }
    );
    var d = new Date();
    $("#schedule-form").find("img#_imgphoto").attr("src", "?" + d);
    $("#_txtattachment").text('');
}

function createdatepickerschedule()
{
    var d = new Date();
    var year = d.getYear() < 1900 ? d.getYear() + 1900 : d.getYear();
    
    var lblDate = document.createElement("label");
    lblDate.innerHTML = "Tanggal: ";
    lblDate.setAttribute("for","_date");
    var selDate = document.createElement("select");
    selDate.setAttribute("name","_date");
    selDate.setAttribute("id","_date");
    $(selDate).bind("change click", function(){
            _date = $(this).val();
        }
    );
    for(var i = 0;i < 31;i++)
    {
        selDate.options[i] = new Option(i + 1, i + 1);
        if((i + 1) == d.getDate())
        {
            _date = i + 1;
            selDate.options[i].setAttribute("selected","selected");
        }
    }
    
    var lblMonth = document.createElement("label");
    lblMonth.innerHTML = "Bulan: ";
    lblMonth.setAttribute("for","_month");
    var selMonth = document.createElement("select");
    selMonth.setAttribute("name","_month");
    selMonth.setAttribute("id","_month");
    $(selMonth).bind("change click", function(){
            _month = $(this).val();
        }
    );
    
    for(var j = 0;j < 12;j++)
    {
        selMonth.options[j] = new Option(months[j], j + 1);
        if(j == d.getMonth())
        {
            _month = j;
            selMonth.options[j].setAttribute("selected","selected");
        }
    }
    
    var lblYear = document.createElement("label");
    lblYear.innerHTML = "Tahun: ";
    lblYear.setAttribute("for","_year");
    var selYear = document.createElement("select");
    selYear.setAttribute("name","_year");
    selYear.setAttribute("id","_year");
    $(selYear).bind("change click", function(){
            _year = $(this).val();
        }
    );
    
    for(var k = year;k < year + 10;k++)
    {
        selYear.options[k] = new Option(k, k.toString());
        if(k == year)
        {
            _year = k;
            selYear.options[k].setAttribute("selected","selected");
        }
    }
    
    var datepicker = document.createElement("div");
    datepicker.appendChild(lblDate);
    datepicker.appendChild(selDate);
    datepicker.appendChild(lblMonth);
    datepicker.appendChild(selMonth);
    datepicker.appendChild(lblYear);
    datepicker.appendChild(selYear);
    $(".date-picker").append(datepicker);
}

function createcomboasset()
{
    var lblAsset = document.createElement("label");
    lblAsset.innerHTML = "Mesin: ";
    lblAsset.setAttribute("for","_assetid");
    var selAsset = document.createElement("select");
    selAsset.setAttribute("name","_assetid");
    selAsset.setAttribute("id","_assetid");
    $(selAsset).bind("change click", function(){
            _assetid = $(this).val();
        }
    );
    $.ajax(
        {
            url: base_url + 'backend.php/assets/getassetcombo',
            type: 'get',
            dataType: 'json',
            success: function(records)
            {
                for(var i = 0;i< records.length;i++)
                {
                    selAsset.options[i] = new Option(records[i]._code + "-" + records[i]._name,records[i]._assetid);
                }
                _assetid = selAsset.options[0];
            }
        }
    );
    var combo = document.createElement("div");
    combo.appendChild(lblAsset);
    combo.appendChild(selAsset);
    $(".asset-combo").append(combo);
}