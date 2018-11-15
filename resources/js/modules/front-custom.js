$(document).ready(function () {
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
        $('#content .inner-info').toggleClass('faded');
    });

    $('#post_duration_form .author_post_duration').change(function(){
        $('#post_duration_form').submit();
    })
});
