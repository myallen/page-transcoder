#!/bin/bash
url="http://top.sina.cn/news/2015-10-22/tnews-ifxizwsf8723803.d.html"
if [[ ! -z $1 ]]; then
    url=$1
fi
echo ${url}
php index.php ${url} > ~/dev/zhuaqu/web/index.php
