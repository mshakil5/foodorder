
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Shambleskorner</title>
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
		<script src="js/jquery2.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<!-- <script src="js/main.js"></script> -->

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
                height: 70px;
                padding-top: 10px;
                background-color: black;
            }
            .list-group-item{
                position: relative;
                display: block;
                padding: 10px 15px;
                margin-bottom: -1px;
                background-color: #fff;
                border: 1px solid #FF4C00 !important;
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




</body>
</html>