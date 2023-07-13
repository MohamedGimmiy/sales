$(document).ready(function(){
    $(document).on('click','#update_image',function(e){
        e.preventDefault();
        if(!$('#photo').length){
            $('#update_image').hide()
            $('#cancel_update_image').show()
            $('#old_image').html('<br><input type="file" name="photo" id="photo">')
        }
        return false;
    });
    $(document).on('click','#cancel_update_image',function(e){
        e.preventDefault();
            $('#update_image').show()
            $('#cancel_update_image').hide()
            $('#old_image').html('')
            return false;
    });
});
