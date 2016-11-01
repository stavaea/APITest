#-*- coding:utf-8 -*-

'''
Created on 2016年10月31日

@author: lsh
'''

import unittest
import requests
import time
import json
from PCClientInterface import TestProvide

class Test(unittest.TestCase):


    def setUp(self):
        self.url = "http://dev.gn100.com "+ "/interface/announcement/GetAnnouncement"
        self.s = requests.session()
        self.params = {}
        self.params['u'] ='p'
        self.params['v'] = "1.7.0"
        self.params['time'] = int(time.time())


    def tearDown(self):
        pass


    def test_getAnnouncement(self):
        plan_id = 8361
        self.params['params'] = {
                        "fk_plan": plan_id        
                    
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
                        "fk_plan": plan_id         
                    }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        self.assertEqual(1,returnObj['code']) 
        self.assertEqual("failure",returnObj['message'] )   

if __name__ == "__main__":
    #import sys;sys.argv = ['', 'Test.testName']
    unittest.main()