#-*- encoding:utf-8 -*-
import requests
import json

host = "http://dev.gn100.com"
env = "dev"
#用户登录
loginurl = host + "/site.main.login"
data = {
		"uname":"18500643574",
		"password":"111111",
		"cid": 1,
		"areaCode":86,
		"areaId":86,
		"submit":"登录"
	}
	
r = requests.session()
response = r.post(loginurl,data=data)
if env == "test":
	token = r.cookies.get('token_test')
	uid = r.cookies.get('uid_test')
else:
	token = r.cookies.get('token_dev')
	uid = r.cookies.get('uid_dev')
	
#response.encoding="utf-8"
print(uid,token)

#删除评分

url = host + "/comment/course/DelComment"
data = {
	'courseId':308,
	'planId':2517	
}
response =r.post(url,data = data)
response.encoding = "utf-8"
print(response.text)


"""
#学生打分	
url = host +"/comment/course/addscore"
data = {
	"course_id":"283",
	"score": 4,
	"plan_id": 888,
	"user_teacher":183,
	"user_owner":116,
	"comment":"2分评价呀呀呀呀!"
}


response = r.post(url,data=data)
response.encoding= "utf-8"
print(response.text)
"""
"""
#获取教师平均分
url = host + "/comment/course/TeacherAverage"
data= {
  "teacher_id":"273"
}
response = r.post(url,data=data)
response.encoding = "utf-8"
print("\033[1;32;40m" + response.text + "\033[0m")

#获取课程平均分
url = host + "/comment/course/CourseAverage"
data = {
	"fk_course":"592"
}
response = r.post(url,data=data)
response.encoding = "utf-8"
print("\033[1;31;40m"+response.text+ "\033[0m")


#老师相关评论数
url = host + "/comment/score/TeacherCountNum"
data= {
	"teacher_id":"273",
	"fk_org":"116"
}
response = r.post(url,data=data)
response.encoding = "utf-8"
print("\033[1;30;40m" + response.text + "\033[0m")
"""
"""
url = host+"/comment/course/DelComment"
data = {
	'userId':274,   
	'planId': 1898,  
	'courseId': 592,
	'teacherId': 273
}
response = r.post(url,data=data)
response.encoding="utf-8"
print("\33[1;31;40m" + response.text +"\033[0m")
"""