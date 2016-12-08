/**
 * Created by user on 10.11.2016.
 * @require jQuery
 */
//Дефолтная цена цели
function bind(func, context) {
    return function() {
        return func.apply(context, arguments);
    }
}
var moduleId = 'tracker';
/*if (!callTrackerJS.id_enter) {
    alert('No enter id!');
} else {
    alert(callTrackerJS.id_enter);
}*/

function NoMatterWhatSend(url, delay, callback, dataCallback){
    var nextRequest = null;
    var checkerTimeout = null;


    function forcedStartRequests () {
        startRequests(true);
    }
    this.startRequests = startRequests;
    /*this.stopRequests = function() {
        if (nextRequest) {
            clearTimeout(nextRequest);
        }
        nextRequest = null;
        clearTimeout(checkerTimeout);
    };*/
    function startRequests (forced) {
        //alert('requests started '+forced);
        if ((!nextRequest)||(forced)) {
            clearTimeout(checkerTimeout);
            checkerTimeout = setTimeout(startRequests, delay * 20);
            clearTimeout(nextRequest);
            nextRequest = setTimeout(function(){
                var data = {};
                if (typeof dataCallback == 'function') {
                    data = dataCallback();
                }
                if (typeof callback != 'function') {
                    callback = function(){};
                }
                $.post(url, data, null, "JSON").done(bind(function(){
                    callback.apply(this, arguments);
                }), this).always(function(){
                    nextRequest = null;
                    forcedStartRequests();
                });
            }, delay);
        }
    }
    startRequests = bind(startRequests, this);
    return this;
}
$(document).ready(function(){
    function reachCallGoal (price) {
        //price = callTrackerJS.price;
        if (!price) {
            price = 250;
        }
        if (callTrackerJS.traceGoal) {
            if (yaCounter40204894) {
                yaCounter40204894.reachGoal('phoneCall', {
                    order_price: price,
                    currency: "RUB"
                });
            } else {
                $.post(baseUrl + '/home/couldNotReachGoal',{type:'call'});
            }
            callTrackerJS.traceGoal = false;
        }
    }
    (function($, window){
        var delay;
        console.log(window.callTrackerJS);
        //alert(window.callTrackerJS.delay);
        if (window.callTrackerJS.delay > 10) {
            delay = window.callTrackerJS.delay;
        } else {
            delay = 1000;
        }
        //alert('TrackerScriptLoaded ,'+delay);
        var returned = 1;
        var stagnation = 0;
        setInterval(function() {
            if ((returned)||(stagnation > 5)) {
                returned = 0;
                $.post(baseUrl + '/' + moduleId + '/CT/CallStatus', {id_enter: callTrackerJS.id_enter}, null, "JSON").done(function (data) {
                    var price = callTrackerJS.price;
                    if (!price) {
                        price = 250;
                    }
                    if (data.called == 1) {
                        reachCallGoal(price);
                    }
                    stagnation = 0;
                    returned = 1;
                });
            } else {
                stagnation ++;
            }
        }, delay);
        /*var obj = new NoMatterWhatSend(
            baseUrl + '/'+moduleId+'/CT/CallStatus',
            delay,
            function(data) {
                if (data.called == 1) {
                    reachCallGoal();
                }
            },
            function() {
                return {id_enter: window.id};
            }
        );
        obj.startRequests();*/
    })(jQuery, window);
});