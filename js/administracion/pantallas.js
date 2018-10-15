function mostrarPantalla(pantalla){

  $("#administracion").fadeOut();
  $("#seccion-usuario-existente").fadeOut();
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