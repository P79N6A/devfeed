#!/usr/bin/python
# -*- coding: UTF-8 -*-

import MySQLdb



def insertBlogs( title, content, author, userHome):

	_db = MySQLdb.connect("127.0.0.1","root","","spider")

	_cursor = _db.cursor()

	_sql = "INSERT INTO `spider`(`id`, `title`, `content`, `author`, `userHome`) VALUES ( null, '%s', '%s', '%s', '%s') " % ( title.encode('utf-8'), MySQLdb.escape_string(content.encode('utf-8')), author.encode('utf-8'), userHome.encode('utf-8') )

	

	try:
		_cursor.execute(_sql)

		_db.commit()

	except MySQLdb.Error, e:
		try:
			print title
			print e
		except IndexError:
			print srt(e)
	_db.close()

	return




# get list
def insert(title, content, author, userHome):

	db = MySQLdb.connect("127.0.0.1","root","","spider")

	cursor = db.cursor()

	stutas = 1

	try:

		cursor.execute("INSERT INTO `unique` VALUES (null,'%s')" % (title.encode('utf-8')))

		db.commit()

	except MySQLdb.Error, e:
		try:
			# if e[0] is not Duplicate entry (1062), insert data to blogs table
			# print e[0] == 1062
			if e[0] == 1062:
				stutas = 0
				print title + 'is a duplicate of data'

		except IndexError:
			print srt(e)
		# db.rollback()

	db.close()


	if stutas == 1:
		insertBlogs(title, content, author, userHome)
	return







