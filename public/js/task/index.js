$(function(){
    //状态选项
    $states = $('select[name="state"]');
    $states.change(function(){
        params = {
            action : 'state_change',
            id : $(this).attr('task_id'),
            state : $(this).val()
        };
        $select = $(this);
        $.post('/task/action',params,function(data){

            //修改背景色
            change_bgcolor($select.parent('td'),data.success);

            if(data.success){

            }else{
                alert(data.message);
            }
        },'JSON')
    });
});