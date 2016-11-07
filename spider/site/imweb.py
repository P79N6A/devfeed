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
		result = self.dom('.topic-title').text()
		return result

	@property
	def content(self):
		return self.dom('#topic_content').html()

	@property
	def author(self):
		return self.dom('.user-wrap .user-name').text()

	@property
	def userHome(self):
		return 'http://imweb.io/user/' + self.dom('.user-wrap .user-name').text()


# get list
class list(object):
	
	def __init__(self, page):
		self.url = 'http://www.imweb.io/' + page
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
		for link in self.dom('.ex-link'):
			l = link.attrib['href']
			s = article('http://www.imweb.io'+l)

			# print s.userHome

			result = r.checkTitle( s.title, l)

			if result == 1:

				mysql.insertBlogs( s.title, s.content, s.author, s.userHome, 'https://imweb.io', 'http://www.imweb.io'+l)	
				
				print s.title+' is not repeat'

			else:

				print s.title+' is repeat'
			
		return 

