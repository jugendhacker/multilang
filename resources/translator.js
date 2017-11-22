var req = new XMLHttpRequest();
req.open("GET","back.php");
req.addEventListener("load",()=>{
	if(req.status>=200 && req.status < 300){
		var data=JSON.parse(req.responseText);
		for(var t in data){
			var h = document.createElement("th");
			h.innerHTML=data[t].language;
			document.getElementById("tb-head").append(h);
		}
		var langs=[];
		for(var l in data){
			langs.push(l);
		}
		for(var key in data[langs[1]]){
			var h = document.createElement("tr");
			var h1 = document.createElement("td");
			h1.setAttribute("contenteditable","true");
			h1.innerHTML = key;
			h.appendChild(h1);
			for(var lang of langs){
				h1 = document.createElement("td");
				h1.innerHTML = data[lang][key];
				h1.setAttribute("contenteditable","true");
				h.appendChild(h1);
			}
			document.getElementById("tbody").appendChild(h)
		}
	}
});
req.send();
