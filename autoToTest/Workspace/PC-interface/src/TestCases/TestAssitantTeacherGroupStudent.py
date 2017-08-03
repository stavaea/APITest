#-*- coding:utf-8 -*-
'''
Created on 2017年4月1日

@author: lsh
'''
import unittest
import Configuration,json
import time,requests
from Provide import TestProvide

class Test(unittest.TestCase):

    def setUp(self):
        url = Configuration.HostUrl + "/interface/group/ClassStudents"
        self.s = requests.session()
        self.timeStamp = int(time.time())
        self.params = {}
        self.params['u'] ='p'
        self.params['v'] = "1.7.0"
        self.params['time'] = self.timeStamp
        
    
    def test_getGroupStudents_notInGroup(self):
        '''未分组学生列表'''
        self.params['params'] = {
                                "classId":3802,
                                "groupId":-2
                            } 
        self.params['key'] = TestProvide.generateKey(self.timeStamp,self.params['params'])
        response = self.s.post(url=self.url,data=json.dumps(self.params['params']))
        response.encoding= "utf-8"
        print(response.txt)
        
        
    def test_getGroupStudents_inGroup(self):
        '''其中一个分组学生列表'''
        self.params['params'] = {
                                "classId":3802,
                                "groupId": 396
                            } 
        self.params['key'] = TestProvide.generateKey(self.timeStamp,self.params['params'])
        response = self.s.post(url=self.url,data=json.dumps(self.params['params']))
        response.encoding= "utf-8"
        print(response.txt)
        
    def test_getGroupStudent_all(self):
        '''分组学生列表--全部分组'''
        self.params['params'] = {
                                "classId":3802,
                                "groupId": 396
                            } 
        self.params['key'] = TestProvide.generateKey(self.timeStamp,self.params['params'])
        response = self.s.post(url=self.url,data=json.dumps(self.params['params']))
        response.encoding= "utf-8"
        print(response.txt)

    def test_getGroupStudent_withnotClassId(self):
        '''不传入ClassId'''
        self.params['params'] = {
                                "groupId": 396
                            } 
        self.params['key'] = TestProvide.generateKey(self.timeStamp,self.params['params'])
        response = self.s.post(url=self.url,data=json.dumps(self.params['params']))
        response.encoding= "utf-8"
        print(response.txt)
        
    def test_getGroupStudent_withnotGroupId(self):
        '''不传入ClassId'''
        self.params['params'] = {
                                "classId": 3802
                            } 
        self.params['key'] = TestProvide.generateKey(self.timeStamp,self.params['params'])
        response = self.s.post(url=self.url,data=json.dumps(self.params['params']))
        response.encoding= "utf-8"
        print(response.txt)
        
    def test_getGroupStudent_withNotExistClass(self):
        '''传入不存在的ClassId'''
        self.params['params'] = {
                                "classId": 3802,
                                "groupId": 396
                            } 
        self.params['key'] = TestProvide.generateKey(self.timeStamp,self.params['params'])
        response = self.s.post(url=self.url,data=json.dumps(self.params['params']))
        response.encoding= "utf-8"
        print(response.txt)

if __name__ == "__main__":
    #import sys;sys.argv = ['', 'Test.testName']
    unittest.main()