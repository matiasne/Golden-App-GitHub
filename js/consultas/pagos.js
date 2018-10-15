var numeroPagoPDF = "";

function generarPDFs(noPago){

    numeroPagoPDF = noPago;
    generarPDFOrdenDePago_mobile(noPago);
    generarPDFRetencionGanancias_mobile(noPago);
    generarPDFRetencionIngresosBrutos_mobile(noPago);

}

function solicitarDetalle(idPago,noRecibo){   

    $(".loader").fadeIn();

    $.ajax({

        url : "includes/consultas/consulta-detalles-pagos.php",
        type: "POST",
        data: "ID_DETALLE="+idPago+"&usuario="+localStorage.getItem('usuario'),
        success: function(response){            

            generarPDFs(noRecibo);             

            $(".loader").fadeOut();
            $('#body-tabla-pagos-detalle').empty();
            $("#body-tabla-pagos-detalle").append(response);

            mostrarPantalla("detalle-pago");
        },
        error: function (jXHR, textStatus, errorThrown) {
            alert(errorThrown);
            console.log(jXHR);
        }
    });
}


function generarPDFOrdenDePago_mobile(idPago){
    $.ajax({

        url : "../descarga/creacion-pdf/creacion-orden-pago.php",
        type: "POST",
        data: {"ID_DETALLE": idPago} ,
        success: function(response){

        },
        error: function (jXHR, textStatus, errorThrown) {
            alert(errorThrown);
            console.log(jXHR);
        }
    });
}

function generarPDFRetencionGanancias_mobile(idPago){
    $.ajax({

        url : "../descarga/creacion-pdf/creacion-retencion-ganancias.php",
        type: "POST",
        data: {"ID_DETALLE": idPago} ,
        success: function(response){   
        },
        error: function (jXHR, textStatus, errorThrown) {
            alert(errorThrown);
            console.log(jXHR);
        }
    });
}

function generarPDFRetencionIngresosBrutos_mobile(idPago){
    $.ajax({

        url : "../descarga/creacion-pdf/creacion-ingresos-brutos.php",
        type: "POST",
        data: {"ID_DETALLE": idPago} ,
        success: function(url_pdf){                
        },
        error: function (jXHR, textStatus, errorThrown) {
            alert(errorThrown);
            console.log(jXHR);
        }
    });
}


function mostrarMenuPDF(noPago){ 

    generarPDFs(noPago);
    $('#modalPDF').modal('show');
}

function onclickGenerarPDF(tipo){
    
    console.log(tipo+"!!!!!!!!!!!!");

    if(tipo == 2){
        mostrarPDF_RG();
    }
    else if(tipo == 31){
        mostrarPDF_RIB();
    }
    else {
        mostrarPDF_OP();
    }
}

function mostrarPDF_OP(){    
    window.open('http://www.goldenpeanut.com.ar/descarga/creacion-pdf/'+numeroPagoPDF+'-OP.pdf', '_system');   
    $('#modalPDF').modal('hide');
}

function mostrarPDF_RG(){ 
    window.open('http://www.goldenpeanut.com.ar/descarga/creacion-pdf/'+numeroPagoPDF+'-RG.pdf', '_system');   
    $('#modalPDF').modal('hide');
}

function mostrarPDF_RIB(){
    window.open('http://www.goldenpeanut.com.ar/descarga/creacion-pdf/'+numeroPagoPDF+'-RIB.pdf', '_system');   
    $('#modalPDF').modal('hide');   
}

$(document).ready(function () {    
   
    $('#form-filtro-pagos').on('submit', function(e) {
        e.preventDefault();
        $(".loader").fadeIn();   
        
        console.log($(this).serialize()+"&ID_ENTIDADSQL="+localStorage.getItem('idEntidadSQL'));

        $.ajax({

            url : $(this).attr('action') || window.location.pathname,
            type: "POST",
            data: $(this).serialize()+"&ID_ENTIDADSQL="+localStorage.getItem('idEntidadSQL'),
            success: function(response){

                $('#body-tabla-pagos').empty();
                $("#body-tabla-pagos").append(response);             
                   
                setTimeout(function() {
                 $(".loader").fadeOut("slow");
                }, 500);           
            },
            error: function (jXHR, textStatus, errorThrown) {
                alert(errorThrown);
                console.log(jXHR);
            }
        });       
    });
});