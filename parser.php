<?php
class Parser {

	private $source;

	public function __construct($source) {/*{{{*/
		$this->source = $source;
    }/*}}}*/

	public function doMagic() {/*{{{*/
        //header
        $opts = array(
                'http'=>array(
                    'method'=>"GET",
                    'header'=>"Accept-language: zh-CN\r\nUser-Agent:Mozilla/5.0 (Linux; U; Android 4.3; en-us; SM-N900T Build/JSS15J) AppleWebKit/534.30 (KHTML, like Gecko) Version/4.0 Mobile Safari/534.30\r\n"
                    ),
                );

        $context = stream_context_create($opts);

        $html = Common::fetchHtml($this->source, $context);

		include('./lib/simple_html_dom.php');
		$dom = new simple_html_dom();
		$dom->load($html);
		
		$node = new Node($dom->find('body', 0));
		return $node->findCore();
	}/*}}}*/

}

