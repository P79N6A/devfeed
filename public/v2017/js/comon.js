var na = navigator.userAgent;
var brow = {
	isLowBrow:!-[1,],
	isIE:/MSIE/i.test(na),
	loadAds:/Android|iPhone|iTouch|BlackBerry|IEMobile/i.test(na),
	isMobile:/Android|iPhone|iTouch|iPad|BlackBerry|IEMobile|Mobile/i.test(na)
};

function setCookie(name, value, expires, path, domain, secure) {
    var exp = new Date(),
        expires = arguments[2] || null,
        path = arguments[3] || "/",
        domain = arguments[4] || null,
        secure = arguments[5] || false;
    expires ? exp.setMinutes(exp.getMinutes() + parseInt(expires)) : "";
    document.cookie = name + '=' + encodeURIComponent(value) + (expires ? ';expires=' + exp.toGMTString() : '') + (path ? ';path=' + path : '') + (domain ? ';domain=' + domain : '') + (secure ? ';secure' : '');
}

$(function (){
	var toggleBtn = $('.toggle-btn'),
		showBtn = $('.show-btn'),
		hideBtn = $('.hide-btn');
	var sideMenu = $('.side-menu'),
		sideMenuCon = $('.side-menu-con');
	var listBtn = $('.type-btns .list'),
		itemBtn = $('.type-btns .item');
	var wrap = $('.wrap');
	var showSideMenu = function(){
		$(sideMenu).animate({marginLeft : 0}, 500);
		$(wrap).animate({marginLeft : 220}, 500);
		$(sideMenuCon).fadeIn(500);
		$(hideBtn).fadeIn(700);
		$(showBtn).hide();
	};
	var hideSideMenu = function(){
		$(sideMenu).animate({marginLeft : -170}, 500);
		$(wrap).animate({marginLeft : 50}, 500);
		$(sideMenuCon).fadeOut(500);
		$(hideBtn).fadeOut(500);
		$(showBtn).delay(500).fadeIn(300);
	};

	jQuery.fn.clickToggle = function(a, b) {
		var ab = [b, a];
		function cb() {
			ab[this._tog ^= 1].call(this);
		}
		return this.on("click", cb);
	};

	if(brow.isMobile){
		$('.uk-button').clickToggle(function(){
			$('body').css('transform','translateX(46%)')
		},function(){
			$('body').css('transform','translateX(0)')
		})
	}else{
		if (parseInt($(sideMenu).css('marginLeft')) == -170) {
			$(toggleBtn).clickToggle(showSideMenu,hideSideMenu)
		}else{
			$(toggleBtn).clickToggle(hideSideMenu,showSideMenu)
		}

	}

	var type = function (){
		if(! brow.isMobile){
			$('.type-btns').css('display','block')
			$(itemBtn).bind('click',function(){
                setCookie('list_type','item',60*24*7,'/','.fedn.it');
				$(this).addClass('on').siblings().removeClass('on')
				if($('.main-con ul.list').hasClass('item')){
					return;
				}else{
					$('.main-con ul.list').addClass('item');
					$(this).addClass('on');
				}
			});
			$(listBtn).bind('click',function(){
                setCookie('list_type','list',60*24*7,'/','.fedn.it');
                $(this).addClass('on').siblings().removeClass('on')
				$('.main-con ul.list').removeClass('item');
			});
		}else{
			$('.type-btns').css('display','none');
			$('.main-con ul.list').addClass('item');
		}
	};
	type();
});

// Add baidu tongji by kairee - 2017-09-05
var _hmt = _hmt || [];
(function () {
    var hm = document.createElement("script");
    hm.src = "https://hm.baidu.com/hm.js?26790bda6fb5f397d7e69299be124586";
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(hm, s);
})();

