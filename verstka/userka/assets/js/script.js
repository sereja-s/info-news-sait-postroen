$(function () {
	$('.index-slider__wrapper-bg').slick({
		infinite: true,
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: true,
		dots: true
	});

	// ============== slider full page ==============
	$('.full-item__slider-mini').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		arrows: true,
		asNavFor: '.full-item__slider-full',
		vertical: true,
		verticalSwiping: true,
		centerMode: true,
		focusOnSelect: true,
		infinite: true
	});
	$('.full-item__slider-full').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		asNavFor: '.full-item__slider-mini',
		arrows: false,
		dots: false,
		focusOnSelect: true,
		fade: true,
		infinite: true,
		responsive: [{
			breakpoint: 768,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
				dots: true
			}
		}]
	});

	// ============== tabs ==============
	$("#full-item__tabs").tabs();


	// ============== accordion toggle ==============
	$(".full-item__di-show").hide();

	$(".full-item__di-title").on("click", function () {
		$(this).toggleClass('di-active');
		$(this).next('.full-item__di-show').slideToggle('slow');
	});

	// ============== focus input search ==============
	// $(".header__search-input").on("focus", function () {
	//   $(this).parent('.header__search').addClass('header__search-active');
	// });

	// $(".header__search-input").on("focusout", function () {
	//   $(this).parent('.header__search').removeClass('header__search-active');
	// });

	// ============== add card like and comprasion ==============
	$(".short-item__add-link").on("click", function () {
		$(this).toggleClass('short-item__add-link-active');
		clickItem = $(this).parent();
		activeItemClick(clickItem)
	});

	$(".short-item__add-compare").on("click", function () {
		$(this).toggleClass('short-item__add-compare-active');
		clickItem = $(this).parent();
		activeItemClick(clickItem)
	});

	// ============== проверка для активной карточки ==============
	function activeItem() {
		if ($('.short-item__add-link').hasClass('short-item__add-compare-active') ||
			$('.short-item__add-compare').hasClass('short-item__add-compare-active')) {
			$('.short-item__add-link-active').parent('.short-item__rt-info').addClass('short-item__rt-info-active');
		} else {
			$('.short-item__add-link-active').parent('.short-item__rt-info').removeClass('short-item__rt-info-active');
		}
	}
	activeItem()

	function activeItemClick(clickItem) {
		if ($(clickItem).children('.short-item__add-link').hasClass('short-item__add-link-active') ||
			$(clickItem).children('.short-item__add-compare').hasClass('short-item__add-compare-active')) {
			$(clickItem).addClass('short-item__rt-info-active')
		} else {
			$(clickItem).removeClass('short-item__rt-info-active')
		}
	}

	// ============== arrow button top up ==============
	/* $(window).scroll(function () {
	  if ($(window).scrollTop() > 100) {
		 $('#arrow-top-page').fadeIn(700)
	  } else {
		 $('#arrow-top-page').fadeOut(700)
	  }
 
	  if ($(window).scrollTop() > 1) {
		 $('#header').addClass('header__fixed-header')
		 $('#header-block').addClass('header-block__show')
	  } else {
		 $('#header').removeClass('header__fixed-header')
		 $('#header-block').removeClass('header-block__show')
	  }
	}) */

	$('#arrow-top-page').click(function () {
		$('html, body').animate({
			scrollTop: 0
		}, 600)
		return false
	})

	// ============== cheange style (line to block) category items ==============
	$('#line-view-style-button').click(function () {
		$(this).addClass('active')
		$('#block-view-style-button').removeClass('active')

		$('#item-list-style').addClass('active-list-style-view')

	})

	$('#block-view-style-button').click(function () {
		$(this).addClass('active')
		$('#line-view-style-button').removeClass('active')

		$('#item-list-style').removeClass('active-list-style-view')
	})

	// ============== slider compare ==============
	$('.compare-page__slider').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		arrows: true,
		dots: false,
		infinite: false,
		responsive: [{
			breakpoint: 1200,
			settings: {
				slidesToShow: 2,
				slidesToScroll: 1,
			}
		},
		{
			breakpoint: 768,
			settings: {
				slidesToShow: 1,
				slidesToScroll: 1,
			}
		},
		]
	});


	function compareResize() {
		let lineNum = $('.compare-page__line-num');
		let itmTable;
		let arr = []
		let maxHeight;

		for (let z = 0; z < lineNum.length; z++) {
			itmTable = $('.itm-' + z)

			for (let i = 0; i < itmTable.length; i++) {
				getHeight = itmTable.eq(i).height();
				arr[i] = getHeight
			}
			maxHeight = Math.max.apply(null, arr) + 24;
			itmTable.css({
				"height": maxHeight + 'px'
			})
		}
	}
	compareResize()

	// ============== accordion install page ==============
	$('.work-price__category').hide()

	$('.work-price__open-category').click(function () {
		$(this).toggleClass('active')
		$(this).next('.work-price__category').slideToggle();
	})

	// ============== slider user-order-list ==============
	$('.order-list__item-slider').slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		variableWidth: true,
		arrows: true,
		responsive: [{
			breakpoint: 1300,
			settings: {
				slidesToShow: 2,
			}
		},
		{
			breakpoint: 768,
			settings: {
				slidesToShow: 1,
			}
		},
		]
	});
	// ============== slider reviews ==============
	$('.order-list__my-reviews-slider').slick({
		slidesToShow: 5,
		slidesToScroll: 1,
		arrows: true,
		responsive: [{
			breakpoint: 1300,
			settings: {
				slidesToShow: 4,
			}
		},
		{
			breakpoint: 1100,
			settings: {
				slidesToShow: 3,
			}
		},
		{
			breakpoint: 768,
			settings: {
				slidesToShow: 2,
			}
		},
		{
			breakpoint: 576,
			settings: {
				slidesToShow: 1,
			}
		},
		]
	});

	// ===================== modal poput CATEGORY FILTER ==================
	$('.category-filter__sort-list').click(function (event) {
		event.preventDefault()
		$(this).children('.category-filter-list').slideToggle('fast');
	})

	// ===================== modal poput HEADER USER ==================
	$('.header__profile-link').click(function (event) {
		event.preventDefault()
		$(this).next('.header-user-menu').slideToggle('fast');
	})


	// ===================== modal poput HEADER CART ==================
	$('.header__cart-link').click(function (event) {
		event.preventDefault()
	})

	// ===================== modal poput HEADER navi-category ==================
	$('.header__all-category-link').click(function (event) {
		event.preventDefault()
		$('#navi-category').slideToggle('fast');
		$(this).toggleClass('header__all-category-link-active');
		$('.header__all-category-link2').toggleClass('header__all-category-link2-active');
	})

	$('.header__all-category-link2').click(function (event) {
		event.preventDefault()
		$('#navi-category').slideToggle('fast');
		$(this).toggleClass('header__all-category-link2-active');
		$('.header__all-category-link').toggleClass('header__all-category-link-active');
	})

	// ================ tabs navi-category =====================

	// let categoryNum;
	// $( ".navi-category__list-link" ).hover(function() {
	//  $('.navi-category__list-content').hide();
	//  categoryNum = $(this).attr('data-attribute')
	//  $('.navi-category__nc-' + categoryNum).show();
	// });

	let navItem = $('.navi-category__list-link');
	let windowsWidth;
	let categoryNum;
	let categoryMenuTimer;

	// при наведении запускается таймер на 300мс, и через 300мс выполняется функция $('.navi-category__list-content').hide()
	// и отображает ИД ссылкы на которую навеен курсор мыши
	// если мышку убрали раньше таймера  то таймер останавливается  clearTimeout(categoryMenuTimer);
	// и если перевели курсор на другую ссылку то таймер тоже останавливается с предедущей функции
	// когда нажимаем пос ссылки происходит перещёт ширины екрана и если ширина меньше 768 то стандартное событые по клике отменяется
	navItem.each(function (i, el) {
		$(el).on({
			mouseenter: function () {
				clearTimeout(categoryMenuTimer);
				categoryMenuTimer = setTimeout(function () {
					categoryNum = $(el).attr('data-attribute')
					$('.navi-category__list-content').hide()
					$('.navi-category__nc-' + categoryNum).show('fade', 300);
				}, 300)
			},
			mouseleave: function () {
				clearTimeout(categoryMenuTimer);
			},
			click: function (event) {
				windowsWidth = $(window).width();
				if (windowsWidth <= 768) {
					event.preventDefault()
				}
			}
		})
	})

	// =================== POPUP ==========================
	$('.popup-open-modal').magnificPopup({
		type: 'inline',
		midCLick: false,
		mainClass: 'mfp-fade',
		removalDelay: 160,
	});

	// =================== jquery MASK for form ==========================
	$('.popup-form__mask-phone-number').mask('+38 (000)-00-00-000');

	// =================== focus input 1 number ==========================
	$('.popup-form__input-sms').keyup(function () {
		if ($(this).val().length == '1') {
			$(this).next('.popup-form__input-sms').focus()
		} else if (($(this).val().length == '0')) {
			$(this).prev('.popup-form__input-sms').focus()
		} else if (($(this).val().length >= '1')) {
			$(this).blur();
		}
	})

	// =================== ajax popup для просмотра товара по кнопке Быстрый просмотр ==========================
	$('.fast-view-ajax').magnificPopup({
		type: 'ajax',
		midCLick: false,
		mainClass: 'mfp-fade',
		removalDelay: 160,
	});

	// =================== search popup ==========================
	$('.popup-search-modal').magnificPopup({
		type: 'inline',
		midCLick: false,
		mainClass: 'mfp-fade',
		removalDelay: 160,
		alignTop: true,
	});

	// =================== Плавный скролл ==========================
	$('a.scroll-to').on('click', function (event) {
		event.preventDefault();
		var anchor = $(this).attr('href');
		$('html,body').stop().animate({
			scrollTop: $(anchor).offset().top - 150
		}, 800)
	});

	// ============== index-catalog wrapper for mobile ==============
	$('.index-catalog__wrapper').slick({
		arrows: false,
		infinite: false,
		variableWidth: true,
		responsive: [{
			breakpoint: 768,
			settings: {
				slidesToShow: 1,
			}
		},
		{
			breakpoint: 991,
			settings: {
				slidesToShow: 2,
			}
		},
		{
			breakpoint: 10000,
			settings: "unslick",
		},
		]
	});

	// =================== Появления меню хедера ==========================
	$('.header__more-menu-link').on('click', function (event) {
		event.preventDefault();
	});

	// ===================== modal poput HEADER Burger ==================
	$('.header__mobile-main-menu-link').click(function (event) {
		event.preventDefault()
		$('.header__top').addClass('header__top-active');
	})

	$('.header__mb-menu-close').click(function (event) {
		event.preventDefault()
		$('.header__top').removeClass('header__top-active');
	})

	$('.header__all-category-link3').click(function (event) {
		event.preventDefault()
		$('#navi-category').slideToggle('fast');
	})

	$('.navi-category__mobile-back-to-menu').click(function (event) {
		event.preventDefault()
		$('#navi-category').slideToggle('fast');
	})

	$('.navi-category__mobile-back-all-category').click(function (event) {
		event.preventDefault()
		$(this).parent('.navi-category__list-content').hide('fast');
	})

	$('.navi-category__category-title').click(function (event) {
		windowsWidth = $(window).width();
		if (windowsWidth <= 768) {
			event.preventDefault()
			$(this).next('.navi-category-subcategory-menu').slideToggle('fast');
			$(this).toggleClass('navi-category__category-title-active')
		}
	})

	// ===================== beadcrumbs fo last child ==================
	let breadCrumbsMobile = $('.breadcrumbps__wrapper a')
	breadCrumbsMobile.eq(breadCrumbsMobile.length - 1).css('display', 'inline-block').addClass('breadcrumbps__link-mobile')

	// ===================== sldier for full-item-page ==================
	$('.full-item__recommendation-wrapper').slick({
		arrows: false,
		infinite: false,
		variableWidth: true,
		responsive: [{
			breakpoint: 768,
			settings: {
				slidesToShow: 1,
			}
		},
		{
			breakpoint: 991,
			settings: {
				slidesToShow: 2,
			}
		},
		{
			breakpoint: 10000,
			settings: "unslick",
		},
		]
	});

	$('.full-item__more-buy-wrapper').slick({
		arrows: false,
		infinite: false,
		variableWidth: true,
		responsive: [{
			breakpoint: 768,
			settings: {
				slidesToShow: 1,
			}
		},
		{
			breakpoint: 991,
			settings: {
				slidesToShow: 2,
			}
		},
		{
			breakpoint: 10000,
			settings: "unslick",
		},
		]
	});

	$('.full-item__present-wrapper').slick({
		arrows: false,
		infinite: false,
		variableWidth: true,
		responsive: [{
			breakpoint: 768,
			settings: {
				slidesToShow: 1,
			}
		},
		{
			breakpoint: 991,
			settings: {
				slidesToShow: 2,
			}
		},
		{
			breakpoint: 10000,
			settings: "unslick",
		},
		]
	});

	// ===================== accordeon for return page==================
	$('.return__mobile-slide').click(function (event) {
		windowsWidth = $(window).width();
		if (windowsWidth <= 768) {
			event.preventDefault()
			$(this).next('.return__mobile-wrapper').slideToggle('fast');
			$(this).toggleClass('return__mobile-slide-active')
		}
	})

	// ===================== sldier for leter-list catalog ==================
	$('.leter-list__catalog').slick({
		arrows: false,
		infinite: false,
		variableWidth: true,
		responsive: [{
			breakpoint: 768,
			settings: {
				slidesToShow: 1,
			}
		},
		{
			breakpoint: 991,
			settings: {
				slidesToShow: 2,
			}
		},
		{
			breakpoint: 10000,
			settings: "unslick",
		},
		]
	});

	// ===================== category page mobile filter link =================
	$('.category-items__mobile-filter-link').click(function (event) {
		event.preventDefault()
		$('.category-page__filter').show('fast');

	})

	// ===================== category page mobile close link =================
	$('.category-filter__close-link').click(function (event) {
		event.preventDefault()
		$('.category-page__filter').hide('fast');
	})

	$('.compare-info__compare-fixed-clear').click(function (event) {
		event.preventDefault()
		$('.compare-info').hide('fast');
	})

	$('.category-filter__more-link').click(function (event) {
		event.preventDefault()
		$(this).hide('fast');
		$('.category-filter').removeClass('category-filter__small-height');
	})

	$('.category-filter__result-clear').click(function (event) {
		event.preventDefault()
		$('.category-filter__result').hide('fast');
	})
})