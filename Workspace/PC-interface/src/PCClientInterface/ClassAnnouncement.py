#!/usr/bin/env python3
#-*- coding:utf-8 -*-

'''
Created on 2016年10月28日

@author: lsh
'''
import unittest
import requests
from PCClientInterface import Configuration,TestProvide
import time,json
import pymysql
import pymysql.cursors
import os


class Test_Announcement(unittest.TestCase):
    
    @classmethod
    def setUpClass(cls):
        db_url = {"host":"115.28.222.160","user":"michael","passwd":"michael","db":"db_course","charset":"utf8","cursorclass":pymysql.cursors.DictCursor}
        cls.connect = pymysql.connect(**db_url)
        cls.connect.autocommit(True)
        cls.cursor = cls.connect.cursor()
    
    def setUp(self):
        self.s = requests.session()
        #self.s = TestProvide.login(self.s)
        self.url = Configuration.HostUrl +"/interface/announcement/Announcement"
        self.timeStamp = int(time.time())
        self.params = {}
        self.params['u'] ='p'
        self.params['v'] = "1.7.0"
        self.params['time'] = self.timeStamp
        self.plan_id = Configuration.Plan_Id
        
    def test_Announcement_Add(self):
        """添加公告 """
        
        content = "今日课堂作业1234"
        self.params['params'] = {
                     "status": "1",      
                     "fkPlan": self.plan_id, 
                     "content": content
                }
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':')))
        response.encoding = "utf-8"
        returnObj = json.loads(response.text)
        self.assertEqual(0,returnObj['code'] ,"返回状态码错误")
        self.assertEqual("success", returnObj['message'])
        #数据库验证公告已插入
        sql = "SELECT fk_plan,content FROM `t_announcement` WHERE fk_plan={} and status=1".format(self.plan_id)
        cursor = self.cursor
        cursor.execute(sql)
        result = cursor.fetchone()
        if result:
            Anno_content = result['content']
            self.assertEqual(content,Anno_content)    
        else:
            raise("课堂公告未插入")
              
    def test_Announcement_Update(self):
        """修改公告"""
        content = "测试课堂作业"
        self.params['params'] = {
                     "status": "1",      
                     "fkPlan": self.plan_id, 
                     "content": content
                }
    
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params']) 
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':')))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        self.assertEqual(0,returnObj['code'] ,"返回状态码错误")
        self.assertEqual("success", returnObj['message'])
        #数据库验证公告已更新
        sql = "SELECT fk_plan,content FROM `t_announcement` WHERE fk_plan={} and status=1".format(self.plan_id)
        cursor = self.cursor
        cursor.execute(sql)
        result = cursor.fetchone()
        if result :
            Anno_content = result['content']
            self.assertEqual(content,Anno_content)    
        else:
            raise("课堂公告未插入")
         
    def test_Announcement_Update_SameContent(self):
        """修改公告，不更新文本"""
        sql = "select fk_plan,content from t_announcement where fk_plan={} and status=1".format(self.plan_id)
        cursor = self.cursor
        cursor.execute(sql)
        result = cursor.fetchone()
        content = result['content']
        self.params['params'] = {
                     "status": "1",      
                     "fkPlan": self.plan_id, 
                     "content": content
                }
    
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':')))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        self.assertEqual(0,returnObj['code'])
        self.assertEqual("success",returnObj['message']) 
    
    def test_DeleteAnnouncement(self):
        self.params['params'] = {
                     "status": "2",      
                     "fkPlan": self.plan_id
                }
    
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':')))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        sql = "select fk_plan,content from `t_announcement` where fk_plan={} and status=-1".format(self.plan_id)
        cursor = self.cursor
        cursor.execute(sql)
        result = cursor.fetchone()
        cursor.close()
        self.assertIsNotNone(result)
     
    def test_DeleteAnnouncement_whichIsDeleted(self):
        self.params['params'] = {
                     "status": "2",      
                     "fkPlan": self.plan_id
                }
    
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':')))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        self.assertEqual(1,returnObj['code'])
        self.assertEqual("failure",returnObj['message'])  
    
    @classmethod
    def tearDownClass(cls):
        cls.cursor.close()
        cls.connect.close() 

if __name__ == "__main__":
    #import sys;sys.argv = ['', 'Test.testName']
    unittest.main()