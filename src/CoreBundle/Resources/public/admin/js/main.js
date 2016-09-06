$(function() {

    var speed = 250;

    $('#student_group_exists_0').click(function(){
        $('#notexisting').hide(speed);
        $('#existing').show(speed);
    });

    $('#student_group_exists_1').click(function(){
        $('#existing').hide(speed);
        $('#notexisting').show(speed);
    });

    $('select').material_select();
});