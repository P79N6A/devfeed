# -*- coding: UTF-8 -*-

import redis
import md5

r = redis.StrictRedis(host='127.0.0.1', port=6379, db=0)

# converted to md5
def transTitle(title):

	string = title.encode('utf-8')

	m1 = md5.new()

	m1.update(string)

	return m1.hexdigest()

# check wherher the data is duplicated
# if the value data does no exist redis
# return true
def checkTitle(title, url):

	hash_value = transTitle(title + url)

	result = r.sadd('title:unique', hash_value)

	# print result
	# sdiff 'title:unique'

	return result