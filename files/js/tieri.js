var rowNum = 0;
function addRow(frm) {
	rowNum ++;
	var row ='<div id="form-group'+rowNum+'">'+
	'<label class="col-md-1 control-label"></label>'+
	'<div class="col-md-4"><input type="text" class="form-control" name="title[]" value="YYY" placeholder="Title" /></div>'+
	'<div class="col-md-4"><input type="text" class="form-control" name="isbn[]" value="YYY" placeholder="ISBN"/></div>'+
	'<div class="col-md-2"><input type="text" class="form-control" name="price[]" value="123" placeholder="Price"/></div>'+
	'<div class="col-md-1">'+
		'<button type="button" class="btn btn-default addButton" onclick="removeRow('+rowNum+');"><i class="fa fa-minus"></i></button>'+
	'</div>'+
	'</div>'
	$('#form').append(row);
//	frm.add_title.value = '';
//	frm.add_isbn.value = '';
//	frm.add_price.value = '';
}

function removeRow(rnum){
	$('#form-group'+rnum).remove();
}
$("#bookForm").submit(function(e){
//	alert($("form").serialize());
	e.preventDefault();
//	var $form = $(this);
		var options = {
			type    : "POST",
			url     : "ajax/traitementCommand.php",
			data    : $("form").serialize(),
//			dataType: "json",
			success : function(data){
		        // En cas de succès
					$('#jsondata').html(data);
				}
		};
	$.ajax(options);
});

$(function () {
		$(".gridAffaire").dataTable();
		$("#filtredTable").dataTable();
 //$("#barChart").click(function(){
 //	 $.get("includes/pages/feedschart.php", function(data, status){
 //			 alert("Data: " + data + "\nStatus: " + status);
	//	});
});
$('.open-popup-link').click(function(){
	$('.service').empty();
	$('#acte').empty();
	$('#facturation').empty();

//	var $val = $(this).attr('id');
	var $services = $('.service');
	var service = $(this).attr('data');
	$(function () {
		var $actes = $('#acte');
		var $facturation = $('#facturation');
		var $param = $(location).attr('search').replace("?", "");

		$.ajax({
					url: '../ajax/listeacte.php',
					data: $param +'&go', // on envoie $_GET['go']
					dataType: 'json', // on veut un retour JSON
					success: function(json) {
						$facturation.empty();
						$services.append('<option value="">-- Services --</option>');
						$actes.append('<option value="">-- Acte --</option>');
						$.each(json, function(index, value) { // pour chaque noeud JSON
								// on ajoute l option dans la liste
							$services.append('<option value="'+ index +'">'+ value +'</option>');
						});
						$facturation.html('<input type="text" name="facturation" readonly="readonly" class="form-control" value="0">');
					}
			});

		$services.on('change', function() {
					if($services.val() != '') {
						$actes.empty(); 
						$facturation.empty();
							$.ajax({
									url: '../ajax/listeacte.php',
									data: 'idService='+ parseInt($services.val()), // on envoie $_GET['idService']
									dataType: 'json',
									success: function(json) {
										$actes.empty();	
										$facturation.append('<input type="text" name="facturation" readonly="readonly" class="form-control" value="0">');
										$actes.append('<option value="">-- Veuillez choisir un acte --</option>');
										$.each(json, function(index, value) {
											$actes.append('<option value="'+ index +'">'+ value +'</option>');
										});
									}
							});
					}
					else{
						$actes.empty();
						$facturation.empty();
						$facturation.html('<input type="text" name="facturation" readonly="readonly" class="form-control" value="0">');
					}
			});
			$actes.on('change', function() {
//				var $service = $services.val();
				var val = $(this).val();
				if(val != ''){
					$.ajax({
						url: '../ajax/facturation.php',
						data: $param +'&idService='+ parseInt($services.val()) +'&idActe='+ val,
						dataType: 'json',
						success: function(json) {
							$facturation.empty();
							$facturation.html('<input type="text" name="facturation" readonly="readonly" class="form-control" value=" '+ json +'">');
//							$max.append('<input type="numeric" min="0" max="'+ json +'" class="form-control" placeholder="Entrez le montant reçu" name="versement"/>');
						}
					});
				}
				else{
					$facturation.empty();
					$facturation.html('<input type="text" name="facturation" readonly="readonly" class="form-control" value="0">');
				}
			});
			$(".form").submit(function( event ){
			var val = $('#facturation > input[type=text]').val();
			var versement = $('#reglement').val();
			if(parseInt(versement)>=0){
				if(parseInt(val)>=parseInt(versement)){
					return;
				}
				else{
					alert('Veuillez saisir un montant inférieur ou égal ' + parseInt(val));
					event.preventDefault();
				}
			}
			else if(isNaN(parseInt(versement))){
				alert('Veuillez saisir la somme perçue');
				event.preventDefault();
			}
			else{
				alert('Veuillez saisir un montant supérieur à 0.');
				event.preventDefault();
			}
		});
	});
});

$('.open-popup-link.add').click(function(){
	var $val = $(this).attr('data');
	$services = $('.service').attr('value', $val);
	$(function () {
		var $actes = $('#acte');
		var versement = $('#reglement').val();
			if($val != '') {
				$actes.empty(); 
					$.ajax({
							url: '../ajax/listeacte.php',
							data: 'idService='+$val, // on envoie $_GET['idService']
							dataType: 'json',
							success: function(json) {
								$actes.empty();
								$actes.append('<option value="">-- Veuillez choisir un acte --</option>');
								$.each(json, function(index, value) {
									$actes.append('<option value="'+ index +'">'+ value +'</option>');
								});
							}
					});
			}
			else{
				$actes.empty();
//				$actes.append('<option value="">-- Acte --</option>');
			}
	});
});
var $operation = $('.operation');
var destination = $('.destination');
var inOut = $('#inOut');
$operation.on('change', function() {
var i = parseInt($operation.val());
if(i==0){
inOut.attr('value', 'in');
destination.attr('class', 'form-group destination hidden');
}else{
inOut.attr('value', 'out');
destination.attr('class', 'form-group destination');
}
});

var $batim = $('.batim');
var prod1 = $('.prod1');
var prod2 = $('.prod2');
$batim.on('change', function() {
var sel = parseInt($batim.val());
if(sel==1){
prod1.removeClass('hidden');
prod2.addClass('hidden');
}else{
prod1.addClass('hidden');
prod2.removeClass('hidden');
}
});
$("#centre").change(function () {
	var status = $('#centre option:selected').attr('value');
	bool = false;
	if(status==""){
		$("input").each(function(){
	    	$(".form-control:not(#centre), input").attr("disabled","disabled");
	    });
		return false;
	}
	else{
		bool = true;
	    $("input").each(function(){
	    	$(".form-control[disabled], input[disabled]").removeAttr("disabled");
	    });
	}
    $("form").submit(function(evt) {
    	if(bool== true){
    		$('#target').submit();
    	}
    	else {
    		alert('Veuillez selectionner un centre');
    		evt.preventDefault();
    	}
    });
  });