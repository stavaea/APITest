#-*- coding:utf-8 -*-
#/usr/bin/env python3
'''
Created on 2016年10月26日

@author: lsh
'''

import unittest
import json
import time
import requests
from PCClientInterface import Configuration,TestProvide,Confirm
import HTMLTestRunner
import os,re

class TeacherMyClasses(unittest.TestCase):

    def setUp(self):
        self.s = requests.session()
        self.url = Configuration.HostUrl +"/interface/teacher/classcourselist"
        self.s = TestProvide.login(self.s)
        self.timeStamp = int(time.time())
        self.params = {}
        self.params['u'] ='p'
        self.params['v'] = "1.7.0"
        self.params['time'] = self.timeStamp
        self.teacherId= self.s.cookies.get("uid_test")
        
    #教师课程表--全部
    def test_GetTeacherCourse_all(self):
        """班主任下的课程--默认排序 """
        self.params['params'] = {
                                 "keywords":"",
                                 "length":20,
                                 "page":1,
                                 "sort":1000,
                                 "status":0,
                                 "teacherId": self.teacherId,
                                 "type":0
                            }
    
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        #print(json.dumps(self.params,separators=(',',':'),ensure_ascii=False))
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        #print(returnObj) 
        self.assertEqual(returnObj['code'],0)
        self.assertEqual(returnObj['message'],"success")
        ActualFirstCourseOfList = returnObj['result']['data'][0]
        ExpectStructure = ['courseId','courseName','courseImg','className','classId','userTotal','subname','livingNum','recordNum','underNum','total','courseType','selectCount','planNum','schedule']
        self.assertTrue(Confirm.VerifyDataStucture(ExpectStructure,ActualFirstCourseOfList.keys()),"数据结构不匹配")
        self.assertEqual(10,ActualFirstCourseOfList['total'])
        self.assertEqual(6,ActualFirstCourseOfList['livingNum'])
        self.assertEqual(3,ActualFirstCourseOfList['recordNum'])
        self.assertEqual(1,ActualFirstCourseOfList['underNum'])
        
    
#获取教师课程--分页，下一页
    def test_TeacherCoursePaging(self):
        """班主任下课程--翻页"""
        self.params['params'] = {
                                 "length":20,
                                 "page":2,
                                 "sort":2000,
                                 "status":0,
                                 "teacherId":self.teacherId,
                                 "type":0
                            }
    
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        CourseList = returnObj['result']['data']
        CourseOne = {
                "courseId": "349",
                "courseName": "测试1216",
                "courseImg": "http://testf.gn100.com/7,19f0b22a8366",
                "courseType": "1",
                "className": "1班",
                "classId": "473",
                "userTotal": "12",
                "selectCount": "6",
                "planNum": "第6章",
                "schedule": 1,
                "subname": "高能测试",
                "livingNum": 121,
                "recordNum": 17,
                "underNum": 16,
                "total": 154
            }
        self.assertEqual(2,returnObj['result']['page'] ,"没有翻页")
        self.assertIn(CourseOne, CourseList, "预期的课程数据不在第二页")
    
    
#通过关键字搜索课程
    def test_SearchCourseByKeyword(self):
        """班主任下课程--关键词搜索"""
        keywords = "PC-Client"
        self.params['params'] = {
                                 "keywords":keywords,
                                 "length":20,
                                 "page":1,
                                 "sort":1000,
                                 "status":0,
                                 "teacherId":self.teacherId,
                                 "type":0
                            }
    
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        courseObjs = list(returnObj['result']['data'])
        Compile = re.compile(r"PC.*Client", re.I|re.M)
        result = True
        for course in courseObjs:
            #print(course['courseName'])
            if not Compile.search(course['courseName']):
                result= False
        
        self.assertTrue(result,"关键词搜索失败")        
    
    #教师课程表--按学生最多排序
    def test_TeacherCourseSortByStudent(self):
        """班主任下课程--学生最多排序"""
        self.params['params'] = {
                                 "keywords":"",
                                 "length":20,
                                 "page":1,
                                 "sort":2000,
                                 "status":0,
                                 "teacherId":self.teacherId,
                                 "type":0
                            }
        
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        CourseList = returnObj['result']['data']
        #print("按学生排序1={}".format(CourseList))
        self.assertGreaterEqual(CourseList[0]['userTotal'],CourseList[1]['userTotal'])
        self.assertGreaterEqual(CourseList[-2]['userTotal'],CourseList[-1]['userTotal'],"未按学生人数倒序排序")
        
        #默认排序数据
        #self.params['params'] = {
        #                         "keywords":"",
        #                         "length":20,
        #                        "page":1,
        #                         "sort":1000,
        #                         "status":0,
        #                         "teacherId":"281",
        #                         "type":0
        #                    }
        #self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        #response2 = self.s.post(self.url,data=json.dumps(self.params))
        #response2.encoding= "utf-8"
        #CourseListSortedByDefault  = (json.loads(response2.text))['result']['data']
        # sort ListDict by userTotal
        #CourseListSortedByStudent  = sorted(CourseListSortedByDefault,key=itemgetter('userTotal'),reverse=True)
        #print("按学生排序222={}".format(CourseListSortedByStudent))
        #确认返回值是否按学生人数排序
        #self.assertListEqual(CourseList,CourseListSortedByStudent)
    
    # 按课程类型筛选---直播课
    def test_TeacherCourseOfLiving(self):
        """班主任下课程--直播课筛选"""
        self.params['params'] = {
                                 "keywords":"",
                                 "length":20,
                                 "page":1,
                                 "sort":1000,
                                 "status":0,
                                 "teacherId":self.teacherId,
                                 "type":1
                            }
    
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        courseList= returnObj['result']['data']
        print(courseList)
        #判断返回的课程都是直播课
        result = True
        for course in courseList:
            if int(course['courseType']) != 1:
                result =False
        self.assertTrue(result, "返回的课程包含非直播课")

                

'''
def suite():
    suite = unittest.TestSuite()
    suite.addTest(TeacherMyClasses("test_GetTeacherCourse_all"))
    suite.addTest(TeacherMyClasses("test_TeacherCoursePaging"))
    suite.addTest(TeacherMyClasses("test_SearchCourseByKeyword"))
    suite.addTest(TeacherMyClasses("test_TeacherCourseSortByStudent"))
    suite.addTest(TeacherMyClasses("test_TeacherCourseOfLiving"))
    currentPath = os.path.dirname(__file__)
    
    now = time.strftime("%Y-%m-%d-%H_%M_%S",time.localtime(time.time()))
    filePath =currentPath + "\\"+now+ "-TestResult.html"
    #print(filePath)
    fp = open(filePath,'wb')
    runner = HTMLTestRunner.HTMLTestRunner(stream=fp,title="班主任 下课程",description="班主任下的课程接口测试报告详情")
    runner.run(suite)
    time.sleep(20)
    fp.close()
'''            
        
if __name__ == "__main__":
    #import sys;sys.argv = ['', 'Test.testName']
    suite= unittest.TestSuite()
    suite.addTest(unittest.makeSuite(TeacherMyClasses,"test"))
    runnner = unittest.TextTestRunner()
    runnner.run(suite)
    
    