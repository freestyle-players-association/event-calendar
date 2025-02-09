import Cropper from "cropperjs";
import "cropperjs/dist/cropper.css";

document.addEventListener("DOMContentLoaded", function () {
    const imageInput = document.getElementById("imageInput");
    const imagePreview = document.getElementById("imagePreview");
    let cropper;

    imageInput.addEventListener("change", function (event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
                if (cropper) cropper.destroy();

                cropper = new Cropper(imagePreview, {
                    aspectRatio: 16 / 9, // Adjust aspect ratio as needed
                    viewMode: 1
                });
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById("cropButton").addEventListener("click", function () {
        if (cropper) {
            const croppedCanvas = cropper.getCroppedCanvas();
            croppedCanvas.toBlob((blob) => {
                const reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function () {
                    document.getElementById("croppedImageInput").value = reader.result;
                };
            }, "image/jpeg");
        }
    });
});
