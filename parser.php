<?php
class Parser {

	private $source;

	public function __construct($source) {
		$this->source = $source;
    }

	public function doMagic() {
		$html = Common::fetchHtml($this->source);

		include('./lib/simple_html_dom.php');
		$dom = new simple_html_dom();
		$dom->load($html);
		
		$body = $dom->find('body', 0);
		$node = new Node($body);
		return $node->findCore();
	}

}

