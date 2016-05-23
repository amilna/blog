<?php /*
<link href="//vjs.zencdn.net/4.12/video-js.css" rel="stylesheet">
<script src="//vjs.zencdn.net/4.12/video.js"></script>

<video id="example_video_1" class="video-js vjs-default-skin vjs-big-play-centered"
  controls preload="auto" width="620" height="360"  
  data-setup='{"example_option":true}'>  
  <source src="<?php echo $_GET['url'];?>" type='video/mp4' />
  <source src="<?php echo $_GET['url'];?>" type='video/webm' />  
  <source src="<?php echo $_GET['url'];?>" type='video/ogg' />
  <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a></p>
</video>
*/ ?>
<html>
<head>	
	<meta charset="UTF-8"/> 	
	<script src="jQuery-2.1.3.min.js"></script>
	<script src="jquery.flash.min.js"></script>
</head>	
<body>

<div id="blog_movie">
</div>


<script>	
$("#blog_movie").flash({
	'src':'gddflvplayer.swf',
	'width':'100%',
	'height':'100%',
	'allowfullscreen':'true',
	//'allowscriptaccess':'always',
	'wmode':'transparent',
	'flashvars': {
	'vdo':'<?php echo $_GET['url'];?>',
	'sound':'50',
	'splashscreen':'<?php echo $_GET['image'];?>',
	'autoplay':'<?php echo $_GET['auto']; ?>'
	//'clickTAG':'http://www.gdd.ro',
	//'endclipaction':'javascript:endclip();'
	}
});
</script>
</body>
</html>
