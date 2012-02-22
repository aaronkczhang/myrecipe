$(document).ready(function() {
	$('#comments a').live('click',function() {
		//var requestPage = {page: $(this).text()};
		var path = $(this).attr("href");
		var recipe_id = $('#comments').find('input').attr('value');
		var url = '/myrecipe/recipes/' + recipe_id + path;
		//alert(url);
		$.get(url, function(data) {
			$('#comments').html(data);
		})
		return false;
	})
})

