$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //头部下拉菜单
    $('.ui.menu .ui.dropdown').dropdown({
        on: 'hover'
    });

    $('.ui.menu a.item')
        .on('click', function() {
            $(this)
                .addClass('active')
                .siblings()
                .removeClass('active');
        });

    $('a.delete').click(function(){
        if(!confirm('确认删除')){
            return false;
        }else{
            $(this).prev('button').click();
        }
    });

    //搜索关键词
    $keywords = $('input[name="keywords"]');

    if($keywords.length > 0){
        $keywords.focus();
    }

});

/**
 * 修改背景色
 * @param $el
 * @param success
 */
function change_bgcolor($el,success){

    if($el.length){
        $el.removeClass('bg-red')
            .removeClass('bg-green')
            .addClass(success ? 'bg-green':'bg-red');
    }
}
