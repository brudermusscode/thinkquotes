$(function(){

  var $siteurl = "https://images.thinkquotes.de/fhmunster";
      $hdr = $(document).find('header'),
      $hdrt = $hdr.find('.top'),
      $hdrb = $hdr.find('.bottom')
      $hd = $(document).find('head'),
      $myFhContent = $(document).find('#myfhContent'),
      $myFhBoxContainer = $(document).find('#myfh-box-container');


  // add to head
  $hd.append('<style>@import URL("https://images.thinkquotes.de/fhmunster/realstyles.css");</style>');

  var contentAppendTo = [
    "https://www.fh-muenster.de/myfh/?__redirect=true",
    "https://www.fh-muenster.de/myfh/"
  ];

  $(window).on("scroll", function(){
    if($(this).scrollTop() > 10) {
      $('[data-structure="hdr:main"]').addClass('mshd-2');
    } else  {
      $('[data-structure="hdr:main"]').removeClass('mshd-2');
    }
  });

  // content reensemble
  $myFhContent.children().not('#myfh-box-container, #myfh_setting_container, #my_messages, iframe').wrapAll('<div class="anus"></div>').closest('.anus').empty();
  $('#my_messages.myfh-box .message').prepend('<div class="acon"><span class="material-icons-round md-24">markunread</span></div><div class="acon-u"><span class="material-icons-round md-24">mark_email_unread</span></div>');

  var getSubContent = function(){

    var myfh;
    if($.inArray(window.location.href, contentAppendTo) !== -1){
      myfh = true;
      $('#packeryJS').remove();
    }

    if(window.location.href === "https://www.fh-muenster.de/myfh/meine-nachrichten.php") {
      $('#my_messages').addClass('fullMessenger');
    }

    $.ajax({

      data: { myfh: myfh },
      url: $siteurl + "/myfh-subheader.php",
      method: "POST",
      dataType: "HTML",
      
      success: function(data) {

        $(document).find('body').prepend(data);

      },
      error: function(data){

      }

    });

  };
  

  // content
  setTimeout(function(){

    var $appendOldContent = $(document).find('#my_messages');
    var $appendOldContentFeedback = $(document).find('#feedback');

    $appendOldContent.removeAttr('style');
    $appendOldContent.appendTo('[data-append="messages"]');
    $appendOldContentFeedback.removeAttr('style');
    $appendOldContentFeedback.appendTo('[data-append="feedback"]');

  }, 200);

  // functions execute
  getSubContent();

});