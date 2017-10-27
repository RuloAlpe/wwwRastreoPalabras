$(document).ready(function(){
    $(".js-recovery-pass").on("click", function(e){
        e.preventDefault();
        
        var token = $(this).data("token");
        var url = baseUrl+"super-admin/reenviar-email-activacion";

        var l = Ladda.create(this);
        l.start();

        $.ajax({
            url: url,
            type:'GET',
            data:{
                token: token
            },
            dataType:'JSON',
            success: function(r){
                swal("Ok", "Correo enviado", "success");
            }
        }).always(function() { l.stop(); });
    });
});