
$(document).ready(function(){
    $('.delete_confirm').click(function(e){
        var r = confirm("Are you sure want to continue?");
        if (r == true) {
            return true;
        } else {
           e.preventDefault();
        }
    });

    // Init select2
    $('.select2').select2();

    // Init tooltip
    var config  = {
      showDelay: 100,
      style: {
        padding: 5
      },
      offset: { x: 2, y: 2 }
    }
    tooltip(config);

    // Disable Select box
    jQuery('select.readonly option:not(:selected)').attr('disabled',true);

    // Populate company field in user creation edition
    if($('select[name="role"]').val() == 'user'){
        $('#user_companies').fadeIn();
    }else{
        $('#user_companies').fadeOut();
        $('#user_companies select').select2('val', 0);
    }

    $('select[name="role"]').change(function(){
        if($(this).val() == 'user'){
            $('#user_companies').fadeIn();
        }else{
            $('#user_companies').fadeOut();
            $('#user_companies select').select2('val', 0);
        }
    });

});
