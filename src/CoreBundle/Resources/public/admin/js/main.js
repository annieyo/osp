$(function() {
    var changeButton = $('#student_edit_group_exists_0');
    var createButton = $('#student_edit_group_exists_1');
    var editButton = $('#student_edit_group_exists_2');


    changeButton.click(function(){
        $('.group-form').hide();
        $('#change-group').show();
    });

    createButton.click(function(){
        $('.group-form').hide();
        $('#create-group').show();
    });

    editButton.click(function(){
        $('.group-form').hide();
        $('#edit-group').show();
    });


    $('select').material_select();
});