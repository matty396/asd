$(document).ready(function(){
    //var form = '#add-user-form';

    //$(form).on('submit', function(event){
        //event.preventDefault();

        //var url = $(this).attr('data-action');
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        alert(CSRF_TOKEN);
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: 'getSocio/',
            method: 'POST',
            data: { "id": 1},
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success:function(response)
            {alert("pasa");
                //$(form).trigger("reset");
                //alert(response.success)
            },
            error: function(response) {
            }
        });
    //});

});