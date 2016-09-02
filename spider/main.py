#!/usr/bin/python
# -*- coding: UTF-8 -*-

import sys

sys.path.insert(0, './site')

sys.path.append('/Users/weng/Dropbox/2016/python/spider/site/')

import segmentfault

segmentfaultJavascript = segmentfault.list('javascript')
segmentfaultNodejs = segmentfault.list('node.js')
segmentfaultHtml5 = segmentfault.list('html5')
segmentfaultCSS = segmentfault.list('css')
segmentfaultCSS3 = segmentfault.list('css3')


segmentfaultJavascript.article
segmentfaultNodejs.article
segmentfaultHtml5.article
segmentfaultCSS.article
segmentfaultCSS3.article