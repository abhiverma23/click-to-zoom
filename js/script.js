class ClickToZoom {
    static isAttributeSearch = true;
    static attribute = 'click-to-zoom';
    static isClassSearch = false;
    static class = null;
    static modal;
    static modalImg;
    static captionText;
    constructor(configuration) {
        ClickToZoom.isAttributeSearch = configuration.attribute != null ? true : false;
        ClickToZoom.attribute = configuration.attribute;
        ClickToZoom.isClassSearch = configuration.class != null && configuration.attribute == null ? true : false;
        ClickToZoom.class = configuration.class;

        document.addEventListener('DOMContentLoaded', ClickToZoom.init);
    }

    static init() {

        // Get the image and insert it inside the modal - use its "alt" text as a caption
        const imgs = document.getElementsByTagName("img");

        ClickToZoom.modalImg = document.getElementById("click-to-zoom-img");
        if (ClickToZoom.modalImg == null) {
            const rootNode = document.getRootNode();
            const div = document.createElement('div');
            div.setAttribute("class", "click-to-zoom-modal");
            div.setAttribute("id", "click-to-zoom-id");
            // div.setAttribute("style", "")
            div.innerHTML = `<span class="click-to-zoom-close">&times;</span>
                <img class="click-to-zoom-modal-content" id="click-to-zoom-img">
                <div id="click-to-zoom-caption"></div>`;
            rootNode.body.appendChild(div);
            div.ondblclick = function () {
                ClickToZoom.modal.style.display = "none";
            }
            ClickToZoom.modalImg = document.getElementById("click-to-zoom-img");
        }
        // Get the modal
        ClickToZoom.modal = document.getElementById("click-to-zoom-id");


        // Get captionText
        ClickToZoom.captionText = document.getElementById("click-to-zoom-caption");

        for (let img in imgs) {
            if (typeof imgs[img].hasAttribute === 'function' && imgs[img].hasAttribute('click-to-zoom')) {
                if (imgs[img].getAttribute('class') == null || imgs[img].getAttribute('class') == '') {
                    imgs[img].setAttribute('class', "click-to-zoom-img");
                }
                imgs[img].onclick = function () {
                    ClickToZoom.modal.style.display = "block";
                    ClickToZoom.modalImg.src = this.src;
                    ClickToZoom.captionText.innerHTML = this.alt;
                }
            }
        }

        // Get the <span> element that closes the modal
        const span = document.getElementsByClassName("click-to-zoom-close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function () {
            ClickToZoom.modal.style.display = "none";
        }
    }
}