var na = navigator.userAgent;
var brow = {
	isLowBrow:!-[1,],
	isIE:/MSIE/i.test(na),
	loadAds:/Android|iPhone|iTouch|BlackBerry|IEMobile/i.test(na),
	isMobile:/Android|iPhone|iTouch|iPad|BlackBerry|IEMobile|Mobile/i.test(na)
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
		$(toggleBtn).clickToggle(function(){
			$(sideMenu).animate({marginLeft : -170}, 500);
			$(wrap).animate({marginLeft : 50}, 500);
			$(sideMenuCon).fadeOut(500);
			$(hideBtn).fadeOut(500);
			$(showBtn).delay(500).fadeIn(300);
		},function(){
			$(sideMenu).animate({marginLeft : 0}, 500);
			$(wrap).animate({marginLeft : 220}, 500);
			$(sideMenuCon).fadeIn(500);
			$(hideBtn).fadeIn(700);
			$(showBtn).hide();
		})
	}

	var type = function (){
		if(! brow.isMobile){
			$('.type-btns').css('display','block')
			$(itemBtn).bind('click',function(){
				$(this).addClass('on').siblings().removeClass('on')
				if($('.main-con ul.list').hasClass('item')){
					return;
				}else{
					$('.main-con ul.list').addClass('item');
					$(this).addClass('on');
				}
			});
			$(listBtn).bind('click',function(){
				$(this).addClass('on').siblings().removeClass('on')
				$('.main-con ul.list').removeClass('item');
			});
		}else{
			$('.type-btns').css('display','none');
			$('.main-con ul.list').addClass('item');
		}
	}
	type();
})