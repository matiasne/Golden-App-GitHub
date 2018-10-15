function logOut(){
    localStorage.setItem('token',0);
    window.location.href = 'http://www.goldenpeanut.com.ar/goldenApp/main.html';
}

$(document).ready(function () {       

    mostrarPantalla("principal");  
    
    $("#btn-consulta-estadisticas").click( function(){
        mostrarPantalla("estadisticas");
        }
    );
  
    $("#btn-solicitar-estadistica").click(function(){        
        $('#modalEstadisticas').modal('hide');
    });

    $('#form-consulta-usuario').on('submit', function(e) {
        e.preventDefault();      

        var usuario = $('#usuario-nombre').val();

        $.ajax({

            url : $(this).attr('action') || window.location.pathname,
            type: "POST",
            data: $(this).serialize(),
            success: function(response){  
                 
                 if(response == 'encontrado') {
                    mostrarPantalla('datos-usuario'); 

                    $("#razon-social").text(localStorage.getItem('razonSocial'));                  
                 } 
                 else if(response == 'inexistente'){
                    mostrarPantalla('crear-usuario');
                 }           
                 
            },
            error: function (jXHR, textStatus, errorThrown) {
                alert(errorThrown);
                console.log(jXHR);
            }
        });
    });


    $('#signup-user').on('submit', function(e) {
        e.preventDefault(); 

        var cuit = $('#cuit-nuevo').val();
        var usuario = $('#usuario-nombre').val();        

        $.ajax({

            url : $(this).attr('action') || window.location.pathname,
            type: "POST",
            data: {"CUIT": cuit, "USUARIO": usuario },
            success: function(response){  
                alert(response);                
            },
            error: function (jXHR, textStatus, errorThrown) {
                alert(errorThrown);
                console.log(jXHR);
            }
        });
    });

    $('#actualizar-usuario').on('submit', function(e) {
        e.preventDefault();  

        var usuario =  $("#usuario-nombre").val();
        var contrasena = $('#contrasena-nueva').val();     
        var conf_contrasena = $('#conf-contrasena-nueva').val(); 

        $.ajax({

            url : $(this).attr('action') || window.location.pathname,
            type: "POST",
            data: {"USUARIO": usuario, "CONTRASENA": contrasena, "CONF-CONTRASENA": conf_contrasena },
            success: function(response){  
                 
                 if(response == 'usuario_actualizado') {
                    alert('usuario actualizado');
                 } 
                 else {
                    alert(response);
                 }    
            },
            error: function (jXHR, textStatus, errorThrown) {
                alert(errorThrown);
                console.log(jXHR);
            }
        });
    });

});