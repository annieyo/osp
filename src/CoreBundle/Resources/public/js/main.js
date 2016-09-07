$(function() {

    if($('#student_group_exists_0').is(':checked')){
        $('#notexisting').hide();
        $('#existing').show();
    }

    if($('#student_group_exists_1').is(':checked')){
        $('#existing').hide();
        $('#notexisting').show();
    }

    $('#student_group_exists_0').click(function(){
        $('#notexisting').hide();
        $('#existing').show();
    });

    $('#student_group_exists_1').click(function(){
        $('#existing').hide();
        $('#notexisting').show();
    });
});