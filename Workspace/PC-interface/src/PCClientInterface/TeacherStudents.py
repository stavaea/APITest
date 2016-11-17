#-*- coding:utf-8 -*-
#/usr/bin/env python3
'''
Created on 2016年11月2日

@author: lsh
'''
import unittest
from PCClientInterface import TestProvide,Configuration,Confirm
import json
import time
import requests


class Test_TeacherOfStudents(unittest.TestCase):


    def setUp(self):
        self.s = requests.session()
        self.s = TestProvide.login(self.s)
        self.url = Configuration.HostUrl +"/interface/teacher/students"
        self.timeStamp = int(time.time())
        self.params = {}
        self.params['u'] ='p'
        self.params['v'] = 2
        self.params['time'] = self.timeStamp
        self.teacherId= self.s.cookies.get("uid_test")

    def tearDown(self):
        pass
    
    def test_getStudentList(self):
        self.params['params'] = {
                "page":1,
                "length":20,
                "classId": Configuration.class_id,
                "courseId": Configuration.course_id,
                "teacherId":self.teacherId,
              }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        firstObj=returnObj['result']['data'][0]
        keys = ['startTime','address','sex','userName','mobile','userId']
        Result=Confirm.VerifyDataStucture(keys,firstObj.keys())
        self.assertTrue(Result, "学生属性值返回错误")
        
     
    def test_getStudentWithPaging(self):
        self.params['params'] = {
                "page":2,
                "length":20,
                "classId": Configuration.class_id,
                "courseId":Configuration.course_id,
                "teacherId":self.teacherId,
              }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        OneUser=  {
                'mobile': '13645420000',
                'userName': '周振宇',
                'userId': '22519',
                'startTime': '2016年11月10日13:56',
                'address': '移动山东',
                'sex': ''
            }
        
        if returnObj['code']==0:
            self.assertEqual(2,returnObj['result']['page'])
            print(returnObj['result']['data'])
            Result = Confirm.objIsInList(OneUser,returnObj['result']['data'])
            self.assertTrue(Result,"学生列表未翻页")
        else:
            raise("接口返回失败")     
         
    def test_getStudentWithErrorClassId(self):
        self.params['params'] = {
                "page":1,
                "length":20,
                "classId":1566,
                "courseId":3623,
                "teacherId":self.teacherId,
              }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        self.assertEqual(3002,returnObj['code'])
        self.assertEqual("get data failed",returnObj['message'])
    
    @unittest.skip("3")    
    def test_getStudentWithErrorCourseId(self):
        self.params['params'] = {
                "page":1,
                "length":20,
                "classId":1567,
                "courseId":3624,
                "teacherId":self.teacherId,
              }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        self.assertEqual(3002,returnObj['code'])
        self.assertEqual("get data failed",returnObj['message'])    

if __name__ == "__main__":
    #import sys;sys.argv = ['', 'Test.testName']
    unittest.main()