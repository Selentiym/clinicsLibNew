$(document).ready (function() {
    var url = window.location.toString();
    
    /*if (url.match('search'))
        $("#searchForm").show();
    else {
        $("#filter").empty();
        $("#searchForm").hide();
    }*/
    
    if (url.match('#all')) {
         panelId = url.substring(url.lastIndexOf("/")+1,url.lastIndexOf("#"));    
         $('.panel-collapse#' + panelId).collapse('show');
    }

    $('#articles').find('.panel-title a').click(function() {
        $('#articles').find('#' + $(this).data('href')).collapse('toggle');
    });
 
})

function myFileBrowser(field_name, url, type, win) {

 alert("Field_Name: " + field_name + "nURL: " + url + "nType: " + type + "nWin: " + win); // debug/testing

    /* If you work with sessions in PHP and your client doesn't accept cookies you might need to carry
       the session name and session ID in the request string (can look like this: "?PHPSESSID=88p0n70s9dsknra96qhuk6etm5").
       These lines of code extract the necessary parameters and add them back to the filebrowser URL again. */

    var cmsURL = $("#fileUpload").val();  // script URL - use an absolute path!
    if (cmsURL.indexOf("?") < 0) {
        //add the type as the only query parameter
        cmsURL = cmsURL + "?type=" + type;
    }
    else {
        //add the type as an additional query parameter
        // (PHP session ID is now included if there is one at all)
        cmsURL = cmsURL + "&type=" + type;
    }

    tinyMCE.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'Files',
        width : 420,  // Your dimensions may differ - toy around with them!
        height : 100,
        resizable : "yes",
        inline : "yes",  // This parameter only has an effect if you use the inlinepopups plugin!
        close_previous : "no"
    }, {
        window : win,
        input : field_name
    });
    return false;

}   /*
    $("#submitUpload").on("click", function(){
      item_url = $("#fileUploaded").data("src"); alert(item_url0);
      var args = top.tinymce.activeEditor.windowManager.getParams();
      win = (args.window);
      input = (args.input);
      win.document.getElementById(input).value = item_url;
      top.tinymce.activeEditor.windowManager.close();
    });
   */
$(function() {
      
    $("#menuLevel").change(function() {
        if($('option:selected', this).val() == 1)
            $("#articleCategory").css('display', 'block');
        else
            $("#articleCategory").css('display', 'none');
    });
});

function showCommentForm(target) {
    var s;
    s = $(target).prop('id').split('_');
    $('#comment-form-' + s[2]).toggle();
}

function showImportClinicsForm() {
    $('#import-clinics').toggle();
}
function showImportDoctorsForm() {
    $('#import-doctors').toggle();
}

function showExportClinicsForm() {
   // $('#export-clinics').toggle();
}

function showServiceFilterBlock(target) {
    var filterService = $('#filterDay label.active input').val();
    alert(filterService);
    // current inactive service
    var inactive = $(target).find('a.inactive');
    inactive.removeClass('inactive');

    //current inactive service
    var active = $(target).find('a.active');
    active.addClass('inactive');

    if ($('a#service_mrt').hasClass('inactive')) {
        $('#kt_filter').css('display','block');
        $('#mrt_filter').css('display','none');
        $('#service').val('2');
        $('#field').val('');
        $('#type_magnet').val('');
    } else {
        $('#kt_filter').css('display','none');
        $('#mrt_filter').css('display','block');
        $('#service').val('1');
        $('#slice').val('');
    }
}

function showJobForm() {
    $('#job-form').toggle();
    $('#add_position').toggle();
}

function follow(id,type,style,text)
{
style = (typeof style === "undefined") ? "button" : style; //button or link
text = (typeof text === "undefined") ? "short" : text; //short or long

var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
            // handle return data
            data = xmlhttp.responseText;
	    ftext=" ";
	    if (text == "long") {	
	    	if (type=="T") ftext=" Topic";
		if (type=="Q") ftext=" Question";
		if (type=="P") ftext=" User"; 
	    } 
	    document.getElementById("follow"+type+id).innerHTML = data + ftext; 
	    if (style == "button"){
		    if (data == "Follow") {
			document.getElementById("follow"+type+id).setAttribute("class", "btn btn-success");
		    } else {
			document.getElementById("follow"+type+id).setAttribute("class", "btn btn-danger");
		    }
	    }
    }
  }
xmlhttp.open("GET","/mednet/index.php/following/toggle/id/"+id+"/type/"+type,true);
xmlhttp.send();
}

function invite(id,style)
{
style = (typeof style === "undefined") ? "button" : style; //button or link
text = (typeof text === "undefined") ? "short" : text; //short or long

var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
            // handle return data
            data = xmlhttp.responseText;
            document.getElementById("invite"+id).innerHTML = data;
            if (style == "button"){
                    if (data == "Sent") {
                        document.getElementById("invite"+id).setAttribute("class", "btn btn-success");
                        document.getElementById("invite"+id).setAttribute("disabled", "disabled");
                    } else {
                        document.getElementById("invite"+id).setAttribute("class", "btn btn-danger");
                    }
            }
	    mixpanel.track('Sent Invite', {'type': 'Direct'});
    }
  }
xmlhttp.open("GET","/mednet/index.php/invitation/InviteUser/id/"+id,true);
xmlhttp.send();
}

function share(id,type,user,modal)
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
            // handle return data
            data = xmlhttp.responseText;
            document.getElementById("share"+"_"+type+"_"+modal+"_"+id+"_"+user).innerHTML = data;
                    if (data == "Sent") {
                        document.getElementById("share"+"_"+type+"_"+modal+"_"+id+"_"+user).setAttribute("class", "question-disable");
                        document.getElementById("share"+"_"+type+"_"+modal+"_"+id+"_"+user).style.color = "#a19d9d";
                    } else {
                        document.getElementById("share"+"_"+type+"_"+modal+"_"+id+"_"+user).setAttribute("class", "question-disable");
			document.getElementById("share"+"_"+type+"_"+modal+"_"+id+"_"+user).style.color = "#a19d9d";
                    }
    }
  }
xmlhttp.open("GET","/mednet/index.php/question/share/id/"+id+"/user/"+user+"/type/"+type,true);
xmlhttp.send();

}


