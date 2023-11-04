//This is the main Javascript file to access the global functions of the Framework

//SET the IPINFO REQUEST
// executeRequestAsync('http://ipinfo.io/201.191.95.57?token=bce7e4c61e3e38', function(data){
//   console.log(data)
// });




let xhr_processing_pending_request = false;

//Find Class or Repeatable Element
function findall(elem) {
  return document.querySelectorAll(elem);
};

//Find Single ID
function findone(elem) {
  return document.querySelector(elem);
}


function printElem(elem, title = '<?=APP_NAME?>') {
  var mywindow = window.open('', '_blank', 'height=400,width=600');

  mywindow.document.write('<html><head><title>' + title + '</title>');
  mywindow.document.write('<link rel="stylesheet" href="<?=PATH_ASSETS?>bootstrap/css/bootstrap.min.css"/>');
  mywindow.document.write('</head><body >');
  //mywindow.document.write('<h1>' + document.title  + '</h1>');
  mywindow.document.write(findone(elem).innerHTML);
  mywindow.document.write('</body></html>');
  mywindow.document.close(); // necessary for IE >= 10
  mywindow.focus(); // necessary for IE >= 10*/

  mywindow.print();

  return true;
}



function validateEmail(email) {
  const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}

function checkValidNumber(dato) {
  return (!!dato.match(/^[0-9]+$/));
}


//return the value of the get variable selected
function retrieveGET(name) {
  name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
  var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
  return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}




const ContainerLoader = {
  savedSettings:{},
  show:(targetContainer, config = {}) => {

    const SETTINGS = {
      container:targetContainer,
      customStyle:'',
      spinnerID:`${targetContainer}__spinner`,
      spinnerColor:'text-primary',
      background:'rgba(255,255,255, 0.6)',
      showText:false,
      text:'Loading...',
      textColor:''
    }
    this.savedSettings = Object.assign(SETTINGS, config)

    const element = document.querySelector(`#${SETTINGS.container}`)
    element.classList.add('overlay-block', 'overlay')
    element.insertAdjacentHTML( 'beforeend', `
    <div id="${SETTINGS.spinnerID}" class="overlay-layer card" 
      style="background:${SETTINGS.background}; ${SETTINGS.customStyle}">
        <div class="spinner-border ${SETTINGS.spinnerColor}" role="status"> </div>
        <span class="${SETTINGS.showText ? '' : 'd-none'} ${SETTINGS.textColor}">
          ${SETTINGS.text}
        </span>
    </div>` );

  },
  hide:() => {
    document.querySelector(`#${this.savedSettings.container}`).classList.remove('overlay-block', 'overlay')
    document.querySelector(`#${this.savedSettings.container}__spinner`).remove()
  }
} 






const FetchPagination = {
  Instance:'',
  settings:{
    path:'',
    start_called:false,
    current_page:1,
    current_page_label:'current_page_label',
    max_page:1,
    max_page_label:'max_page_label',
    pagesize:10,
    container:'',
    navID:'pagination_nav_container',
    anterior:{
      text:'Anterior',
      color:'btn-light',
      id:'pagina_anterior-btn',
      errorEvt:function(){
        notification('Oops!', 'No hay más páginas para mostrar', 'error');
      },
    },
    anterior_event:()=>{
      this.movePagination(-1)
    },
    siguiente:{
      text:'Siguiente',
      color:'btn-primary',
      id:'pagina_siguiente-btn',
      errorEvt:function(){
        notification('Oops!', 'No hay más páginas para mostrar', 'error');
      }
    },
    siguiente_event:()=>{
      this.movePagination(-1)
    },
    callback:function(data){
      //console.log(data)
    }
  },

  movePagination: function(val){

    const { anterior:PREV, siguiente:NEXT } = this.settings;
    const s = this.settings;
    const PREV_ELM = document.querySelector(`#${this.Instance}-${PREV.id}`);
    const NEXT_ELM = document.querySelector(`#${this.Instance}-${NEXT.id}`);

    PREV_ELM.classList.remove('disabled')
    NEXT_ELM.classList.remove('disabled')


    if( s.current_page == 1 && val < 1 ){
      PREV_ELM.classList.add('disabled')
      PREV.errorEvt()
      return;
    }

    if( s.current_page == s.max_page && val > 0 ) {
      NEXT_ELM.classList.add('disabled')
      NEXT.errorEvt()
      return;
    }


    this.settings.current_page += val;
    document.querySelector(`#${this.Instance}-${this.settings.current_page_label}`).innerHTML = this.settings.current_page;
    this.loadData();

  },

  loadData: function(){
    const s = this.settings;
    fetch(`${s.path}?pagesize=${s.pagesize}&pageno=${s.current_page}`)
    .then( r => r.json() )
    .then( r => {
      this.settings.max_page =  Math.floor( r.document.total_count / s.pagesize ) + 1
      document.querySelector(`#${this.Instance}-max_page_label`).innerHTML = this.settings.max_page;
      this.settings.callback( r )
    })
  },

  start: function( element, path, callback, name = 'FetchPagination', conf = {} ){
    
    this.Instance = name;
    this.settings = Object.assign(this.settings, conf)
    this.settings.callback = callback;
    this.settings.path = path;
    this.settings.container = document.querySelector(`#${element}`)
    this.settings.start_called = true;
    this.renderPagination()
    this.loadData()

  },

  renderPagination: function(){
    if(!this.settings.start_called){
      console.error('Ejecutar el metodo "start()" para mostar los botones.')
      return;
    }
    this.settings.container.insertAdjacentHTML( 'beforeend', this.buttons() )
  },
  
  buttons: function(){
    const { anterior:PREV, siguiente:NEXT } = this.settings;
    return `
    <nav id="${this.settings.navID}">
      <ul class="pagination justify-content-center">
          <li class="page-item" onclick="${this.Instance}.movePagination(-1)">
              <button id="${this.Instance}-${PREV.id}" class="btn ${PREV.color} disabled">${PREV.text}</button>
          </li>
          <li class="page-item disabled">
              <span class="page-link">
                  Página: 
                  <span id="${this.Instance}-current_page_label">${this.settings.current_page}</span> 
                  de 
                  <span id="${this.Instance}-max_page_label">${this.settings.max_page}</span>
              </span>
          </li>
          <li class="page-item" onclick="${this.Instance}.movePagination(1)">
              <button id="${this.Instance}-${NEXT.id}" class="btn ${NEXT.color}">${NEXT.text}</button>
          </li>
      </ul>
    </nav>
    `
  }

}











//Function to show notifications with toastr
function notification(titulo, descripcion, tipo, opciones = {}) {

  toastr.options = {
    "closeButton": false,
    "debug": false,
    "newestOnTop": false,
    "progressBar": false,
    "positionClass": "toast-top-center",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
  };

  Object.assign(toastr.options,opciones);
  toastr[tipo](descripcion,titulo);
}


//function to add an Event Listener to an element
function trigger(elem, listen, action) {
  const array = findall(elem);
  for (var i = 0; i < array.length; i++) {
    array[i].removeEventListener(listen, action);
    array[i].addEventListener(listen, function(e) {
      e.custom__this = this;
      action(e);
    }, false);
  }
};





function dynTrigger(elem, listen, action) {
  if (elem.includes('#')) {
    elem = elem.split('#')[1];
    document.addEventListener('click', function(e) {
      if (e.target && e.target.id == elem) {
        e.custom__this = this;
        action(e);
      }
    });
  } else if (elem.includes('.')) {
    const array = findall(elem);
    elem = elem.split('.')[1];
    for (var i = 0; i < array.length; i++) {
      document.addEventListener(listen, function(e) {
        if (e.target && e.target.classList.contains(elem)) {
          e.custom__this = this;
          action(e);
        }
      });
    }

  }
}


//Objeto para el key Listener.
class OffsetListener {
  //Instanciar el objeto con la configuración deseada,
  //dejar en blanco para los valores por defecto
  constructor(cnf, action = null) {
    this.config = {
      wait: 2000,
      elem: "",
      listen: 'keydown', //vanilla JS listeners
      timeout: false,
      action: function(e) {
        console.log('keyListenerActionHere');
      },
      inmediate: function() {

      }
    };
    if (typeof cnf === 'object') {
      Object.assign(this.config, cnf);
    } else {
      this.config.elem = cnf;
      this.config.action = action;
    }
    let self = this;
    trigger(self.config.elem, self.config.listen, function(e) {
      self.config.inmediate();
      (self.config.timeout) ? clearTimeout(self.config.timeout): null;
      self.config.timeout = setTimeout(none => self.config.action(e), self.config.wait);
    });
  }

}




//Function to load the data into a Select
function LoadSelect(elem, array, label, value, load = true, sep = ' - ') {
  let html = ``;

  let labels = [label];
  if (Array.isArray(label)) {
    labels = label;
  }

  for (var i = 0; i < array.length; i++) {
    let sel_text = '';
    for (var j = 0; j < labels.length; j++) {
      let innsep = (j > 0) ? sep : '';
      sel_text += innsep + array[i][labels[j]]
    }

    let isSelected = (array[i][value] == elem) ? 'selected' : '';
    html += `<option ${isSelected} value="${array[i][value]}">${sel_text}</option>`;
  }
  if (load) findone(elem).innerHTML = html;
  return html;
}


//returns current date in format dd/mm/yyyy
function getDate() {
  var today = new Date();
  var dd = String(today.getDate()).padStart(2, '0');
  var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
  var yyyy = today.getFullYear();
  return yyyy + '-' + mm + '-' + dd;
};



//returns a past date with an offset.
function getPastDate(days = 0) {
  var date = new Date();
  var last = new Date(date.getTime() - (days * 24 * 60 * 60 * 1000));
  var day = last.getDate();
  var month = last.getMonth() + 1;
  var year = last.getFullYear();
  return year + '-' + month + '-' + day;
};



//function to format the number with commas
function formatNum(n) {
  return parseFloat(n).format(2, 3, '.', ',');
};


//returns number rounded to 2 decimals
function rnd(n, decimals = 2) {
  var r = null;
  if (typeof n === 'string') {
    r = +parseFloat(n).toFixed(decimals);
  } else {
    r = +n.toFixed(decimals);
  }
  return r;
};




function tokenExpired() {
  let current = String(new Date().getTime()).substring(0, 10);
  let expire = localStorage.getItem("JWT_expire");
  return (current > expire);
}



function generateToken(url, callback, config, type = 'request') {

  let xhr = new XMLHttpRequest();
  xhr.open('post', '<?=PATH_TOKEN?>');
  const data = {
    username: '<?=GENERAL?>',
    password: '<?=SPECIFIC?>'
  };
  xhr.send(JSON.stringify(data));
  xhr.onreadystatechange = function() {
    //&& xhr.status === 200
    if (xhr.readyState === XMLHttpRequest.DONE) {

      let response = JSON.parse(xhr.responseText);
      //console.log(xhr);

      if (response.code == 0) {
        alert('There has been an error connecting to the application, please come back later.');
      } else {
        const token = response.document.access_token;
        const expire = response.document.expires_in;
        localStorage.setItem("JWT_token", token);
        localStorage.setItem("JWT_expire", expire);
        if (type == 'request') {
          executeRequest(url, callback, config);
        } else {
          executeRequestAsync(url, callback, config);
        }
      }
    }
  };

}



const recurrent = {
  start: function(f, start = true, t = 30000) {
    if (start) {
      f();
    }
    return setInterval(function() {
      f();
    }, t);
  },
  stop: function(v) {
    clearInterval(v);
  }
};



function request(url, callback, config) {
  if (!localStorage.getItem("JWT_token") || tokenExpired()) {
    generateToken(url, callback, config);
    return;
  }
  executeRequest(url, callback, config);
}


//function to execute Requests to the backend API
function executeRequest(url, callback, config) {

  let token = localStorage.getItem('JWT_token');

  const c = {
    json_data: true,
    log_response: false,
    f_data: new FormData(),
    headers: [{
      name: 'Authorization',
      value: 'Bearer ' + token
    }],
    type: 'post',
    data: {}
  };

  Object.assign(c, config);

  //add the definition of the type of app
  if (c.json_data) {
    c.headers.push({
      name: 'Content-Type',
      value: 'application/json'
    });
  }

  //Validate if there is an open request already
  if (!xhr_processing_pending_request) {

    xhr_processing_pending_request = true;

    let xhr = new XMLHttpRequest();


    xhr.open(c.type, url);
    for (var i = 0; i < c.headers.length; i++) {
      let header = c.headers[i];
      xhr.setRequestHeader(header.name, header.value);
    }

    if (c.json_data) {
      xhr.send(JSON.stringify(c.data));
    } else {
      xhr.send(c.f_data);
    }

    xhr.onreadystatechange = function() {

      //&& xhr.status === 200
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (c.log_response) {
          console.log(xhr);
        }
        callback(JSON.parse(xhr.responseText));
      }
      xhr_processing_pending_request = false;
    };

  } else {
    alert('We are currently processing your previous request, please wait.');
  }


};






function requestAsync(url, callback, config) {
  if (!localStorage.getItem("JWT_token") || tokenExpired()) {
    generateToken(url, callback, config, 'requestAsync');
    return;
  }
  executeRequestAsync(url, callback, config, 'requestAsync');
}



function executeRequestAsync(url, callback, config) {

  let token = localStorage.getItem('JWT_token');

  const c = {
    json_data: true,
    log_response: false,
    f_data: new FormData(),
    headers: [{
      name: 'Authorization',
      value: 'Bearer ' + token
    }],
    type: 'post',
    data: {}
  };

  Object.assign(c, config);

  //add the definition of the type of app
  if (c.json_data) {
    c.headers.push({
      name: 'Content-Type',
      value: 'application/json'
    });
  }

  let xhr = new XMLHttpRequest();


  xhr.open(c.type, url);
  for (var i = 0; i < c.headers.length; i++) {
    let header = c.headers[i];
    xhr.setRequestHeader(header.name, header.value);
  }

  if (c.json_data) {
    xhr.send(JSON.stringify(c.data));
  } else {
    xhr.send(c.f_data);
  }

  xhr.onreadystatechange = function() {

    //&& xhr.status === 200
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (c.log_response) {
        console.log(xhr);
      }
      callback(JSON.parse(xhr.responseText));
    }
  };
};




const Loader = {
  show: function(text = 'Cargando...', config) {

    const c = {
      clickToClose: false,
      background: 'rgba(0,0,0, 0.9)',
      svgColor: '#fed136',
      textColor: '#fed136',
      type: 'CurveBar'
    };

    Object.assign(c, config);

    Fnon.Wait.Init(c);
    Fnon.Wait[c.type]();
    Fnon.Wait.Change(text);
  },
  hide: function(time = 500) {
    Fnon.Wait.Remove(time);
  }
};




function FnonDispose() {
  fireEvent('.f__btn', 'click');
}



function fireEvent(el, etype) {
  el = (el.includes('#')) ? findone(el) : findall(el)[0]
  if (el.fireEvent) {
    el.fireEvent('on' + etype);
  } else {
    var evObj = document.createEvent('Events');
    evObj.initEvent(etype, true, false);
    el.dispatchEvent(evObj);
  }
}



//Global Definitons
Number.prototype.format = function(n, x, s, c) {
  var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
    num = this.toFixed(Math.max(0, ~~n));
  return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
};

Object.defineProperty(Array.prototype, 'shuffle', {
  value: function() {
    for (let i = this.length - 1; i > 0; i--) {
      const j = Math.floor(Math.random() * (i + 1));
      [this[i], this[j]] = [this[j], this[i]];
    }
    return this;
  }
});

Date.isLeapYear = function(year) {
  return (((year % 4 === 0) && (year % 100 !== 0)) || (year % 400 === 0));
};

Date.getDaysInMonth = function(year, month) {
  return [31, (Date.isLeapYear(year) ? 29 : 28), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
};

Date.prototype.isLeapYear = function() {
  return Date.isLeapYear(this.getFullYear());
};

Date.prototype.getDaysInMonth = function() {
  return Date.getDaysInMonth(this.getFullYear(), this.getMonth());
};

Date.prototype.addMonths = function(value) {
  var n = this.getDate();
  this.setDate(1);
  this.setMonth(this.getMonth() + value);
  this.setDate(Math.min(n, this.getDaysInMonth()));
  return this;
};
