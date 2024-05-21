// Array amb les rutes de les imatges que vols mostrar
var images = [
    "Imatge1.jpg",
    "Imatge2.jpg",
    "Imatge3.jpg"
];

// Variable per portar el compte de la imatge actual
var currentImageIndex = 0;

// Funció per canviar la imatge
function changeImage() {
    // Obtenir l'element de la imatge pel seu ID
    var imgElement = document.getElementById("imatge");

    // Canviar l'atribut src de la imatge a l'element següent de l'array
    imgElement.src = images[currentImageIndex];

    // Incrementar l'índex de la imatge actual
    currentImageIndex++;

    // Si arribem al final de l'array, tornar a l'inici
    if (currentImageIndex === images.length) {
        currentImageIndex = 0;
    }
}

// Cridar a la funció changeImage cada cert interval de temps (per exemple, cada 3 segons)
setInterval(changeImage, 3000);

