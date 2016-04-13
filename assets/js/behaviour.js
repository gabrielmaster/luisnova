// UTILITAIRES
function is_all_ws(nod) {
	return !(/[^\t\n\r ]/.test(nod.data));
}
function is_ignorable(nod) {
	return (nod.nodeType == 8) || // A comment node
			((nod.nodeType == 3) && is_all_ws(nod)); // a text node, all ws
}
function node_before(sib) {
	while ((sib = sib.previousSibling)) {
		if (!is_ignorable(sib)) return sib;
	}
	return null;
}
function node_after(sib) {
	while ((sib = sib.nextSibling)) {
		if (!is_ignorable(sib)) return sib;
	}
	return null;
}
function getOffset(el) {
	var _x = 0;
	//var _y = 0;
	while (el && !isNaN(el.offsetLeft) /*&& !isNaN( el.offsetTop )*/) {
		_x += el.offsetLeft - el.scrollLeft;
		//_y += el.offsetTop - el.scrollTop;
		el = el.offsetParent;
	}
	return { /*top: _y,*/ left: _x };
}

var lazyloader;
var ps = 5;
var videos;
var photos;

/*
 if (document.body.id === 'photos' || document.body.id === 'films') {
 var galerie = document.getElementById('galerie');

 // events for window
 if (typeof(document.addEventListener) != 'undefined') {
 window.addEventListener('resize', adaptation, false);
 } else if (typeof(document.attachEvent) != 'undefined') {
 window.attachEvent('on' + 'resize', adaptation);
 } else {
 window['on' + resize] = adaptation;
 }

 function adaptation() {
 var wwidth = getViewportW();
 var gwidth =  wwidth - 20;

 galerie.style.width = gwidth + 'px';
 galerie.style.left = '50%';
 galerie.style.marginLeft = '-' + gwidth/2 + 'px';
 }

 adaptation();
 }
 */

function goLeft(n) {
	var n1 = node_before(n);
	var n2 = n;
	if (n1.nodeName.toLowerCase() === 'div') {
		if (n2.className === 'div last' && n1.className == 'div first') {
			n2.className = 'div first';
			n1.className = 'div last';
		} else if (n2.className === 'div last' && n1.className == 'div') {
			n2.className = 'div';
			n1.className = 'div last';
		} else if (n2.className === 'div' && n1.className == 'div first') {
			n2.className = 'div first';
			n1.className = 'div';
		}
		n1.parentNode.replaceChild(n1, n2);
		n1.parentNode.insertBefore(n2, n1);
		return true;
	} else {
		return false;
	}
}

function goRight(n) {
	var n2 = node_after(n);
	var n1 = n;
	if (n2.nodeName.toLowerCase() === 'div') {
		if (n2.className === 'div last' && n1.className == 'div first') {
			n2.className = 'div first';
			n1.className = 'div last';
		} else if (n2.className === 'div last' && n1.className == 'div') {
			n2.className = 'div';
			n1.className = 'div last';
		} else if (n2.className === 'div' && n1.className == 'div first') {
			n2.className = 'div first';
			n1.className = 'div';
		}
		n1.parentNode.insertBefore(n2, n1);
		return true;
	} else {
		return false;
	}
}

function onOff(n) {
	if (n.parentNode.id === 'assets_on') {
		var nombre = document.getElementById('assets_off').getElementsByTagName('div').length;
		if (nombre === 0) {
			n.className = 'div first';
		}
		if (nombre > 0) {
			document.getElementById('assets_off').getElementsByTagName('div')[nombre - 2].className = 'div';
			n.className = 'div last';
		}
		document.getElementById('assets_off').appendChild(n);

	} else if (n.parentNode.id === 'assets_off') {
		var nambre = document.getElementById('assets_on').getElementsByTagName('div').length;
		if (nambre === 0) {
			n.className = 'div first';
		}
		if (nambre > 0) {
			document.getElementById('assets_on').getElementsByTagName('div')[nambre - 2].className = 'div';
			n.className = 'div last';
		}
		document.getElementById('assets_on').appendChild(n);

	} else if (n.parentNode.id === 'assetsVideo_on') {
		var num = document.getElementById('assetsVideo_off').getElementsByTagName('div').length;
		if (num === 0) {
			n.className = 'div first';
		}
		if (num > 0) {
			document.getElementById('assetsVideo_off').getElementsByTagName('div')[num - 2].className = 'div';
			n.className = 'div last';
		}
		document.getElementById('assetsVideo_off').appendChild(n);

	} else if (n.parentNode.id === 'assetsVideo_off') {
		var num2 = document.getElementById('assetsVideo_on').getElementsByTagName('div').length;

		if (num2 === 0) {
			n.className = 'div first';
		}
		if (nambre > 0) {
			document.getElementById('assetsVideo_on').getElementsByTagName('div')[num2 - 2].className = 'div';
			n.className = 'div last';
		}
		document.getElementById('assetsVideo_on').appendChild(n);
	}
}

function poubelle(n) {
	var answer = confirm('Voulez-vous vraiment effacer ce fichier ?');
	console.log(answer);

	if ((answer === true && n.parentNode.id === 'assets_on')
			|| (answer === true && n.parentNode.id === 'assetsVideo_on')) {
		console.log('effacage : ' + n.id);
		ajaxConnect('POST', '/admin/deleteasset', alertDelete, 'group=assets:on&asset=' + n.id);
	}
	else if ((answer === true && n.parentNode.id === 'assets_off')
			|| (answer === true && n.parentNode.id === 'assetsVideo_off')) {
		console.log('effacage : ' + n.id);
		ajaxConnect('POST', '/admin/deleteasset', alertDelete, 'group=assets:off&asset=' + n.id);
	}
}


//------------------------------------------------------------------------------
// creating a new id
var newId = "";

function createNewFilm() {
	var answer = confirm('Voulez-vous vraiment créer un film ?');
	console.log(answer);
	if (answer === true) {
		newId = uniqid('film');
		ajaxConnect('POST', '/admin/createfilm', alertCreateFilmCallback, 'id=' + newId);
	}
}

//------------------------------------------------------------------------------

function setPoster(n) {
	document.getElementById("name_poster").value = n.id + "_0000";
}

function alertCreateFilmCallback(n) {
	if (newId != '') {
		window.alert('Le film a bien été crée et porte le nom : ' + newId);
		window.location.href = "/admin/interface";
	}
}

function alertDelete() {
	window.alert('Le fichier a bien été effacé.');
	window.location.href = "/admin/interface";
}
function alertSave() {
	window.alert('La nouvelle organisation est enregistrée.');
	window.location.href = "/admin/interface";
}

function maj_client(ev) {
	var event = ev || window.event;
	var target = event.target || event.srcElement;

	stopDef(event);

	var new_list = new Object();

	new_list.assets_on = [];
	new_list.assets_off = [];
	new_list.assets_random = [];

	var assets_on = document.getElementById('assets_on').getElementsByTagName('div');
	var assets_off = document.getElementById('assets_off').getElementsByTagName('div');
	var assetsVideo_on = document.getElementById('assetsVideo_on').getElementsByTagName('div');
	var assetsVideo_off = document.getElementById('assetsVideo_off').getElementsByTagName('div');

	for (var i = 0; i < assets_on.length; i++) {
		if (assets_on[i].id.charAt(0) === 'f' || assets_on[i].id.charAt(0) === 'p') {
			new_list.assets_on.push(assets_on[i].id);
		}
	}
	for (var j = 0; j < assets_off.length; j++) {
		if (assets_off[j].id.charAt(0) === 'f' || assets_off[j].id.charAt(0) === 'p') {
			new_list.assets_off.push(assets_off[j].id);
		}
	}
	for (var i = 0; i < assetsVideo_on.length; i++) {
		if (assetsVideo_on[i].id.charAt(0) === 'f' || assetsVideo_on[i].id.charAt(0) === 'p') {
			new_list.assets_on.push(assetsVideo_on[i].id);
		}
	}
	for (var j = 0; j < assetsVideo_off.length; j++) {
		if (assetsVideo_off[j].id.charAt(0) === 'f' || assetsVideo_off[j].id.charAt(0) === 'p') {
			new_list.assets_off.push(assetsVideo_off[j].id);
		}
	}

	// storing option to render in random order photos and films
	new_list.assets_random.push(document.getElementById('randomPhoto_form').randomPhoto_checkbox.checked ? "true" : "false");
	new_list.assets_random.push(document.getElementById('randomVideo_form').randomVideo_checkbox.checked ? "true" : "false");

	var temp = JSON.stringify(new_list);

	ajaxConnect('POST', '/admin/save', alertSave, 'temp=' + temp);
}

function sync_videos() {
	for (var j = 0; j < videos.length; j++) {
		if (videos[j].id !== this.id) {
			videos[j].pause();
		}
	}
}

function fileUpload(form, action_url, div_id) {
	// Create the iframe...
	var iframe = document.createElement("iframe");
	iframe.setAttribute("id", "upload_iframe");
	iframe.setAttribute("name", "upload_iframe");
	iframe.setAttribute("width", "0");
	iframe.setAttribute("height", "0");
	iframe.setAttribute("border", "0");
	iframe.setAttribute("style", "width: 0; height: 0; border: none;");

	// Add to document...
	form.parentNode.appendChild(iframe);
	window.frames['upload_iframe'].name = "upload_iframe";

	iframeId = document.getElementById("upload_iframe");

	// Add event...
	var eventHandler = function() {

		if (iframeId.detachEvent)
			iframeId.detachEvent("onload", eventHandler);
		else
			iframeId.removeEventListener("load", eventHandler, false);

		// Message from server...
		if (iframeId.contentDocument) {
			content = iframeId.contentDocument.body.innerHTML;
		} else if (iframeId.contentWindow) {
			content = iframeId.contentWindow.document.body.innerHTML;
		} else if (iframeId.document) {
			content = iframeId.document.body.innerHTML;
		}

		document.getElementById(div_id).innerHTML = content;

		// Del the iframe...
		setTimeout(iframeId.parentNode.removeChild(iframeId), 2500);
	};

	// events for iframeId
	if (typeof(document.addEventListener) != 'undefined') {
		iframeId.addEventListener('load', eventHandler, true);
	} else if (typeof(document.attachEvent) != 'undefined') {
		iframeId.attachEvent('on' + 'load', eventHandler);
	} else {
		iframeId['on' + load] = eventHandler;
	}

	// Set properties of form...
	form.setAttribute("target", "upload_iframe");
	form.setAttribute("action", action_url);
	form.setAttribute("method", "post");
	form.setAttribute("enctype", "multipart/form-data");
	form.setAttribute("encoding", "multipart/form-data");

	// Submit the form...
	form.submit();

	document.getElementById(div_id).innerHTML = "Uploading...";
}

function init() {
	videos = document.getElementsByTagName('video');
	photos = document.getElementsByTagName('img');
	//var div = new CursorDivScroll( 'galerie', 150, 30 );
	var u = videos.length;
	var s = 0;


	function f() {
		VideoJS.setup(videos[s]);
		videos[s].preload = "auto";
		if (s < (u - 1)) {
			window.setTimeout(f, 8000);
			s++;
		}
	}

	f();

	lazyloader = window.setInterval(lazy, 500);
}

function lazy() {
	// verifier si on est à - de 1000px du viewport
	// si oui remplacer le src de elem par le bon src
	if (ps < (photos.length - 1)) {
		ps++;
		if (photos[ps].id) {
			//photos[ps].src = '/assets/photos/' + photos[ps].id + '.jpg';
			photos[ps].parentNode.style.backgroundImage = 'url(/assets/photos/' + photos[ps].id + '.jpg)';
		}
	} else {
		clearInterval(lazyloader);
	}
}
