var 	responseImages,
		footerId,
		output = '',
		page = 0,
		footer = "footer" + page,
		countSomething_i = 0,
		countStart = 0,
		session,
		fetchedAmount = 0;

getImages();
function intersectObj(){
	let options = {
		root: null,
		rootMargin: "0px",
		threshold: 0.5
	}
	const observer = new IntersectionObserver((p) =>{
		if(p[0].isIntersecting){
			countStart += 3
			getImages();
		}
	}, options);
	observer.observe(document.getElementById(footer));
}
function getImages(){
	const xhr = new XMLHttpRequest();

	xhr.open("POST", "fetchGallary.php", true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.send("countStart=" + countStart);
	xhr.onreadystatechange = function(e){
		if (xhr.readyState == 4 && xhr.status == 200){
			responseImages = xhr.responseText;
			responseImages = JSON.parse(responseImages);
			fetchedAmount = responseImages[0]['fetchedAmount'] + 1;
			putThree();
		}
	}
}
function putThree(){
	if (fetchedAmount > 1){
		for(i = 1; i < fetchedAmount; i++){
			var id = responseImages[i]['id'];
			output +=	`<div class="img_con">
			<form method="POST" action="gallary_delete.php">
			<img class="imageCont" height="300" width="100%" src="data:image;base64,${responseImages[i]['image']}">
			<input type="text" name="id" style="display: none;">
			<a href="gallary_delete.php?id=${id}" class="delete_btn">Delete</a>
			</form></div>`;
			if (i + 1 == fetchedAmount){
				if(footerId = document.getElementById(footer)){
					page++;
					footer = 'footer'+page;
				}
				output += `<footer id="${footer}" style="rgb(0, 0, 0); text-align:center; color: white; padding: 1px;"></footer>`;
				document.getElementById('gallary').innerHTML = output;
			}
		}
		intersectObj();
	}
}