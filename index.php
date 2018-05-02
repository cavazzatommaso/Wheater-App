<?php
date_default_timezone_set("Europe/Rome"); 
$date= strtoupper(date("M jS l", time()));
$db = mysqli_connect('localhost', 'root', 'raspberry', 'todo');
$tasks = mysqli_query($db, "SELECT * FROM tasks");
?>
<html>
<head>
    <meta charset="utf-8">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700,inherit,400" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="weather.css">
    <link rel="stylesheet" href="rasp.css">

    <script type="text/javascript">
        // PHP dependant js vars ~
        // page udate after t seconds
        setTimeout(function(){ document.forms["poster"].submit(); }, <?php echo $t; ?>);        
    </script>
    
</head>

<body>
    <div class ="col1">
       

        <div class="weather">
            <div class="w_left">
                <p class="temperature"></p>
                <p class="location"></p>
                <p class="updated" style="font-size:1em;"></p>
                <p class="data">Cosa bisogna fare?</p>
                <div id="show"></div>
                <script type="text/javascript" src="jquery.js"></script>
                <script type="text/javascript">
					$(document).ready(function(){
						setInterval(function(){
								$('#show').load('data.php')
							}, 3000);
						});
				</script>
            </div>
            
            <div class="w_right">
                <div class="climate_bg"></div>
				<p class="forecast"></p>
                
                <div class="info_bg"> 
                    <p class="i1"><img class="dropicon" src="images/Droplet.svg"><span class="humidity"></span></p>       
                    <p class="i2"><img class="windicon" src="images/Wind.svg"><span  class="windspeed"></span></p>
                    <div style="clear: both;"></div>
                </div>
            </div>
    
            <div style="clear: both;"></div>
        </div>

        <div id="nav">
             </div>
  
    </div>


    <div class="col2 <?php echo bg('col2'); ?>">
            <div class="dial">
      <div class="dot"></div>
      <div class="sec-hand"></div>
      <div class="sec-hand shadow"></div>
      <div class="min-hand"></div>
      <div class="min-hand shadow"></div>
      <div class="hour-hand"></div>
      <div class="hour-hand shadow"></div>
      <span class="twelve">12</span>
      <span class="three">3</span>
      <span class="six">6</span>
      <span class="nine">9</span>
      <span class="diallines"></span>
      <div class="date"></div>
   </div>
        </a>

        
    <div style="clear: both;"></div>

    <script src="jquery-2.2.3.min.js"></script>
    <script src="jquery.simpleWeather.min.js"></script>
    <script src="weather.js"></script>
    <script src="jsclock.js"></script>
    <script src="library.js"></script>

    
</body>
</html>

<?php
function bg($id){
    $col2=array('col1_sunrise','col1_morning','col1_midday','col1_evening','col1_night');
    $hr=date('H', time()); 

    if($hr<=5){
        $class=${$id}[4];
    }elseif($hr<=9){
        $class=${$id}[0];
    }elseif($hr<=12){
        $class=${$id}[1]; 
    }elseif($hr<=17){
        $class=${$id}[2];    
    }elseif($hr<=20){
        $class=${$id}[3];
    }else{
        $class=${$id}[4];
    }
    return $class;
}

function getHeadlines(){
    $html="";
    
    // NEWS FROM RSS FEED 
    // $file=file_get_contents("http://feeds.bbci.co.uk/news/rss.xml?edition=uk"); // BBC UK
    
    // FOR BBC US NEWS, JUST CHANGE THE 'edition' PARAMETER IN THE LINK ABOVE TO 'US'
    $file=file_get_contents("http://feeds.bbci.co.uk/news/rss.xml?edition=us"); // BBC US
    
    // OR TRY OTHER RSS NEWS FEEDS...
    // http://rss.nytimes.com/services/xml/rss/nyt/World.xml
    // http://www.cbc.ca/cmlink/rss-world
    
    preg_match_all("%<title>(.*?)</title>%s", $file, $titles,PREG_PATTERN_ORDER,920);
    preg_match_all("%<link>(.*?)</link>%s", $file, $links,PREG_PATTERN_ORDER,920);
    preg_match_all("%<description>(.*?)</description>%s", $file, $desc,PREG_PATTERN_ORDER,920);

    for($i=0;$i<=19;$i+=2){
        $html.="'<a href=\"".$links[1][$i]."\">".clean($titles[1][$i])."</a><br><span>".clean($desc[1][$i])."</span>',";
    }
    return $html;
}

function clean($val){
    $val=str_replace("'","",$val);
    $val=str_replace("<![CDATA[","",$val);
     $val=str_replace("]]>","",$val);
    return $val;
}

function getS($streams){
$output=1;
    if(isset($_GET['s']) && array_key_exists($_GET['s'],$streams)){
        $output=$_GET['s'];
    } 
    return $output;
}

function isPlaying($key){
    $c="";
    if($_GET['s']==$key){
        $c=" play";
    }
    return $c;
}
?>
