var changes;

function setup(){
	changes=[];
	var el=document.getElementsByTagName('button');
	for(var e of el){
		e.disabled=true;
	}
	var req = new XMLHttpRequest();
	req.open("GET","back.php",true);
	req.addEventListener("load",()=>{
		if(req.status>=200 && req.status < 300){
			var data=JSON.parse(req.responseText);
			document.getElementById('tb-head').innerHTML="";
			document.getElementById('tbody').innerHTML="";
			var h = document.createElement("th");
			h.innerHTML = "Key";
			document.getElementById('tb-head').append(h);
			for(var t in data){
				h = document.createElement("th");
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
				h1.setAttribute("prev",key);
				h1.innerHTML = key;
				h.appendChild(h1);
				for(var lang of langs){
					h1 = document.createElement("td");
					h1.setAttribute("contenteditable","true");
					h1.setAttribute("lang",lang);
					h1.innerHTML = data[lang][key];
					h.appendChild(h1);
				}
				document.getElementById("tbody").appendChild(h)
			}
			// listeners for every editable column
			var elems = document.querySelectorAll('td');
			for(var i = 0; i < elems.length; i++){
				elems[i].oninput=(evt)=>{
					var lang=evt.target.getAttribute('lang');
					var key=evt.target.parentNode.querySelector('td').innerHTML;
					changes.push({
						lang: lang,
						key: key,
						value: evt.target.innerHTML.replace(/<br>/g,'')
					});
					var el=document.getElementsByTagName('button');
					for(var e of el){
						e.disabled=false;
					}
				};
			}
			// override listeners for key fields
			elems = document.querySelectorAll('td:first-child');
			for(var i = 0; i < elems.length; i++){
				elems[i].oninput=(evt)=>{
					var lang=evt.target.getAttribute('lang');
					var prev=evt.target.getAttribute('prev');
					evt.target.setAttribute('prev',evt.target.innerHTML.replace(/<br>/g,''));
					changes.push({
						lang: lang,
						prev: prev,
						new: evt.target.innerHTML.replace(/<br>/g,'')
					});
					var el=document.getElementsByTagName('button');
					for(var e of el){
						e.disabled=false;
					}
				};
			}
		}
	});
	req.send();
}

function saveChanges(){
	if(changes.length==0)
		return;
	var req = new XMLHttpRequest();
	req.open("POST","back.php",true);
	req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8");
	req.send('update='+JSON.stringify(changes));
	var el=document.getElementsByTagName('button');
	for(var e of el){
		e.disabled=true;
	}
}
