#-*- coding:utf-8 -*-
#!/usr/bin/env python3
'''
Created on 2016年11月4日

@author: lsh
'''

import unittest
import json
import time,re
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
        self.params['v'] = '1.9.0'
        self.params['time'] = self.timeStamp
        self.params['token'] = self.s.cookies.get('token_test')
        self.plan_id = Configuration.Plan_Id

    def test_startClassNormal(self):
        '''直播课堂--开始上课'''
        self.params['params'] = {
                        "planId" : self.plan_id
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
    
    def test_getPlayStream(self):
        '''获取语音流信息'''
        self.url = Configuration.HostUrl + "/interface/play/stream" 
        self.params['params'] ={
                                "planId":Configuration.Plan_Id
                            }
        
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        
        self.assertEqual(0,returnObj['code'])
        
        result = re.search('rtmp:\/\/115.28.38.142',response.text,re.M|re.I)
        self.assertEqual('', result)
        
        
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
        self.assertEqual('0',returnObj['code'],"返回值状态吗错误")
        self.assertEqual("success", returnObj['message'])
        
        time.sleep(10)
        #从数据表t_course_plan验证排课状态
        connect = DB.Generate_DB_Connect()
        cursor = connect.cursor()
        sql = "SELECT status FROM `t_course_plan` WHERE pk_plan={}".format(self.plan_id)
        result = DB.fetchone_fromDB(cursor, sql)
        connect.close()
        self.assertEqual(2,result['status'],"开始上课后，排课状态不是直播中")
        
    def test_stopClassNormal(self):
        '''直播课堂教师下课'''
        self.url = Configuration.HostUrl +"/interface/plan/ClosePlay"
        teacherId = self.s.cookies.get("uid_test")
        self.params['params'] = {
                        "planId" : self.plan_id,
                        "uid":teacherId
                    }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        
        #从数据表表验证plan的status状态值是否变为3
        connect = DB.Generate_DB_Connect()
        cursor = connect.cursor()
        sql = "SELECT status FROM `t_course_plan` WHERE pk_plan={}".format(self.plan_id)
        result = DB.fetchone_fromDB(cursor, sql)
        connect.close()
        self.assertEqual(3,result['status'],"开始上课后，排课状态不是直播中")
        
    def test_stopClassWithErrorTeacherId(self):
        self.url = Configuration.HostUrl +"/interface/plan/ClosePlay"
        self.params['params'] = {
                        "planId" : self.plan_id,
                        "uid":3425
                    }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        self.assertEqual(2001,returnObj['code'])
        self.assertEqual("teacher no permission teaching", returnObj['message'])

    def test_stopClassWithErrorToken(self):
        self.url = Configuration.HostUrl +"/interface/plan/ClosePlay"
        teacherId = self.s.cookies.get("uid_test")
        self.params['params'] = {
                        "planId" : self.plan_id,
                        "uid":3425
                    }
        self.params['token'] = "a875392d928ec052e2d19e192b8a6b84"
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        self.assertEqual(2001,returnObj['code'])
        self.assertEqual("teacher no permission teaching", returnObj['message'])

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
        self.assertEqual(0,returnObj['code'])  
    
    def tearDown(self):
        pass

    
        
if __name__ == "__main__":
    #import sys;sys.argv = ['', 'Test.testName']
    #unittest.main()
    suite = unittest.TestSuite()
    #suite.addTest(Test_startClass('test_startClassNormal'))
    #suite.addTest(Test_startClass('test_restartClassNormal'))
    #suite.addTest(Test_startClass('test_stopClassNormal'))
    #suite.addTest(Test_startClass('test_stopClassWithErrorTeacherId'))
    suite.addTest(Test_startClass('test_stopClassWithErrorToken'))
    suite.addTest(Test_startClass('test_startClassWithErrorPlanId'))
    runner = unittest.TextTestRunner()
    runner.run(suite)
    