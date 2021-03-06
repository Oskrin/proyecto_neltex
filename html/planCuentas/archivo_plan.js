$(document).on("ready", inicio);
function evento(e) {
    e.preventDefault();
}
function scrollToBottom() {
    $('html, body').animate({
        scrollTop: $(document).height()
    }, 'slow');
}
function scrollToTop() {
    $('html, body').animate({
        scrollTop: 0
    }, 'slow');
}

function openPDF(){
window.open('../../ayudas/ayuda.pdf');
}

$(function() {
    $('#main-menu').smartmenus({
        subMenusSubOffsetX: 1,
        subMenusSubOffsetY: -8
    });
});

function inicio(){
    function getDoc(frame) {
        var doc = null;     
     	
        try {
            if (frame.contentWindow) {
                doc = frame.contentWindow.document;
            }
        } catch(err) {
        }
        if (doc) { 
            return doc;
        }
        try { 
            doc = frame.contentDocument ? frame.contentDocument : frame.document;
        } catch(err) {
       
            doc = frame.document;
        }
        return doc;
    }
    $("#btnGuardarCargar").on("click",guardarCargar);
}


function guardarCargar(){
    $("#tabla_excel tbody").empty(); 
    $("#formulario_excel").submit(function(e) {
        var formObj = $(this);
        var formURL = formObj.attr("action");
        if(window.FormData !== undefined) {	
            var formData = new FormData(this);   
            formURL=formURL;        	
            $.ajax({
                url: "guardarExcel.php",
                type: "POST",
                data:  formData,
                mimeType:"multipart/form-data",
                dataType: 'json',
                contentType: false,
                cache: false,
                processData:false,
                success: function(data, textStatus, jqXHR)
                {
                    var res=data;
                    if(res != ""){
                        alertify.alert("Datos cargados");
                        cargarTabla(data);
                    }
                    else{
                        alertify.alert("Error..... Al cargar los registros");
                        cargarTabla(data);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) 
                {
                } 	        
            });
            e.preventDefault();
            $(this).unbind("submit");
        } else {
            var  iframeId = "unique" + (new Date().getTime());
            var iframe = $('<iframe src="javascript:false;" name="'+iframeId+'" />');
            iframe.hide();
            formObj.attr("target",iframeId);
            iframe.appendTo("body");
            iframe.load(function(e)
            {
                var doc = getDoc(iframe[0]);
                var docRoot = doc.body ? doc.body : doc.documentElement;
                var data = docRoot.innerHTML;
            });
        }
    });
}

function cargarTabla(data){
    for(var i=0;i<data.length;i+=4){
        vector = new Array();
        vector[0]=data[i];
        vector[1]=data[i+1];
        vector[2]=data[i+2];
        vector[3]=data[i+3];
        guardar_datos_excel(vector);
    }
}

function guardar_datos_excel(vector){
    $.ajax({
        type: "POST",
        url: "guardar_plan_excel.php",
        data: "var="+vector[0]+"&var1="+vector[1]+"&var2="+vector[2]+"&var3="+vector[3]+"&var4="+vector[4]+"&var5="+vector[5]+"&var6="+vector[6]+"&var7="+vector[7]+"&var8="+vector[8]+"&var9="+vector[9]+"&var10="+vector[10]+"&var11="+vector[11]+"&var12="+vector[12],
        success: function(data) {
            var val = data;
            if (val == 1) {
                $("#tabla_excel tbody").append( "<tr>" +
                    "<td align=center>" + vector[0] + "</td>" +
                    "<td align=center>" + vector[1] + "</td>" +	            
                    "<td align=center>" + 'Guardado Correctamente' + "</td>" +            
                    "<td align=center>" + " <a class='elimina'><img src='../../imagenes/valid.png'/>"  + "</td>" + "</tr>" );
            }
            
            if (val == 2) {
                $("#tabla_excel tbody").append( "<tr>" +
                    "<td align=center>" + vector[0] + "</td>" +
                    "<td align=center>" + vector[1] + "</td>" +	            
                    "<td align=center>" + 'Producto Repetido' + "</td>" +            
                    "<td align=center>" + " <a class='elimina'><img src='../../imagenes/invalid.png' />"  + "</td>" + "</tr>" );
            }
            
            if (val == 3) {
                $("#tabla_excel tbody").append( "<tr>" +
                    "<td align=center>" + vector[0] + "</td>" +
                    "<td align=center>" + vector[1] + "</td>" +	            
                    "<td align=center>" + 'Sintaxis incorrecta' + "</td>" +            
                    "<td align=center>" + " <a class='elimina'><img src='../../imagenes/delete.png' />"  + "</td>" + "</tr>" );
            }
        }
    });
}