


$(document).ready(function () {     


    $('#form-consulta').on('submit', function(e) {
        e.preventDefault();

        $(".loader").fadeIn();
       
        console.log($(this).serialize()+"&ID_ENTIDAD="+localStorage.getItem('idEntidad'));

        $.ajax({

            url : "includes/consultas/consulta.inc.php",
            type: "POST",
            data: $(this).serialize()+"&ID_ENTIDAD="+localStorage.getItem('idEntidad'),
            success: function(response){ 

                console.log(response);
                $("#numero-contrato-titulo").empty();
                $("#numero-contrato-titulo").text($('#opciones-contrato').val()); 
                $('#body-tabla-consulta').empty();              
                $('#body-tabla-consulta').append(response);
                
                procesarColumnas();   
                setTimeout(function() {
                 $(".loader").fadeOut("slow");
                }, 500 );
                          
            },
            error: function (jXHR, textStatus, errorThrown) {
                alert(errorThrown);
                console.log(jXHR);
            }
        });

        $.ajax({

            url : "includes/consultas/consulta-promedios.php",
            type: "POST",
            data: $(this).serialize()+"&ID_ENTIDAD="+localStorage.getItem('idEntidad')+"&contrato="+$('#opciones-contrato').val(),
            success: function(response){ 

                console.log(response);

                var resp = response.split("-");   
                $("#sumatoria-kgneto").empty();    
                $("#sumatoria-kgneto").append(resp[0]);

                $("#sumatoria-kgSecoLimpio").empty();    
                $("#sumatoria-kgSecoLimpio").append(resp[1]);

                $("#sumatoria-mani").empty();    
                $("#sumatoria-mani").append(resp[2]);

                $("#sumatoria-gsuelto").empty();   
                $("#sumatoria-gsuelto").append(resp[3]);

                $("#pp-mani").empty();   
                $("#pp-mani").append(resp[4]+"%");

                $("#pp-gsuelto").empty();   
                $("#pp-gsuelto").append(resp[5]+"%");

                $("#pp-confiteria").empty();   
                $("#pp-confiteria").append(resp[6]+"%");
                               
                $("#sumatoria-kgneto-propios").empty();    
                $("#sumatoria-kgneto-propios").append(resp[7]);

                $("#sumatoria-kgSecoLimpio-propios").empty();    
                $("#sumatoria-kgSecoLimpio-propios").append(resp[8]);

                $("#sumatoria-mani-propios").empty();    
                $("#sumatoria-mani-propios").append(resp[9]);

                $("#sumatoria-gsuelto-propios").empty();   
                $("#sumatoria-gsuelto-propios").append(resp[10]);

                $("#pp-mani-propios").empty();   
                $("#pp-mani-propios").append(resp[11]+"%");

                $("#pp-gsuelto-propios").empty();   
                $("#pp-gsuelto-propios").append(resp[12]+"%");

                $("#pp-confiteria-propios").empty();   
                $("#pp-confiteria-propios").append(resp[13]+"%");



                $("#sumatoria-kgneto-terceros").empty();    
                $("#sumatoria-kgneto-terceros").append(resp[14]);

                $("#sumatoria-kgSecoLimpio-terceros").empty();    
                $("#sumatoria-kgSecoLimpio-terceros").append(resp[15]);

                $("#sumatoria-mani-terceros").empty();    
                $("#sumatoria-mani-terceros").append(resp[16]);

                $("#sumatoria-gsuelto-terceros").empty();   
                $("#sumatoria-gsuelto-terceros").append(resp[17]);

                $("#pp-mani-terceros").empty();   
                $("#pp-mani-terceros").append(resp[18]+"%");

                $("#pp-gsuelto-terceros").empty();   
                $("#pp-gsuelto-terceros").append(resp[19]+"%");

                $("#pp-confiteria-terceros").empty();   
                $("#pp-confiteria-terceros").append(resp[20]+"%");                

            },
            error: function (jXHR, textStatus, errorThrown) {
                alert(errorThrown);
                console.log(jXHR);
            }
        });
    });



});