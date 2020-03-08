const video = document.getElementById('video');
const snap = document.getElementById('snap');
const upload = document.getElementById('upload');
const file = document.querySelector('input[type="file"]');
const save = document.getElementById('save');
const cancel = document.getElementById('cancel');
const canvas = document.getElementById('canvas');
const imgsrc = document.getElementById('imgsrc');
const errorMsgElement = document.getElementById('span#ErrorMsg');

const flower = document.getElementById('flower');
const sun = document.getElementById('sun');
const star = document.getElementById('star');
const heart = document.getElementById('heart');
const enter = document.getElementById('enter');
const typical = document.getElementById('typical');

const stickers = document.getElementById("stickers");
stickers.style = "display: none;";
const gifs = document.getElementById("gifs");
var ret;

const constraints = {
    audio: false,
    video:{
        width: 350, height: 360
    }
};
async function init()
{
    try
    {
        const stream = await navigator.mediaDevices.getUserMedia(constraints);
        handleSuccess(stream);
    }
    catch(e)
    {
        errorMsgElement.innerHTML = `navigator.getUserMedia.error:${e.toString()}`;
    }
}
function handleSuccess(stream)
{
    window.stream = stream;
    video.srcObject = stream; 
}

init();

var context = canvas.getContext('2d');
snap.addEventListener("click", function(e){
    e.preventDefault();
    context.drawImage(video, 0, 0, 350, 300);
	video.style = "display: none;";
	snap.style = "display: none;";
	upload.style = "display: none;";
	imgsrc.style = "display: block";
    save.style = "display: inline-block";
    cancel.style = "display: inline-block";
    stickers.style = "display: block;";
	
    dataURL = canvas.toDataURL('image/jpeg');
    imgsrc.src = dataURL;
	
	flower.addEventListener('click', function(){
        addStick("stickers/flower.png");
    });
    star.addEventListener('click', function(){
        addStick("stickers/star.png");
    });
    sun.addEventListener('click', function(){
        addStick("stickers/sun.png");
    });
    heart.addEventListener('click', function(){
        addStick("stickers/heart.png");
    });
    enter.addEventListener('click', function(){
        addStick("stickers/enter.png");
    });
    typical.addEventListener('click', function(){
        addStick("stickers/typical.png");
    });
    function addStick(path){
        dataURL = dataURL.replace("data:image/jpeg;base64,", "");
        var xhr = new XMLHttpRequest();
    
        xhr.open("POST", "merge.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("img1=" + encodeURIComponent(dataURL)+"&img2=" + path);
        xhr.onreadystatechange = function() {
            if(xhr.readyState == 4 && xhr.status == 200) {
                console.log("picture merged");
                imgsrc.src = xhr.responseText;
                path = imgsrc.src;
                dataURL = path;
            }
        }
    }
});

var dataURL;
var dataURL1;
cancel.addEventListener("click", function(){
    video.style = "display: block;";
    snap.style = "display: inline-block;";
    upload.style = "display: inline-block;";
    imgsrc.style = "display: none";
    save.style = "display: none";
    cancel.style = "display: none";
    stickers.style = "display: none;";
    imgsrc.src = ""; 
    dataURL = "";
    dataURL1 = "";
    path = "";
    context.clearRect(0,0,350,300);
    console.log("canvas cleared"); 
});
save.addEventListener("click", function(){
    if (imgsrc.src.startsWith("data:image/jpeg;base64,") || imgsrc.src.startsWith("data:image/jpg;base64,")){
        dataURL1 = imgsrc.src.replace("data:image/jpeg;base64,", "");
        console.log("image is a jpeg");
    }else if (imgsrc.src.startsWith("data:image/png;base64,")){
        dataURL1 = imgsrc.src.replace("data:image/png;base64,", "");
        console.log("image is a png");
    }else if (imgsrc.src.startsWith("data:image/gif;base64,")){
        dataURL1 = imgsrc.src.replace("data:image/gif;base64,", "");
        console.log("image is a png");
    }
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "save_image.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("img=" + encodeURIComponent(dataURL1));
    xhr.onreadystatechange = function() {
        if(xhr.readyState == 4 && xhr.status == 200) {
            console.log("saved");
        }
    }
	cancel.click();
});

upload.addEventListener("click", function(){
	file.click();
});
var path;
file.addEventListener("change", function(){
    var file = this.files[0];
    var fileType = file.type;
    if(file){
        const reader = new FileReader();
        reader.addEventListener('load', function(){
            path = reader.result;
            imgsrc.src = path;
        });
        reader.readAsDataURL(file);
		
		video.style = "display: none;";
		snap.style = "display: none;";
		upload.style = "display: none;";
		imgsrc.style = "display: block";
        save.style = "display: inline-block";
        stickers.style = "display: block;";
        cancel.style = "display: inline-block";

		flower.addEventListener('click', function(){
			addStick("stickers/flower.png");
		});
		star.addEventListener('click', function(){
			addStick("stickers/star.png");
		});
		sun.addEventListener('click', function(){
			addStick("stickers/sun.png");
		});
		heart.addEventListener('click', function(){
			addStick("stickers/heart.png");
		});
		enter.addEventListener('click', function(){
			addStick("stickers/enter.png");
		});
		typical.addEventListener('click', function(){
			addStick("stickers/typical.png");
		});
		function addStick(path2, e){
			var xhr = new XMLHttpRequest();
            path = path.replace("data:image/jpeg;base64,", "");
            if (fileType == 'image/jpeg'){
                xhr.open("POST", "merge.php", true);
            }else{
                xhr.open("POST", "merge_upload.php", true);
            }
			xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xhr.send("img1=" + encodeURIComponent(path) + "&img2=" + path2 + "&fileType=" + fileType);
			xhr.onreadystatechange = function(){
				if(xhr.readyState == 4 && xhr.status == 200){
                    console.log(xhr.responseText);
                    imgsrc.src = xhr.responseText;
                    path = imgsrc.src;
				}
            }
		}
		
	}
});