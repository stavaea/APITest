#!/usr/bin/env python3
#-*- coding: utf-8 -*-

import pymysql
import pymysql.cursors
import json
from datetime import date,timedelta

orgArr = [] #存储机构列表
"""
{
	'OrgId': 0,  #机构ID
	'Owner_id':0, #机构所有者ID
	'OrgRegUserCount':0, #机构注册用户数
	'OrgImportUserCount':0, #机构导入用户数
	'OrgActiveUserCount':0, #激活用户数
	'OrgTeacherCount':0, #机构教师数量
	'OrgActiveTeacherCount':0, #机构激活教师数
	'OrgRegStudentCount':0,  #报名课程人数
	'OrgFeeRegStudentCount':0, #付费课程报名人数
	'TeacherHasVideoCount':0,  #有视频的教师数
	'vv_live': 0,   #直播次数
	'vv_record' : 0, #直播时长
	'vt_live':0,     #录播次数 
	'vt_record' : 0,  #录播时长
	'vv' : 0,    #视频播放次数
	'vt' : 0,    #视频播放时长
	'video_count':0,  #视频总个数
	'CourseTotal':0,  #课程总数
	'video_total_time':0  #视频总时长
}
"""

host = "115.28.222.160"
Db_user= "michael"
Db_password = "michael"
Connect_url = {"host":host,"user":Db_user, "passwd":Db_password, "db":"db_user", "charset":"utf8", "cursorclass":pymysql.cursors.DictCursor}
DB_connect = pymysql.connect(**Connect_url)
DB_connect.autocommit(True)
DBcursor = DB_connect.cursor()
	
#获取已审核通过机构ID和机构所有者ID.
def GetOrgAndOwner():	
	sql = "select pk_org,fk_user_owner from t_organization where status <> -1"
	DBcursor.execute(sql)
	rows = DBcursor.fetchall()
	if(rows):
		for row in rows:
			orginfo = {
					'OrgId': 0,
					'Owner_id':0,
					'OrgRegUserCount':0,
					'OrgImportUserCount':0,
					'OrgActiveUserCount':0,
					'OrgTeacherCount':0,
					'OrgActiveTeacherCount':0,
					'OrgRegStudentCount':0,
					'OrgFeeRegStudentCount':0,
					'TeacherHasVideoCount':0,
					'vv_live': 0,
					'vv_record' : 0,
					'vt_live':0,
					'vt_record' : 0,
					'vv' : 0,
					'vt' : 0,
					'video_count':0,
					'CourseTotal':0,
					'video_total_time':0,
					'ActiveUserAccount':0
				}
			orginfo['OrgId'] = row['pk_org']
			orginfo['Owner_id'] = row['fk_user_owner']
			orgArr.append(orginfo)
			#print(orginfo)
	#print(orgArr)		
    #输出已审核通过的机构的机构Id和机构所有者Id。	
	
def GetOrgRegUser():
	OrgRegUserCount = 0 #机构注册用户数
	QueryRegisterUser = "select fk_user,owner_from from db_stat.`t_user_stat` where owner_from <>0"
	DBcursor.execute(QueryRegisterUser)
	RegUsers = DBcursor.fetchall()
	#RegUserArr = []
	#RegOrgInfo = {}
	if RegUsers:
		for org in orgArr:
			for RegUser in RegUsers:
				if RegUser['owner_from'] == org['Owner_id']:
					OrgRegUserCount += 1
					org['OrgRegUserCount'] += 1
			#if org['OrgRegUserCount'] > 0:		
			#	print("机构注册用户数 %d,%d,%d" %(org['OrgId'],org['Owner_id'],org['OrgRegUserCount']))
		#print("总注册数:" + str(OrgRegUserCount))
	
	
def GetOrgImportUser():
	sql = "select pk_user,source from t_user where source<>0"
	DBcursor.execute(sql)
	rows = DBcursor.fetchall()
	for org in orgArr:
		for row in rows:
			if row['source'] == org['OrgId']:
				org['OrgImportUserCount'] += 1
		#if(org['OrgImportUserCount']>0):
		#	print("机构ID:%d,导入用户数:%d" %(org['OrgId'],org['OrgImportUserCount']))

def GetActiveUser():
	ImportUser = {}
	RegisterUser = {}
	sourceArr = []
	ownerfromArr = []
	
	#获取机构导入用户
	ImportUsersql = "select pk_user,source FROM t_user WHERE source<>0 order by source"
	DBcursor.execute(ImportUsersql)
	rows = DBcursor.fetchall()
	
	#获取机构ID列表
	for row in rows:
		sourceArr.append(row['source'])
	sourceSet = set(sourceArr)

	for source in sourceSet:
		fk_users = []
		for row in rows:
			if(row['source'] == source):
				fk_users.append(row['pk_user'])
		ImportUser[source] = fk_users		
		#print("source:{},fk_users:{}".format(source,ImportUser[source]))
	#获取机构注册用户
	RegisterUsersql = "select fk_user,owner_from from db_stat.`t_user_stat` where owner_from<>0 order by owner_from"
	DBcursor.execute(RegisterUsersql)
	rows = DBcursor.fetchall()
	
	#获取机构所有者ID列表
	for row in rows:
		ownerfromArr.append(row['owner_from'])
	ownerfromSet = set(ownerfromArr)
	for owner in ownerfromSet:
		fk_users = []
		for row in rows:
			if owner == row['owner_from']:
				fk_users.append(row['fk_user'])
		RegisterUser[owner] = fk_users
		#print("Owner_from:{},fk_users:{}".format(owner,RegisterUser[owner]))
	
	for org in orgArr:
		for OrgId,fk_users in ImportUser.items():
			if org['OrgId'] == OrgId:
				count = 0
				for fk_user in fk_users:
					sql = "select * FROM t_user WHERE pk_user={pk_user} and last_login<>'0000-00-00 00:00:00'".format(pk_user=int(fk_user))
					#print(sql)
					DBcursor.execute(sql)
					result = DBcursor.fetchone()
					if result:
						count += 1
				org['ActiveUserAccount'] += count
		for userOwner,fk_users in RegisterUser.items():
			if org['Owner_id'] == userOwner:
				count = 0
				for fk_user in fk_users:
					sql = "select * FROM t_user WHERE pk_user={pk_user} and last_login<>'0000-00-00 00:00:00'".format(pk_user=int(fk_user))
					#print("reg:"+sql)
					DBcursor.execute(sql)
					result = DBcursor.fetchone()
					if result:
						count += 1
				org['ActiveUserAccount']+= count
		#print("机构:%d,激活用户数:%d"%(org['OrgId'],org['ActiveUserAccount']))
	
def OrgAddTeacherTotal():
	#机构下添加为教师人数总和
	sql = "SELECT fk_org,fk_user FROM `t_organization_user` WHERE STATUS<>-1"
	DBcursor.execute(sql)
	rows = DBcursor.fetchall()
	for org in orgArr:
		for row in rows:
			if row['fk_org'] == org['OrgId']:
				org['OrgTeacherCount'] += 1
		#if (org['OrgTeacherCount'] > 0)	:
		#	print("机构ID:%d,教师总人数:%d" %(org['OrgId'],org['OrgTeacherCount']))

	#机构下激活教师总人数
	sqlReg = "SELECT COUNT(a.`fk_user`)AS active_teacher_count, fk_org FROM `t_organization_user` AS a JOIN t_user AS b ON a.`fk_user`=b.`pk_user` WHERE a.`status`<>-1  \
		AND b.`last_login`<>'0000-00-00 00:00:00' GROUP BY a.`fk_org`"	
	DBcursor.execute(sqlReg)
	rows = DBcursor.fetchall()	
	for org in orgArr:
		for row in rows:
			if row['fk_org'] == org['OrgId']:
				org['OrgActiveTeacherCount'] += row['active_teacher_count']
		#if (org['OrgActiveTeacherCount'] > 0)	:
		#	print("机构ID:%d , 激活教师总人数:%d" %(org['OrgId'],org['OrgActiveTeacherCount']))
	
def GetOrgRegStudents():
	#获取机构下报名学生数
	sql = "SELECT COUNT(fk_user) as reg_user,fk_user_owner FROM db_course.`t_course_user` WHERE STATUS=1 GROUP BY fk_user_owner" 
	DBcursor.execute(sql)
	rows = DBcursor.fetchall()
	for org in orgArr:
		for row in rows:
			if row['fk_user_owner'] == org['Owner_id']:
				org['OrgRegStudentCount'] += row['reg_user']
		#if (org['OrgRegStudentCount'] > 0)	:
		#	print("机构ID:%d , 报名学生总数:%d" %(org['OrgId'],org['OrgRegStudentCount']))

	#获取机构下付费报名学生数
	sqlFeeRegStudents = "select org_id,count(fk_user)as feeRegStudents from db_order.`t_order_content` where status=2 and object_type=1 group by org_id"
	DBcursor.execute(sqlFeeRegStudents)
	FeeRegStudents = DBcursor.fetchall()
	for org in orgArr:
		for RegStudent in FeeRegStudents:
			if org['OrgId'] == RegStudent['org_id']:	
				org['OrgFeeRegStudentCount'] += RegStudent['feeRegStudents']
		#if (org['OrgFeeRegStudentCount'] >0 ):
		#	print("机构ID:%d  ,付费课报名人数: %d" % (org['OrgId'],org['OrgFeeRegStudentCount']))

	
#获取机构下有视频教师数
def GetTeacherHasVideo():
	sql = "select distinct fk_user,fk_user_plan from db_course.`t_course_plan` where fk_video<>0 order by fk_user;"	
	DBcursor.execute(sql)
	rows = DBcursor.fetchall()
	for org in orgArr:
		for row in rows:
			if org['Owner_id'] == row['fk_user']:
				org['TeacherHasVideoCount'] +=1
		#if org['TeacherHasVideoCount'] >0:		
		#	print("\033[1;32;40m 机构ID: %d, 机构下有视频的教师数: %d \033[0m" %(org['OrgId'],org['TeacherHasVideoCount']))
	
#获取机构直播,录播次数和时长
def GetOrgLiveAndRecord():
	sql = "select fk_user,vv_live,vv_record,vt_live,vt_record from db_stat.`t_user_org_stat`"
	DBcursor.execute(sql)
	rows = DBcursor.fetchall()
	for org in orgArr:
		for row in rows:
			if org['Owner_id'] == row['fk_user']:
				org['vv_live'] = row['vv_live']
				org['vv_record'] = row['vv_record']
				org['vt_live'] = row['vt_live']
				org['vt_record'] = row['vt_record']
				org['vv'] = (row['vv_live'] + row['vv_record'])
				org['vt'] = (row['vt_live'] + row['vt_record'])
				#print(org['Owner_id'],org['vv_live'],org['vv_record'],org['vt_live'],org['vt_record'])
		#if(org['vt']>0 or org['vv']>0):
		#	print("\033[1;32;40m 机构ID:%d,总时长:%d, 直播时长:%d, 录播时长:%d, 总次数:%d, 直播次数:%d, 录播次数:%d \033[0m" %(org['OrgId'],org['vt'],
		#org['vt_live'],org['vt_record'],org['vv'],org['vv_live'],org['vv_record']))

	
#获取机构报名课程总数		
def GetOrgCourseTotal():
	sql = "SELECT COUNT(pk_course) AS course_count,fk_user FROM db_course.`t_course` WHERE STATUS<>-1 GROUP BY fk_user"
	DBcursor.execute(sql)
	rows =DBcursor.fetchall()
	for org in orgArr:
		for row in rows:
			if org['Owner_id'] == row['fk_user']:
				org['CourseTotal'] += row['course_count']
		#if org['CourseTotal'] > 0:		
		#	print("\033[1;32;40m 机构ID:%d,课程总数:%d \033[0m" % (org['OrgId'],org['CourseTotal']))


def GetOrgVideoInfo():
	#获取机构视频个数
	sql = "SELECT COUNT(fk_video) as video_count,fk_user FROM db_course.`t_course_plan` WHERE fk_video<>0 GROUP BY fk_user"		
	DBcursor.execute(sql)
	rows = DBcursor.fetchall()
	org_ownerIds = []
	VideoInfo = {}
	for org in orgArr:
		for row in rows:
			if org['Owner_id'] == row['fk_user']:
				org['video_count'] = row['video_count']
		#if org['video_count'] > 0:			
		#	print("\033[1;32;40m 机构ID:%d,视频个数:%d \033[0m" % (org['OrgId'],org['video_count']))	
	for row in rows:
		org_ownerIds.append(row['fk_user'])

	#获取机构视频总时长
	sql1 = "select fk_video,fk_user from db_course.`t_course_plan` where fk_video<>0"
	DBcursor.execute(sql1)
	rows = DBcursor.fetchall()
	for owner in org_ownerIds:
		fk_videos = []
		for row in rows:
			if row['fk_user'] == owner:
				fk_videos.append(row['fk_video'])
		VideoInfo[owner] = fk_videos
		#print("\033[1;32;40m 机构所有者ID: %d,视频Id列表: %s  \033[0m" %(owner,str(fk_videos)))

	#将机构总时长存入机构列表	
	for fk_user ,fk_videos in VideoInfo.items():
		fk_videostr = ""
		for videoid in fk_videos:
			fk_videostr += (str(videoid) + ",")
		fk_videostr = fk_videostr.rstrip(',')	
		sql2 = "select sum(totaltime) as video_time from db_video.`t_video` where pk_video in ({fk_video})".format(fk_video=fk_videostr)
		#print(sql2)	
		DBcursor.execute(sql2)
		result = DBcursor.fetchone()
		video_total_time = int(result['video_time'])
		#print(video_total_time)
		#print("\033[1;32;40m 机构ID:%d,视频总时长:%d \033[0m" %(fk_user,video_total_time))
		for org in orgArr:
			if fk_user ==org['Owner_id']:
				org['video_total_time'] = video_total_time
	
def main():
	GetOrgAndOwner()
	GetOrgRegUser()
	GetOrgImportUser()	
	OrgAddTeacherTotal()
	GetOrgRegStudents()
	GetTeacherHasVideo()
	GetOrgLiveAndRecord()
	GetOrgCourseTotal()
	GetOrgVideoInfo()
	GetActiveUser()
	today = date.today()
	yesterday = today + timedelta(days=-1)
	sql = "select * from db_stat.`t_day_org_stat` where pk_day='{}'".format(yesterday)
	print(sql)
	DBcursor.execute(sql)
	rows = DBcursor.fetchall()
	
#验证结果
	for org in orgArr:
		if(org['OrgRegUserCount']>0 or org['OrgImportUserCount']>0 or org['OrgTeacherCount']>0 or org['OrgActiveTeacherCount']>0 or org['OrgRegStudentCount']>0
		or org['OrgFeeRegStudentCount']>0 or org['TeacherHasVideoCount']>0 or org['vv']>0 or org['vt']>0 or org['video_count']>0 or org['CourseTotal']>0 or org['video_total_time']>0): 
			#orginfo = json.dumps(org)
			#print("\033[1;32;40m"+ orginfo + "\033[0m")
			for row in rows:
				print("t_day_org_stat:{} {} {}".format(row['fk_org'],row['reg_user_count'],row['import_user_count']))
				if org['OrgId'] == row['fk_org']:
					if(org['OrgRegUserCount'] == row['reg_user_count'] and org['OrgImportUserCount'] ==row['import_user_count'] and org['OrgActiveTeacherCount'] == row['active_teacher_count'] and 
					org['OrgFeeRegStudentCount'] ==row['pay_enroll_count'] and org['OrgRegStudentCount'] ==row['enroll_count'] and org['TeacherHasVideoCount'] == row['have_video_teacher_count'] and org['video_count'] == row['video_count'] 
					and org['CourseTotal']==row['course_count'] and org['video_total_time']==row['video_length']):
						print("pass:{} {}".format(org['OrgId'],org['Owner_id']))
					elif org['OrgRegUserCount'] != row['reg_user_count']:
						print("注册用户数--failed:{} 脚本统计:{} 数据库表:{}".format(org['OrgId'],org['OrgRegUserCount'],row['reg_user_count']))
					elif org['OrgImportUserCount'] != row['import_user_count']:
						print("导入用户数--failed:{} 脚本统计:{} 数据库表:{}".format(org['OrgId'],org['OrgImportUserCount'],row['import_user_count']))
					elif org['OrgActiveTeacherCount'] != row['active_teacher_count']:
						print("激活教师数--failed:{} 脚本统计:{} 数据库表:{}".format(org['OrgId'],org['OrgActiveTeacherCount'],row['active_teacher_count']))
					elif org['OrgFeeRegStudentCount'] !=row['pay_enroll_count']:
						print("付费课报名人数--failed:{} 脚本统计:{} 数据库表:{}".format(org['OrgId'],org['OrgFeeRegStudentCount'],row['pay_enroll_count']))
					else:
						pass
					break

	DBcursor.close()				
	DB_connect.close()	
	
if __name__	 == "__main__":
	main()
