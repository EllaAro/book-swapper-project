$(window).load(function () {
    $(".trigger_popup_fricc").click(function(){
    	var parent = $(this).closest('.bookdiv');
    	var box = parent.find('.hover_bkgr_fricc');
        box.show();
    });

    $('.popupCloseButton').click(function(){
        var parent = $(this).closest('.bookdiv');
    	var box = parent.find('.hover_bkgr_fricc');
        box.hide();
    });

    $(".genreButton").click(function(){
    	var parent = $(this).closest('.TagItDiv');
    	var opt1 = parent.find('.firstOption').val();
    	var opt2 = parent.find('.secondOption').val();
    	var user = parent.find('.curruser').val();
    	var book = parent.find('.currbook').val();
        console.log(book);
        console.log(opt1);
        console.log(opt2);
        console.log(user);


    	$.post("includes/tag_inc.php", {user: user, opt1:opt1, opt2:opt2, book:book },  
			function(data){
                console.log(data);
                parent.find('.firstOption').css({"display":"none"});
                parent.find('.secondOption').css({"display":"none"});
                parent.find('.opt1').css({"display":"none"});
                parent.find('.opt2').css({"display":"none"});
                parent.find('.genreButton').css({"display":"none"});
                if(data=="success"){
                    parent.find('.tagMsg').html("Successfully tagged");
                }
                else if(data=="alreadytagged"){
                    parent.find('.tagMsg').html("You've already tagged this book.");
                }
				
			});

    });

});


