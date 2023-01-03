
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
    
    $('body').on('click', '.errors-mask-holder-close', function(e){
        e.preventDefault();
        $(this).parent().parent().fadeOut()
    })

    //block scope
    {
        let toggleMenu = false;
        let leftMenu = new TimelineMax({ paused: true });
            leftMenu.addLabel('concurrent')
            leftMenu.fromTo('.flex-dashboard-left', 0.4, {width:'12%'}, {width:'0'}, 'concurrent')
            leftMenu.fromTo('.flex-dashboard-right', 0.4, {width:'88%'}, {width:'99%'}, 'concurrent') //left side has a border of 1px

            $('body').on('click', '.cms-menu-hold-trigger', function(e){
                e.preventDefault();
                toggleMenu = !toggleMenu
                if(toggleMenu){
                    leftMenu.play();
                }else{
                    leftMenu.reverse();
                }
            })
    }
    
    
    
})
