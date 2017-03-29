#-*- coding:utf-8 -*-
#!/usr/bin/env python3
'''
Created on 2016年11月3日

@author: lsh
'''
import unittest
from Provide import TestProvide,Confirm
import Configuration
import json
import time
import requests
import pymysql
from pymysql import cursors

class Test_CoursePlanOfTeacher(unittest.TestCase):
    '''课程卡片详情--学生列表'''
    def setUp(self):
        self.s = requests.session()
        self.url = Configuration.HostUrl +"/interface/teacher/plans"
        self.timeStamp = int(time.time())
        self.params = {}
        self.params['u'] ='p'
        self.params['v'] = '1.7.0'
        self.params['time'] = self.timeStamp

    def test_getCoursePlans_onlyTeacherId(self):
        '''只传入班主任Id'''
        self.params['params'] = {
                 "classId":914,
                "teacherId":273,
                "courseId":780
            }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        #验证返回值排课数据结构
        ExpectKeys = ['planId','sectionDesc','sectionName','teacherId','teacherName','adminId','adminName','courseType','startTime','status','totalTime']
        self.assertTrue(Confirm.VerifyDataStucture(ExpectKeys, returnObj['result']['data'][0].keys()), "返回排课对象属性字段值不对")
        OnePlanInfo = {
                'adminName': '李胜红',
                'courseType': 1,
                'adminId': 273,
                'sectionDesc': '1',
                'planId': 2558,
                'startTime': '2016-08-31 19:08:00',
                'sectionName': '第1课时',
                'status': 1,
                'teacherId': 281,
                'totalTime': 0,
                'teacherName': '王喜山'
            }
        
        self.assertTrue(Confirm.VerifyDictEqual(OnePlanInfo,returnObj['result']['data'][0]),"排课信息不匹配  预期:{},返回值:{}".format(OnePlanInfo,returnObj['result']['data'][0]))
        
    def test_getCoursePlansWithlessTeacherId(self):
        '''不传入班主任Id'''
        self.params['params'] = {
                 "classId":914,
                "lecturerId":281,
                "courseId":780
            }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        self.assertIsNotNone(returnObj['result']['data'],"返回排课列表为空")
    
    def test_getCoursePlanWithAllTeacher(self):
        '''传入班主任Id,讲师Id'''
        
        self.params['params'] = {
                "classId":914,
                "teacherId":273, 
                "lecturerId":281,
                "courseId":780
            }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        self.assertIsNotNone(returnObj['result']['data'],"返回排课列表为空")
        connect = self.InitSqlConnect()
        cursor = connect.cursor()
        sql = "SELECT section.`name`,section.`descript`,plan.`pk_plan`,plan.`fk_user_plan` as teacherId,plan.`start_time`,plan.`status` FROM `t_course_plan` \
        AS plan JOIN `t_course_section` AS section ON plan.`fk_section` = section.`pk_section` WHERE plan.`fk_course`=780 AND plan.`fk_class`=914"
        cursor.execute(sql)
        rows = cursor.fetchall()
        num = 0 
        for row in rows:
            for obj in returnObj['result']['data']:
                if row['name']==obj['sectionName'] and row['pk_plan'] ==obj['planId'] and row['teacherId'] ==obj['teacherId'] \
                and row['descript'] ==obj['sectionDesc'] and row['status'] == obj['status']:
                    print("equal infomation {} {}".format(row,obj))
                    num = num + 1 
                    continue
                else:
                    print("sql:{} return:{}".format(row,obj))
                    
        cursor.close()
        connect.close()
        self.assertEqual(len(rows),num,"返回的章节列表信息有误")
                
    def test_getCoursePlansWithErrorClassIdOrCourseId(self):
        self.params['params'] = {
                 "classId":915,
                "teacherId":273,
                "courseId":780
            }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        self.assertEqual(3002,returnObj['code'],"test failed")
        self.assertEqual("get data failed", returnObj['message'], "test failed")
        
    def test_getCoursePlanWithErrorTeacherId(self):
        self.params['params'] = {
                 "classId":914,
                "teacherId":288,
                "courseId":780
            }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)   
        self.assertEqual(3002,returnObj['code'],"test failed")
        self.assertEqual("get data failed", returnObj['message'], "test failed")
        
    def test_getCoursePlanWithErrorlecturerId(self):
        self.params['params'] = {
                "classId":914,
                "lecturerId":275,
                "courseId":780
            }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)   
        self.assertEqual(3002,returnObj['code'],"test failed")
        self.assertEqual("get data failed", returnObj['message'], "test failed")
        
    def test_getCoursePlan_WithOnlyMandatoryArgument(self):
        self.params['params'] = {
                 "classId":914,
                "courseId":780
            }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        self.assertEqual(0,returnObj['code'] ,'test failed')
        self.assertIsNotNone(returnObj['result']['data'],"返回排课列表为空")
    
    def InitSqlConnect(self):
        db_url = {"host":"115.28.222.160","user":"michael","passwd":"michael","db":"db_course","charset":"utf8","cursorclass":cursors.DictCursor}
        connect = pymysql.connect(**db_url)
        connect.autocommit(True)    
        return connect      
        
if __name__ == "__main__":
    #unittest.main()
    suite = unittest.TestSuite()
    suite.addTest(Test_CoursePlanOfTeacher('test_getCoursePlans_onlyTeacherId'))
    runner = unittest.TextTestRunner()
    runner.run(suite)