/**
 * Created by user on 17.12.2016.
 */
var pwContent = $("<div>", {
    id:'popup-content',
    class:'b-popup-content'
});
var pwInner = $("<div>", {
    id:'popup-inner',
    class:'b-container'
});
var pw=$("<div>",{
    id:'popup-window',
    class:'b-popup',
    css:{
        display:"none"
    }
}).html(pwInner.html(pwContent));

$(document).ready(function(){
    $('body').append(pw);
});
var dafaultTimeToAnimatePopup = 500;
var timeToAnimatePopup;
function popup(html, time) {
    if (time > 9) {
        timeToAnimatePopup = time;
    } else {
        timeToAnimatePopup = dafaultTimeToAnimatePopup;
    }
    if (html) {
        pwContent.html(html);
    }
    pw.fadeIn(timeToAnimatePopup);
}
pw.click(function(e) {
    hidePopup();
});
pwInner.click(function (e) {
    if ($(e.target).hasClass('fancybox-close')) {
        hidePopup();
    }
    e.stopPropagation();
    return false;
});
$(document).on('click','.fancybox-close', function(){
    hidePopup();
    alert('asd');
    return false;
});
function hidePopup() {
    pw.fadeOut(timeToAnimatePopup);
}