<?php
header("Content-type: text/css");

/*  Define site colours  */

$style["SharpGreen"] = "#6BCC02";
$style["BlueWash"] = "#F8FAFE";
$style["PostBackground"] = "#FFFFFF";
$style["PostForeground"] = "#000000";
$style["Black"] = "#000000";
$style["OrangeHighlight"] = "red";
$style["LinkBlue"] = "#0000C0";
$style["SignYellow"] = "#FFD43F";
$style["LightYellow"] = "#FFD43F";
$style["LightGrey"] = "#C0C0C0";
$style["DarkGrey"] = "#404040";
$style["PanelBorder"] = "#CCC";

if(isset($theme) && $theme == 'dark') {
	$style["BlueWash"] = "#000000";
	$style["PostBackground"] = "#000000";
	$style["PostForeground"] = "#909090";
	$style["PanelBorder"] = "#404040";
}

?>

@charset "utf-8";
/*
Theme Name: Deconflations
Theme URI: www.deconflations.com
Description: Custom theme for deconflations
Author: Duncan Kimpton
Author URI: www.deconflations.com
Template:
Version: 2
.
.
*/
html {overflow-y: scroll;}

a[href^="http:"], a[href^="https:"] {
 background: url(offsite.png) no-repeat right top;
    padding-right: 16px;
}

a[href^="http://www.deconflations.com"], a[href^="http:// deconflations.com"],
a[href^="https://www.deconflations.com"], a[href^="https:// deconflations.com"] ,
a[href^="http://192.168.0.52"], a[href^="http:// 192.168.0.52"],
a[href^="https://192.168.0.52"], a[href^="https:// 192.168.0.52"] {
 background-image: none;
 padding-right: 0;
}

/* General */
body {
	background-color: <?php echo $style["BlueWash"] ?>;
	text-align:center;
	font-family:Verdana, sans-serif;
}

a:visited {
	color: purple;
}

#header, .post, #footer, #terminator, .about,.navLinks, #navBar, .gallery {
	margin:auto;
	margin-top:5px;
	margin-bottom:0px;
	max-width:700px;
	width:100%;
	padding:5px;
	position:relative;
}

#header, .post, #footer, #terminator, .about, .gallery{
	background-color: <?php echo $style["PostBackground"]?> ;
	text-align:left;
	color: <?php echo $style["PostForeground"] ?>;
}

#header, .post, #footer, #terminator, .about{
	border: <?php echo $style["PanelBorder"] ?> 1px solid;
}

#header {
	background-color: #FFFFFF ;
}

 .gallery {
 	clear: both;
 }
.
galleryDescription {
	font-size:80%;
	color: #999;
}

.galleryTitle{
	margin:0;
	font-size:120%;
	letter-spacing: 0.10em;
	color: #56682C;
}

.galleryPreviousLink {
	cursor:pointer;
	float: left;
	margin-left: -5em;
	margin-top: 70px;
	width: 5em;
}

.galleryNextLink {
	cursor:pointer;
	float: left;
	margin-left: 700px;
	margin-top: 70px;
	width: 5em;
	text-align: right;
}

.galleryItem {
	padding: 0.5em;
}

#TapDescription {
	padding: 1em;
	text-align: center;
	padding-bottom: 80px;
	font-weight: bold;
	letter-spacing: 0.10em;
}

.navLinks{
	font-size:80%;
	text-decoration: none;
	color: blue;
	letter-spacing: 0.08em;
}

img {
	border:0px solid;
	margin:0px;
	padding:0px;
}

h2 {
	padding-bottom: 5px;
	padding-bottom: 0px;
}

/* Header */
#logo {
	border:0px solid black;
}
#tagline {
	color: #616CD9;
}

.headerContent {
	margin:0px;
		position:relative;
}

.headerTags {
	margin:0px;
	padding:0px;
	margin-left:5px;
	position:absolute;
	bottom:0;
	left:100%;
	background-color:#FFF;
}

.headerTags a {
	margin:0px;
	padding:0px;
}

.headerTags a img {
	display:block;
}

/** Nav Bar */

#navBar {
	clear:both;
	margin-top:0px;
	padding-top:0px;
}
#tab-bar {
	display: block;
	float: right;
	width: 100%;
	margin: 0px;
	padding: 0px;
	margin-bottom: 1%;
}

#tab-bar ul{
	display: block;
	float: right;
	list-style: none;
	padding: 0px;
	margin: 0px;
	margin-right: 5%;;
	white-space:nowrap;
}

.tab {
	background-color: <?php echo $style["PostBackground"]?> ;
	color: <?php echo$style["LinkBlue"]?>;
	display: block;
	float: left;
	font-weight: bold;
	font-size: 110%;
	margin: 5px;
	margin-top: 0px;
	padding: 0px
}

.tabLink {
	color: inherit ! important;
	display:block ! important;
	text-decoration: none ! important;
	padding: 5px ! important;
	padding-left: 15px ! important;
	padding-right: 15px ! important;
	cursor:pointer;
}

#activeTab {
	color: black;
	background-color: white;
	border: 2px solid gray;
	border-top: 0px;
	margin-top: -1px;
	margin-bottom: 10px;
	padding-top: 3px;
}

.tab:hover, #activeTab:hover {
	background-color: white;
	color: <?php echo$style["linkOrange"]?>;
	border-bottom: 2px solid gray;
}


/* Pages */

.pageTitle{
	margin:0;
	font-size:130%;
	padding: 10px;
	letter-spacing: 0.10em;
	color: #56682C;
}

/* Post */
.post {
	min-height:36px;
	clear:both;
}

.postDate {
	float:left;
	margin-left:-25px;
}

.singlePostTitle{
	margin:0;
	font-size:120%;
}

.postTitle{
	margin:0;
	font-size:130%;
	cursor:pointer;
	letter-spacing: 0.10em;
	color: #56682C;
}

h3 {
	color: #76923C;
	letter-spacing: 0.07em;
}

h4 {
	letter-spacing: 0.05em;
	color: #56682C;
}
.clickPrompt {
	font-size:9pt;
	font-weight:lighter;
	margin-left:15px;
	color:#CCC;
}

.cap {
	font-size:130%;
}

.content {
	display:none;
}

.postContent {
	margin:5px;
	margin-bottom:20px;
	margin-top:0px;
	line-height:125%;
	position:relative;
	min-height: 3em;
}
.postContent p {
	letter-spacing: 0.05em;
}


.tags {
	margin:0px;
	margin-left:10px;
	padding:5px;
	position:absolute;
	bottom:0;
	left:100%;
	font-size:70%;
	background-color:#FFF;
	border: #CCC 1px solid;
	border-left: #CCC 1px dashed;
	color: #555;
}

.tagList {
	margin:0px;
	font-size:80%;
	padding:0px;
}

.tagItem {
	margin:0px;
	padding:0px;
	list-style:none;
}
.tagItem a {
	margin:0px;
	padding:0px;
	color: #777;
}

.feedbackHeader {
	margin:0px;
}

.feedback {
	display:none;
}

.community {
	font-size:80%;
	color: #006;
	text-align:right;
	border-top:solid 1px #EEE;
	cursor:pointer;
	margin-bottom: 15px;
}

.loggedInUser {
	margin:1px;
	margin-left: 5px;
	margin-right: 15px;
	font-size:60%;
	color: #006;
	width:100%;
	text-align: right;;
}

.commentForm {
	border-top:solid 1px #EEE;
}

.commentPrompt {
	color: #212984;
	font-size: 75%;
	margin:3px;
	margin-left: 5px;
	padding-top: 7px;
}

.comment {
	margin-top: 10px;
	color: #212984;
	font-size: 90%;
}

.comment cite {
	font-weight: bold;
}

.commentText {
}

.commentText p {
	margin:0.5em;
	padding:0px;
	font-size: 90%;
	font-weight:lighter;
}
.userDetails {
	margin-left: 20px;
}

.offsite {
}


/* Footer */

#cloudHead {
	margin:0;
	font-size:120%;
	color: <?php echo $style["PostForeground"]  ?>;
}

/* Copyright */

#terminator {
	font-size:80%;
	color: #999;
	text-align:center;
	margin-bottom:3em;
}

 /* search */

#search {
	margin-right: 2em;
	float:right;
	padding: 2px;
	margin-top: -4em;
	background: right no-repeat  url(search.png) #F8FAFE;
	border:1px solid #CCC;
}

#searchform
{
	height: 1.6em;
	line-height: 1.6em;
	display: inline;
	margin: 0px;
	padding: 0px;
	background: left no-repeat url(searchPrompt.png);
}

#s {
	border: 0px solid #111111;
	font-family:Verdana,Geneva,sans-serif;
	background:none;
	height:1.6em;
	line-height: 1.6em;
	margin: 0px;
	padding:0px;
	padding-left: 3px;
	display: inline;
}


#searchsubmit {
	border: 0px solid red;
	background:none;
	height: 1.6em;
	line-height: 1.6em;
	width: 25px;
	margin: 0px;
	margin-left: -5px;
	padding:0px;
	display: inline;
}

/* About */

.about {
	line-height:125%;
}

/* Hacks */

/* Hides from IE5-mac \*/
* html .postContent {height: 1%;}
/* End hide from IE5-mac */


/* Code */
.csharpcode, .csharpcode pre
{
	font-size: small;
	color: black;
	font-family: Consolas, "Courier New", Courier, Monospace;
	background-color: #fefefe;
	white-space: pre;
}

.csharpcode pre { margin: 0em; }

.csharpcode .rem { color: #008000; }

.csharpcode .kwrd { color: #0000ff; }

.csharpcode .str { color: #006080; }

.csharpcode .op { color: #0000c0; }

.csharpcode .preproc { color: #cc6633; }

.csharpcode .asp { background-color: #ffff00; }

.csharpcode .html { color: #800000; }

.csharpcode .attr { color: #ff0000; }

.csharpcode .alt
{
	background-color: #f4f4f4;
	width: 100%;
	margin: 0em;
}

.csharpcode .lnum { color: #606060; }

em { font-family: courier; }
.aligncenter  { text-align: center; }