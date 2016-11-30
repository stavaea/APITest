#-*- coding:UTF-8 -*-
#/usr/bin/env python3
'''
Created on 2016年9月21日

@author: lsh
'''
import unittest
import json
import time
import requests
from PCClientInterface import Configuration,TestProvide,Confirm

class TeacherPlanTest(unittest.TestCase):
    def setUp(self):
        self.s = requests.session()
        #self.s = TestProvide.login(self.s)
        self.url = Configuration.HostUrl +"/interface/course/Teacherplan"
        self.timeStamp = int(time.time())
        self.params = {}
        self.params['u'] ='p'
        self.params['v'] = 2
        self.params['time'] = self.timeStamp

    def _GetTeacherPlan(self):
        courseId = 3425
        self.params['params']= {
                    "courseId":courseId         
                    }
        
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        self.assertEqual(returnObj['code'],0)
        self.assertEqual(returnObj['message'],"success")
        
    def test_getTeacherCourselist(self):
        url = Configuration.HostUrl + "/interface/teacher/classcourselist"
        self.params['params'] =  {
                "page": 1,
                "length": 20,
                "type": 0,
                "sort": 1,
                "teacherId": 255,
                "status": 0
            }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        print(json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response = self.s.post(url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False)) 
        response.encoding = "utf-8"
        print(response.text)
        returnObj = json.loads(response.text)
        CompareObj =  {
                "courseId": "2940",
                "courseName": "测试直播课001",
                "courseImg": "http://devf.gn100.com/3,1cd82285ac16",
                "courseType": "1",
                "className": "1班",
                "classId": "323",
                "userTotal": "5",
                "selectCount": "5",
                "planNum": "第2章",
                "schedule": 0,
                "subname": "高能",
                "livingNum": 21,
                "recordNum": 432,
                "underNum": 321,
                "total": 100
            }
        
        self.assertEqual(returnObj['page'], 1)
        self.assertEqual(returnObj['totalPage'], 5, "pass")
        self.assertListEqual(Confirm.objIsInList(CompareObj, returnObj['data']),"Test failed")   

    def tearDown(self):
        pass
    
if __name__ == "__main__":
    #import sys;sys.argv = ['', 'TeacherPlanTest.test_getTeacherCourselist']
    unittest.main()