function mostrarPDFOrdenDePago(data){

json = JSON.parse(data);

console.log(data);
console.log(json);

var margen_izquierdo = 10;
var margen_derecho = 10;
var ancho = 190;

var margen_izquierdo_box = 3;

var margen_superior_valores = 150;

var doc = new jsPDF(); 

doc.setFontSize(10);

//20 margen izquierdo
//17 siguiente renglon

//Pagina


doc.text(175, 17, json[0].DS_CBTE);	

doc.rect(120, 20, 80, 40); // empty square
doc.text(130, 30, 'Número:');	
doc.text(160, 30, json[0].RECIBO);

doc.text(130, 35, 'Emisión:');
doc.text(160, 35, json[0].DT_EMISION.date);


doc.text(130, 45, 'CUIT:');
doc.text(160, 45, '30-64225906-3');

doc.text(130, 50, 'IBB:');
doc.text(160, 50, '9019609491');

doc.rect(margen_izquierdo, 70, ancho, 40); // empty square

doc.text(margen_izquierdo, 68, 'Pagamos a:');

doc.text(margen_izquierdo+margen_izquierdo_box, 76, 'Razón Social:');
doc.text(margen_izquierdo+margen_izquierdo_box+30, 76, json[0].DS_RAZON_SOCIAL);

doc.text(margen_izquierdo+margen_izquierdo_box, 90, 'Domicilio:');
doc.text(margen_izquierdo+margen_izquierdo_box+30, 90, json[0].Direccion);
doc.text(margen_izquierdo+margen_izquierdo_box+29, 97, json[0].Localidad);

doc.text(margen_izquierdo+120, 76, 'C.U.I.T:');
doc.text(margen_izquierdo+120+30, 76, json[0].CD_CUIT);


doc.rect(margen_izquierdo, 120, ancho, 8); // empty square
doc.text(margen_izquierdo, 118, 'Aplicación');
doc.text(margen_izquierdo+margen_izquierdo_box, 125, 'Tipo');
doc.text(margen_izquierdo+margen_izquierdo_box+35, 125, 'Descripción');
doc.text(margen_izquierdo+margen_izquierdo_box+35+55, 125, 'Número');
doc.text(margen_izquierdo+margen_izquierdo_box+35+55+40, 125, 'Fecha');
doc.text(margen_izquierdo+margen_izquierdo_box+35+55+40+40, 125, 'Importe');

doc.setFontSize(8);
//Bucle de carga de datos
var sumatoria_importe = 0;
for (var i=0; i < json.length;i++){
	if(json[i].Tipo === "Aplicacion"){
		
		doc.text(margen_izquierdo+margen_izquierdo_box, 135 +(i*7), json[i].DS_VALOR_TIPO);

		if(json[i].DS_CONCEPTO != null)
			doc.text(margen_izquierdo+margen_izquierdo_box+35, 135 +(i*7), json[i].DS_CONCEPTO);

		doc.text(margen_izquierdo+margen_izquierdo_box+35+55, 135+(i*7), json[i].Comprobante);
		doc.text(margen_izquierdo+margen_izquierdo_box+35+55+40, 135+(i*7), json[i].Emision.date);
		doc.text(margen_izquierdo+margen_izquierdo_box+35+55+40+40, 135+(i*7), json[i].VL_IMPORTE);

		sumatoria_importe += Number(json[i].VL_IMPORTE);

		margen_superior_valores += (i*7); 
	}
}

doc.line(margen_izquierdo+margen_izquierdo_box+35+55+40+40, margen_superior_valores-20, margen_izquierdo+margen_izquierdo_box+30+50+40+50+15, margen_superior_valores-20); // horizontal line
doc.text(margen_izquierdo+margen_izquierdo_box+35+55+40+40, margen_superior_valores-15, sumatoria_importe.toFixed(2).toString());

doc.setFontSize(10);

doc.rect(margen_izquierdo, margen_superior_valores, ancho, 8); // empty square
doc.text(margen_izquierdo, margen_superior_valores-2, 'Valores');
doc.text(margen_izquierdo+margen_izquierdo_box, margen_superior_valores+5, 'Tipo');
doc.text(margen_izquierdo+margen_izquierdo_box+35, margen_superior_valores+5, 'Descripción');
doc.text(margen_izquierdo+margen_izquierdo_box+35+55, margen_superior_valores+5, 'Número');
doc.text(margen_izquierdo+margen_izquierdo_box+35+55+40, margen_superior_valores+5, 'Fecha');
doc.text(margen_izquierdo+margen_izquierdo_box+35+55+40+40, margen_superior_valores+5, 'Importe');

//Bucle de carga de datos
sumatoria_importe = 0;
var margen_superior_valores_linea_total = 0;

doc.setFontSize(8);
for (var i=0; i < json.length;i++){

	if(json[i].Tipo === "Valor"){

		if(json[i].DS_VALOR_TIPO != null)
			doc.text(margen_izquierdo+margen_izquierdo_box, margen_superior_valores+(i*7), json[i].DS_VALOR_TIPO);

		if(json[i].DS_CONCEPTO != null)
			doc.text(margen_izquierdo+margen_izquierdo_box+35, margen_superior_valores +(i*7), json[i].DS_CONCEPTO);

		if(json[i].Comprobante != null)
			doc.text(margen_izquierdo+margen_izquierdo_box+35+55, margen_superior_valores+(i*7), json[i].Comprobante);

		if(json[i].Emision != null)
			doc.text(margen_izquierdo+margen_izquierdo_box+35+55+40, margen_superior_valores+(i*7), json[i].Emision.date);

		doc.text(margen_izquierdo+margen_izquierdo_box+35+55+40+40, margen_superior_valores+(i*7), json[i].VL_IMPORTE);

		sumatoria_importe += Number(json[i].VL_IMPORTE);

		margen_superior_valores_linea_total = (i*7);
	}
}

doc.line(margen_izquierdo+margen_izquierdo_box+35+55+40+40, margen_superior_valores+margen_superior_valores_linea_total+2, margen_izquierdo+margen_izquierdo_box+30+50+40+50+15, margen_superior_valores+margen_superior_valores_linea_total+2); // horizontal line
doc.text(margen_izquierdo+margen_izquierdo_box+35+55+40+40, margen_superior_valores+margen_superior_valores_linea_total+7, sumatoria_importe.toFixed(2).toString());
 
doc.addImage(logoData, 'JPEG', 45, 20, 35, 30);
doc.setFontSize(12);
doc.text(20, 58, 'GOLDEN PEANUT AND TREE NUTS S.A.');

doc.output('datauri');
// doc.save('orden_de_pago.pdf');
}