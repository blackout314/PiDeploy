<?php
/**
 * PiDeploy responsive test suite
 */
include 'inc.config.php';
$url = $_GET['url'];

if( $url ) {
	$url = str_replace('-','/',$url);

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="Responsive design testing for the masses">
	<title><?php echo TITLE; ?> - responsive view</title>
	<style>
		*{vertical-align:top;}
		body{padding:20px;font-family:sans-serif;overflow-y:scroll;}
		h2{margin:0 0 20px 0;}
		span.small{font-size:60%;vertical-align:middle;}
		#url{margin:0 0 20px 0px;display:block;}
		#url input[type=text]{border:solid 1px #666;width:85%;margin:0 auto;font-size:2em;text-align:left;}
		#url input[type=submit]{display:none;}
		#url #options{float:right;line-height:25px;width:13%;}
		#url #options input{margin-top:5px;}
		#frames{overflow-x:scroll;width:100%;margin-bottom:10px;padding-bottom:20px;}
		.frame{margin-right:20px;float:left;}
		.frame:last-child{margin-right:0;}
		.frame img{display:none;vertical-align:middle;}
		iframe{border:solid 1px #000;}
		.widthOnly {height:580px;}
		.widthOnly h2 span{display:none;}
		.widthOnly iframe{height:500px;}
	</style>
</head>
<body id="container">
	<!--
	<div id="url">
		<form method="post">
			<input type="text" placeholder="Test your own site... type the url and hit enter" />
			<input type="submit" value="submit">
			<div id="options">
				<label for="normal"><input id="normal" type="radio" name="option" value="1" checked>Width only</label><br />
        <label for="accurate"><input id="accurate" type="radio" name="option" value="2">Device sizes</label><br />
				<label for="scrollbar"><input id="scrollbar" type="checkbox" name="scrollbar" value="1" checked>Visible Scrollbars</label>
			</div>
		</form>
	</div>
	-->
	<div id="frames" class="widthOnly">
		<div id="inner">
			<div id="f1" class="frame">
				<h2>240<span> x 320</span> <span class="small">(small phone)</span> <img src="http://mattkersley.com/wp-content/themes/mattkersley/images/loader_large.gif" /></h2>
				<iframe sandbox="allow-same-origin allow-forms allow-scripts" seamless width="255" height="320"></iframe>
			</div>
			<div id="f2" class="frame">
				<h2>320<span> x 480</span> <span class="small">(iPhone)</span> <img src="http://mattkersley.com/wp-content/themes/mattkersley/images/loader_large.gif" /></h2>
				<iframe sandbox="allow-same-origin allow-forms allow-scripts" seamless width="335" height="480"></iframe>
			</div>
			<div id="f3" class="frame">
				<h2>480<span> x 640</span> <span class="small">(small tablet)</span> <img src="http://mattkersley.com/wp-content/themes/mattkersley/images/loader_large.gif" /></h2>
				<iframe sandbox="allow-same-origin allow-forms allow-scripts" seamless width="495" height="640"></iframe>
			</div>
			<div id="f4" class="frame">
				<h2>768<span> x 1024</span> <span class="small">(iPad - Portrait)</span> <img src="http://mattkersley.com/wp-content/themes/mattkersley/images/loader_large.gif" /></h2>
				<iframe sandbox="allow-same-origin allow-forms allow-scripts" seamless width="783" height="1024"></iframe>
			</div>
			<div id="f5" class="frame">
				<h2>1024<span> x 768</span> <span class="small">(iPad - Landscape)</span> <img src="http://mattkersley.com/wp-content/themes/mattkersley/images/loader_large.gif" /></h2>
				<iframe sandbox="allow-same-origin allow-forms allow-scripts" seamless width="1039" height="768"></iframe>
			</div>
		</div>
	</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js"></script>
<script>
var defaultURL = '<? echo $url; ?>';

//show loading graphic
function showLoader(id) {
  $('#' + id + ' img').fadeIn('slow');
}

//hdie loading graphic
function hideLoader(id) {
  $('#' + id + ' img').fadeOut('slow');
}

//function to check load state of each frame
function allLoaded(){
  var results = [];
  $('iframe').each(function(){
    if(!$(this).data('loaded')){results.push(false)}
  });
  var result = (results.length > 0) ? false : true;
  return result;
};

function loadPage($frame, url) {
  if ( url.substr(0,7) !== 'http://' && url.substr(0,8) !== 'https://' && url.substr(0, 7) !== 'file://' ) {
    url = 'http://'+url;
  }
  $('iframe').not($frame).each(function(){showLoader($(this).parent().attr('id'));})
  $('iframe').not($frame).data('loaded', false);
  $('iframe').not($frame).attr('src', url);
}

$('.frame').each(function(){showLoader($(this).attr('id'))});


//when document loads
$(document).ready(function(){

  loadPage('', defaultURL);

  //query string
  var qsArray = window.location.href.split('?');
  var qs = qsArray[qsArray.length-1];

  if(qs != '' && qsArray.length > 1){
    $('#url input[type=text]').val(qs);
    loadPage('', qs);
  }

  //set slidable div width
  $('#frames #inner').css('width', function(){
    var width = 0;
    $('.frame').each(function(){width += $(this).outerWidth() + 20});
    return width;
  });

  //add event handlers for options radio buttons
  $('input[type=radio]').change(function(){
    $frames = $('#frames');
    $inputs = $('input[type=radio]:checked').val();

    if($inputs == '1'){
      $frames.addClass('widthOnly');
    } else {
      $frames.removeClass('widthOnly');
    }
  });

  //add event handlers for scrollbars checkbox
  $('input[type=checkbox]').change(function(){
    var scrollBarWidth = 15;
    $frames = $('#frames');
    $inputs = $('#scrollbar:checked');

    if( $inputs.length == 0 ){
      scrollBarWidth = -15;
    }

    $frames.find('iframe').each(function(i,el) {
      $(el).attr('width', parseInt($(el).attr('width')) + scrollBarWidth);
    });
  });

  //when the url textbox is used
  $('form').submit(function(){
    loadPage('' , $('#url input[type=text]').val());
    return false;
  });

  //when frame loads
  $('iframe').load(function(){

    var $this = $(this);
    var url = '';
    var error = false;

    try{
      url = $this.contents().get(0).location.href;
    } catch(e) {
      error = true;
      if($('#url input[type=text]').val() != ''){
        url = $('#url input[type=text]').val();
      } else {
        url = defaultURL;
      }
    }

    //load other pages with the same URL
    if(allLoaded()){
      if(error){
        alert('Browsers prevent navigation from inside iframes across domains.\nPlease use the textbox at the top for external sites.');
        loadPage('', defaultURL);
      }else{
        loadPage($this, url);
      }
    }

    //when frame loads, hide loader graphic
    else{
      error = false;
      hideLoader($(this).parent().attr('id'));
      $(this).data('loaded',true);
    }
  });

});
</script>

</body>
</html>
<?
}

// -- eof
?>
