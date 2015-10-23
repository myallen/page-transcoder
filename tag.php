<?php
class Tag {

    const TAG_TYPE_IMG = 'img';
    const TAG_TYPE_TEXT = 'text';

    public $type;
    public $content;

    public function __construct($type, $content) {/*{{{*/
        $this->type = $type;
        $this->content = $content;
    }/*}}}*/

    public function isImg() {/*{{{*/
        return $this->type === Tag::TAG_TYPE_IMG ? true : false;
    }/*}}}*/

}
