
$(document).ready(function(){
    $('.delete_confirm').click(function(e){
        var r = confirm("Are you sure want to continue?");
        if (r == true) {
            return true;
        } else {
           e.preventDefault();
        }
    })
});
