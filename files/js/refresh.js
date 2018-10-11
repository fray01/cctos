$(function (){
		
	var $displayPatient = $('.displayPatient');
	var $displayCasSocial = $('.displayCasSocial');
	var $displayPatientOnWaiting = $('.displayPatientOnWaiting');
	var $displayNotification = $('.displayNotification');
	var $displayPersonnelIn = $('.displayPersonnelIn');
	var $displayTodayInOut = $('.displayTodayInOut');
	var param = '';
	function displayPatientload(){
		var link = '../ajax/loading.php?p=displayPatient';
		$.ajax({
			type: 'GET',
			url: link,
			dataType: "json",
			timeout: 3000,
			success: function(mydata) {
				//	alert(mydata.play);
					$displayPatient.html(mydata.info);
					$(".gridAffaire").dataTable();
			},
			error: function() {
				//alert('impossible de rafraichir les informations'); 
			}
		});
	}	
	function displayCasSocialload(){
		//var link = '../ajax/loading.php?p='+param;
		var link = '../ajax/loading.php?p=displayCasSocial';
		$.ajax({
			type: 'GET',
			url: link,
			dataType: "json",
			timeout: 3000,
			success: function(mydata) {
					$displayCasSocial.html(mydata.info);
					$(".gridAffaire").dataTable();

			},
			error: function() {
			//	alert('impossible de rafraichir les informations'); 
			}
		});
	}	
	function displayNotificationload(){
		var link = '../ajax/loading.php?p=displayNotification';
		$.ajax({
			type: 'GET',
			url: link,
			dataType: "json",
			timeout: 3000,
			success: function(mydata) {
				
				$displayNotification.html(mydata.info);
				if($('#chatAudio').html() ==null){
					$('<audio id="chatAudio"><source src="../files/sound/notify.ogg" type="../files/sound/audio/ogg"><source src="../files/sound/notify.mp3" type="audio/mpeg"><source src="../files/sound/notify.wav" type="audio/wav"></audio>').appendTo('body');
				}
			//	alert(mydata.play);
				if(mydata.play > 0){
					$('#chatAudio')[0].play();
				}
			},
			error: function() {
			//	alert('impossible de rafraichir les informations'); 
			}
		});
	}	
	
	function displayPatientOnWaitingload(){
		var link = '../ajax/loading.php?p=displayPatientOnWaiting';
		$.ajax({
			type: 'GET',
			url: link,
			dataType: "json",
			timeout: 3000,
			success: function(mydata) {
					$displayPatientOnWaiting.html(mydata.info);
					$(".gridAffaire").dataTable();
			},
			error: function() {
			
			}
		});
	}	
	
	function displayPersonnelInload(){
		var link = '../ajax/loading.php?p=displayPersonnelIn';
		$.ajax({
			type: 'GET',
			url: link,
			dataType: "json",
			timeout: 3000,
			success: function(mydata) {
					$displayPersonnelIn.html(mydata.info);
			},
			error: function() {
			
			}
		});
	}	
	
	function displayTodayInOutload(){
		var link = '../ajax/loading.php?p=displayTodayInOut';
		$.ajax({
			type: 'GET',
			url: link,
			dataType: "json",
			timeout: 3000,
			success: function(mydata) {
					$displayTodayInOut.html(mydata.info);
			},
			error: function() {
			
			}
		});
	}	

	if($displayPatient.html()!=null){
		setInterval(displayPatientload, 10000);
	}
	if($displayCasSocial.html()!=null){
		setInterval(displayCasSocialload, 10000);
	}
	if($displayNotification.html()!=null){
		setInterval(displayNotificationload, 10000);
	}
	if($displayPatientOnWaiting.html()!=null){
		setInterval(displayPatientOnWaitingload, 10000);
	}
	if($displayPersonnelIn.html()!=null){
		setInterval(displayPersonnelInload, 10000);
	}
	if($displayTodayInOut.html()!=null){
		setInterval(displayTodayInOutload, 10000);
	}
});