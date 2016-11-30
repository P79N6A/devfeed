#!/usr/bin/python
# -*- coding: UTF-8 -*-

import requests
import mysql
import re
import r
from pyquery import PyQuery as Pq

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
		result = self.dom('title').text()
		pattern = re.compile(r'(.*) - Div.IO')
		match = pattern.match(result)

		if match:
			tit = match.group(1)
		return tit

	@property
	def content(self):
		return self.dom('.topic-firstfloor-detail').html()

	@property
	def author(self):
		return self.dom('.topic-firstfloor-info > p a').text()

	@property
	def userHome(self):
		return self.dom('.topic-firstfloor-info > p a').attr('href')


# get list
class list(object):
	
	def __init__(self, page):
		self.url = 'http://div.io/pro/index?page=' + page
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
		for link in self.dom('.title'):
			l = link.attrib['href']
			s = article(l)
			s.title
			result = r.checkTitle( s.title, l)

			if result == 1:

				mysql.insertBlogs( s.title, s.content, s.author, s.userHome, 'https://div.io', l)	
				
		return 

