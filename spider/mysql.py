#!/usr/bin/python
# -*- coding: UTF-8 -*-

import MySQLdb

def insertBlogs( title, content, author, userHome, website, source):

	db = MySQLdb.connect("127.0.0.1","root","","spider")

	cursor = db.cursor()

	try:

		dataTitle = title.encode('utf-8')
		dataContent = content.encode('utf-8')
		dataAuthor = author.encode('utf-8')
		dataUserHome = userHome.encode('utf-8')

		sql = "INSERT INTO `spider`(`id`, `title`, `content`, `author`, `userHome`, `website`, `source`) VALUES ( null, '%s', '%s', '%s', '%s', '%s', '%s') " % ( MySQLdb.escape_string(dataTitle), MySQLdb.escape_string(dataContent), MySQLdb.escape_string(dataAuthor), MySQLdb.escape_string(dataUserHome), website, source)

	except:
		print 'sql error'

	try:
		cursor.execute(sql)

		db.commit()

	except MySQLdb.Error, e:
		try:
			print title
			print e
		except IndexError:
			print srt(e)

	db.close()

	return

# get list
# unique title
# discarded
def insert(title, content, author, userHome, website, source):

	db = MySQLdb.connect("127.0.0.1","root","","spider")

	cursor = db.cursor()

	stutas = 1

	dataTitle = title.encode('utf-8')

	try:
		# checke article title
		cursor.execute("INSERT INTO `unique` VALUES (null,'%s')" % (MySQLdb.escape_string(dataTitle)))

		db.commit()

	except MySQLdb.Error, e:
		try:
			# if e[0] is not Duplicate entry (1062), insert data to blogs table
			# print e[0] == 1062
			if e[0] == 1062:
				stutas = 0
				print title + ' is a duplicate of data'

		except IndexError:
			print srt(e)
		# db.rollback()

	db.close()

	# if stutas is 1, this data no repeat
	if stutas == 1:
		insertBlogs(title, content, author, userHome, website, source)
	return







