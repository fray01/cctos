$(function (){
	//initialisation
	var id = null;
	clearInterval(id);
	var y = 0;
	var tempY = 0;  
	
	//Go to locksreen
	function lockingSession(){
	//		alert(y);
			location.href ='index.php?p=lockscreen';
	}
	//delete Timer
	function resetTimer(){
			if(id != null){
				clearInterval(id);
				id = null;
			}
	}
	//Start Timer
	function startTimer(){
			if(id == null){
			//300000 =-> 5min
				id = setInterval(lockingSession, 300000);
			}
	}
	// start mouse event following
	$(document).mousemove(function(event){
			tempY = event.pageY
			if( y != tempY){
				y = tempY;
				resetTimer();
			}
			else{
				startTimer();
			}
    });
	//delete timer if key is up
	$(document).keydown(function(event){
			resetTimer();
    });	
	//start timer if key is down
	$(document).keydown(function(event){
			startTimer()
    });
	//start timer if mouse leave screen
	$("body").mouseleave(function(){
			startTimer()
	});
	
});

