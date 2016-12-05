/**
 * Created by user on 17.11.2016.
 */
var clinicInfoContainer = $("#topClinicContainer");
var clinicBottomContainer = $("#bottomClinicContainer");
function loadClinicInfo(id) {
    var loader = $("<img>",{
        src:baseUrl + '/img/loading.gif',
        class:'loadingGif'
    });
    if (clinicInfoContainer.length) {
        //asd
        clinicInfoContainer.html(loader);
        $.post(baseUrl + '/home/getClinicTopInfo/' + id).done(function (data) {
            clinicInfoContainer.html(data);
            //активируем "показать телефон"
            showInfoAjaxButton(".ajaxShow");
        });
    }
    if (clinicBottomContainer.length) {
        clinicBottomContainer.html(loader);
        $.post(baseUrl + '/home/getClinicBottomInfo/' + id).done(function (data) {
            clinicBottomContainer.html(data);
            sendVkLoginRequest();
        });
    }
}