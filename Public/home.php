<?PHP

/*
 * Copyright (c) 2016, 2028 NuMode
 * All rights reserved.
 * 
 * This file is part of Placeroll.
 * 
 * Placeroll is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Placeroll is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.  
 * 
 * You should have received a copy of the GNU General Public License
 * along with Placeroll. If not, see <https://www.gnu.org/licenses/>.
 * config.inc
 * 
 * Placeroll Home.
 *
 * @author Daniele Bonini <my25mb@aol.com>
 * @copyrights (c) 2021, 2028 NuMode 
 */

 function grabProfileImage($avatar_name) {
   
   $AVATAR_PATH = APP_DATA_PATH . DIRECTORY_SEPARATOR . $avatar_name;
   $AVATARPIC_PATH = $AVATAR_PATH . DIRECTORY_SEPARATOR . "avatar";
   
   $pattern = $AVATARPIC_PATH . DIRECTORY_SEPARATOR . "*";
   $aImagePaths = glob($pattern);
   if (isset($aImagePaths[0])) {
     $retval = basename($aImagePaths[0]);
   } else {
     $retval = null;
   }
   return $retval;
   
 }

// PAGE PARAMETERS
 $lang = APP_DEF_LANG;
 $lang1 = substr(strip_tags(filter_input(INPUT_GET, "hl")??""), 0, 5);
 if ($lang1 !== PHP_STR) {
   $lang = $lang1;
 }
 $shortLang = getShortLang($lang);
 
?> 

<!DOCTYPE html>
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml">
<head>

  <meta name="viewport" content="width=device-width, initial-scale=1"/>
   
<!--<?PHP echo(APP_LICENSE);?>-->  
  
  <title><?PHP echo(APP_TITLE);?></title>

  <link rel="shortcut icon" href="/favicon.ico" />

  <meta name="description" content="Welcome to Placeroll! Let everyone have its place."/>
  <meta name="keywords" content="place,roll,placeroll,on,premise,solution,NuMode"/>
  <meta name="robots" content="index,follow"/>
  <meta name="author" content="NuMode"/>
  
  <script src="/js/jquery-3.6.0.min.js" type="text/javascript"></script>
  <script src="/js/sha.js" type="text/javascript"></script>
  <script src="/js/common.js" type="text/javascript"></script>
  <script src="/js/bootstrap.min.js" type="text/javascript"></script>  
    
  <link href="/css/style-biteidea.css?r=<?PHP echo(time());?>" type="text/css" rel="stylesheet">
  
  <link href="/css/bootstrap.min.css" type="text/css" rel="stylesheet">
   
</head>
<body style="background:#dadada no-repeat; background-size: cover; background-attachment: fixed; background-position: center;">

<?php if (file_exists(APP_PATH . DIRECTORY_SEPARATOR . "jscheck.html")): ?>
<?php include(APP_PATH . DIRECTORY_SEPARATOR . "jscheck.html"); ?> 
<?php endif; ?>

    <div id="HCsplash" style="padding-top: 40px; text-align:center;color:#ffffff;display:none;">
       <div id="myh1"><H1 style="font-weight:900">TRIP IDEA!</H1></div><br/>
       <img src="/res/AFlogo.png" style="width:310px;"/>
    </div>      
                  
   <!--<div id="AFHint">
        <button type="button" class="close" aria-label="Close" onclick="closeMe(this);" style="position:relative; top:5px; left:-7px;">
           <span aria-hidden="true" style="color:black; font-weight:900;">&times;</span>
       </button>
       <br>  
      <span onclick="showHowTo();"><?PHP echo(getResource0("How-to: Manage your avatars in Puzzleu", $lang));?></span>
      <br><br>
   </div> -->
   
   <br>
   
   <div id="header" class="header" style="margin-top:18px;margin-bottom:18px;display:none;">
        <div style="float:left">
            <a href="<?PHP echo(APP_WEBDIR);?>" target="_self" style="color:#000000; text-decoration: none;"><img id="piclogo" src="/res/AFlogo.png" align="middle">&nbsp;<span id="avatarTitle"><?PHP echo(strtoupper(APP_NAME));?></span></a>
        </div>
   </div>
   <div id="headerMob" class="header" style="margin-top:18px;margin-bottom:18px;display:none">
        <div style="float:left">
             <a href="<?PHP echo(APP_WEBDIR);?>" target="_self" style="color:#000000; text-decoration: none;"><img id="piclogo" src="/res/AFlogo.png" align="middle">&nbsp;<span id="avatarTitle"><?PHP echo(strtoupper(APP_NAME));?></span></a>
        </div>   
   </div>
   
   <br>  
         
   <form id="frmUpload" role="form" method="post" action="/?hl=<?PHP echo($lang);?>" target="_self" enctype="multipart/form-data">  
      
<?PHP

   $pattern = APP_DATA_PATH . DIRECTORY_SEPARATOR . "*" . DIRECTORY_SEPARATOR . "blog" . DIRECTORY_SEPARATOR . "*";
   $aFiles = glob($pattern);
   $aFiles2 = [];
   
   foreach($aFiles as $path) {
      $orifilename = basename($path);
      $filename = explode("|", basename($path))[2];
      $fileExt = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
      if ($fileExt === "jpg" || $fileExt === "png") {
        $aFiles2[$orifilename] = $path;
      }
   }
   
   krsort($aFiles2);

   // SET A MAX 50 ITEMS ARRAY
   $aFiles2 = array_slice($aFiles2, 0, APP_HOME_MAX_ITEMS);

?>

<br><br>

<table style="width:95%">

<?PHP         
  $i=0;
   foreach($aFiles2 as $key => $val) {
      $i++;
      $ipos1 = mb_stripos($val, "/data/");
      $ipos2 = mb_stripos($val, "/blog/");
      $AVATAR_NAME = substr($val, $ipos1 + 6, ($ipos2 - ($ipos1+6))); 
      $AVATAR_PATH = APP_DATA_PATH . DIRECTORY_SEPARATOR . $AVATAR_NAME;
      $BLOG_PATH = $AVATAR_PATH . DIRECTORY_SEPARATOR . "blog";         
      $profilePic = grabProfileImage($AVATAR_NAME) ?? APP_DEF_PROFILE_PIC;
      $filename = "$key";
      $orifilename = explode("|",$filename)[2];
      $extlen = strlen(pathinfo($orifilename, PATHINFO_EXTENSION));
      $title = left($orifilename, strlen($orifilename) - ($extlen+1));
      $title = str_replace("_", " ", $title);
      $title = ucfirst($title);
      $place = explode("|",$filename)[1];
      $place = str_replace("_", " ", $place);
      $orifilename2 = $filename;
      $desc = file_get_contents($BLOG_PATH . DIRECTORY_SEPARATOR . left($orifilename2, strlen($orifilename2) - ($extlen+1)) . ".txt1");      
      $desc = ucfirst($desc);
      //echo("<img id=\"picavatarp\" src=\"/img?av=" . $AVATAR_NAME . "&pic=" .  $profilePic . "\" align=\"middle\">" . $AVATAR_NAME  . "-" .  $filename . "<br>");
      
      $background1 = ""; //"#bfd5ec";
      $background2 = "#d3c4ae";
?>

        <tr>
           <td style="width: 160px;text-transform: uppercase; white-space: nowrap; font-weight:900;border:1px solid #000000;background:<?PHP echo($i%2===0?$background1:$background2);?>">
              <a href="<?PHP echo(APP_WEBDIR);?><?PHP echo($AVATAR_NAME);?>" target="_self" style="color:#000000; text-decoration: none;"><img id="picavatarp" src="<?PHP echo(APP_WEBDIR);?>img?av=<?PHP echo($AVATAR_NAME);?>&pic=<?PHP echo($profilePic);?>" align="middle">&nbsp;&nbsp;&nbsp;<span style="position:relative;top:+2px;text-decoration:underline"><?PHP echo($AVATAR_NAME);?></span></a>
           </td>
           <td style="width: 300px; vertical-align:top;font-weight:900;border:1px solid #000000;background:<?PHP echo($i%2===0?$background1:$background2);?>">
              <?PHP echo($title);?>&nbsp;(<?PHP echo($place);?>)
           </td>           
           <td style="vertical-align:top;border:1px solid #000000;background:<?PHP echo($i%2===0?$background1:$background2);?>">
              <?PHP echo($desc);?>
           </td>           
        </tr>
<?PHP
   }
?>   

     </table>
   </form>

  <br><br><br>

  <div id="halSys" class="col-xs-12 col-sm-10 col-md-10 col-lg-7 col-xl-5 col-haligned input-group" style="display: none; position:fixed; top:-85px; left:-35px;">
 
   <div class="input-group-btn" style="border: 0px solid red;">
     <span id="halTerm" style="float: left; position:relative; left:+4%; top: +2px; cursor:pointer;"><img id="hal" src="/res/hal2_closed.png" style="width: 52px; position:relative; left:+5px;"></span>
     <div id="halBoard" style="float: left; position:relative; left:+5%; top: +2px; display: none;">

      <?PHP if (defined("APP_EMAIL_CONTACT") && APP_EMAIL_CONTACT!==PHP_STR): ?>
      <h3 class="board-entry" style="border-radius:3px;font-size: 1.45vw; font-weight:700; float:left; background-color:lightgray; margin-right:4px; padding:4px;">
        &nbsp;&nbsp;<a id="halContact" href="mailto:<?PHP echo(APP_EMAIL_CONTACT);?>" style="cursor:pointer; color: #000000;"><?PHP echo(APP_EMAIL_CONTACT);?></a>&nbsp;&nbsp;
      </h3>
      <?PHP Endif; ?>

     </div>
   </div>  
 </div>

  <div id="footerCont">&nbsp;</div>
  <div id="footer1" style="float:left; width:80px;">
        <select id="cbLang" onchange="changeLang(this);">
          <option value="en-US" <?PHP echo($lang==PHP_EN?"selected":"");?>>en</option>
            <option value="it-IT" <?PHP echo($lang==PHP_IT?"selected":"");?>>it</option>
            <option value="zh-CN" <?PHP echo($lang==PHP_CN?"selected":"");?>>cn</option>
        </select> 
    </div>
    <div id="footer2" style="float:right; width:450px;">
        <span style="background:#FFFFFF; opacity:0.7;">get <a id="fooddishlink" href="https://github.com/par7133/Placeroll/">Placeroll!</a>&nbsp;&nbsp;A <a href="http://numode.eu" class="aaa">NuMode</a> project.</span>
    </div>

<script>
function setFooterPos() {
  if (document.getElementById("footerCont")) {
    tollerance = 16;
    $("#footerCont").css("top", parseInt( window.innerHeight - $("#footerCont").height() - tollerance ) + "px");
    $("#footer1").css("top", parseInt( window.innerHeight - $("#footer1").height() - tollerance ) + "px");
    $("#footer2").css("top", parseInt( window.innerHeight - $("#footer2").height() - tollerance ) + "px");
    $("#footer2").css("left",  parseInt( window.innerWidth - $("#footer2").width() - tollerance ) + "px");
    $("#footer").css("top", parseInt( window.innerHeight - $("#footer").height() - tollerance ) + "px");
    
    if (window.innerWidth < 650) {
      $("#fooddishlink").hide();
    } else {
      $("#fooddishlink").show();    
    }
  }
}

window.addEventListener("load", function() {

  setTimeout("setFooterPos()", 1000);

}, true);

window.addEventListener("resize", function() {

  setTimeout("setFooterPos()", 1000);

}, true);
</script>

<script>

  var bHal = false;

  $("span#halTerm").on("click",function(e) {
    bHal=!bHal;
    if (bHal) {
      document.getElementById("hal").src = '/res/hal2_open.png';
      $("div#halBoard").show("fast");
    } else {  
      document.getElementById("hal").src = '/res/hal2_closed.png';
      $("div#halBoard").hide("slow");
    }  
  });  

  function setHalPos() {
    bodyRect = document.body.getBoundingClientRect();
    //document.getElementById('q').write = bodyRect.width;
    bHal=false;
    document.getElementById("hal").src = '/res/hal2_closed.png';
    $("div#halBoard").hide();
    if (parseInt(bodyRect.width) < 690) {
      $("div#predSys").hide();
      $("div#halSys").hide();
    } else {
      $("div#predSys").show();
      $("div#halSys").show();
    }
    if (parseInt(bodyRect.width) > 1200) {
      $("h3.board-entry").css("font-size", "1.0vw");
      $("a#halCVOptions").css("font-size", "1.0vw");
      $("span#halTerm").css("left", "+3%");
      $("div#halBoard").css("left", "+3%");
    } else if (parseInt(bodyRect.width) < 800) {  
      $("h3.board-entry").css("font-size", "14px");
      $("a#halCVOptions").css("font-size", "14px");
      $("span#halTerm").css("left", "+0%");
      $("div#halBoard").css("left", "+0%");
    } else {
      $("span#halTerm").css("left", "+8%");
      $("div#halBoard").css("left", "+9%");
      $("h3.board-entry").css("font-size", "1.45vw");  
      $("a#halCVOptions").css("font-size", "1.45vw");
    }
    tollerance = 50;
    $("div#halSys").css("top", parseInt( window.innerHeight - $("div#halSys").height() - tollerance ) + "px");
  }  

  window.addEventListener("load", function() {
    setTimeout("setHalPos()", 100);
  }, true);  

  window.addEventListener("resize", function() {
    setTimeout("setHalPos()", 100);
  }, true);  

</script>

<script>
  function changeLang(tthis) {
    window.open("<?PHP echo(APP_WEBDIR);?><?PHP echo($AVATAR_NAME);?>?hl="+$(tthis).val(),"_self");
  }
</script>


<script>
    
    function hideTitle() {
      $("#myh1").hide("slow");
    }

    function startApp() {
      $("#HCsplash").hide("slow");
      //$(document.body).css("background","url('/res/demoris_ad.png')");
      //$("#content").show();
      //getQueryString();      
      //Init(QStype, QSmaterial, QSplace);
      $("#header").show();
    }			

    window.addEventListener("load", function() {
      $("#HCsplash").css("color","#000000");
      $("#HCsplash").show("slow");	  
      setTimeout("hideTitle()", 4000);
      setTimeout("startApp()", 2000);
    }, true);
    
</script>

</body>
</html>
