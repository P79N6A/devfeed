import requests
from pyquery import PyQuery as Pq

class run(object):

	def __init__(self, segmentfault_id):
		self.url = 'http://segmentfault.com/q/{0}'.format(segmentfault_id)
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
		return self.dom('h1#questionTitle').text()

	@property
	def content(self):
		return self.dom('.question.fmt').html()

	# @property
	# def answers(self):
	# 	return list(answer.html() for answer in self.dom('.answer.fmt').items())

	@property
	def tags(self):
		return self.dom('ul.taglist--inline > li').text().split()