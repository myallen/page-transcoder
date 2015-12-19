<?php
class Common {
	
	public static function fetchHtml($url, $context) {/*{{{*/
		return file_get_contents($url, false, $context);
	}	/*}}}*/

}
