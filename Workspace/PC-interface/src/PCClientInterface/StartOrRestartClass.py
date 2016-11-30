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
from PCClientInterface import Configuration,TestProvide,Confirm

class Test_startClass(unittest.TestCase):


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

    def tearDown(self):
        pass


    def test_startClassNormal(self):
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
        
    def test_restartClassNormal(self):
        self.params['params'] = {
                        "planId" : self.plan_id,
                        "cleanFile": "no"
                    }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)    

    def test_startClassWithErrorPlanId(self):
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
    
        
if __name__ == "__main__":
    #import sys;sys.argv = ['', 'Test.testName']
    unittest.main()