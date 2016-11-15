#-*- coding:utf-8 -*-

'''
Created on 2016年10月26日

@author: lsh
'''
import unittest
import json
import time
import requests
from PCClientInterface import Configuration,TestProvide,Confirm

class Test_courseLivingPlan(unittest.TestCase):

    def setUp(self):
        self.s = requests.session()
        self.s = TestProvide.login(self.s)
        self.url = Configuration.HostUrl +"/interface/course/PlanList"
        self.timeStamp = int(time.time())
        self.params = {}
        self.params['u'] ='p'
        self.params['v'] = '1.7.2'
        self.params['time'] = self.timeStamp
    
    def test_getLivingPlan(self):
        teacherId = self.s.cookies.get('uid_test')
        month = Configuration.month
        year  = Configuration.year
        self.params['params'] = {
                                 "month":month,
                                 "teacherId":teacherId,
                                 "year":year
                            }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        #print(json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        ExpectKeys = ['sectionDescipt','start_time','status','class_id','thumb','type','class_name','section_name','teacher_name','course_id','userTotal','num','title',
                'plan_id','course_type']
        for key in returnObj['result']:
            if returnObj['result'][key]['flag'] == 1:
                CompareObj = returnObj['result'][key]['data'][0]
                self.assertTrue(Confirm.VerifyDataStucture(ExpectKeys, CompareObj))
        OneDayPlanInfo  =  {
                    'sectionDescipt': '001',
                    'start_time': '17: 55',
                    'status': '开始上课',
                    'class_id': '1224',
                    'thumb': "http: //testf.gn100.com/3,73b4d6997d24",
                    'type': '1',
                    'class_name': '1班',
                    'section_name': '1',
                    'teacher_name': '王喜山',
                    'course_id': '1005',
                    'userTotal': '0',
                    'num': '3',
                    'title': 'PC-Client接口测试1026',
                    'plan_id': '3558',
                    'course_type': '1'
                }
        self.assertTrue(Confirm.objIsInList(OneDayPlanInfo, returnObj['result']['26']['data']),"返回排课信息有误")                      

if __name__ == "__main__":
    #import sys;sys.argv = ['', 'Test.testName']
    unittest.main()