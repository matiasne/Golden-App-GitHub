



function scrollTablaDerecha() {
    $('#table-scroll').animate({scrollLeft: '+=300'});
}

function scrollTablaIzquierda() {
    $('#table-scroll').animate({scrollLeft: '-=300'});
}


var arrayContratos;

function procesarColumnas(){
  if($('#columnaTipo').is(':checked') == true){
          console.log("mostrar");
          $('#tabla-consulta tr > td:nth-child(2), #tabla-consulta tr > th:nth-child(2)').show();
        }
        else{
          console.log("ocultar");
          $('#tabla-consulta tr > td:nth-child(2), #tabla-consulta tr > th:nth-child(2)').hide();
        }

        if($('#columnaCartaporte').is(':checked') == true){
          console.log("mostrar");
          $('#tabla-consulta tr > td:nth-child(3), #tabla-consulta tr > th:nth-child(3)').show();
        }
        else{
          console.log("ocultar");
          $('#tabla-consulta tr > td:nth-child(3), #tabla-consulta tr > th:nth-child(3)').hide();
        }

        if($('#columnaKgNeto').is(':checked') == true){
          console.log("mostrar");
          $('#tabla-consulta tr > td:nth-child(4), #tabla-consulta tr > th:nth-child(4)').show();
        }
        else{
          console.log("ocultar");
          $('#tabla-consulta tr > td:nth-child(4), #tabla-consulta tr > th:nth-child(4)').hide();
        }

        if($('#columnaPHumedad').is(':checked') == true){
          console.log("mostrar");
          $('#tabla-consulta tr > td:nth-child(5), #tabla-consulta tr > th:nth-child(5)').show();
        }
        else{
          console.log("ocultar");
          $('#tabla-consulta tr > td:nth-child(5), #tabla-consulta tr > th:nth-child(5)').hide();
        }

        if($('#columnaMermaHumedad').is(':checked') == true){
          console.log("mostrar");
          $('#tabla-consulta tr > td:nth-child(6), #tabla-consulta tr > th:nth-child(6)').show();
        }
        else{
          console.log("ocultar");
          $('#tabla-consulta tr > td:nth-child(6), #tabla-consulta tr > th:nth-child(6)').hide();
        }

        if($('#columnaMermaTierra').is(':checked') == true){
          console.log("mostrar");
          $('#tabla-consulta tr > td:nth-child(7), #tabla-consulta tr > th:nth-child(7)').show();
        }
        else{
          console.log("ocultar");
          $('#tabla-consulta tr > td:nth-child(7), #tabla-consulta tr > th:nth-child(7)').hide();
        }

        if($('#columnaMermaCpos').is(':checked') == true){
          console.log("mostrar");
          $('#tabla-consulta tr > td:nth-child(8), #tabla-consulta tr > th:nth-child(8)').show();
        }
        else{
          console.log("ocultar");
          $('#tabla-consulta tr > td:nth-child(8), #tabla-consulta tr > th:nth-child(8)').hide();
        }

        if($('#columnaSecosLimpios').is(':checked') == true){
          console.log("mostrar");
          $('#tabla-consulta tr > td:nth-child(9), #tabla-consulta tr > th:nth-child(9)').show();
        }
        else{
          console.log("ocultar");
          $('#tabla-consulta tr > td:nth-child(9), #tabla-consulta tr > th:nth-child(9)').hide();
        }

        if($('#columnaSueltos').is(':checked') == true){
          console.log("mostrar");
          $('#tabla-consulta tr > td:nth-child(10), #tabla-consulta tr > th:nth-child(10)').show();
        }
        else{
          console.log("ocultar");
          $('#tabla-consulta tr > td:nth-child(10), #tabla-consulta tr > th:nth-child(10)').hide();
        }

        if($('#columnaMani').is(':checked') == true){
          console.log("mostrar");
          $('#tabla-consulta tr > td:nth-child(11), #tabla-consulta tr > th:nth-child(11)').show();
        }
        else{
          console.log("ocultar");
          $('#tabla-consulta tr > td:nth-child(11), #tabla-consulta tr > th:nth-child(11)').hide();
        }

        if($('#columnaConfiteria').is(':checked') == true){
          console.log("mostrar");
          $('#tabla-consulta tr > td:nth-child(12), #tabla-consulta tr > th:nth-child(12)').show();
        }
        else{
          console.log("ocultar");
          $('#tabla-consulta tr > td:nth-child(12), #tabla-consulta tr > th:nth-child(12)').hide();
        }

        if($('#columnaNroCertificado').is(':checked') == true){
          console.log("mostrar");
          $('#tabla-consulta tr > td:nth-child(13), #tabla-consulta tr > th:nth-child(13)').show();
        }
        else{
          console.log("ocultar");
          $('#tabla-consulta tr > td:nth-child(13), #tabla-consulta tr > th:nth-child(13)').hide();
        }

        if($('#columnaKilosSecos').is(':checked') == true){
          console.log("mostrar");
          $('#tabla-consulta tr > td:nth-child(14), #tabla-consulta tr > th:nth-child(14)').show();
        }
        else{
          console.log("ocultar");
          $('#tabla-consulta tr > td:nth-child(14), #tabla-consulta tr > th:nth-child(14)').hide();
        }

        if($('#columnaTipoLugar').is(':checked') == true){
          console.log("mostrar");
          $('#tabla-consulta tr > td:nth-child(15), #tabla-consulta tr > th:nth-child(15)').show();
        }
        else{
          console.log("ocultar");
          $('#tabla-consulta tr > td:nth-child(15), #tabla-consulta tr > th:nth-child(15)').hide();
        }

        if($('#columnaNombreCampo').is(':checked') == true){
          console.log("mostrar");
          $('#tabla-consulta tr > td:nth-child(16), #tabla-consulta tr > th:nth-child(16)').show();
        }
        else{
          console.log("ocultar");
          $('#tabla-consulta tr > td:nth-child(16), #tabla-consulta tr > th:nth-child(16)').hide();
        }
}


function logOut(){
      localStorage.setItem('token',0);
      mostrarPantalla("login");
  }



function consultaContratos(){ 

  $.ajax({
      url : "includes/consultas/opciones-contratos.php",
      type: "POST",
      data: "ID_ENTIDAD="+localStorage.getItem('idEntidad'),
      success: function(response){                 
          
          arrayContratos = JSON.parse(response); 
          console.log("Consultando contratos");
          console.log(arrayContratos);          
          return arrayContratos;
      },
      error: function (jXHR, textStatus, errorThrown) {
          alert(errorThrown);
          console.log(jXHR);
          return 0;
      }
  });
}


function reinciodeValores(){

  console.log("Reiniciano valores");
  
  $('#opciones-cosecha').val( "default" );
  $('#opciones-contrato').empty();
  

  $('#body-tabla-pagos-detalle').empty();
  $('#body-tabla-consulta').empty();
  $('#body-tabla-pagos').empty();

  $("#sumatoria-kgneto").empty();
  $("#sumatoria-kgSecoLimpio").empty(); 
  $("#sumatoria-mani").empty();
  $("#sumatoria-gsuelto").empty();
  $("#pp-mani").empty();
  $("#pp-gsuelto").empty(); 
  $("#pp-confiteria").empty();  

  $("#sumatoria-kgneto-propios").empty();
  $("#sumatoria-kgSecoLimpio-propios").empty(); 
  $("#sumatoria-mani-propios").empty();
  $("#sumatoria-gsuelto-propios").empty();
  $("#pp-mani-propios").empty();
  $("#pp-gsuelto-propios").empty(); 
  $("#pp-confiteria-propios").empty(); 

  $("#sumatoria-kgneto-terceros").empty();
  $("#sumatoria-kgSecoLimpio-terceros").empty(); 
  $("#sumatoria-mani-terceros").empty();
  $("#sumatoria-gsuelto-terceros").empty();
  $("#pp-mani-terceros").empty();
  $("#pp-gsuelto-terceros").empty(); 
  $("#pp-confiteria-terceros").empty(); 
  
}


function ObtenerInfoDelToken(){
  $.ajax({

    url : "http://www.goldenpeanut.com.ar/login/usuarios.php/tokenInfo",
    type: "POST",
    data: "token="+localStorage.getItem('token'),
    success: function(resp){  

      var response = JSON.parse(resp);
      console.log(response);

      if(response.code == "204"){
        mostrarPantalla("login");
        setTimeout(function() {
          $(".loader").fadeOut("slow");
        }, 2000 );
      }
      else{

        
        localStorage.setItem('usuario',response.data.nombre);
        localStorage.setItem('idEntidad',response.data.idEntidad);
        localStorage.setItem('idEntidadSQL',response.data.idEntidadSQL);
        localStorage.setItem('razonSocial',response.data.razonSocial);
        localStorage.setItem('admin',response.data.admin);

        var admin = response.data.admin;
        if(admin){        

          window.location.replace("adminPanel.html");
        }
        else{

          

          mostrarPantalla("inicio");
          
          arrayContratos = consultaContratos();                
          
          $('#barra-usuario').empty();
          $('#barra-usuario').append(response.data.razonSocial);

          $.ajax({

              url : "http://www.goldenpeanut.com.ar/cuadernoCampoWS/entidades.php/propiedades/"+response.data.idEntidad,
              type: "GET",
              data: $(this).serialize(),
              success: function (resp) { 

                var response = JSON.parse(resp);
                console.log(response); 
                
                if(response.code == "404"){
                  localStorage.setItem('idPropiedad',"0");
                }
                else{
                  localStorage.setItem('idPropiedad',response.data[0].ID_PROPIEDAD.toString());
                }

          
              },
              error: function (jXHR, textStatus, errorThrown) {
                  console.log(errorThrown);
                  console.log(textStatus);
                  console.log(jXHR);
              }
          });

        }         

        setTimeout(function() {
          $(".loader").fadeOut("slow");
        }, 2000 );
      }
      
    },
    error: function (jXHR, textStatus, errorThrown) {
        alert(errorThrown);
        console.log(jXHR);
    }
  }); 
}

$(document).ready(function () {

    document.getElementById('fechaHasta').valueAsDate = new Date();    
    ObtenerInfoDelToken();    
    
    $("#btn-cuaderno-campo").click(function(){
      window.open('http://www.goldenpeanut.com.ar/cuadernoCampoApp/', '_system');   
    $('#modalPDF').modal('hide');
    });

    $("#btn-consulta-entrega").click(function(){
          mostrarPantalla("consulta");
        }
    );

    $("#btn-consulta-pago").click( function(){
          mostrarPantalla("pagos");
      }
    );

    $("#btn-archivos").click( function(){
      ObtenerArchivosCliente();
      mostrarPantalla("archivos");
    }
  );

    $("#btn-solicitar-pagos").click(function(){        
        $('#modalFiltroPagos').modal('hide');
    });   


    $("#btn-solicitar-consulta").click(function(){        
        $('#modalConsulta').modal('hide');
    });

     $("#btn-solicitar-consulta").click(function(){       
        $('#modalConsulta').modal('hide');
    });

    $("#btn-volver").click( function(){         
        mostrarPantalla("inicio");
    });

    $("#btn-exportar").click(function(){
      
      fnExcelReport(); 
    });

    $("#btn-config").click(function(){
       $('#modalConfig').modal('show');
    });

    $("#btn-print").click(function(){
       imprimitConsulta();
    });

    $("#btn-guardar-config").click(function(){
      $('#modalConfig').modal('hide');
    });

    $("#btn-scroll-derecha").click(function(){
      scrollTablaDerecha();
    });

    $("#btn-scroll-izquierda").click(function(){
      scrollTablaIzquierda();
    });

    $("#cerrar-detalle-pago").click(function(){
      mostrarPantalla("pagos");
    });    

    $('#form-login').on('submit', function(e) {
        
        e.preventDefault();
        $('#modalConsulta').modal('hide');
        reinciodeValores();        
        
        $.ajax({

            url : $(this).attr('action') || window.location.pathname,
            type: "POST",
            data: $(this).serialize(),
            success: function (resp) { 

              var response = JSON.parse(resp);
              console.log(response);             

  			   	  if(response.code == '200'){
                localStorage.setItem('token',response.data.token);
                ObtenerInfoDelToken();       
              }              
              else if(response.message == 'cambiar contrasena'){
                $('#cambiarContrasena').modal('show');
              }              
              else{
                  console.log(response.message);
               		$('#myModal .modal-body').text(response.message);
               		$('#myModal').modal('show');
              }         
				
            },
            error: function (jXHR, textStatus, errorThrown) {
                console.log(errorThrown);
                console.log(textStatus);
                console.log(jXHR);
            }
        });
    });

    $("#opciones-cosecha").change(function () {          

      var id = $(this).children(":selected").attr("id");   
      numberID = Number(id);

      console.log(numberID+"!!!!");
               
      if(numberID!=0){
      //Busca en el array de Contratos y carga aquellos que concueerden con el ID
         $('#opciones-contrato').empty();

         console.log(arrayContratos.length);
         console.log(arrayContratos);

         if (arrayContratos.length == undefined){ //Si es un solo valor
            $('#opciones-contrato').append("<option  value='"+arrayContratos.CD_CONTRATO+"'>"+arrayContratos.CD_CONTRATO+"</option>"); 
         }
         else{
           for (var i=0; i<arrayContratos.length;i++){ //Si tiene más de un valor
              
             if (numberID === arrayContratos[i].ID_COSECHA){                 
                
                $('#opciones-contrato').append("<option  value='"+arrayContratos[i].CD_CONTRATO+"'>"+arrayContratos[i].CD_CONTRATO+"</option>"); 

            
             }
           }
         }         
      }
    });


    $('#form-contrasena-nueva').on('submit', function(e) {
        
        e.preventDefault(); 
        console.log("Falta método en login principal");       
    });

    $('#form-config').on('submit', function(e) {
      e.preventDefault();      
      procesarColumnas();

    });

  });


  
function ObtenerArchivosCliente(){
 
  var form_data = new FormData(); 
  form_data.append('nombreUsuario', localStorage.getItem('idEntidad'));       
  var nombreUsuario = localStorage.getItem('idEntidad');
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
                  $('#tabla-archivos').append("<tr><th>"+element+"</th><th><a href='../goldenApp/includes/uploads/"+nombreUsuario.trim()+"/"+element.trim()+"'><button  class='btn btn-default'>Ver</button></th></tr></a>");
          });
         
      },
      error: function (jXHR, textStatus, errorThrown) {
          alert(errorThrown);
          console.log(jXHR);
      }
  });

}


