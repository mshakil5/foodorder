
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Shambleskorner</title>
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
		{{-- <link rel="stylesheet" href="css/bootstrap.min.css"/>
		<script src="js/jquery2.js"></script>
		Shambleskorner@123!
		<script src="js/bootstrap.min.js"></script> --}}
		<!-- <script src="js/main.js"></script> -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


        <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<style>
			@media screen and (max-width:480px){
				#search{width:80%;}
				#search_btn{width:30%;float:right;margin-top:-32px;margin-right:10px;}
			}
            ul {
            list-style-type: none;
            }
            .navheight{
                height: 100px;
                padding-top: 26px;
                background-color: #ffffff;
            }
            .list-group-item{
                position: relative;
                display: block;
                padding: 10px 15px;
                margin-bottom: -1px;
                background-color: #fff;
                border: 1px solid #337ab7 !important;
                }

			.modal-header{
				color: #ffffff;
				background-color: #337ab7;
				border-color: #337ab7;
			}



		</style>

		@yield('styles')
	</head>
<body>
	
    @include('frontend.inc.header')
	
	@yield('content')

				
<br><br>
<hr>
<div class="custom"  >



<center><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2347.4356877614537!2d-1.0835028244357812!3d53.95953042866852!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487931af517f817b%3A0x6007d198d80d50db!2s10%20Newgate%2C%20York%20YO1%207LA%2C%20UK!5e0!3m2!1sen!2sbd!4v1695314548804!5m2!1sen!2sbd" width="100%" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
    

</center>
<br/>
	<p style="text-align: center;">Copyright © 2023 Shambleskorner All Rights Reserved.<br />10 Newgate| 
 York |
YO1 7LA  </br> Design and Developed by . <a href="http://www.mentosoftware.co.uk" target="_blank" rel="lightbox noopener noreferrer">Mento Software</a></p></br></div>

    </div>

		<script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
		<script>
			$('body').on('focus',".date-picker", function(){
		        $(this).datepicker();
		    });
		</script>


		<style>
			.modal-scrol {
			max-height: 350px;
			overflow-y: scroll;
		}
		</style>


        @yield('script')


	<script>
		$(document).ready(function () {

			//header for csrf-token is must in laravel
			$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
			// select ticket type

			var url = "{{URL::to('/search-product')}}";

			$("#search").keyup(function(){
					event.preventDefault();
					var searchdata = $(this).val();
					console.log(searchdata);
					
					$.ajax({
					url: url,
					method: "POST",
					data: {searchdata:searchdata},
					success: function(d){
						$("#get_product").html(d.product);
						// console.log((d.min));
					},
					error:function(d){
						console.log(d);
					}
				});
			});
			
		});
	</script>

</body>
</html>