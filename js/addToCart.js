
$(".add_to_cart").click(function(){

	$.ajax({
		url: 'https://localhost/netbeans/eShop/buyer/addToCart.php',
		type: 'POST',
		data: {product_id:$(this).data('id')},
		success: function(d) {
			if(d=="success")
				window.location.reload(true);
		},
		error: function() {
			
		}
	});

});

$(".delete_product").click(function(){

	$.ajax({
		url: 'https://localhost/netbeans/eShop/buyer/deleteProduct.php',
		type: 'POST',
		data: {product_id:$(this).data('id')},
		success: function(d) {
			window.location.reload(true);
		},
		error: function() {
			
		}
	});

});

$(".qty").bind('keyup mouseup', function () {
    $.ajax({
		url: 'https://localhost/netbeans/eShop/buyer/changeQuantity.php',
		type: 'POST',
		data: {product_id:$(this).data('id'), previous:$(this).data('previousValue'),quantity:$(this).val()},
		success: function(d) {
			window.location.reload(true);
		},
		error: function() {
			
		}
	});            
});

$(".qty").each(function () {
    $(this).data("previousValue", $(this).val());
});