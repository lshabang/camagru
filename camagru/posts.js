var 	responseImages,
		footerId,
		output = '',
		page = 0,
		footer = "footer" + page,
		countSomething_i = 0,
		countStart = 0,
		session,
		imageNumber = 0,
		ifetchedAmount = 0;

const xhr = new XMLHttpRequest();
xhr.open("POST", "checkSession.php", true);
xhr.send();
xhr.onreadystatechange = () => {
	if (xhr.readyState == 4 && xhr.status == 200){
		session = xhr.responseText;
		getImages();
	}
}
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

	xhr.open("POST", "fetchImages.php", true);
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
function addLikes(){
	let likeBtnText = document.querySelectorAll('.like_btn');
	likeBtnText.forEach((btn)=>{
		fetching(btn);
	});
}
async function fetching(btn){
	const promise = new Promise((resolve, reject) => {
		const xhr = new XMLHttpRequest();
		let img_id = btn.id;
		xhr.open("GET", "fetchLikes.php?img_id="+img_id, true);
		xhr.send();
		xhr.onreadystatechange = () =>{
			if (xhr.readyState == 4 && xhr.status == 200){
				btn.innerText = xhr.responseText;
				resolve("as promised");
			}
		};
	});
	let msg = await promise;
	console.log(msg);
}
function putThree(){
	if(fetchedAmount > 1){		
		for(i = 1; i < fetchedAmount; i++){
			var id = responseImages[i]['id'];
			var userName = responseImages[i]['username'];
			var email = responseImages[i]['email'];
			output +=	`<div class="img_cont2">
			<div class="info">${userName}</div>
			<img class="imageCont" height="300" width="350" src="data:image;base64,${responseImages[i]['image']}">`;
			
			if(session === '1'){
				output += `<input type="text" name="img_id" style="display: none; value="${id}">
				<input type="text" name="img_uid" style="display: none; value="${userName}">
				<input type="text" name="img_email" style="display: none; value="${email}">
				<div class="post_buttons"><button onclick="like(${id},${imageNumber})" class="like_btn" id="${id}"></button>
				<a href="comments.php?id=${id}&imageby=${userName}">comments</a></div>`;
			}
			output += `</div>`;
			imageNumber++;
			if (i + 1 == fetchedAmount){
				if(footerId = document.getElementById(footer)){
					page++;
					footer = 'footer'+page;
				}
				output += `<footer id="${footer}" style="rgb(0, 0, 0); text-align:center; color: white; padding: 1px;"></footer>`;
				document.getElementById('gallary').innerHTML = output;		
			}
		}
		addLikes();
		intersectObj();
	}
}
function like(img_id, imagenum){
	const xhr = new XMLHttpRequest();
	xhr.open("GET", "like.php?img_id="+img_id, true);
	xhr.send();
	xhr.onreadystatechange = () => {
		if(xhr.readyState == 4 && xhr.status == 200){
			var img_cont = document.querySelectorAll(".like_btn");
			updateLike(img_id, imagenum, img_cont);
		}
	};
}
function updateLike(img_id, imagenum, img_cont){
	const xhr = new XMLHttpRequest();
	xhr.open("GET", "fetchLikes.php?img_id="+img_id, true);
	xhr.send();
	xhr.onreadystatechange = (e) => {
		if(xhr.readyState == 4 && xhr.status == 200){

			response = xhr.responseText;
			img_cont[imagenum].innerText = response;
		}
	};
}