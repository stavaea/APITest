#-*- coding:UTF-8 -*-
#!/usr/bin/env python3
import sys
import unittest
import json
import time
import requests
from PCClientInterface import Configuration,TestProvide

class Test_uploadVideo(unittest.TestCase):
    def setUp(self):
        self.s = requests.session()
        self.url = Configuration.HostUrl +"/interface/course/TeacherCourse"
        self.timeStamp = int(time.time())
        self.params = {}
        self.params['u'] ='p'
        self.params['v'] = 2
        self.params['time'] = self.timeStamp
        
    def test_GetTeacherCousrse1(self): 
        #构造参数
        page = 1
        length = 20
        userId = 255
        self.params['params'] = {
                                 "page":page,
                                 "length":length,
                                 "userId":userId 
                                 }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        text = response.text
        returnObj = json.loads(text)
        print(returnObj) 
        self.assertEqual(returnObj['code'],0)
        self.assertEqual(returnObj['message'],"success")

            
    def test_GetTeacherCousrsePutPage(self): 
        page = 3
        length = 20
        userId = 255
        self.params['params'] = {
                   "page": page,
                   "length":length,
                   "userId":userId          
            }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        #提交请求
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        text = response.text
        returnObj = json.loads(text)
        print(returnObj) 
        self.assertEqual(returnObj['result']['page'],page)
        #self.assertEqual(returnObj['result']['length'],length)
        self.assertIsNotNone(returnObj['result']['data'], "返回值不是一个对象")
        
    
    def test_GetTeacherCousrseKeywords(self): 
        page = 1
        length = 20
        userId = 255
        keyWords = "dev测试"
        self.params['params'] = {
                   "page": page,
                   "length":length,
                   "userId":userId,
                   "keyWords":keyWords         
            }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        #提交请求
        print(json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        text = response.text
        returnObj = json.loads(text)
        print(returnObj) 
        #self.assertEqual(returnObj['result']['page'],page)
    
    def Test_GetTeacherCousrseLessDefaultParam(self): 
        #构造参数
        page = 1
        length = 20
        #userId = 255
        self.params['params'] = {
                                 "page":page,
                                 "length":length
                                 }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
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