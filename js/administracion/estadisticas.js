
$(document).ready(function () {   

    $('#form-consulta-estadisticas').on('submit', function(e) {
        e.preventDefault();
        $(".loader").fadeIn();      

        $.ajax({

            url : $(this).attr('action') || window.location.pathname,
            type: "POST",
            data: $(this).serialize(),
            success: function(response){

                $('#body-tabla-estadisticas').empty();
                $("#body-tabla-estadisticas").append(response);             
                   
                setTimeout(function() {
                 $(".loader").fadeOut("slow");
                }, 500);           
            },
            error: function (jXHR, textStatus, errorThrown) {
                alert(errorThrown);
                console.log(jXHR);
            }
        });    
        
        $.ajax({
            url : "includes/consultas/consulta-grafico.php",
            type: "POST",
            data: $(this).serialize(),
            success: function(response){      
                             
                datos = JSON.parse(response); 

                console.log(datos);

                porcentajeLogeuados = (datos.logueados * 100)/datos.total;
                /*porcentajeEntregas = (datos.entregas * 100)/datos.total;
                porcentajePromedios = (datos.promedios * 100)/datos.total;
                porcentajePagos = (datos.pagos * 100)/datos.total;*/

                var ctx = document.getElementById("myChart");

                

			    var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: [
                            "Logueados "+porcentajeLogeuados.toFixed(0)+"%"/*, 
                            "Consulta Entrega"+porcentajeEntregas.toFixed(0)+"%", 
                            "Consulta Promedios"+porcentajePromedios.toFixed(0)+"%", 
                            "Consulta Pagos"+porcentajePagos.toFixed(0)+"%"*/],
                        datasets: [{
                            label: 'Porcentaje de usuarios que utilizaron la funcionalidad',
                            data: [porcentajeLogeuados.toFixed(0)/*, porcentajeEntregas.toFixed(0), porcentajePromedios.toFixed(0), porcentajePagos.toFixed(0)*/],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        legend: {
                            labels: {
                                 fontColor: 'white'
                                }
                             },
                        title: {
                           display: true,
                           fontColor: 'white',
                           text: 'Custom Chart Title'
                        }     ,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    min: 0,
                                    max: 100,
                                    beginAtZero:true,
                                    fontColor: 'white'
                                }
                            }],
                            xAxes: [{
                                  ticks: {
                                      fontColor: 'white'
                                  },
                              }]
                             
                        },
                        responsive: true,
                        maintainAspectRatio: false,
                        
                    }
                });


                porcentajeEntregas2 = (datos.entregas * 100)/datos.logueados;
                porcentajePromedios2 = (datos.promedios * 100)/datos.logueados;
                porcentajePagos2 = (datos.pagos * 100)/datos.logueados;

                var ctx2 = document.getElementById("myChart2");
			    var myChart2 = new Chart(ctx2, {
                    type: 'bar',
                    data: {
                        labels: [                            
                            "Consulta Entrega"+porcentajeEntregas2.toFixed(0)+"%", 
                            "Consulta Promedios"+porcentajePromedios2.toFixed(0)+"%", 
                            "Consulta Pagos"+porcentajePagos2.toFixed(0)+"%"],
                        datasets: [{
                            label: 'Porcentaje de usuarios logeados que utilizaron la funcionalidad',
                            data: [porcentajeEntregas2.toFixed(0), porcentajePromedios2.toFixed(0), porcentajePagos2.toFixed(0)],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        legend: {
                            labels: {
                                 fontColor: 'white'
                                }
                             },
                        title: {
                           display: true,
                           fontColor: 'white',
                           text: 'Custom Chart Title'
                        }     ,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    min: 0,
                                    max: 100,
                                    beginAtZero:true,
                                    fontColor: 'white'
                                }
                            }],
                            xAxes: [{
                                  ticks: {
                                      fontColor: 'white'
                                  },
                              }]
                             
                        },
                        responsive: true,
                        maintainAspectRatio: false,
                        
                    }
                }); 
                
                
                
            },
            error: function (jXHR, textStatus, errorThrown) {
                alert(errorThrown);
                console.log(jXHR);
            }
        });


        $.ajax({
            url : "includes/consultas/consulta-estadisticas-por-dia.php",
            type: "POST",
            data: $(this).serialize(),
            success: function(response){ 
                
                
                
            var weekday = new Array(7);
            weekday[0] =  "Domingo";
            weekday[1] = "Lunes";
            weekday[2] = "Martes";
            weekday[3] = "Miercoles";
            weekday[4] = "Jueves";
            weekday[5] = "Viernes";
            weekday[6] = "Sábado";

            
                             
                datos = JSON.parse(response); 

                _labels = new Array();
                _valores = new Array();
                datos.forEach(function(element) {

                    var d = new Date(element.Expr1);                   
                    var n = weekday[d.getDay()];
                    console.log (n);

                    _labels.push(element.Expr1+" "+n);

                    
                    _valores.push(element.Expr2);


                });

                console.log(_labels);
                console.log(_valores);

                var ctx3 = document.getElementById("myChart3");
			    var myChart3 = new Chart(ctx3, {
                    type: 'line',
                    data: {
                        labels: _labels,
                        datasets: [{
                            label: 'Cantidad de login por día',
                            data: _valores,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255,99,132,1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        legend: {
                            labels: {
                                 fontColor: 'white'
                                }
                             },
                        title: {
                           display: true,
                           fontColor: 'white',
                           text: 'Custom Chart Title'
                        }     ,
                        scales: {
                            yAxes: [{
                                ticks: {
                                    min: 0,
                                    max: 100,
                                    beginAtZero:true,
                                    fontColor: 'white'
                                }
                            }],
                            xAxes: [{
                                  ticks: {
                                      fontColor: 'white'
                                  },
                              }]
                             
                        },
                        responsive: true,
                        maintainAspectRatio: false,
                        
                    }
                }); 

            },
            error: function (jXHR, textStatus, errorThrown) {
                alert(errorThrown);
                console.log(jXHR);
            }
        });

    });



});