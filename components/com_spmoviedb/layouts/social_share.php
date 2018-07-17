<?php
/**
 * @package     SP Movie Databse
 *
 * @copyright   Copyright (C) 2010 - 2016 JoomShaper. All rights reserved.
 * @license     GNU General Public License version 2 or later.
 */

defined('_JEXEC') or die('Restricted Access');

$url 		= $displayData['url'];
$title 		= $displayData['title'];
$root       = JURI::base();
$root       = new JURI($root);
$itemUrl   	= $root->getScheme() . '://' . $root->getHost() . $url;

?>

<ul>
	<li>
		<a class="facebook" onClick="window.open('http://www.facebook.com/sharer.php?u=<?php echo $itemUrl; ?>','Facebook','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;" href="http://www.facebook.com/sharer.php?u=<?php echo $itemUrl; ?>"><i class="spmoviedb-icon-facebook"></i></a>
	</li>
	<li>
		<a class="twitter" onClick="window.open('http://twitter.com/share?url=<?php echo $itemUrl; ?>&amp;text=<?php echo str_replace(" ", "%20", $title); ?>','Twitter share','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;" href="http://twitter.com/share?url=<?php echo $itemUrl; ?>&amp;text=<?php echo str_replace(" ", "%20", $title); ?>"><i class="spmoviedb-icon-twitter"></i></a>
	</li>
	<li>
		<a class="googleplus"  onClick="window.open('https://plus.google.com/share?url=<?php echo $itemUrl; ?>','Google plus','width=585,height=666,left='+(screen.availWidth/2-292)+',top='+(screen.availHeight/2-333)+''); return false;" href="https://plus.google.com/share?url=<?php echo $itemUrl; ?>" ><i class="spmoviedb-icon-google-plus"></i></a>
	</li>
	<li>
		<a class="pinterest" href='javascript:void((function()%7Bvar%20e=document.createElement(&apos;script&apos;);e.setAttribute(&apos;type&apos;,&apos;text/javascript&apos;);e.setAttribute(&apos;charset&apos;,&apos;UTF-8&apos;);e.setAttribute(&apos;src&apos;,&apos;http://assets.pinterest.com/js/pinmarklet.js?r=&apos;+Math.random()*99999999);document.body.appendChild(e)%7D)());'><i class="spmoviedb-icon-pinterest"></i></a>
	</li>
</ul>