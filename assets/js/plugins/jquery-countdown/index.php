<span id="clock"></span>

 <script src="//code.jquery.com/jquery.js"></script>
<script type="text/javascript" src="jquery.countdown.js"></script>
<script type="text/javascript" src="jquery.countdown.min.js"></script>

<script type="text/javascript">
	$('#clock').countdown('2020/10/10', function(event) {
	  $(this).html(event.strftime('%D days %H:%M:%S'));
	});
</script>