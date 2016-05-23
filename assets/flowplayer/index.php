<html>
<head>	
	<meta charset="UTF-8"/> 
	<script type="text/javascript" src="./flowplayer-3.2.13.min.js"></script>		
</head>	
<body>
	<a  
		 href="<?php echo $_GET['url']; ?>"
		 style="display:block;width:100%;height:100%"  
		 id="player"> 
	</a> 

	<script>
		flowplayer("player", "./flowplayer-3.2.18.swf",{
			clip:  {
				  autoPlay: <?php echo $_GET['auto']; ?>,
				  autoBuffering: true
			  }
		});
	</script>
</body>
</html>
