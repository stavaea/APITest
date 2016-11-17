#-*- coding:utf-8 -*-
#!/usr/bin/env python3
'''
Created on 2016年10月31日

@author: lsh
'''

import unittest
import requests
import time
import json
from PCClientInterface import TestProvide,Configuration

class Test_getAnnounce(unittest.TestCase):


    def setUp(self):
        self.url = Configuration.HostUrl + "/interface/announcement/GetAnnouncement"
        self.s = requests.session()
        self.timeStamp = int(time.time())
        self.params = {}
        self.params['u'] ='p'
        self.params['v'] = "1.7.0"
        self.params['time'] = self.timeStamp


    def tearDown(self):
        pass


    def est_getAnnouncement(self):
        plan_id = Configuration.Plan_Id
        self.params['params'] = {
                        "fkPlan": plan_id
                    }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        self.assertEqual(0,returnObj['code'])
        self.assertEqual("success",returnObj['message'])
        self.assertIsNotNone(returnObj['result'])
        
    def test_getAnnouncementWithReturnError(self):
        plan_id = 8311
        self.params['params'] = {
                        "fkPlan": plan_id         
                    }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        self.assertEqual(0,returnObj['code']) 
        self.assertEqual("success",returnObj['message'])
        self.assertEqual(0,len(returnObj['result']))

if __name__ == "__main__":
    #import sys;sys.argv = ['', 'Test.testName']
    unittest.main()