function insertarAbajo(el, referenceNode) {
    referenceNode.parentNode.insertBefore(el, referenceNode.nextSibling);
}

function limpiarErrores(lista){
    for (let item of lista) {
        item.innerHTML='';
    }
}
function spanErrores(error){
    errores = error.responseJSON.errors;
    //obtiene los spans donde se muestran los errores de las validaciones y se setea el texto a vacio
    spans = document.getElementsByClassName("spanclass");
    for (let item in spans) {
        spans[item].innerHTML = "";
    }
    //itera sobre los errores de las validaciones
    for (let key in errores) {
        if (errores.hasOwnProperty(key)) {
            //si el elemento ya existe solo agrega el texto de error
            if (document.getElementById(key + "_span")) {
                var newEl = document.getElementById(key + "_span");
                newEl.innerHTML = errores[key];
            } else {
                //para cada error se crea un objeto span con id y clase para identificarlas, además de que sean color rojo y agrega el texto dle error
                var newEl = document.createElement('span');
                newEl.setAttribute("id", key + "_span");
                newEl.setAttribute("class", "spanclass " + key);
                newEl.setAttribute("style", "color:red");
                newEl.innerHTML = errores[key];
                var ref = document.getElementById(key);
                insertarAbajo(newEl, ref);
            }

        }

    }
}