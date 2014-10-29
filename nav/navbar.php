<?
    $pageName = $_SERVER['PHP_SELF'];
    $pos = strpos($pageName, "about.php");
?>
<div class="row">
   <div class="col-md-9">
      <h1><a href="/">Alpha Omega Epsilon @ UVa</a></h1>
      <h4 style="margin-left: 40px;">pi chapter est. 2005</h4>
   </div>
   <div class="col-md-3" style="margin-top: 40px; height: 40px;">
       <form class="form-inline">  <fieldset>
         <input type="text" class="form-control" id='searchText' name='searchText' style="width: 70%" placeholder="Search A.O.E @ UVa">
         <a href="#searchbox" class="btn btn-primary btn-sm" id='submitBtn' name='submitBtn' >Submit</a>
       </fieldset></form>
   </div>
</div>
<br><br>

<div class="navbar navbar-default" role="navigation">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mainnavbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <div class="navbar-collapse collapse" id="mainnavbar">
        <ul class="nav navbar-nav">
            <li <? if ($pageName == "/index.php") { echo "class=\"active\""; } ?> >
                <a href="/">Home</a></li>
            <li id="about" class="dropdown">
                <a id="drop1" href="" role="button" class="dropdown-toggle" data-toggle="dropdown">About 
                    <b class="caret"></b></a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="/about/about.php?select=1">
                        A&Omega;E History</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="/about/about.php?select=2">
                        Pi History</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="/about/about.php?select=3">
                        Mission Statement</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="/about/about.php?select=4">
                        Ideals and Objectives</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="/about/about.php?select=5">
                        Testimonials</a></li>
                </ul>
            </li>
            <li <? if ($pageName == "/public/recruitment.php") { echo "class=\"active\""; } ?> > 
                <a href="/public/recruitment.php">Recruitment </a></li>
            <li id="sisters" class="dropdown">
                <a id="drop1" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Sisters 
                    <b class="caret"></b></a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="/sisters/sisters.php?select=1">
                        Kappa Class</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="/sisters/sisters.php?select=2">
                        Lambda Class
                        </a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="/sisters/sisters.php?select=3">
                        Mu Class</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="/sisters/sisters.php?select=5">
                        Nu Class</a></li>
                    <li role="presentation" class="divider"></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="/sisters/sisters.php?select=4">
                        Alumnae</a></li>
                </ul>
            </li>
            <li id="leadership" class="dropdown">
                <a id="drop1" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">Leadership 
                    <b class="caret"></b></a>
                <ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="/public/leadership.php?select=1">
                        Exec. Board</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="/public/leadership.php?select=2">Chairs
                        </a></li>
                </ul>
            </li>
            <li <? if ($pageName == "/public/photos.php") { echo "class=\"active\""; } ?> >
                <a href="/public/photos.php">Photos</a></li>
            <li <? if ($pageName == "/public/contact.php") { echo "class=\"active\""; } ?> >
                <a href="/public/contact.php">Contact</a></li>
        </ul>
        <ul class="nav navbar-nav pull-right" role="navigation">
            <?
                if(isset($_SESSION['user_id'])) {
                    echo "<li id=\"account\"";
                    echo "> <a href=\"/users/userHome.php\">My Account </a></li>";
                }
            ?>

                <?
                if(!isset($_SESSION['user_id'])) {
                    echo "<li class=\"dropdown\">";
                    echo "<a class=\"dropdown-toggle\" href=\"#\" data-toggle=\"dropdown\">Sign In  
                        <strong class=\"caret\"></strong></a>
                    <div class=\"dropdown-menu\" style=\"padding: 15px; width:225px\">
                <!-- Login form here -->";
                    //$root = realpath($_SERVER["DOCUMENT_ROOT"]);
                    include "nav/login.php";
                    echo "</div></li>";
                } else {
                    echo "<li> <a href=\"/nav/logout.php\">Logout </a></li>";
                }
                ?>
                <li></li>
        </ul>
    </div>
</div>

<div style='display:none'>
     <div id='searchbox' style='padding:20px; background:#fff;'>
         <h3>Test</h3>
     </div>
</div>
<script type="text/javascript">
      var select = window.location.href.toString();
      if(select.indexOf("about.php") > -1) {
            document.getElementById("about").className += " active";
      }
      if(select.indexOf("leadership.php") > -1) {
            document.getElementById("leadership").className += " active";
      }
      if(select.indexOf("sisters.php") > -1) {
            document.getElementById("sisters").className += " active";
      }
      if(select.indexOf("userHome.php") > -1 || select.indexOf("webmaster.php") > -1) {
            document.getElementById("account").className += " active";
      }
</script>
<script src="../bootstrap/colorbox/jquery.colorbox.js"></script>
<link rel="stylesheet" href="../bootstrap/colorbox/example4/colorbox.css" type="text/css">
<script type="text/javascript"> 
   var res = window.location.href.split("/");
   var spot = res[0] + "//" + res[2] + "/" + "nav/search.php";
  $('#submitBtn').colorbox({
    width:'60%', 
    height:"70%",
    href: function(){ return spot + "?term=" + $("#searchText").val(); }
});
</script>