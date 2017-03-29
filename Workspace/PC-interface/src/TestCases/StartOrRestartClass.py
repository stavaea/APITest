#-*- coding:utf-8 -*-
#!/usr/bin/env python3
'''
Created on 2016年11月4日

@author: lsh
'''

import unittest
import json
import time
import requests
from Provide import TestProvide,Confirm,DB
import Configuration

class Test_startClass(unittest.TestCase):
    '''直播课堂--上课/下课'''

    def setUp(self):
        self.s = requests.session()
        self.s = TestProvide.login(self.s)
        self.url = Configuration.HostUrl +"/interface/plan/StartPlay"
        self.timeStamp = int(time.time())
        self.params = {}
        self.params['u'] ='p'
        self.params['v'] = '1.7.2'
        self.params['time'] = self.timeStamp
        self.plan_id = Configuration.Plan_Id

    def test_startClassNormal(self):
        '''直播课堂--开始上课'''
        self.params['params'] = {
                        "planId" : self.plan_id,
                        "cleanFile": "yes"
                    }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        self.assertEqual('0',returnObj['code'],"返回值状态吗错误")
        self.assertEqual("success", returnObj['message'])
        
        time.sleep(10)
        #从数据表t_course_plan验证排课状态
        connect = DB.Generate_DB_Connect()
        cursor = connect.cursor()
        sql = "SELECT status FROM `t_course_plan` WHERE pk_plan={}".format(self.plan_id)
        result = DB.fetchone_fromDB(cursor, sql)
        self.assertEqual(2,result['status'],"开始上课后，排课状态不是直播中")
           
    def test_restartClassNormal(self):
        '''直播课堂--重新上课'''
        self.params['params'] = {
                        "planId" : self.plan_id,
                        "cleanFile": "Yes"
                    }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        #从数据表t_course_plan验证排课状态    

    def test_startClassWithErrorPlanId(self):
        '''开始上课---错误plan_id'''
        self.params['params'] = {
                        "planId" : 2345,
                        "cleanFile": "no"
                    }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)  
    
    def tearDown(self):
        pass

    
        
if __name__ == "__main__":
    #import sys;sys.argv = ['', 'Test.testName']
    unittest.main()