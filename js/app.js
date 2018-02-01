var image = document.getElementById('imageFile');
var saveImage = document.getElementById('saveImage');
saveImage.addEventListener('click', uploadImage);

function uploadImage(e) {
     e.preventDefault();
     if (image.files.length > 0) {
          console.log(image.files[0])
          var form = new FormData();
          form.append('image', image.files[0]);

          $.ajax({
               url: "server/upload.php",
               method: "POST",
               data: form,
               contentType: false,
               processData: false,
               success: function (data) {
                    if (data == 'Image upload successful') {
                          alert('Image upload successful');
                    } else {
                         alert('Image upload failed');
                    }
                   
               },
               error: function (error) {
                    console.log(error)
               }
          })
     } else {
          alert("Select an Image to proceed");
     }
     
}