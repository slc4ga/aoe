<?
    $pageName = $_SERVER['PHP_SELF'];
?> 

<div class="col-md-3">
     
     <ul class="nav nav-pills nav-stacked">
        <li class="dropdown-header">Who are we?</li>
        <li <? if ($pageName == "/index.php") { echo "class=\"active\""; } ?> >
            <a href="/index.php">Home</a></li>
        <li <? if ($pageName == "/public/recruitment.php") { echo "class=\"active\""; } ?> >
            <a href="/public/recruitment.php">Recruitment</a></li>
        <li <? if ($pageName == "/sisters/sisters.php") { echo "class=\"active\""; } ?> >
            <a href="/sisters/sisters.php?select=1">Sisters</a></li>
        <li <? if ($pageName == "/public/contact.php") { echo "class=\"active\""; } ?> >
            <a href="/public/contact.php">Contact Us</a></li>
        <hr>
        <li class="dropdown-header">Useful links</li>
        <li ><a href="http://www.alphaomegaepsilon.org/">A&Omega;E National </a></li>
        <li ><a href="http://www.virginia.edu/">UVa Home </a></li>
        <li ><a href="http://seas.virginia.edu/">UVa Engineering</a></li>
    </ul>
     
 </div>