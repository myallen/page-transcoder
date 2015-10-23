<?php
class Node {

	private $root;

    private $filter_tags = array('i' => 1, 'css' => 1, 'script' => 1, 'comment' => 1,);
	
	public function __construct($node) {/*{{{*/
		$this->root = $node;
	}/*}}}*/

	public function findCore() {/*{{{*/
		$core_node = $this->root->find('div .content', 0);
		$core_node = $this->root->find('section', 0);
		return $this->node2arr($core_node);
	}/*}}}*/

	protected function node2arr($node) {/*{{{*/
		$tags = array();
		if (!$node) {
			return $tags;
		}
        if (isset($this->filter_tags[$node->tag])) {
            return $tags;
        }
        if ($this->isHidden($node)) {
            return $tags;
        }
		if (!$node->has_child()) {
            if ($tag = $this->node2tag($node)) {
                $tags[] = $tag;
            }
			return $tags;
		}

		foreach($node->nodes as $child) {
            $tags = array_merge($tags, $this->node2arr($child));
		}
		return $tags;
	}/*}}}*/

	protected function node2tag($node) {/*{{{*/
        if ($node->tag === 'img') {
            return $this->getImgTag($node);
        } else {
            return $this->getTextTag($node);
		}
	}/*}}}*/

    protected function isHidden($node) {/*{{{*/
        if ($style = $node->getAttribute('style')) {
            if (preg_match('/display:\s*none/', $style)) {
                return true;
            }
        }
        if ($class = $node->getAttribute('class')) {
            if (preg_match('/(hide)/', $class)) {
                return true;
            }
        }
        return false;
    }/*}}}*/

    protected function getImgTag($node) {/*{{{*/
        $src = trim($node->getAttribute('src'));
        $attrs = $node->getAllAttributes();
        foreach($attrs as $attr) {
            if ($attr == $src) {
                continue;
            }
            if (preg_match('/http[s]?:\/\/[^?]+(.jpg|.jpeg|.png|.icon)(\?.*|$)/i', $attr)) {
                $src = $attr;
            }
        }
        if ($src !== '') {
            return new Tag(Tag::TAG_TYPE_IMG, $src);
        }
        return false;
    }/*}}}*/

    protected function getTextTag($node) {/*{{{*/
        $text = trim($node->innertext);
        if ($this->isTextValid($text)) {
            return new Tag(Tag::TAG_TYPE_TEXT, $text);
        }
        return false;
    }/*}}}*/

    protected function isTextValid($text) {/*{{{*/
        return ($text === '' || $text === '0') ? false : true;
    }/*}}}*/

}
