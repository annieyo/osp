$(function() {
    $('#student_group_exists_0').click(function(){
        $('#notexisting').hide();
        $('#existing').show();
    });

    $('#student_group_exists_1').click(function(){
        $('#existing').hide();
        $('#notexisting').show();
    });
});