#!/usr/bin/env python3
#-*- coding: utf-8 -*-
import pymysql
import pymysql.cursors
import json
from datetime import datetime,timedelta

host = "115.28.222.160"
Db_user = "michael"
Db_password ="michael"
plan_id = 2288
DBCourse_url = {"host":host, "user":Db_user, "passwd":Db_password, "db":"db_course", "charset":"utf8", "cursorclass":pymysql.cursors.DictCursor}
DBCourse_connect = pymysql.connect(**DBCourse_url)
DBCourse_connect.autocommit(True)
DBCoursecursor = DBCourse_connect.cursor()

DBStat_url = {"host":host,"user":Db_user, "passwd":Db_password, "db":"db_stat", "charset":"utf8", "cursorclass":pymysql.cursors.DictCursor}
DBStat_connect = pymysql.connect(**DBStat_url)
DBStat_connect.autocommit(True)
DBStatcursor = DBStat_connect.cursor()

DBExam_url = {"host":host,"user":Db_user, "passwd":Db_password, "db":"db_exam", "charset":"utf8", "cursorclass":pymysql.cursors.DictCursor}
DBExam_connect = pymysql.connect(**DBExam_url)
DBExam_connect.autocommit(True)
DBExamcursor = DBExam_connect.cursor()

DBRoom_url = {"host":host,"user":Db_user, "passwd":Db_password, "db":"test", "charset":"utf8", "cursorclass":pymysql.cursors.DictCursor}
DBRoom_connect = pymysql.connect(**DBRoom_url)
DBRoom_connect.autocommit(True)
DBRoomcursor = DBRoom_connect.cursor()

exam_arr   =[] #存储备课出题题目ID
phrase_arr =[] #存储快速出题题目ID
ask_arr    =[] #询问题目ID


#获取备课出题题目
sql = "SELECT pk_plan_exam,fk_question FROM `t_course_plan_exam` WHERE fk_plan={fk_plan} AND STATUS=1".format(fk_plan=plan_id)
DBCoursecursor.execute(sql)
rows = DBCoursecursor.fetchall()
for row in rows:
	exam_arr.append(row['pk_plan_exam'])

#获取快速出题题目
sql = "SELECT pk_plan_phrase,fk_phrase FROM `t_course_plan_phrase` WHERE fk_plan={fk_plan} and fk_phrase not in (10,11,12)".format(fk_plan=plan_id)
DBCoursecursor.execute(sql)
rows = DBCoursecursor.fetchall()
for row in rows:
	phrase_arr.append(row['pk_plan_phrase'])


#获取询问出题题目
sql = "SELECT pk_plan_phrase,fk_phrase FROM `t_course_plan_phrase` WHERE fk_plan={fk_plan} and fk_phrase in (10,11,12)".format(fk_plan=plan_id)
DBCoursecursor.execute(sql)
rows = DBCoursecursor.fetchall()
for row in rows:
	ask_arr.append(row['pk_plan_phrase'])

rate_total = 0
avg_rate = 0

'''
if len(exam_arr) == 0:
	pass
else:
	print(exam_arr)	
	for question_id in exam_arr:
		#获取每道题目的答题记录数(除去未答)
		sql = "SELECT COUNT(fk_user) as answer_count FROM t_log_plan_user_question WHERE fk_plan={fk_plan} AND fk_answers<>'' AND  \
		fk_question={fk_question}".forma t(fk_plan=plan_id,fk_question=question_id)
		DBExamcursor.execute(sql)
		result = DBExamcursor.fetchone()
		answer_count = result['answer_count']
		
		#每道题答对记录数
		sql = "SELECT COUNT(fk_user) as answer_right_count FROM t_log_plan_user_question WHERE fk_plan={fk_plan} AND fk_answers<>'' AND correct=1 AND \
		fk_question={fk_question}".format(fk_plan=plan_id,fk_question=question_id)
		DBExamcursor.execute(sql)
		result = DBExamcursor.fetchone()
		answer_right_count = result['answer_right_count']
		#print("题目ID:{},答题记录数:{},答对记录数:{}".format(question_id,answer_count,answer_right_count))
		if answer_count == 0:
			rate = 0
		else:
			rate = answer_right_count/answer_count
		rate_total += rate
		print("题目ID:{},题目答题正确率:{}".format(question_id,rate))
	length = len(exam_arr)	
	avg_rate = round(rate_total/length,4)*100
	print("\033[1;33;40m 备课出题平均概率: {} \033[0m".format(avg_rate))
	

rate_total = 0	
if len(phrase_arr) == 0:
	pass
else:
	print(phrase_arr)	
	for phrase in phrase_arr:
		#获取快速出题答题记录数
		answersql = "SELECT COUNT(fk_user) AS answer_count FROM `t_course_plan_phrase_log` WHERE answer<>'' AND fk_plan={fk_plan} and \
		fk_plan_phrase={phrase_id}".format(fk_plan=plan_id,phrase_id=phrase)
		DBStatcursor.execute(answersql)
		result = DBStatcursor.fetchone()
		answer_count = result['answer_count']

		answerRightsql = "SELECT COUNT(fk_user) AS answer_right_count FROM `t_course_plan_phrase_log` WHERE answer<>'' and answer_status=1 AND fk_plan={fk_plan} and \
		fk_plan_phrase={phrase_id}".format(fk_plan=plan_id,phrase_id=phrase)
		DBStatcursor.execute(answerRightsql)
		result = DBStatcursor.fetchone()
		answer_right_count = result['answer_right_count']
		if answer_count == 0:
			rate = 0
		else:
			rate = answer_right_count/answer_count
		print("题目ID:{},快速出题概率:{}".format(phrase,rate))	
		rate_total += rate		
	avg_rate = round(rate_total/len(phrase_arr),4)*100
	print("\033[1;31;40m 快速出题平均概率: {} \033[0m".format(avg_rate))
'''

rate_total = 0

#获取到课人数
sql = "SELECT content FROM `t_stat_online` WHERE plan_id={plan_id}".format(plan_id=plan_id)
DBRoomcursor.execute(sql)
rows = DBRoomcursor.fetchall()
onlineUserList= []
for row in rows:
	onlineUser = json.loads(row['content'])
	onlineUser = list(onlineUser.keys())
	onlineUserList.extend(onlineUser)
onlineset = set(onlineUserList)
print("到课人数{}".format(onlineset))

'''
First_start_time = "SELECT t FROM `t_stat_class` WHERE plan_id=2227 ORDER BY t"
plan_start_time = "SELECT start_time FROM `t_course_plan` WHERE pk_plan=2227"

if First_start_time > plan_start_time :
	start_time = plan_start_time
else:
	start_time = First_start_time	

start_time_object = datetime.strptime(timestr,"%Y-%m-%d %H:%M:%S")
duration = datetime.delta(seconds=10)
endtime = str(start_time_object + duration)

#准时人数  开始时间后10分钟内算准时
sql = "SELECT content FROM `t_stat_online` WHERE t>'{start_time}' and t<'{end_time}' AND plan_id ={plan_id}".format(start_time=start_time,end_time=endtime,plan_id=plan_id)
DBRoomcursor.execute(sql)
rows = DBRoomcursor.fetchall()
OntimeList = []
for row in rows:
	OntineUser = json.loads(row['content'])
	OntineUser = list(OntineUser.keys())
	OntimeList.extend(OntineUser)
OntimeSet = set(OntimeList)
print("准时上课用户id列表：{}".format(OntimeSet))

#迟到人数
lateSet = onlineset - OntimeSet
print("迟到用户ID列表:".format(OntimeSet))
'''

if len(ask_arr) == 0:
	pass
else:
	print(ask_arr)	
	for ask in ask_arr:
		#获取询问答题记录
		sql = "SELECT COUNT(fk_user) AS asking_response_count FROM `t_course_plan_phrase_log` WHERE fk_plan={fk_plan} and \
		fk_plan_phrase={phrase_id}".format(fk_plan=plan_id,phrase_id=ask)
		DBStatcursor.execute(sql)
		result = DBStatcursor.fetchone()
		ask_response_count = result['asking_response_count']
		rate_total += (ask_response_count/len(onlineset))
		#print("询问回答记录数: %d "% ask_response_count)	
	avg_rate = round(rate_total/len(ask_arr),4)*100
	print("\033[1;32;40m 询问回答平均概率: {} \033[0m".format(avg_rate))	


DBCourse_connect.close()
DBStat_connect.close()
DBExam_connect.close()
DBRoom_connect.close()






