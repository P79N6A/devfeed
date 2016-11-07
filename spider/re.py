# -*- coding: UTF-8 -*-

import re

pattern = re.compile(r'(.*)\s\<span.*')

match = pattern.match('''iShare.js分享插件
                    <span class="muted">2个回复</span>
                    <span class="com-tag pro_tag">专栏</span>
        <span class="topic-firstfloor-info-at-node">@ <a href="http://div.io/node/javascript">Javascript</a></span>''')

if match:

	print match.group(1)