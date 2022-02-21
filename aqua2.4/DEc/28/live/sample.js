require(["jquery", "owlcarousel"], function ($) {
    $(document).ready(function () {
        setTimeout(function(){ 
        $('.homeSlider').owlCarousel({
            loop: true,
            margin: 10,
            responsiveClass: true,
            pagination: true,
            autoplay: false,
            stopOnHover: true,
            navigation: true,
            navigationText: ["prev", "next"],
            rewindNav: true,
            scrollPerPage: false,
            animateOut: 'fadeOut',
            autoplayTimeout: 5000,
            smartSpeed: 1000,
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                600: {
                    items: 1,
                    nav: true
                },
                1000: {
                    items: 1,
                    nav: true,
                    loop: true
                }
            }
        });
       }, 1000);
    });
});
require(["jquery", "owlcarousel"], function ($) {
    $(document).ready(function () {
        setTimeout(function(){ 
        $('.sampleslider').owlCarousel({
            loop: true,
            margin: 10,
            center: true,
            responsiveClass: true,
            pagination: true,
            autoplay: true,
            stopOnHover: true,
            navigation: false,
            navigationText: ["prev", "next"],
            rewindNav: true,
            scrollPerPage: false,
            animateOut: 'fadeOut',
            autoplayTimeout: 6000,
            smartSpeed: 1000,
            responsive: {
                0: {
                    items: 1,
                    nav: true
                },
                769: {
                    items: 2,
                    nav: true
                },
                1000: {
                    items: 3,
                    nav: true,
                    loop: true
                }
            }
        });
       }, 1000);
    });
});
require(["jquery", "owlcarousel"], function ($) {
    $(document).ready(function () {
		if(!$('body').hasClass('cms-home-page-v15')) { 
   $('.pcustom.head').remove();
  }
	});
});
require(["jquery"], function ($)
 {
var checkExistt = setInterval(function() {
        if (jQuery('input[name=telephone]').length) {
            jQuery("input[name=telephone]").val("+1");      
            jQuery("input[name=telephone]").attr("maxlength", "12");
            clearInterval(checkExistt);
        }
        }, 100);    
 jQuery("body").delegate("input[name=telephone]","onchange",function (e) {    
    
    var charCode = (e.which) ? e.which : event.keyCode    
    jQuery("input[name=telephone]").val(jQuery("input[name=telephone]").val()); 
    jQuery("input[name=telephone]").trigger('change'); 
    if (String.fromCharCode(charCode).match(/[^0-9]/g))    

        return false;                        
        jQuery("input[name=telephone]").val(jQuery("input[name=telephone]").val()); 
        jQuery("input[name=telephone]").trigger('change'); 
}); 
}); 
require(["jquery"], function ($)
 {
jQuery("body").delegate("input[name=telephone]","keydown",function(event){
console.log(this.selectionStart);
console.log(event);
if(event.keyCode == 8){
this.selectionStart--;
}
if(this.selectionStart < 2){
this.selectionStart = 2;
console.log(this.selectionStart);
event.preventDefault();
}
});
});
// require(["jquery"], function ($)
//  { 
// jQuery("body").delegate("input[name=telephone]","keyup",function(event){
//     console.log(this.selectionStart);
//     if(this.selectionStart < 2){
//         this.selectionStart = 2;
//         console.log(this.selectionStart);
//         event.preventDefault();
//     }
// });
// });