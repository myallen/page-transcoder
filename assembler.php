<?php
class Assembler {

    private $tags;

    public function __construct($tags) {/*{{{*/
        $this->tags = $tags;
    }/*}}}*/

    public function doMagic() {/*{{{*/
        $html = '';
        foreach($this->tags as $tag) {
            if ($tag->isImg()) {
                $html .= '<img src="'.$tag->content.'">';
            } else {
                $html .= '<p>'.$tag->content.'</p>';
            }
        }
        return $html;
    }/*}}}*/

}
