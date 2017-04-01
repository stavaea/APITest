#-*- coding:utf-8 -*-
#!/usr/bin/env python3
'''
Created on 2016年10月26日

@author: lsh
'''
import unittest
import json
import time
import requests
from Provide import TestProvide,Confirm,Seek
import Configuration
from datetime import datetime

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
        month = 2016
        year  =  9
        self.params['params'] = {
                                 "month":month,
                                 "teacherId":teacherId,
                                 "year":year
                            }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        ExpectKeys = ['sectionDescipt','start_time','status','class_id','thumb','type','class_name','section_name','teacher_name','course_id','userTotal','num','title',
                'plan_id','course_type']
        for key in returnObj['result']:
            if returnObj['result'][key]['flag'] == 1:
                CompareObj = returnObj['result'][key]['data'][0]
                self.assertTrue(Confirm.VerifyDataStucture(ExpectKeys, CompareObj))
                break
            
        count = 0
        format = ["course_name","class_name","section_name","section_desc","course_type","plan_id","start_time","totaltime","teacher_id","teacher_real_name"]
        query = {"start_time":"2016-09-01,2016-10-01","teacher_id":281,"status":"1,2,3"}
        ob = {"start_time":"asc"}
        planList = Seek.seekPlan(format, query,ob)
        planList = planList['data']
        print(planList)
        for i in range(len(planList)):
            dateObj = datetime.strptime(planList[i]['start_time'],"%Y-%m-%d %H:%M:%S")
            key = str(dateObj.day)
            for plan in returnObj['result'][key]['data']:
                if plan['title'] == planList[i]['course_name'] and plan['class_name']==planList[i]['class_name'] and plan['plan_id']==planList[i]['plan_id'] \
                and plan['section_desc']==planList[i]['sectionDescipt']:
                    count += 1
                
        self.assertEqual(len(planList), count, "排课信息不符")        
                            

if __name__ == "__main__":
    unittest.main()