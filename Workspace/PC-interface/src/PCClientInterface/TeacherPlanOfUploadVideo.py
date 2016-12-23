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

class test_getPlanList(unittest.TestCase):
    def setUp(self):
        self.s = requests.session()
        #self.s = TestProvide.login(self.s)
        self.url = Configuration.HostUrl +"/interface/course/Teacherplan"
        self.timeStamp = int(time.time())
        self.params = {}
        self.params['u'] ='p'
        self.params['v'] = 2
        self.params['time'] = self.timeStamp

    def test_GetTeacherPlan(self):
        self.params['params']= {
                    "courseId":1007      
                }
        
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        print(self.url)
        print(json.dumps(self.params,separators=(',',':')))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        self.assertEqual(returnObj['code'],0)
        self.assertEqual(returnObj['message'],"success")
        ClassInfo  =     {
                'classId': '1226',
                'planNum': 4,
                'uploadVideo': 0,
                'data': [
                    {
                        'planId': 3568,
                        'status': '1',
                        'sectionDesc': '001',
                        'sectionName': '第1课时'
                    },
                    {
                        'planId': 3569,
                        'status': '1',
                        'sectionDesc': '002',
                        'sectionName': '第2课时'
                    },
                    {
                        'planId': 4378,
                        'status': '1',
                        'sectionDesc': '003',
                        'sectionName': '第3课时'
                    },
                    {
                        'planId': 4379,
                        'status': '1',
                        'sectionDesc': '004',
                        'sectionName': '第4课时'
                    }
                ],
                'name': '1班'
            }
        self.assertTrue(Confirm.objIsInList(ClassInfo, returnObj['result']))
        
    def test_getPlanlist_forlivingCourse(self):
        self.params['params']= {
                    "courseId":891             
                }
        
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        print(self.url)
        print(json.dumps(self.params,separators=(',',':')))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        self.assertEqual(returnObj['code'],0)
        self.assertIsNotNone(returnObj['result'],"直播课程也返回了排列列表")
    
    
    def tearDown(self):
        pass
    
if __name__ == "__main__":
    #import sys;sys.argv = ['', 'TeacherPlanTest.test_getTeacherCourselist']
    unittest.main()