
function goUp(input){
    var label = $(input).parent().find('.login-label');
    $(label).animate({
        top: 0,
        fontSize: 14,
        opacity: 1
    });

}
function checkInput(){
    var tt = $('.login-input-holder');
    $.each(tt, function(_index, value){
        var cc = $(value).val();
        console.log(cc.length);
        (cc.length === 0) ? goUp(value) : goDown();
    })
}
$(document).ready(function(){

    setTimeout(function(){
      checkInput();
    }, 500)
    
})