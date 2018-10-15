function ImagetoPrint(source) {
    return "<html><head><script>function step1(){\n" +
            "setTimeout('step2()', 10);}\n" +
            "function step2(){window.print();window.close()}\n" +
            "</scri" + "pt></head><body onload='step1()'>\n" +
            "<img src='" + source + "' /></body></html>";
}
function PrintImage(source) {
    Pagelink = "about:blank";
    var pwa = window.open(Pagelink, "_new");
    pwa.document.open();
    pwa.document.write(
        );
    pwa.document.close();
}

function PrintElem(elem)
{
    var mywindow = window.open('', 'PRINT', 'height=400,width=600');   

    mywindow.document.write('<html><head><title>' + $('#barra-usuario').text()  + '</title>');
    mywindow.document.write('</head><body >');
    mywindow.document.write('<div class="row">');
    mywindow.document.write('<img src="http://www.goldenpeanut.com.ar/goldenApp/images/logo_golden_print.png">');    
    mywindow.document.write($('#barra-usuario').text());    
    mywindow.document.write('</div>');
    mywindow.document.write(document.getElementById(elem).innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;
}

function imprimitConsulta(){
		
		console.log("IMPRIMIR__");
           
		PrintElem("tabla-consulta-entrega");

        PrintElem("tabla-consulta-totales");

        PrintElem("tabla-consulta-totales-propios");

        PrintElem("tabla-consulta-totales-terceros");
	
}
