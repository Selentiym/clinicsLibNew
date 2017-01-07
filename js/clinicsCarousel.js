/**
 * Created by user on 03.01.2017.
 */
function startClinicsCarousel (w, selectedClinic) {
    var element = $('#clinicsCarousel');
    w.onClinicSelected = function (id) {
        element.smoothDivScroll('jumpToElement', 'id', 'clinicsScroll' + id);
        element.smoothDivScroll('stopAutoScrolling');
        //Переходим к большой карте
        $('body,html').animate({scrollTop: $('#clinicChangeableContainer').offset().top - 200}, 1500);
    };
    var params = {
        autoScrollingStep: 1.5,
        autoScrollingInterval: 15,
        getContentOnLoad: {
            method: 'getAjaxContent',
            content: w.baseUrl + '/home/ClinicsCarouselData',
            manipulationMethod: 'replace'
        }
    };
    if (selectedClinic) {
        //Иначе цель не отправляется
        setTimeout(function(){
            try {
                if (window.yaCounter) {
                    window.yaCounter.reachGoal('brandRequest',{
                        clinicId: selectedClinic
                    });
                }
            } catch(err) {}
        },3000);
        params.startAtElementId = 'clinicsScroll' + selectedClinic;
        params.addedAjaxContent = function() {
            w.onClinicSelected(selectedClinic);
        };
    } else {
        params.autoScrollingMode = 'onStart';
    }
    var clinicsCarousel = element.smoothDivScroll(params);

    clinicsCarousel.bind('mouseover', function () {
        $(this).smoothDivScroll('stopAutoScrolling');
    }).bind('mouseout', function () {
        $(this).smoothDivScroll('startAutoScrolling');
    });
    w.clinicsCarousel = clinicsCarousel;
}