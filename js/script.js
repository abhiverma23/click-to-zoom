// Get the image and insert it inside the modal - use its "alt" text as a caption
var imgs = document.getElementsByTagName("img");

var modalImg = document.getElementById("click-to-zoom-img");
if (modalImg == null) {
    var rootNode = document.getRootNode();
    var div = document.createElement('div');
    div.setAttribute("class", "click-to-zoom-modal");
    div.setAttribute("id", "click-to-zoom-id");
    // div.setAttribute("style", "")
    div.innerHTML = '<span class="click-to-zoom-close">&times;</span>\n' +
        '    <img class="click-to-zoom-modal-content" id="click-to-zoom-img">\n' +
        '    <div id="click-to-zoom-caption"></div>';
    rootNode.body.appendChild(div);
    modalImg = document.getElementById("click-to-zoom-img");
}
// Get the modal
var modal = document.getElementById("click-to-zoom-id");

// Get captionText
var captionText = document.getElementById("click-to-zoom-caption");

for (img in imgs) {
    if (typeof imgs[img].hasAttribute === 'function' && imgs[img].hasAttribute('click-to-zoom')) {
        if(imgs[img].getAttribute('class') == null ||  imgs[img].getAttribute('class') == '') {
            imgs[img].setAttribute('class', "click-to-zoom-img");
        }
        imgs[img].onclick = function () {
            modal.style.display = "block";
            modalImg.src = this.src;
            captionText.innerHTML = this.alt;
        }
    }
}

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("click-to-zoom-close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}