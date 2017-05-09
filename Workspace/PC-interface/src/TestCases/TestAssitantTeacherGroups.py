#-*- coding:utf-8 -*-
'''
Created on 2017年4月1日

@author: lsh
'''
import unittest
import Configuration
import time,requests,json
from Provide import TestProvide

class Test_AssiantTeacherGroups(unittest.TestCase):

    def setUp(self):
        self.s = requests.session()
        self.s = TestProvide.login(self.s,"13175867645","111111")
        token = self.s.cookies.get('token_test')
        #print(self.s.cookies.get('token_test'))
        self.url = "http://dev.gn100.com" +"/interface/group/classlist"
        self.timeStamp = int(time.time())
        self.params = {}
        self.params['u'] ='p'
        self.params['v'] = '1.7.2'
        self.params['time'] = self.timeStamp
        self.params['token'] = token

    def test_getGroupList(self):
        self.params['params'] =  {"classId":3802}
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        print(self.url)
        print(json.dumps(self.params,separators=(',',':')))
        response = self.s.post(url=self.url,data=json.dumps(self.params['params'],separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        print(returnObj)
        


if __name__ == "__main__":
    #import sys;sys.argv = ['', 'Test.testName']
    unittest.main()