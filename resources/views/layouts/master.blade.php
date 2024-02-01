
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Shambleskorner</title>
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
		{{-- <link rel="stylesheet" href="css/bootstrap.min.css"/>
		<script src="js/jquery2.js"></script>
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
                background-color: black;
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
	</head>
<body>
	
    @include('frontend.inc.header')
	
	@yield('content')

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