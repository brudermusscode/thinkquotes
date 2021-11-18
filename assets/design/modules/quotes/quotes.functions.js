$(function(){

    // >> quotes, add
    $(document).on("click", "[data-action='function:quotes,add']", function(){

        var dataSerialized = $(this).parents(1).find('[data-form="quotes,add"]').serialize() + "&categories=" + categoryArray;
        let url = dynamicHost + "/dyn/quotes/add";

        $.ajax({
            
            url: url,
            dataType: "text",
            data: dataSerialized,
            method: "POST",
            success: function(data){
                
                var dataInt = parseInt(data);
                var error;
                var overlay = $('response-overlay');
                
                switch(dataInt) {
                    case 1:
                        error = "Fill out all forms!";
                        break;
                    case 69:
                        error = "You have no permissions to post new quotes!";
                        break;
                    case 88:
                        error = "You can't add new authors, categories or sources!";
                        break;
                    case 100:
                        error = "You my friend, are truly loved. Your quote has been added!";
                        closeOverlay();
                        // empty array of categories
                        categoryArray = [];
                        break;
                    case 101:
                        
                        overlay.empty();
                        url = dynamicHost + "/dyn/popups/quotes-add-updatepermissions";

                        $.ajax({

                            url: url,
                            dataType: "HTML",
                            method: "POST",
                            beforeSend: function(){

                                addLoaderFloat(overlay);

                            },
                            success: function(data){
                                
                                overlay.empty();
                                overlay.append(data);
                                fitPopupModule();
                                
                            },
                            error: function(data){
                                closeOverlay();
                                showErrorModule("One of your quotes now needs to be upvoted atleast 20 times!");
                            }
                            
                        });
                        
                        error = "Your quote has been added! But...";
                        categoryArray = [];
                        break;
                        
                        
                    default:
                        error = randomStringArray(randomErrorTexts);
                }
                
                showErrorModule(error);
                
            },
            error: function(data){
                showErrorModule('Something weird happened, please try again!');
            }
                
        });

    })

    // >> quotes, edit
    .on("click", "[data-action='function:quotes,edit']", function() {

        var error;
        let overlay = $('response-overlay');
        let dataInt;
        var dataSerialized = $(this).parents(1).find('[data-form="quotes,add"]').serialize() + "&categories=" + categoryArray;
        let url = dynamicHost + "/dyn/quotes/edit";

        $.ajax({
            
            url: url,
            dataType: "text",
            data: dataSerialized,
            method: "POST",
            success: function(data){

                dataInt = parseInt(data);
                
                switch(dataInt) {
                    case 1:
                        error = "Fill out all forms!";
                        break;
                    case 88:
                        error = "You can't add new authors, categories or sources!";
                        break;
                    case 100:
                        error = "Your quote was edited successfully!";
                        closeOverlay();
                        // empty array of categories
                        categoryArray = [];
                        break;
                    default:
                        error = randomStringArray(randomErrorTexts);
                }
                
                showErrorModule(error);
                
            },
            error: function(data){
                showErrorModule('Something weird happened, please try again!');
            }
                
        });

    })
    
    // >> quotes, categories
    .on('keypress', "[data-action='function:quotes,categories,add']", function(event) {
        
        var error;
        var keycode = (event.keyCode ? event.keyCode : event.which);
        var $t = $(this);
        var val = $.trim($t.val().toLowerCase().replace(/[^a-z0-9äöüß\s]/gi, ''));
        var $react = $t.parents(3).find('[data-react="function:quotes,categories,add"]');
        var emptiedVal;
        
        if(keycode == '13' || keycode == "32"){
            
            if($.inArray(val, categoryArray) !== -1) {
                
                error = "You've added this category already!";
                showErrorModule(error);
                
            } else if(val === "") {
                      
                error = "Category can't be empty!";
                showErrorModule(error);
                      
            } else {
            
                var append = $react.prepend('<div class="category-banner zoom-in mt8 lt" data-value="'+$t.val()+'" style="background:var(--colour-light);">'+$t.val()+' <span data-action="function:quotes,categories,remove" class="category-delete material-icons-round md-18 rt">close</span></div>');
                var addToArray = categoryArray.push($t.val());
                
            }
            
            var emptyVal = $t.val('');
            var realEmptyThisShit = $t.val().slice(0, -1);
            var yes = $.trim(realEmptyThisShit);
            var yess = $t.val(yes);
            
        }

    })
    
    .on("click", '[data-action="function:quotes,categories,remove"]', function(){
        
        var $t = $(this);
        var val = $t.parent().data("value");
        //var filterString = val.replace(/[^a-z0-9äöüß\s]/gi, '');
        var removeFromArray = categoryArray.removeFromArray(val);
        var removeCont = $t.parent().remove();
        
    })
    
    // >> quotes, favorite
    .on("click", "[data-action='function:quotes,favorite']", function(){

        var $t = $(this);
        var getData = $t.closest('quote').data("json");
        var qid = getData[0].qid;
        var $reactCount = $t.closest('quote').find('[data-react="functions:quotes,favorite,count"]');
        let url = dynamicHost + "/dyn/quotes/favorite";

        $.ajax({
            
            url: url,
            dataType: "text",
            data: { qid: qid },
            method: "POST",
            success: function(data){
                
                console.log(data);
                
                var dataInt = parseInt(data);
                var error,
                    newCount = $reactCount.html(),
                    setNewCount;
                
                switch(dataInt) {
                    case 1:
                        newCount = parseInt($reactCount.html()) + 1;
                        error = "Added to your favorite library!";
                        $t.toggleClass("active");
                        break;
                    case 2:
                        newCount = parseInt($reactCount.html()) - 1;
                        error = "Removed from your favorites!";
                        $t.toggleClass("active");
                        break;
                    default:
                        error = randomStringArray(randomErrorTexts);
                }
                
                setNewCount = $reactCount.html(newCount);
                showErrorModule(error);
                
            },
            error: function(data){
                showErrorModule('Something weird happened, please try again!');
            }
            
        });
        
    })
    
    // >> quotes, report
    .on("click", "[data-action='function:quotes,report']", function(){

        var $t = $(this);
        var formSerialized = $t.closest('form[data-form="quotes,report"]').serialize();
        var getData = $t.closest('form[data-form="quotes,report"]').data("json");
        var qid = getData[0].qid;
        let url = dynamicHost + "/dyn/quotes/report";

        var serializedData = formSerialized + "&qid=" + qid;
        
        $.ajax({
            
            url: url,
            dataType: "text",
            data: serializedData,
            method: "POST",
            success: function(data){
                
                console.log(data);
                
                var dataInt = parseInt(data),
                    error;
                
                switch(dataInt) {
                    case 1:
                        error = "Your report has been sent!";
                        closeOverlay();
                        break;
                    case 2:
                        error = "Select a report reason!";
                        break;
                    default:
                        error = randomStringArray(randomErrorTexts);
                        
                }
                
                showErrorModule(error);
                
            },
            error: function(data){
                showErrorModule('Something weird happened, please try again!');
            }
            
        });
        
    })

    // >> quotes, delete
    .on("click", "[data-action='function:quotes,delete']", function(){

        var $t = $(this);
        let qid = cacheID[0];
        let $error;
        let $q = $(document).find('quote[data-quote-id="'+qid+'"]');
        let url = dynamicHost + "/dyn/quotes/delete";

        $.ajax({
            
            url: url,
            dataType: "text",
            data: { qid: qid },
            method: "POST",
            success: function(data){

                if(parseInt(data) !== 0) {
                    $error = "Your quote has been deleted!";
                    $q.toggleClass('slideUp tran-all-cubic-imp').css({ "overflow":"hidden", "height":"0px" });
                    setTimeout(function(){
                        $q.remove()
                    }, 600);


                } else {
                    $error = "A wild error appeared! Fight it!";
                }
                
                showErrorModule($error);
                closeOverlay();

                // delete cache
                cacheID = [];

            },
            error: function(data){
                showErrorModule('Something weird happened, please try again!');
            }
            
        });
        
    });



    $(document).on('mouseup', function(e){

        if(!$(e.target).is('[data-react="function:type,search"]')) {
            closeSearchType();
        }

    });
    
});

var closeSearchType = function(){
    
    var $react = $('[data-react="function:type,search"]');
    return $react.removeClass('active').removeAttr('style').children().empty();
    
}