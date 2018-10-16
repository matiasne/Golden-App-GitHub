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

        ObtenerArchivos();

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


    $('#subir-archivo').on('submit', function(e) {
        e.preventDefault();  

        var usuario = $('#usuario-nombre').val();

        var file_data = $('#file').prop('files')[0];   
        var form_data = new FormData();                  
        form_data.append('file', file_data);
        form_data.append('nombreUsuario', usuario);   
        
        

        console.log($(this).serialize());
        $.ajax({

            url : $(this).attr('action') || window.location.pathname,
            type: "POST",
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            success: function(response){  
                 
                ObtenerArchivos();
               
            },
            error: function (jXHR, textStatus, errorThrown) {
                alert(errorThrown);
                console.log(jXHR);
            }
        });
    });     
});

function ObtenerArchivos(){

    var usuario = $('#usuario-nombre').val();    
    var form_data = new FormData(); 
    form_data.append('nombreUsuario', usuario);       

    $('#tabla-archivos').empty();

    console.log($(this).serialize());
    $.ajax({

        url : 'includes/administracion/obtenerArchivos.php',
        type: "POST",
        dataType: 'text',  // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        success: function(response){  
             
            console.log(response);
            var obj = JSON.parse(response);
            obj.archivos.forEach(element => {
                if(element!="." && element!="..")
                    $('#tabla-archivos').append("<tr><th>"+element+"</th><th><button onclick='onclickBorrar(\""+element+"\")' class='btn btn-default'>Borrar</button></th></tr>");
            });
           
        },
        error: function (jXHR, textStatus, errorThrown) {
            alert(errorThrown);
            console.log(jXHR);
        }
    });

}

function onclickBorrar(nombreArchivo){
   
    var usuario = $('#usuario-nombre').val();    
    var form_data = new FormData(); 
    form_data.append('nombreArchivo', nombreArchivo);
    form_data.append('nombreUsuario', usuario);        

    console.log($(this).serialize());
    $.ajax({

        url : 'includes/administracion/eliminarArchivo.php',
        type: "POST",
        dataType: 'text',  // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,
        success: function(response){  
             
            ObtenerArchivos();
           
        },
        error: function (jXHR, textStatus, errorThrown) {
            alert(errorThrown);
            console.log(jXHR);
        }
    });
}
