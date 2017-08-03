#-*- coding:utf-8 -*-
#!/usr/bin/env python3
'''
Created on 2016年11月8日

@author: lsh
'''

import unittest
import json
import time
import requests
from Provide import TestProvide,Confirm
import Configuration
import pymysql
import pymysql.cursors

class Test_GetQuestion(unittest.TestCase):
    """创建快速出题，互动问答题目"""
    
    @classmethod
    def setUpClass(cls):
        connect_url = {"host":"115.28.222.160","user":"michael", "passwd":"michael", "db":"db_course", "charset":"utf8", "cursorclass":pymysql.cursors.DictCursor}
        cls.connect = pymysql.connect(**connect_url)
        cls.connect.autocommit(True)
        cls.cursor = cls.connect.cursor()
    
    def setUp(self):
        self.s = requests.session()
        self.url = Configuration.HostUrl +"/interface/plan/getQuestionId"
        self.timeStamp = int(time.time())
        self.params = {}
        self.params['u'] ='p'
        self.params['v'] = '1.7.2'
        self.params['time'] = self.timeStamp
        self.plan_id = Configuration.Plan_Id
        #创建快速出题与互动问答
        
    #快速出题
    def test_CreateQuestion(self):
        """快速出题--选择题"""
        self.params['params'] = {"answerRight":"B",
                                 "phraseId":4,
                                 "planId":self.plan_id
                            }

        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        
        time.sleep(5)
        #t_course_plan_phrase表验证
        sql = "SELECT fk_plan,fk_phrase FROM  t_course_plan_phrase WHERE pk_plan_phrase={}".format(returnObj['result']['questId'])
        self.cursor.execute(sql)
        result = self.cursor.fetchone()
        print(result['fk_plan'],result['fk_phrase'])
        self.assertIsNotNone(result, "数据库表里不存在此条记录")
    
    #互动问答
    def test_createAnswer(self):
        """互动问答"""
        self.params['params'] = {"answerRight":"",
                                 "phraseId":10,
                                 "planId":self.plan_id
                            }

        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text) 
        time.sleep(5)
        #数据库表验证
        sql = "SELECT fk_plan,fk_phrase FROM t_course_plan_phrase WHERE pk_plan_phrase={}".format(returnObj['result']['questId'])
        self.cursor.execute(sql)
        result = self.cursor.fetchone()
        self.cursor.close()
        self.assertIsNotNone(result, "数据库表里不存在此条记录")
    
    def test_createQuestionWithLessParameter(self):
        self.params['params'] = {"answerRight":"",
                                 "phraseId":10
                            }

        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        self.assertEqual(1000,returnObj['code'])
        self.assertEqual("request param empty", returnObj['message'])
    
    
    @classmethod
    def tearDownClass(cls):
        cls.cursor.close()
        cls.connect.close()
        
    
if __name__ == "__main__":
    #import sys;sys.argv = ['', 'Test.testName']
    unittest.main()