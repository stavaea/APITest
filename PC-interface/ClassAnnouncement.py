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
import HTMLTestRunner

db_url = {"host":"192.168.0.43","user":"michael","passwd":"michael","db":"db_course","charset":"utf8","cursorclass":pymysql.cursors.DictCursor}
connect = pymysql.connect(**db_url)
connect.autocommit(True)
cursor = connect.cursor()

class Test_Announcement(unittest.TestCase):
    
    def setUp(self):
        self.s = requests.session()
        loginurl = "http://dev.gn100.com/site.main.login"
        self.s.post(loginurl,data={"uname":"18500643574","password":"111111","areaCode":86,"areaId":86,"Cid":1,"submit":"登录"})
        print(self.s.cookies.get("uid_dev"))
        print(self.s.cookies.get("token_dev"))
        #Configuration.HostUrl
        self.url = "http://dev.gn100.com" +"/interface/announcement/Announcement"
        self.timeStamp = int(time.time())
        self.params = {}
        self.params['u'] ='p'
        self.params['v'] = "1.7.0"
        self.params['time'] = self.timeStamp
        
    def tearDown(self):
        pass


    def est_Announcement_Add(self):
        plan_id = "8361"
        content = "今日课堂作业1+2+3+4"
        self.params['params'] = {
                     "status": "1",      
                     "fkPlan": plan_id, 
                     "content": content
                }
    
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        print(json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response = self.s.post(self.url,data=json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        print(returnObj)
        self.assertEqual(0,returnObj['code'] ,"返回状态码错误")
        self.assertEqual("success", returnObj['message'])
        #数据库验证公告已插入
        sql = "SELECT fk_plan,content FROM`t_announcement` WHERE fk_plan={}".format(plan_id)
        cursor.execute(sql)
        result = cursor.fetchone()
        if result :
            self.assertEqual(content,result['result'] )    
        else:
            raise("课堂公告未插入")
        
    def est_Announcement_Update(self):
        plan_id = 8361
        content = "测试课堂作业"
        self.params['params'] = {
                     "status": "1",      
                     "fkPlan": plan_id, 
                     "content": content
                }
    
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        self.assertEqual(0,returnObj['code'] ,"返回状态码错误")
        self.assertEqual("success", returnObj['message'])
        #数据库验证公告已更新
        sql = "SELECT fk_plan,content FROM `t_announcement` WHERE fk_plan={} and status=1".format(plan_id)
        cursor.execute(sql)
        result = cursor.fetchone()
        if result :
            self.assertEqual(content,result['result'] )    
        else:
            raise("课堂公告未插入")
    
    def test_Announcement_AddAndUpdate_ErrorPlanId(self):
        plan_id = "8519"
        self.params['params'] = {
                     "status": "1",      
                     "fkPlan": plan_id, 
                     "content": "测试444333"
                }
    
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        self.assertEqual(2017,returnObj['code'])
        self.assertEqual("get course data failed",returnObj['message'])     
    
    def est_Announcement_Update_SameContent(self):
        plan_id = 8361
        sql = "select fk_plan,content from t_announcement where fk_plan={} and status=1".format(plan_id)
        cursor.execute(sql)
        result = cursor.fetchone()
        content = result['content']
        self.params['params'] = {
                     "status": "1",      
                     "fkPlan": plan_id, 
                     "content": content
                }
    
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        self.assertEqual(1,returnObj['code'])
        self.assertEqual("failure",returnObj['message']) 
    
    def est_DeleteAnnouncement(self):
        plan_id = 8361
        self.params['params'] = {
                     "status": "2",      
                     "fkPlan": plan_id
                }
    
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        sql = "select fk_plan,content from `t_announcement` where fk_plan={} and status=-1".format(plan_id)
        cursor.execute(sql)
        result = cursor.fetchone()
        self.assertNotNone(result)
        
    def est_DeleteAnnouncement_withErrorPlanId(self):
        plan_id = 3488
        self.params['params'] = {
                     "status": "2",      
                     "fkPlan": plan_id
                }
    
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        self.assertEqual(2017,returnObj['code'])
        self.assertEqual("get course data failed",returnObj['message'])  
        

if __name__ == "__main__":
    #import sys;sys.argv = ['', 'Test.testName']
    unittest.main()