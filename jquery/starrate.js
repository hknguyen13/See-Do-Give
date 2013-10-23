
function SaveReview(){ //alert(ItemId); alert(page);
var review_title=$('#reviewtitle').val();
var desc=$('#desc').val();
var rate=$('#rating_value').val();
var itemid=$('#itemid').val();





if(rate=="")
{
	alert("Select rating");
	return false;
}
$.post("/index.php/iesinventory/IesReviewSubmit",{ItemId:itemid,Rating:rate,ReviewDesc:desc,Reviewtitle:review_title},function(data){
	   //alert(data);
		   if(data==1)
		   {
		   		//alert("test");
				$.ajax({ 
				type: "GET",
				//url: "update.php",
				url:"/index.php/iesinventory/IesGetRating",
				data: "itemid="+$("#itemid").val(), 
				cache: false,
				async: false, 
				success: function(result) { //alert(result);
					// apply star rating to element
					$("#show-rating").css({ width: "" + result + "%" });
					/*$("#current-rating-two").css({ width: "" + result + "%" });*/
				},
				error: function(result) {
					alert("some error occured, please try again later 10");
				}
			});
				 closebox5();
		   }
		});
}