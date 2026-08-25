
try {

function buscar() {
  let texto = document.getElementById("buscador").value.toLowerCase();
  let tarjetas = document.querySelectorAll(".col-tarjeta");

  tarjetas.forEach(tarjeta => {
    let titulo = tarjeta.querySelector(".titulo-tarjeta").textContent.toLowerCase();
    if (titulo.includes(texto)) {
      tarjeta.classList.remove("ocultar"); // mostrar coincidencia
    } else {
      tarjeta.classList.add("ocultar"); // ocultar lo que no coincide
    }
  });
}

function limpiar() {
  document.getElementById("buscador").value = "";
  let tarjetas = document.querySelectorAll(".col-tarjeta");
  tarjetas.forEach(tarjeta => {
    tarjeta.classList.remove("ocultar");
  })
}
} catch (error) {
  console.log(`Ha ocurrido un error:${error}`);
}