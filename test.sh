#!/bin/bash
url="http://top.sina.cn/news/2015-10-22/tnews-ifxizwsf8723803.d.html"
if [ $# -lt 1 ]; then
    echo "error.. need args"
    exit 1
fi

php index.php $1  > /home/yfzhang/work/page-transcoder/web/index.php
