<?php
class Node {

	private $root;
	
	public function __construct($node) {
		$this->root = $node;
	}

	public function findCore() {
		$core_node = $this->root->find('.info_module', 0);
		$core_node = $this->root->find('.art_abstract', 0);
		$core_node = $this->root->find('section', 0);
		return $this->node2arr($core_node);
	}

	protected function node2arr($node) {
		$tags = array();
		if (!$node) {
			return $tags;
		}
		if (!$node->has_child()) {
			$tags[] = $this->node2tag($node);
			return $tags;
		}

		//var_dump($node->nodes);exit;
		foreach($node->nodes as $child) {
			//echo $child->tag.'bbb'.$child->innertext."ccc\n";continue;
			if ($child->has_child()) {
				$tags = array_merge($tags, $this->node2arr($child));
				if ($tag = $this->node2tag($child, true)) {
					$tags[] = $tag;
				}
				continue;
			}
			if ($tag = $this->node2tag($child)) {
				$tags[] = $tag;
			}
		}
//exit;
		return $tags;
	}

	protected function node2tag($node, $has_child = false) {
		switch($node->tag) {
			case 'comment':
			case 'script':
			case 'css':
				return false;
			case 'img':
				$src = trim($node->getAttribute('src'));
				$attrs = $node->getAllAttributes();
				foreach($attrs as $attr) {
					if ($attr == $src) {
						continue;
					}
					if (preg_match('/http:\/\/[^?]+(.jpg|.jpeg|.png|.icon)(\?.*|$)/i', $attr)) {
						$src = $attr;
					}
				}
				if ($src !== '') {
					return array(
						'type' => 'img',
						'content' => $src,
					);
				}
			default:
				if ($has_child) {
					$plaintext = trim($node->plaintext);
					if ($plaintext !== '') {
						return array(
							'type' => 'text',
							'content' => $plaintext,
						);
					}
				} else {
					$innertext = trim($node->innertext);
					if ($innertext !== '') {
						return array(
							'type' => 'text',
							'content' => $innertext,
						);
					}
				}
		}
		return false;
	}

}
