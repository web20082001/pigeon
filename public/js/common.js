$(function () {

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
            $(this).next('button').click();
        }
    });

});
