// JavaScript Document
	$(document).ready(function() {//alert('load time');
		// get current rating
		//getRating(); 
		// get rating function
		/*function getRating(){ //alert('Jai Ram'); 
			$.ajax({ 
				type: "GET",
				url:"/index.php/user/usergetrating",
				data: "userid="+$("#userid").val(), 
				cache: false,
				async: false, 
				success: function(result) { //alert(result);
					// apply star rating to element
					$("#show-rating").css({ width: "" + result + "%" });
					/*$("#current-rating-two").css({ width: "" + result + "%" });*/
				/*},
				error: function(result) {
					alert("some error occured, please try again later 10");
				}
			});
		}*/

		
		// link handler
		$('#ratelinks li a').click(function(){ 
			$('#rating_value').val($(this).text());
			var rate=(parseInt($(this).text())*20);
			$("#current-rating").css({ width: "" + rate+ "%" });
						
		});
	});
