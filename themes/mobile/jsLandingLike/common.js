/**
 * Created by user on 05.12.2016.
 */
function getCorrespondingEl($tab){
    var sel=$tab.attr('data-mine_tab_selector');
    var collect = $(sel);
    if (collect.length) {
        return collect;
    }
    return false;
}
$('body').on('click','.mine_tab',function(){
    $(this).parent().find('.mine_tab').each(function(key,el){
        var toClose = getCorrespondingEl($(el));
        if (toClose) {
            toClose.hide();
        }
    });
    var toOpen = getCorrespondingEl($(this));
    if (toOpen) {
        toOpen.show();
    }
});
function sendVkLoginRequest() {

    $("body").on("click",'#send_post',function(){
        alert('asd');
        $('#ReviewTextHidden').val($('#post_field').html());
        $('#comment-form').submit();
    });
    VK.Auth.getLoginStatus(function(data){
        var button = $('#show_input');
        if (data.session) {
            button.parent().remove();
            VK.Api.call('users.get', {user_ids:data.session.mid, fields:'domain, photo_50'}, function(userData){
                console.log(userData);
                if (userData.response.length) {
                    var user = userData.response[0];
                    $('#vk_avatar_round_small').attr('src',user.photo_50);
                    var url = 'http://vk.com/';
                    if (user.domain) {
                        url += user.domain;
                    } else {
                        url += 'id' + user.uid;
                    }
                    $('#vk_avatar_link').attr('href',url);
                    $('.wcomments_form').show();
                    $('#VkIdHidden').val(user.uid);
                    $('#post_field').keyup(function(){
                        if ($(this).html().length > 0) {
                            $('.placeholder').hide();
                        } else {
                            $('.placeholder').show();
                        }
                    });
                } else {
                    alert('Ошибка авторизации');
                }
            });
        } else {
            button.click(function(){
                var params = {
                    client_id:5711487,
                    redirect_uri:window.location.host + window.location.pathname,
                    response_type:'token'
                };
                location.href = 'https://oauth.vk.com/authorize?'+$.param(params);
            });
        }
    });
}