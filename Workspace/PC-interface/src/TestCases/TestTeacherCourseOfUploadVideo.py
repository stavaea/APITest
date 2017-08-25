#-*- coding:UTF-8 -*-
#!/usr/bin/env python3
import sys
import unittest
import json
import time
import requests
from Provide import TestProvide,Confirm
import Configuration

class Test_getCourseList(unittest.TestCase):
    def setUp(self):
        self.s = requests.session()
        self.url = Configuration.HostUrl +"/interface/course/TeacherCourse"
        self.timeStamp = int(time.time())
        self.params = {}
        self.params['u'] ='p'
        self.params['v'] = 2
        self.params['time'] = self.timeStamp
        
    def test_GetVideoCousrse(self): 
        '''获取录播课程列表--默认参数'''
        page = 1
        length = 20
        userId = 42
        self.params['params'] = {
                                 "page":page,
                                 "length":length,
                                 "userId":userId 
                                 }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        self.assertEqual(3002,returnObj['code'])
  
    def test_GetVideoCousrsePaging(self):
        '''录播课程列表--翻页(下一页)''' 
        page = 2
        length = 20
        userId = 42
        self.params['params'] = {
                   "page": page,
                   "length":length,
                   "userId":userId          
            }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        text = response.text
        returnObj = json.loads(text)
        print(returnObj) 
        self.assertEqual(returnObj['result']['page'],page)
        self.assertEqual(len(returnObj['result']['data']),length)
        self.assertIsNotNone(returnObj['result']['data'], "翻页后，课程列表为空")
        
    
    def test_GetCVideoousrse_ByKeywords(self):
        '''通过关键词搜索录播课程''' 
        page = 1
        length = 20
        userId = 42
        keyWords = "录播"
        self.params['params'] = {
                   "page": page,
                   "length":length,
                   "userId":userId,
                   "keyWords":keyWords         
            }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        OneCourseObj = returnObj['result']['data'][0]
        self.assertEqual(0,returnObj['code'])
        self.assertEqual(OneCourseObj['courseName'],keyWords)
    
    def test_GetVideoCousrse_LessDefaultParameter(self): 
        '''获取录播课程--缺少必传参数'''
        page = 1
        length = 20
        self.params['params'] = {
                                 "page":page,
                                 "length":length
                                 }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        text = response.text
        returnObj = json.loads(text)
        #print(returnObj) 
        self.assertEqual(returnObj['code'],1000)
        self.assertEqual(returnObj['errMsg'],"请求参数为空")
    
        
    def tearDown(self):
        pass

if __name__ == "__main__":
    #import sys;sys.argv = ['', 'Test.TestName']
    unittest.main()