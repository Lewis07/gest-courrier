$(document).ready(function () {
    $(".image-preview").change(function () {
        filePreview(this);
    });

    function filePreview(input){
        if(input.files && input.files[0]){
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.avatar-preview').attr({'src': e.target.result,'width':450,'height':300,'border-radius':50});
                $('.avatar-preview').addClass('border-radius-100');
            }
            reader.readAsDataURL(input.files[0])
        }
    }
});