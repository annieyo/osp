$(function() {
    var groupExists0 = $('#student_group_exists_0');
    var groupExists1 = $('#student_group_exists_1');
    var notExisting = $('#notexisting');
    var existing = $('#existing');

    if(groupExists0.is(':checked')) {
        changeDisplay(notExisting, existing);
    }

    if(groupExists1.is(':checked')) {
        changeDisplay(existing, notExisting);
    }

    groupExists0.click(function(){
        changeDisplay(notExisting, existing);
    });

    groupExists1.click(function(){
        changeDisplay(existing, notExisting);
    });

    function changeDisplay(hide, show, speed) {
        speed = speed || 250;
        hide.hide(speed);
        show.show(speed);
    }

    $('select').material_select();
});