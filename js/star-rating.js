$('.rating-star').click(function() {
			            $(this).parents('.rating').find('.rating-star').removeClass('checked');
			            $(this).addClass('checked');
			                
			            var submitStars = $(this).attr('data-value');
			            alert(submitStars);
			        });