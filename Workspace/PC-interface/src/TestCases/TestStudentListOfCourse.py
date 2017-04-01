#-*- coding:utf-8 -*-
#/usr/bin/env python3
'''
Created on 2016年11月2日

@author: lsh
'''
import unittest
from Provide import TestProvide,Confirm
import Configuration
import json
import time
import requests


class Test_TeacherOfStudents(unittest.TestCase):
    '''课程卡片详情--学生列表'''
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
        """获取学生列表---通过班主任获取"""
        self.params['params'] = {
                "page":1,
                "length":20,
                "classId": Configuration.class_id,
                "courseId": Configuration.course_id,
                "teacherId":273,
              }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        print("Url:{}\r\n Parameters:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        firstObj=returnObj['result']['data'][0]
        keys = ['startTime','address','sex','userName','mobile','userId']
        Result=Confirm.VerifyDataStucture(keys,firstObj.keys())
        self.assertTrue(Result, "学生属性值返回错误")
    
    def test_getStudentList_withlecturerId(self):
        """获取学生列表---通过讲师获取"""
        self.params['params'] = {
                "page":1,
                "length":20,
                "classId": Configuration.class_id,
                "courseId": Configuration.course_id,
                "lecturerId":self.teacherId,
              }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        print("Url:{}\r\n Parameters:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        self.assertIsNotNone(returnObj['result']['data'],"返回学生列表为空")
         
    def test_getStudentWithPaging(self):
        """学生列表翻页"""
        self.params['params'] = {
                "page":2,
                "length":20,
                "classId": Configuration.class_id,
                "courseId":Configuration.course_id,
                "lecturerId":self.teacherId,
              }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        print("Url:{}\r\n Parameters:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        OneUser=  {
                "userId": "22610",
                "userName": "刘明中  ",
                "sex": "",
                "mobile": "13645420091",
                "address": "移动 山东",
                "startTime": "2016年09月02日 15:53"
            }
        
        if returnObj['code']==0:
            self.assertEqual('2',returnObj['result']['page'])
            Result = False
            Students = returnObj['result']['data']
            for studentObj in Students:
                if OneUser['mobile']==studentObj['mobile'] and OneUser['userName']==studentObj['userName']  and OneUser['userId']==studentObj['userId']:
                    Result = True
                    break
            self.assertTrue(Result,"学生列表未翻页")
        else:
            raise("接口返回失败")
             
    def test_getStudentWithErrorClassId(self):
        """获取学生列表传入错误班级ID"""
        self.params['params'] = {
                "page":1,
                "length":20,
                "classId":1566,
                "courseId":3623,
                "lecturerId":self.teacherId,
              }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        print("Url:{}\r\n Parameters:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        self.assertEqual(3002,returnObj['code'])
        self.assertEqual("get data failed",returnObj['message'])
     
    def test_getStudentWithErrorCourseId(self):
        """获取学生列表传入错误课程ID"""
        self.params['params'] = {
                "page":1,
                "length":20,
                "classId":1567,
                "courseId":3624,
                "lecturerId":self.teacherId,
              }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        print("Url:{}\r\nParameters:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        self.assertEqual(3002,returnObj['code'])
        self.assertEqual("get data failed",returnObj['message'])    

if __name__ == "__main__":
    unittest.main()