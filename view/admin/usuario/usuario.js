// Variables globales
let g__usuarios = [];
let g__usuarios_datatable = null;
let g__search_timeout = null;
let g__selected_user_id = null;
let g__current_page = 1;
let g__max_page = 1;
let g__total_users_count = null;
let g__pagesize = 10;



//Init
init();


async function init(){

  let loaderInit = ContainerLoader;
  loaderInit.show('usuarios-card');


  FetchPagination.start( 
    'users_pagination_container', 
    '<?=PATH_API?>usuario/read.php',
    function(data){
      renderTableUsuarios(data.document.records)
    },
    'FetchPagination'
  )
  loaderInit.hide();

}




document.addEventListener('keypress', e => {
  if(e.target && e.target.id == 'buscar_persona-nombre'){
    
    clearTimeout(g__search_timeout)
    g__search_timeout = setTimeout(()=>{
      executeCargaPersonas(e.target.value)
    },1500)

  }
})



async function executeCargaPersonas(value){

  ContainerLoader.show('add_usuario_modal_body')
  let response = await cargaPersonas(value)

  content = '<option value="null"> No hay resultados </option>'
  if(response.length > 0){
    content = ''
    response.forEach(persona => {
      const {id_persona:id, nombre, primer_apellido:ap1, segundo_apellido:ap2} = persona
      content += `<option value="${id}"> ${nombre}  ${ap1}  ${ap2} </option>`
    });
    
  }
  
  ContainerLoader.hide()
  document.querySelector('#f_selec_persona').innerHTML = content;
  
}






async function crearUsuarioEvent(){

  //Obtener los datos del form
  const USER_DATA = {
    id_persona:document.querySelector('#f_selec_persona').value,
    nombre_usuario:document.querySelector('#f_nombre_usuario').value,
    login_password:document.querySelector('#f_login_password').value
  }

  const {id_persona:id, nombre_usuario:nom, login_password:pass} = USER_DATA
  if(id == '' || nom == '' || pass == '' || id == null){
    notification('Ooops!', 'Porfavor llenar todos los datos', 'error');
    return false;
  }
  
  let result = await crearUsuario(USER_DATA)
  if(result){
    init();
  }
  
  document.querySelector('#buscar_persona-nombre').value = '';
  document.querySelector('#f_selec_persona').innerHTML = '';
  document.querySelector('#f_nombre_usuario').value = '';
  document.querySelector('#f_login_password').value = '';
  $('#modal_agregar').modal('hide')
}




function renderTableUsuarios(data){

  if (g__usuarios_datatable) {
    g__usuarios_datatable.destroy();
  }
    g__usuarios_datatable = $('#datatable_usuarios').DataTable({
      data: data,
      destroy: true,
      searching: true,
      responsive: true,
      info:false,
      paging: false,
      columns: [{
          data: 'id_usuario'
        },
        {
          data: 'id_persona'
        },
        {
          data: 'nombre',
          render: (data, type, row) => {
            return `${row.nombre} ${row.primer_apellido} ${row.segundo_apellido}`
          }
        },
        {
          data: 'nombre_usuario'
        },
        {
          data: 'id_usuario',
          render: function(data, type, row) {
            return `
            <button class="btn btn-primary" onclick="editar(${Number(data)})" >
              <i class="fas fa-edit"></i>
            </button>
            <button class="btn btn-danger" onclick="eliminarUsuario(${Number(data)})" >
              <i class="fas fa-ban"></i>
            </button>`;
          }
        }
      ]
    });


}



function editarUsuario(id){

}




function eliminarUsuario(id){
  g__selected_user_id = id;
  $('#modal_eliminar').modal('show');
}


async function executeEliminarUsuario(){
  ContainerLoader.show('delete_usuario_modal_content')
  let x = await deleteUsuario(g__selected_user_id)
  ContainerLoader.hide();
  $('#modal_eliminar').modal('hide');
  init();
  notification('Usuario eliminado!', 'El usuario ha sido eliminado!', 'success')
}





// function movePage(val){

//   document.querySelector('#pagina_anterior-btn').classList.remove('disabled')
//   document.querySelector('#pagina_siguiente-btn').classList.remove('disabled')

//   if( g__current_page == 1 && val < 1 ){
//     document.querySelector('#pagina_anterior-btn').classList.add('disabled')
//     notification('Oops!', 'No hay más páginas para mostrar', 'error').
//     return;
//   }

//   if( g__current_page == g__max_page && val > 0 ) {
//     document.querySelector('#pagina_siguiente-btn').classList.add('disabled')
//     notification('Oops!', 'No hay más páginas para mostrar', 'error').
//     return;
//   }
  

//   g__current_page += val;
//   document.querySelector('#current_page_label').innerHTML = g__current_page;
//   init();

// }












// Funciones de carga

function cargaUsuarios(){


  return new Promise( resolve => {

    fetch(`<?=PATH_API?>usuario/read.php?pageno=${g__current_page}&pagesize=${g__pagesize}`)
    .then( r => r.json() )
    .then( r => {
      g__total_users_count = r.document.total_count
      g__max_page = Math.floor( g__total_users_count / g__pagesize ) + 1
      document.querySelector('#max_page_label').innerHTML = g__max_page;
      resolve( r.code ? r.document.records : [] )
    })

  })


}



function cargaPersonas(value){


  return new Promise( resolve => {

    fetch(`<?=PATH_API?>persona/searchUsuario.php?key=${value}`)
    .then( r => r.json() )
    .then( r => {
      resolve( r.code ? r.document.records : [] )
    })

  })


}





function crearUsuario(data){
  return new Promise( resolve => {
    fetch(`<?=PATH_API?>usuario/create.php`, {
      method:'POST',
      body:JSON.stringify(data)
    })
    .then( r => r.json() )
    .then( r => resolve( r.code ) )
  })
}




function deleteUsuario(id){
  return new Promise( resolve => {
    fetch('<?=PATH_API?>usuario/delete.php', {
      method:'POST',
      body:JSON.stringify({id_usuario:id})
    })
    .then( r => r.json() )
    .then( r => {
      resolve( r.code )
    })
  })
}