#!/usr/bin/python
# -*- coding: UTF-8 -*-

import requests
import mysql
import re
import r
from pyquery import PyQuery as Pq

url = 'https://www.github.com'

class article(object):

	def __init__(self, divio_id):
		self.url = divio_id
		self._dom = None

	@property
	def dom(self):
		if not self._dom:
			document = requests.get(self.url)
			document.encoding = 'utf-8'
			self._dom = Pq(document.text)
		return self._dom

	@property
	def title(self):
		result = self.dom('.js-issue-title').text()
		return result

	@property
	def content(self):
		return self.dom('.js-comment-body').eq(0).html()

	@property
	def author(self):
		return self.dom('.author').eq(0).text()

	@property
	def userHome(self):
		return self.dom('.author').eq(0).attr('href')


# get list
class list(object):
	
	def __init__(self, page):
		self.url = url + page
		self._dom = None

	@property 
	def dom(self):
		if not self._dom:
			document = requests.get(self.url)
			document.encoding = 'utf-8'
			self._dom = Pq(document.text)
		return self._dom

	@property 
	def article(self):
		for link in self.dom('.Box-body .lh-condensed > a'):
			l = link.attrib['href']
			s = article(url+l)

			result = r.checkTitle( s.title, l)

			if result == 1:

				mysql.insertBlogs( s.title, s.content, url+s.author, 'https://github.com//blog/issues', url, url+l)	
				
				print s.title+' is not repeat'

			else:

				print s.title+' is repeat'
			
		return 

