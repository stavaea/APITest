#-*- coding:utf-8 -*-
#!/usr/bin/env python3
'''
Created on 2016年10月13日

@author: lsh
'''
from PCClientInterface import TestProvide, Configuration
import requests,time
import json
import unittest
import pymysql 
from pymysql import cursors


#测试公布答案
class AddAnswerLog(unittest.TestCase):
    def setUp(self):
        self.s = requests.session()
        self.url = Configuration.HostUrl +"/interface/plan/addAnswerLog"
        self.timeStamp = int(time.time())
        self.params = {}
        self.params['u'] ='p'
        self.params['v'] = '1.7.2'
        self.params['time'] = self.timeStamp
        connect_url = {"host":"115.28.222.160","user":"michael", "passwd":"michael", "db":"db_course", "charset":"utf8", "cursorclass":pymysql.cursors.DictCursor}
        connect = pymysql.connect(**connect_url)
        connect.autocommit(True)
        self.cursor = connect.cursor()
        
    def tearDown(self):
        self.cursor.close()
    
    def test_AddAnswerLog(self):
        self.params['params'] = {
                "data": [
                    {
                        "answer": "B",
                        "answerStatus": 1,
                        "planId": 3559,
                        "questId": 2621,
                        "userId": 22519
                    },
                    {
                        "answer": "C",
                        "answerStatus": -1,
                        "planId": 3559,
                        "questId": 2621,
                        "userId": 22520
                    },
                    {
                        "answer": "",
                        "answerStatus": 0,
                        "planId": 3559,
                        "questId": 2621,
                        "userId": 22521
                    },
                    {
                        "answer": "",
                        "answerStatus": 0,
                        "planId": 3559,
                        "questId": 2621,
                        "userId": 22522
                    }
                ]
            }

        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        #print(json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text) 
        self.assertEqual(1,returnObj['result']['code'])
        self.assertEqual(1,returnObj['result']['dbFlag'])
        
        time.sleep(8)
        #验证数据库答题记录已更新
        Flag = True
        inputAnswers = json.loads(self.params['params'])
        sql = "SELECT fk_user,answer,answer_status FROM db_stat.`t_course_plan_phrase_log` WHERE fk_plan_phrase={}".format(2618)
        self.cursor.execute(sql)
        rows = self.cursor.fetchall()
        for row in rows:
            for answer in inputAnswers:
                if row['fk_user'] == answer["userId"]:
                    if row['answer']!=answer["answer"] or row["answer_status"]!= answer["answerStatus"]:
                        Flag = False
                        break
        
        self.assertTrue(Flag, "数据库答题记录与实际不匹配")            
    
    def test_AddAnswerlogWithlessParameter(self):
        self.params['params'] = {
                "data": [
                    {
                        "answer": "B",
                        "answerStatus": 1,
                        "questId": 2621,
                        "userId": 22519
                    },
                    {
                        "answer": "C",
                        "answerStatus": -1,
                        "questId": 2621,
                        "userId": 22520
                    }
                ]         
            }
                                      
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        #提交请求
        #print(json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        print(returnObj)
        #有问题待修复 

if __name__ == '__main__':
    unittest.main()