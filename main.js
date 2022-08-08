
const url = 'http://localhost/DCaC/productos.php'

fetch(url)
.then(response => response.json())
.then(data => monstrarData(data))
.catch(error => console.log(error))

const monstrarData = (data) =>{
    console.log(data)
    let body = ''
    for(let i = 0; i<data.length; i++){
        body += `<tr><td>${data[i].id_producto}</td><td>${data[i].nombre}</td><td>${data[i].precio_pesos}</td></tr>`
    }
    document.getElementById('data').innerHTML = body
}



