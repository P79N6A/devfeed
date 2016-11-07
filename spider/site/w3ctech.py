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
		result = self.dom('h1').text()
		return result

	@property
	def content(self):
		return self.dom('.topic_detail').html()

	@property
	def author(self):
		return self.dom('.latest > img').attr('title')

	@property
	def userHome(self):
		return self.dom('.latest').attr('href')


# get list
class list(object):
	
	def __init__(self, page):
		self.url = 'https://www.w3ctech.com' + page
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
			s = article('https://www.w3ctech.com'+l)

			# print 'https://www.w3ctech.com'+s.userHome

			result = r.checkTitle( s.title, l)

			if result == 1:

				mysql.insertBlogs( s.title, s.content, s.author, 'https://www.w3ctech.com'+s.userHome, 'https://www.w3ctech.com', 'https://www.w3ctech.com'+l)	
				
				print s.title+' is not repeat'

			else:

				print s.title+' is repeat'
			
		return 

