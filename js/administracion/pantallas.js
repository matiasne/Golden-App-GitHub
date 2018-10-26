function mostrarPantalla(pantalla){

  $("#administracion").fadeOut();
  $("#seccion-usuario-existente").fadeOut();
  $("#seccion-usuario-contratos").fadeOut();
  $("#seccion-nuevo-usuario").fadeOut();
  $("#seccion-estadisticas").fadeOut();
  

  switch (pantalla){

    case "principal":
      $("#administracion").fadeIn();
    break;

    case "datos-usuario":
       $("#administracion").fadeIn(function() {
          $("#seccion-usuario-existente").fadeIn();          
      });
    break;

    case "contratos-usuario":
       $("#administracion").fadeIn(function() {
          $("#seccion-usuario-contratos").fadeIn();          
      });
    break;

    case "crear-usuario":      
      $("#administracion").fadeIn(function() {
          $("#seccion-nuevo-usuario").fadeIn();          
      });
    break;   
    
    case "estadisticas":      
      $("#administracion").fadeIn(function() {
          $("#seccion-estadisticas").fadeIn();          
      });
    break;

    

  }
}