#!/usr/bin/python
# -*- coding: UTF-8 -*-
# 

import requests
import mysql
from pyquery import PyQuery as Pq

class article(object):

	def __init__(self, segmentfault_id):
		self.url = 'http://segmentfault.com{0}'.format(segmentfault_id)
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
		return self.dom('#articleTitle > a').text()

	@property
	def content(self):
		return self.dom('.article__content').html()

	@property
	def author(self):
		return self.dom('.article__author > a').text()

	@property
	def userHome(self):
		return 'https://segmentfault.com/u/' + self.dom('.article__author > a').text()

# get list
class list(object):
	
	def __init__(self, segmentfault_tag):
		self.url = 'https://segmentfault.com/t/{0}/blogs'.format(segmentfault_tag)
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
		for link in self.dom('.title > a'):
			l = link.attrib['href']
			s = article(l)
			mysql.insert( s.title, s.content, s.author, s.userHome)
			# print s.content
			# print s.title
		return s
