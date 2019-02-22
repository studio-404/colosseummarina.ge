class Swipe {
    constructor(element) {
        this.xDown = null;
        this.yDown = null;
        this.element = typeof(element) === 'string' ? document.querySelector(element) : element;

        this.element.addEventListener('touchstart', function(evt) {
            this.xDown = evt.touches[0].clientX;
            this.yDown = evt.touches[0].clientY;
        }.bind(this), false);

    }

    onLeft(callback) {
        this.onLeft = callback;

        return this;
    }

    onRight(callback) {
        this.onRight = callback;

        return this;
    }

    onUp(callback) {
        this.onUp = callback;

        return this;
    }

    onDown(callback) {
        this.onDown = callback;

        return this;
    }

    handleTouchMove(evt) {
        if ( ! this.xDown || ! this.yDown ) {
            return;
        }

        var xUp = evt.touches[0].clientX;
        var yUp = evt.touches[0].clientY;

        this.xDiff = this.xDown - xUp;
        this.yDiff = this.yDown - yUp;

        if ( Math.abs( this.xDiff ) > Math.abs( this.yDiff ) ) { // Most significant.
            if ( this.xDiff > 0 ) {
                this.onLeft();
            } else {
                this.onRight();
            }
        } else {
            if ( this.yDiff > 0 ) {
                this.onUp();
            } else {
                this.onDown();
            }
        }

        // Reset values.
        this.xDown = null;
        this.yDown = null;
    }

    run() {
        this.element.addEventListener('touchmove', function(evt) {
            this.handleTouchMove(evt).bind(this);
        }.bind(this), false);
    }
}

var loaded = 1;

var setCookie = (cname, cvalue, minutes) => {
  var d = new Date();
  d.setTime(d.getTime() + (minutes*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
};

var readCookie = (name) => {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0) === ' ') {
            c = c.substring(1,c.length);
        }
        if (c.indexOf(nameEQ) === 0) {
            return c.substring(nameEQ.length,c.length);
        }
    }
    return null;
};

var locationTarget = (url) => {
	window.open(
	  url,
	  '_blank'
	);
};


window.mobilecheck = function() {
	var check = false;
	(function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
	return check;
};

var gofferPopup = (lists, lang) => {

	if(readCookie("offers2")){
		return null;
	}else{
		setCookie("offers2",true,1);
	}

	//console.log(lists);
	var count = lists.length
	
	

	var mobile = mobilecheck();
	var width = 650;
	if(mobile){
		width = window.innerWidth - 20;
	}

	/*MASK*/
	var mask = document.createElement("div");
	mask.setAttribute("class", "gmask");
	
	/* WRAP */
	var wrap = document.createElement("div");
	wrap.setAttribute("class", "gwrap");
	wrap.style.width = width+"px";
	wrap.style.left = "calc(50% - "+(width / 2)+"px)";

	/* PREV button */
	var prev = document.createElement("div");
	prev.setAttribute("class", "gprev");
	prev.style.top = "calc(50% - 25px)";
	prev.innerHTML = "<button type=\"button\" class=\"mfp-arrow mfp-arrow-left\" style=\"margin: 0; padding: 0; left: -15px; top: -15px;\"></button>";

	prev.addEventListener("click", (e) => {
		if(loaded == 1){// go to last
			container.style.marginLeft ="-"+(width*(count-1))+"px";
			loaded=count;
		}else{// go to prev
			var marginLeft = parseInt(container.style.marginLeft);
			container.style.marginLeft = (marginLeft+width)+"px";
			loaded--;
		}
	});

	if(mobile){
		prev.style.display = "none";
	}

	/* NEXT button */
	var next = document.createElement("div");
	next.setAttribute("class", "gnext");
	next.style.top = "calc(50% - 25px)";
	next.innerHTML = "<button type=\"button\" class=\"mfp-arrow mfp-arrow-right\" style=\"margin: 0; padding: 0; left: -15px; top: -15px;\"></button>";

	next.addEventListener("click", (e) => {
		if(loaded >= count){// go to 0
			container.style.marginLeft ="0px";
			loaded=1;
		}else{//+1
			var marginLeft = parseInt(container.style.marginLeft);
			container.style.marginLeft = (marginLeft-width)+"px";
			loaded++;
		}
	});

	if(mobile){
		next.style.display = "none";
	}


	/*CLOSE Button*/
	var close = document.createElement("div");
	close.setAttribute("class", "gclose");
	close.style.left = "calc(50% - "+(((width / 2) - width) + 45)+"px)";
	close.innerHTML = "×";
	
	close.addEventListener("click", (e) => {
		close.style.display = "none";
		mask.style.display = "none";
		wrap.style.display = "none";
		next.style.display = "none";
		prev.style.display = "none";
	});
	

	/* CONTAINER */
	var container = document.createElement("div");
	container.setAttribute("class", "gcontainer");
	container.style.marginLeft = 0;

	/* SOME CALC */
	var containerWidth = width*count;
	container.style.width =  containerWidth+"px";

	/* LOOP CONTENT */
	for(var i = 0; i < count; i++){
		/* LOOP CONTAINER */
		let item = document.createElement("div");
		item.setAttribute("class", "gitem");
		item.style.width = width+"px";
		item.style.float = "left";

		item.setAttribute("data-url", "http://colosseummarina.ge/"+lang+"/offers/"+lists[i].slug+"/"+lists[i].id);

		item.addEventListener("click", (e) => {
			var url = item.getAttribute("data-url");
			locationTarget(url);
		});

		let itemTitle = document.createElement("div");
		itemTitle.setAttribute("class", "gitem-title");
		itemTitle.innerHTML = lists[i].title; 

		let itemImage = document.createElement("div");
		itemImage.setAttribute("class", "gitem-image");

		let img = document.createElement("img");
		img.src = lists[i].imagen;
		img.style.width = "100%";
		itemImage.appendChild(img);

		let itemContent = document.createElement("div");
		itemContent.setAttribute("class", "gitem-content");
		itemContent.innerHTML = lists[i].meta_desc;
		 
		item.appendChild(itemTitle);
		item.appendChild(itemImage);
		item.appendChild(itemContent);
		container.appendChild(item);
	}

	wrap.appendChild(container);


	// document.getElementsByTagName("body")[0].appendChild(close);
	// document.getElementsByTagName("body")[0].appendChild(prev);
	// document.getElementsByTagName("body")[0].appendChild(next);
	// document.getElementsByTagName("body")[0].appendChild(mask);
	// document.getElementsByTagName("body")[0].appendChild(wrap);


	// Get the element yourself.
	var swiper = new Swipe(document.getElementsByClassName('gcontainer')[0]);
	swiper.onLeft(function() { next.click(); });
	swiper.onRight(function() { prev.click(); });
	swiper.run();
};