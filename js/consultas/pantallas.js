var pantallaActual = "";


function mostrarPantalla(pantalla){


  pantallaActual = pantalla;
  
  $("#pantalla-login").fadeOut();
  $("#pantalla-tablas").fadeOut();
    $("#seccion-inicio").fadeOut();
    $("#seccion-consulta").fadeOut();
    $("#seccion-pagos").fadeOut();
    $("#seccion-detalle-pago").fadeOut();

  $("#btn-exportar").fadeOut();
  $("#btn-config").fadeOut();
  $("#btn-print").fadeOut();

  switch (pantalla){

    case "inicio":
      $("#pantalla-tablas").fadeIn(function() {         
          $("#seccion-inicio").fadeIn();
          if(localStorage.getItem('idPropiedad')!="102")
            $("#btn-cuaderno-campo").hide();
      });
    break;

    case "login":
      $("#pantalla-login").fadeIn();
    break;

    case "consulta":
      //$("#seccion-pagos").fadeOut();
      $("#pantalla-tablas").fadeIn(function() {
          $("#seccion-consulta").fadeIn();          
      });
      $("#btn-exportar").fadeIn();
      $("#btn-config").fadeIn();
      $("#btn-print").fadeIn();
    break;

    case "pagos":
    // $("#seccion-consulta").fadeOut();
     $("#pantalla-tablas").fadeIn(function() {         
          $("#seccion-pagos").fadeIn();
      });
    break;

    case "detalle-pago":
      $("#pantalla-tablas").fadeIn(function() {         
          $("#seccion-detalle-pago").fadeIn();
      });
    break;

    

  }
}