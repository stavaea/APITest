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
from pymysql import cursors
import pymysql

class TeacherMyClasses(unittest.TestCase):

    def setUp(self):
        self.s = requests.session()
        self.url = Configuration.HostUrl +"/interface/teacher/PcCourseList"
        self.s = TestProvide.login(self.s)
        self.timeStamp = int(time.time())
        self.params = {}
        self.params['u'] ='p'
        self.params['v'] = "1.7.0"
        self.params['time'] = self.timeStamp
        self.teacherId= self.s.cookies.get("uid_test")
        
    def create_SqlConnect(self):
        db_url = {"host":"115.28.222.160","user":"michael","passwd":"michael","db":"db_course","charset":"utf8","cursorclass":cursors.DictCursor}
        connect = pymysql.connect(**db_url)
        connect.autocommit(True)    
        return connect
    
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
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text) 
        self.assertEqual(returnObj['code'],0)
        self.assertEqual(returnObj['message'],"success")
        ActualFirstCourseOfList = returnObj['result']['list']['data'][0]
        CourseProperty = ['courseId','courseName','courseImg','classList','subname','courseType']
        self.assertTrue(Confirm.VerifyDataStucture(CourseProperty,ActualFirstCourseOfList.keys()),"数据结构不匹配")
        conn = self.create_SqlConnect()
        cursor = conn.cursor()
        sql = "SELECT COUNT(c.`pk_course`) AS num,c.`type` FROM t_course_teacher AS t JOIN t_course AS c ON t.`fk_course`=c.`pk_course` WHERE t.`fk_user_teacher`={} GROUP BY c.`type`".format(self.teacherId)
        cursor.execute(sql)
        rows = cursor.fetchall()
        livingNum,recordNum,underNum = 0,0,0
        for row in rows:
            if row['type'] == 1:
                livingNum = row['num']
            elif row['type'] ==2:
                recordNum = row['num']
            else:
                underNum = row['num']
        total = livingNum + recordNum + underNum
        #验证课程数量           
        self.assertEqual(total,returnObj['result']['nums']['total'])
        self.assertEqual(livingNum,returnObj['result']['nums']['livingNum'])
        self.assertEqual(recordNum,returnObj['result']['nums']['recordNum'])
        self.assertEqual(underNum,returnObj['result']['nums']['underNum'])
        
        #验证课程名称
        Flag = True
        CourseSql = "SELECT c.`pk_course`,c.`title` FROM `t_course_teacher` AS t JOIN t_course AS c ON t.`fk_course`=c.`pk_course` WHERE  t.fk_user_teacher={}".format(self.teacherId)
        cursor.execute(CourseSql)
        rows = cursor.fetchall()
        for courseObj in returnObj['result']['list']['data']:
            for row in rows:
                if courseObj['courseId']!=row['pk_course'] or courseObj['courseName'] != row['title']:
                    msg = ("return CourseInfo:{}-{};from DB:{}-{}".format(courseObj['courseId'],courseObj['courseName'],row['pk_course'],row['title']))
                    Flag = False
                    break
        cursor.close()
        conn.close()        
        self.assertTrue(Flag,msg)
        
    def test_getCourseList_multipleClass(self):
        """教师课程表--多班级课程"""
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
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        if returnObj['code'] ==0:
            ExpectCouresObj = {
                    "courseId": 1158,
                    "courseName": "新版课程表--多班级课程",
                    "courseImg": "http://testf.gn100.com/5,82d771f39607",
                    "courseType": 1,
                    "classList": [
                        {
                            "classId": "1355",
                            "className": "基础班",
                            "sectionNum": 4,
                            "sectionName": "第0章"
                        },
                        {
                            "classId": "1356",
                            "className": "中级班",
                            "sectionNum": 4,
                            "sectionName": "第0章"
                        },
                        {
                            "classId": "1357",
                            "className": "高级班",
                            "sectionNum": 2,
                            "sectionName": "第0章"
                        }
                    ],
                    "subname": "宏盛飞飞"
                }
            if ExpectCouresObj in returnObj['result']['list']['data']:
                Result = True
            else:
                Result = False        
            self.assertTrue(Result,"多班级课程不在此列表内")
        else:
            raise "获取教师课表表失败"
        
     
#获取教师课程--分页，下一页
    def test_TeacherCoursePaging(self):
        """班主任下课程--翻页"""
        self.params['params'] = {
                                 "length":20,
                                 "page":2,
                                 "sort":2000,
                                 "status":0,
                                 "teacherId":273,
                                 "type":0
                            }
    
        self.params['key']= TestProvide.generateKey(self.timeStamp,self.params['params'])
        
        #提交请求
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        CourseList = returnObj['result']['list']['data']
        self.assertEqual(2,returnObj['result']['list']['page'],"没有翻页")
        self.assertEqual(2,returnObj['result']['list']['totalPage'])
        self.assertIsNotNone(CourseList,"翻页后没有数据")   
    
    #通过关键字搜索课程
    def test_SearchCourseByKeyword(self):
        """班主任下课程--关键词搜索"""
        keywords = "PC Client 接口测试1027"
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
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        courseObjs = returnObj['result']['list']['data']
        self.assertIsNotNone(courseObjs,"关键词搜索无返回结果")      
    
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
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        CourseList = returnObj['result']['list']['data']
        self.assertGreaterEqual(int(CourseList[0]['userTotal']),int(CourseList[1]['userTotal']))
        self.assertGreaterEqual(int(CourseList[-2]['userTotal']),int(CourseList[-1]['userTotal']),"未按学生人数倒序排序")
        
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
        print("Url: {} \n Parameter:{}".format(self.url,json.dumps(self.params,separators=(',',':'),ensure_ascii=False)))
        response = self.s.post(self.url,data=json.dumps(self.params))
        response.encoding= "utf-8"
        returnObj = json.loads(response.text)
        courseList= returnObj['result']['list']['data']
        #判断返回的课程都是直播课
        result = True
        for course in courseList:
            if int(course['courseType']) != 1:
                result =False
                break
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
    suite = unittest.TestSuite()
    suite.addTest(TeacherMyClasses("test_GetTeacherCourse_all"))
    suite.addTest(TeacherMyClasses("test_SearchCourseByKeyword"))
    #suite.addTest(TeacherMyClasses("test_TeacherCourseSortByStudent"))
    suite.addTest(TeacherMyClasses("test_TeacherCourseOfLiving"))
    suite.addTest(TeacherMyClasses("test_TeacherCoursePaging"))
    suite.addTest(TeacherMyClasses("test_getCourseList_multipleClass"))
    runner = unittest.TextTestRunner()
    runner.run(suite)
    
    