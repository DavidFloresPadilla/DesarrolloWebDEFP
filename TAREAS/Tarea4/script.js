
function cargarPerfil() {
  const contenedor = document.getElementById("perfil");

  fetch("datos/perfil.json")
    .then(function (respuesta) {
      if (!respuesta.ok) {
        throw new Error("No se pudo cargar el perfil");
      }
      return respuesta.json();
    })
    .then(function (datos) {
      contenedor.innerHTML =
        "<p><strong>Carrera:</strong> " + datos.carrera + "</p>" +
        "<p><strong>Ciudad:</strong> " + datos.ciudad + "</p>" +
        "<p><strong>Hobbies:</strong> " + datos.hobbies.join(", ") + "</p>" +
        "<p>" + datos.descripcion + "</p>";
    })
    .catch(function (error) {
      contenedor.textContent = "Error: " + error.message;
    });
}


const listaPeliculas = document.getElementById("lista-peliculas");
const botonesGenero = document.querySelectorAll("[data-genero]");

function cargarPeliculas(genero) {
  fetch("datos/peliculas.json")
    .then(function (respuesta) {
      return respuesta.json();
    })
    .then(function (peliculas) {
      if (genero !== "todas") {
        peliculas = peliculas.filter(function (p) {
          return p.genero === genero;
        });
      }

      listaPeliculas.innerHTML = "";
      peliculas.forEach(function (p) {
        const li = document.createElement("li");
        li.textContent = p.titulo + " (" + p.anio + ") - " + p.genero;
        listaPeliculas.appendChild(li);
      });

      if (peliculas.length === 0) {
        listaPeliculas.innerHTML = "<li>No hay películas de este género.</li>";
      }
    })
    .catch(function () {
      listaPeliculas.innerHTML = "<li>Error al cargar las películas.</li>";
    });
}

botonesGenero.forEach(function (boton) {
  boton.addEventListener("click", function () {
    botonesGenero.forEach(function (b) {
      b.classList.remove("activo");
    });
    boton.classList.add("activo");
    cargarPeliculas(boton.dataset.genero);
  });
});

const textoFrase = document.getElementById("frase");

function cargarFrase() {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", "datos/frases.json", true);

  xhr.onload = function () {
    if (xhr.status === 200) {
      const frases = JSON.parse(xhr.responseText);
      const indice = Math.floor(Math.random() * frases.length);
      textoFrase.textContent = frases[indice];
    } else {
      textoFrase.textContent = "No se pudo cargar la frase.";
    }
  };

  xhr.onerror = function () {
    textoFrase.textContent = "Error de conexión.";
  };

  xhr.send();
}

document.getElementById("btn-frase").addEventListener("click", cargarFrase);

const formulario = document.getElementById("formulario");
const respuestaForm = document.getElementById("respuesta");

formulario.addEventListener("submit", function (evento) {
  evento.preventDefault();

  const datos = {
    nombre: document.getElementById("nombre").value,
    mensaje: document.getElementById("mensaje").value
  };

  respuestaForm.style.color = "#333";
  respuestaForm.textContent = "Enviando...";

  fetch("https://jsonplaceholder.typicode.com/posts", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(datos)
  })
    .then(function (respuesta) {
      return respuesta.json();
    })
    .then(function (resultado) {
      respuestaForm.style.color = "#27ae60";
      respuestaForm.textContent = "¡Mensaje enviado, " + datos.nombre + "! (id " + resultado.id + ")";
      formulario.reset();
    })
    .catch(function () {
      respuestaForm.style.color = "#c0392b";
      respuestaForm.textContent = "No se pudo enviar. Revisa tu conexión.";
    });
});

cargarPerfil();
cargarPeliculas("todas");
cargarFrase();
