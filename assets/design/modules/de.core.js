'use strict';

// create dynamic host
let parsedHostname = psl.parse(location.hostname);
var dynamicHost;
if (location.hostname === "localhost" || location.hostname === "127.0.0.1") {
    dynamicHost = "http://" + document.domain;
} else {
    dynamicHost = "https://www." + parsedHostname.domain;
}

// global
var categoryArray = [];
var cacheID = [];

// button ripple effect
$(document).ready(function($, window, document, undefined) {

    var $ripple = $('.js-ripple');

    $ripple.on('click.ui.ripple', function(e) {

        var $this = $(this);
        var $offset = $this.parent().offset();
        var $circle = $this.find('.c-ripple__circle');

        var x = e.pageX - $offset.left;
        var y = e.pageY - $offset.top;

        $circle.css({
            top: y + 'px',
            left: x + 'px'
        });

        $this.addClass('is-active');

    });

    $ripple.on('animationend webkitAnimationEnd oanimationend MSAnimationEnd', function(e) {
        $(this).removeClass('is-active');
    });
    
});


$(function(){

    let body = $("body");

    // prevent default and submitting forms statically
    $(document).on("submit", "form", function(e) {

        e.preventDefault();
        return false;
    });

    $(document).scroll(function(){

        // hide header elements on scroll top
        let $hdr = $(document).find("#main-hdr");
        let $inthdr = $(document).find("#intern-hdr");
        let $intSubHdr = $(document).find(".intern-head-tools");

        if($(this).scrollTop() > 20) {
            $hdr.addClass('scrolled');
            $inthdr.addClass('scrolled');
            $intSubHdr.addClass('scrolled');
        } else {
            $hdr.removeClass('scrolled');
            $inthdr.removeClass('scrolled');
            $intSubHdr.removeClass('scrolled');
        }

        closeDropdown();
    });

    // error response actions
	$("#errorResponse").hover(function () {
		clearTimeout(hideErRe);
	}, function () {
		hideErrorResponse();
	});
    
    // dropdown
    $(document).on("click", '[data-action="dropdown:open"]', function() {

        var $t = $(this);
        var $react = $t.closest('[travelhereboy]').find('[data-react="dropdown:open"]');
        var ulHeight = $react.find('ul').outerHeight();
        var ulWidth = $react.find('ul').outerWidth();

        var openMenu = $react.addClass('active').css({
            "height": ulHeight + "px",
            "width": ulWidth + "px"
        });

    });

    // dropdown >> close
    $(document).on("click", "dropdown ul li", closeDropdown);

    // resize textarea on type
    $(document).on("input", "textarea", function() {
        var $t = $(this);

        $t.css({ "height":"auto", "overflow-y":"hidden" });
        $t.css({ "height": $t.prop("scrollHeight") + "px" });
    });

    // input select
    $(document).on("click", "[data-structure='select'] .show-actual", function(){

        var $t = $(this);
        var $dataset = $t.parent().find('dataset');
        var ulHeight = $dataset.find('ul').height();
        
        $dataset.css({ "visibility":"visible", "opacity":"1", "height":"calc(" + ulHeight + "px + 24px)" });


    })

    .on("click", "[data-structure='select'] dataset ul li", function(){

        var $t = $(this);
        var cid = $t.attr('data-set');
        var value = $t.find('p').html();
        var changeHTML = $t.closest("[data-structure='select']").find('.show-actual p.lt').html(value).addClass('active');
        var hiddenInput = $t.parents(1).find('input[type="hidden"]').val(cid);
        
        closeDropdown();

    });
    
    // close popups
    $(document).on('click', 'close-overlay', function(e) { 

        closeOverlay(body);
    });

    // close dropdown
    $(window).on('mouseup', function(e){

        if (! ($(e.target).closest('dataset').is('dataset') || $(e.target).closest('dropdown').is('dropdown'))) {
            closeDropdown();
        }

    });
        
    var loadQuotes = function() {

        var $react = $('[data-load="content:quotes"]');
        var $append = $react.find('.actual');
        var $placeholder = $react.find('.quote-placeholder');
        var getData = $react.data('json');
        var page = getData[0].page;
        var subpage = getData[0].subpage;
        var order = getData[0].order;
        var limit = getData[0].limit;
        var uid = getData[0].uid;
        let url = dynamicHost + "/dyn/content/quotes";

        $.ajax({

            url: url,
            method: "POST",
            dataType: "HTML",
            data: { page: page, order: order, limit: limit, uid: uid, subpage: subpage },
            success: function(data) {

                var $errCode = parseInt(data);
                
                switch($errCode){
                    case 0:
                        showErrorModule("Something went wrong...");
                        break;
                    default:
                        $append.empty();
                        $append.append(data);
                        $placeholder.addClass('dno');
                }

            },
            error: function() {
                showErrorModule("Something is wrong here...");
            }

        });

    }

    loadQuotes();

});

const closeOverlay = (append) => {
    return Overlay.close(append);
}

var fitPopupModule = function() {
    var $md = $(document).find('response-overlay popup-module');
    var mdHeight = $md.outerHeight();
    var wHeight = $(window).height() + 48;

    if(mdHeight >= wHeight) {
        $md.addClass("scrollable");
    } else {
        $md.removeClass("scrollable");
    }
}

function addLoaderFloat(overlay) {

    var overlay;
    var $appendTo;
    var responseOverlay;

    if(overlay !== undefined) {
        $appendTo = $(overlay);
    } else {
        $appendTo = $('body');
    }

    responseOverlay = $appendTo.find('response-overlay');
    responseOverlay.prepend('<div class="progressbar spinner spinner5 float"></div>');
    
}

function addDialogue(append, hdr, body) {
    var a = $(append);
    a.append('<div class="overall-dialogue alignmiddle" style="background:transparent;"><zoom-in class="inr mshd-4 zoom-in" style="display:block;background:white;"><p style="font-weight:700;color:#222;font-size:24px;padding-bottom:12px;padding-top:12px;">' + hdr + '</p><p style="font-weight:400;color:#666;font-size:18px;">' + body + '</p><button-section style="margin-top:32px;"></button-section></zoom-in></div>');
}

function addErrorFloating(append, icon, text) {
    append.append('<post-viewer class="alignmiddle tran-all"><inr class="mshd-2 zoom-in"><div class="close tran-all" data-action="close-post-viewer"><p><i class="material-icons md-24">close</i></p></div><div class="outer"><div class="deleted"><p class="icon" style="color:#FF9800;"><i class="material-icons md-82">' + icon + '</i></p><p class="text">' + text + '</p></div></div></inr></post-viewer>');
}

function togglebody(){
	$('body').toggleClass('toggleBody');
}

function uniqueID() {
  return Math.round(new Date().getTime() + (Math.random() * 100));
}

let resizeTextarea = function(elem) {
    let $elem = $(elem);
    return $elem.css({ "height": $elem.prop("scrollHeight") + "px", "overflow-y":"hidden" });
}

// error module
var hideErRe;
function hideErrorResponse() {
	clearTimeout(hideErRe);
	hideErRe = setTimeout(function(){ $('#errorResponse').css({ "bottom":"-120px" }); }, 5000);	
}

function showErrorModule(error) {
    var $error = error;
    var $errorModule = $('body').find('[data-structure="module:error"]');
    
    hideErrorResponse();
    $errorModule.find('p').html(error);
    $errorModule.css({ "bottom":"24px" });
}

function expandErrorModule(icon, text){
    var $app = $('app');
    var $errorModule = $('body').find('[data-structure="module:error"]');
    var $errorModuleHeight = $errorModule.find('.popper').outerHeight();
    var $errorModuleWidth = $errorModule.find('.popper').outerWidth();
    $errorModule.find('.popper').addClass('transition');
    $errorModule.find('.popper').css({ "height":$errorModuleHeight + "px", "width":$errorModuleWidth + "" });

    setTimeout(function(){

        $errorModule.css({
            "bottom":"-120px", "left":"0", "height":"calc(100% + 120px)", "width":"100%"
        });

        $errorModule.find('.popper').css({ 
            "width":"100%",
            "height":"100%"
        });
        $errorModule.find('p').css({ "opacity":"0" });

        setTimeout(function(){

            $app.prepend('<div data-structure="module:error,expand,text" class="posfix alignmiddle"><div class="error-module--text trans-all"><p class="lt mr24"><span class="material-icons-round md-64" style="color:var(--colour-green);line-height:.8;">'+icon+'</span></p><p class="rt">'+text+'</p></div></div>');
            var $errorModuleExpandText = $app.find('[data-structure="module:error,expand,text"]');
            $errorModuleExpandText.fadeIn(400);

        }, 100);

    }, 600);
}

// RETURN JUST TEXT
jQuery.fn.justtext = function(text) {
  
	return $(this).clone()
			.children()
			.remove()
			.end()
			.text(text);

};
    
// FADE IN ON LOAD
function fadeIn(obj) {
    $(obj).fadeIn(250);
}

function fadeInVisOpa(obj) {
    $(obj).css({ 'visibility':'visible', 'opacity':'1' });
}

function fadeInVisOpaBg(obj) {
    obj.css({ 'visibility':'visible', 'opacity':'1' });
}

function fadeInVisOpaBgClass(obj) {
    obj.addClass('showVisOpa');
}

// shuffle through array
function shuffleArray(array) {
    var currentIndex = array.length,  randomIndex;

    // While there remain elements to shuffle...
    while (0 !== currentIndex) {

        // Pick a remaining element...
        randomIndex = Math.floor(Math.random() * currentIndex);
        currentIndex--;

        // And swap it with the current element.
        [array[currentIndex], array[randomIndex]] = [
        array[randomIndex], array[currentIndex]];
    }

    return array;
}

// Create random error output quote
function randomStringArray(array) {
    var randomString;
    return randomString = array[Math.floor(Math.random()*array.length)];
}

// global close dropdpwns
var closeDropdown = function() {

    var dstr = $('[data-structure="select"] dataset');
    dstr.css({ "height":"0px", "visibility":"hidden", "opacity":"0" });

    var drpdwn = $('dropdown');
    drpdwn.removeClass('active').removeAttr('style');
}

// remove from array
Array.prototype.removeFromArray = function(x) { 
    var i;
    for(i in this){
        if(this[i].toString() == x.toString()){
            this.splice(i,1)
        }
    }
}

// uppercaser first letter of string
function uppercaseFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}