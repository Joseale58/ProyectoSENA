	<!--JQUERY-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <!--FONTAWESOME-->
    <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>  
    
	<!--Script - evitar boton volver del navegador -->
	<script type="text/javascript">
		if (window.history.replaceState) {
		window.history.replaceState(null, null, window.location.href);
		}
		function nobackbutton(){
		   window.location.hash="";	
		   window.location.hash="" //chrome	
		   window.onhashchange=function(){window.location.hash="";}
		}
	</script>

