#-*- coding:utf-8 -*-
#!/usr/bin/env python3
'''
Created on 2016年11月3日

@author: lsh
'''
import unittest
from PCClientInterface import TestProvide,Configuration,Confirm
import json
import time
import requests


class Test_CoursePlanOfTeacher(unittest.TestCase):

    def setUp(self):
        self.s = requests.session()
        self.s = TestProvide.login(self.s)
        self.url = Configuration.HostUrl +"/interface/teacher/plans"
        self.timeStamp = int(time.time())
        self.params = {}
        self.params['u'] ='p'
        self.params['v'] = '1.7.0'
        self.params['time'] = self.timeStamp


    def tearDown(self):
        pass


    def est_getCoursePlans(self):
        TeacherId = self.s.cookies.get('uid_test')
        self.params['params'] = {
                 "classId":1225,
                "teacherId":TeacherId,
                "courseId":1006
            }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        #验证返回值排课数据结构
        ExpectKeys = ['startTime','sectionName','teacherName','totalTime','courseType','status','planId','adminName','teacherId','sectionDesc','adminId']
        self.assertTrue(Confirm.VerifyDataStucture(ExpectKeys, returnObj['result']['data'].keys()), "返回排课对象JSON字段值不对")
        OnePlanInfo = {
                'startTime': '2016-10-27 13:45:00',
                'sectionName': '第1课时',
                'teacherName': '王喜山',
                'totalTime': 0,
                'courseType': 1, 
                'status': 1,
                'planId': 3562,
                'adminName': '王喜山',
                'teacherId': 281,
                'sectionDesc': '奔跑吧兄弟',
                'adminId': 281
            }
        self.assertIs(OnePlanInfo,returnObj['result']['data'][0],"排课信息值不匹配")
    
    def test_getCoursePlansWithErrorClassIdOrCourseId(self):
        TeacherId = self.s.cookies.get('uid_test')
        self.params['params'] = {
                 "classId":1227,
                "teacherId":TeacherId,
                "courseId":1006
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
                 "classId":1225,
                "teacherId":288,
                "courseId":1006
            }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)   
        self.assertEqual(3002,returnObj['code'],"test failed")
        self.assertEqual("get data failed", returnObj['message'], "test failed")
        
    def test_getCoursePlanWithLessArgument(self):
        self.params['params'] = {
                 "classId":1225,
                "courseId":1006
            }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        self.assertEqual(1000,returnObj['code'] ,'test failed')
        self.assertEqual('request param empty',returnObj['message'])
            
        
if __name__ == "__main__":
    #import sys;sys.argv = ['', 'Test.testName']
    unittest.main()