<?php
require_once "headers.php";
?>
		<!--End Navbar-->
		<!--Video-->
		<div class="row">
			<div class="col-sm-7" style="padding-top: 110px; padding-left: 40px;">
				<!-- 16:9 aspect ratio -->
				<div class="embed-responsive embed-responsive-16by9">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $_POST['id'];?>?rel=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
			</div>
			<div class="col-sm-5" style="padding-top: 120px; padding-right: 50px;">
				<div class="panel panel-warning">
					<div class="panel-footer">
						<b><h4><?php echo $_POST['title'];?></h4></b>
						<div >
							<div class="rating">
					            <span class="rating-star" data-value="5"></span>
					            <span class="rating-star" data-value="4"></span>
					            <span class="rating-star" data-value="3"></span>
					            <span class="rating-star" data-value="2"></span>
					            <span class="rating-star" data-value="1"></span>
					        </div>
					        
					        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
					        <script>
					        $('.rating-star').click(function() {
					            $(this).parents('.rating').find('.rating-star').removeClass('checked');
					            $(this).addClass('checked');
					                
					            var submitStars = $(this).attr('data-value');
					        });
					        </script>
						</div>
					</div>
					<div class="panel-body" style="/*background-color: rgba(252, 253, 149, 0.3)*/"><?php echo $_POST['description'];?></div>
				</div>

			</div>
		</div>
	

		
		<div class="row" style="padding-top: 50px; padding-left: 100px; padding-bottom: 0px; margin-bottom: 50px;">
			<a href="#">	
				<div class="col-sm-4 col-md-2">
				    <div class="thumbnail">
				    	<img src="../MN24.jpg" alt="...">
				    </div>
				</div>
				<div class="col-sm-6 col-md-6">
					<div class="caption">
					    <h3>Thumbnail label</h3>
					    <p>Lorem ipsum dolor sit amet, eu aperiam luptatum abhorreant mel, ignota pericula deseruisse eos cu.Lorem ipsum dolor sit amet, eu aperiam luptatum abhorreant mel, ignota pericula deseruisse eos cu.Lorem ipsum dolor sit amet, eu aperiam luptatum abhorreant mel, ignota pericula deseruisse eos cu.</p>
					</div>
				</div>
			</a>
		</div>
		<!----------------------------------------------->
		

</html>
<?php
require_once "footer.php";
?>