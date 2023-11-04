//-----------------------Creación de objeto-----------------------//
  //-----------------------Creación de objeto medio transporte-----------------------//
  function generarObjetoMedioTransporte(){
    return{
      medio_transporte:{
        medio_transporte:$("#f_nombre_medio_transporte").val(),
        active:1,
      }
    }
  }
  //-----------------------End Creación de objeto medio transporte-----------------------//
//-----------------------End Creación de objeto-----------------------//

//-----------------------Eventos del formulario-----------------------//
$("#btn_cancelar_medio_transporte").click(function(){
  $("#f_nombre_medio_transporte").val("");
});
$("#btn_agregar_medio_transporte").click(function(){
  console.log(generarObjetoMedioTransporte());
  $("#f_nombre_medio_transporte").val("");
});
//-----------------------End Eventos del formulario-----------------------//
