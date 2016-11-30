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
		result = self.dom('#articleTitle a').text()
		return result

	@property
	def content(self):
		return self.dom('.article').html()

	@property
	def author(self):
		return self.dom('.article__author > a > strong').text()

	@property
	def userHome(self):
		return self.dom('.article__author > a').attr('href')


# get list
class list(object):
	
	def __init__(self, page):
		self.url = 'http://segmentfault.com/t/' + page + '/blogs'
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
		for link in self.dom('.title a'):
			l = link.attrib['href']
			s = article('https://segmentfault.com'+l)

			# print s.title

			result = r.checkTitle( s.title, l)

			if result == 1:

				mysql.insertBlogs( s.title, s.content, s.author, 'https://segmentfault.com' + s.userHome, 'https://segmentfault.com', 'http://www.segmentfault.com'+l)	
				
		return 

