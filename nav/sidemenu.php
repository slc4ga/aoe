<?
    $pageName = $_SERVER['PHP_SELF'];
?> 

<div class="col-md-3">
     
     <ul class="nav nav-pills nav-stacked">
        <li class="nav-header">Who we are?</li>
        <li <? if ($pageName == "/~Steph/AOE/index.php") { echo "class=\"active\""; } ?> >
            <a href="/~Steph/AOE/index.php">Home</a></li>
        <li <? if ($pageName == "/~Steph/AOE/public/recruitment.php") { echo "class=\"active\""; } ?> >
            <a href="/~Steph/AOE/public/recruitment.php">Recruitment</a></li>
        <li <? if ($pageName == "/~Steph/AOE/sisters/sisters.php") { echo "class=\"active\""; } ?> >
            <a href="/~Steph/AOE/sisters/sisters.php">Sisters</a></li>
        <li <? if ($pageName == "/~Steph/AOE/public/contact.php") { echo "class=\"active\""; } ?> >
            <a href="/~Steph/AOE/public/contact.php">Contact Us</a></li>
        <hr>
        <li class="nav-header">Useful links</li>
        <li ><a href="http://www.alphaomegaepsilon.org/">A&Omega;E National </a></li>
        <li ><a href="http://www.virginia.edu/">UVa Home </a></li>
        <li ><a href="http://seas.virginia.edu/">UVa Engineering</a></li>
    </ul>
     
 </div>