"use strict";

// ==== Initial Google Map ====
function initialize(latitude, longitude, address, zoom) {
    var latlng = new google.maps.LatLng(latitude,longitude);

    var myOptions = {
        zoom: zoom,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: false
    };
    var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

    var marker = new google.maps.Marker({
        position: latlng, 
        map: map, 
        title: "location : " + address
    });
}

// ==== Go to top ====
function goup(){
    // to top
    $(".go-up").hide();
    $(window).scroll(function () {
        if ($(this).scrollTop() > 400) {
            $('.go-up').fadeIn();
        } else {
            $('.go-up').fadeOut();
        }
    });
    $('.go-up a').on('click', function (e) {
        e.preventDefault();
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });
}

$(document).ready(function(){ 
    goup();

    // ==== Create menu for mobile ====
    $('#all').after('<div id="off-mainmenu"><div class="off-mainnav"><div class="close-menu"><i class="fa fa-close"></i></div></div></div>');
    $('#main-nav').clone().appendTo('.off-mainnav');

    $('#btn-menu').on('click', function (e) {
        e.preventDefault();
        $('body').addClass('mainmenu-active');
    });
    
    $('.close-menu').on('click', function (e) {
        e.preventDefault();
        $('body').removeClass('mainmenu-active');
    });

    // ==== Display menu when resize window ====
    $(window).on('resize', function () {
        var win = $(this); //this = window
        if (win.width() >= 1024) {
            $('#main-nav').css({
                display: 'block'
            });
        }
    });

    // Advanced search
    $(".job-advancedsearch a").on('click', function(e){
        e.preventDefault();
        $(".job-searchform").toggleClass('open');
    });

    $(".job-searchform .btn-close").on('click', function(e){
        e.preventDefault();
        $(".job-searchform").toggleClass('open');
    });

    // google map
    var address = jQuery('.contact-address').html();
    var width = '100%';
    var height = '500px';
    var zoom = 16;
   
    // Create map html
	if (address) {
		$('#map').html('<div id="map_canvas" style="width:' + width + '; height:' + height + '"></div>');
		
		var geocoder = new google.maps.Geocoder();

		geocoder.geocode({'address': address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				var latitude = results[0].geometry.location.lat();
				var longitude = results[0].geometry.location.lng();
				initialize(latitude, longitude, address, zoom);
			}
		});
	}
	
	// ===== Price filter ======
	$("#price-filter").slider({
		from: 0,
		to: 100,
		step: 1,
		smooth: true,
		round: 0,
		dimension: "&nbsp;$",
		skin: "plastic"
	});
	
	// ====== Support ========
	$('.support-list .support-item').on('click', function (e) {
        $('html, body').animate({
			scrollTop: $(".support-list .support-content").offset().top
		}, 1000);

        $('.support-list .support-item').each(function( index ) {
            $(this).closest('li').removeClass('active');
        });    
    });
	
	// ======= Load more page recruitment =======
	$(".job-search-all .job-item").slice(0, 5).show();
    $(".job-load a").on('click', function (e) {
        e.preventDefault();
        $(".job-search-all .job-item:hidden").slice(0, 3).slideDown();
        if ($(".job-search-all .job-item:hidden").length == 0) {
            $(".job-load a").fadeOut('slow');
        }
        $('html,body').animate({
            scrollTop: $(this).offset().top
        }, 1500);
    });

    // ======= Load more page freelancer =======
    $(".job-freelancer .job-freelanceritem").slice(0, 4).show();
    $(".job-loadprofile a").on('click', function (e) {
        e.preventDefault();
        $(".job-freelancer .job-freelanceritem:hidden").slice(0, 2).slideDown();
        if ($(".job-freelancer .job-freelanceritem:hidden").length == 0) {
            $(".job-loadprofile a").fadeOut('slow');
        }
        $('html,body').animate({
            scrollTop: $(this).offset().top
        }, 1500);
    });
	
}); //end