#-*- coding:utf-8 -*-
#!/usr/bin/env python3
'''
Created on 2016年11月10日

@author: lsh
'''
import os
from TestCases import TestClassAnnouncement,TestGetAnnounce,TestCourseLivingPlan,TestPlanListOfCourse,TestStudentListOfCourse,TestTeacherCourseList,TestGetQuestion,TestAddAnswerLog, \
TestStartOrRestartClass,TestTeacherCourseOfUploadVideo,TestTeacherPlanOfUploadVideo
import unittest
import HTMLTestRunner
import time

def suite():
    suite = unittest.TestSuite()
    #将所有测试用例加入到测试套件中(容器)
    suite.addTest(unittest.makeSuite(TestPlanListOfCourse.Test_CoursePlanOfTeacher))
    suite.addTest(unittest.makeSuite(TestStudentListOfCourse.Test_TeacherOfStudents))
    suite.addTest(unittest.makeSuite(TestClassAnnouncement.Test_Announcement))
    suite.addTest(unittest.makeSuite(TestGetAnnounce.Test_getAnnounce))
    suite.addTest(unittest.makeSuite(TestCourseLivingPlan.Test_courseLivingPlan))
    suite.addTest(unittest.makeSuite(TestStartOrRestartClass.Test_startClass))
    suite.addTest(unittest.makeSuite(TestGetQuestion.Test_GetQuestion))
    suite.addTest(unittest.makeSuite(TestAddAnswerLog.Test_AddAnswerLog))
    suite.addTest(unittest.makeSuite(TestTeacherCourseOfUploadVideo.Test_getCourseList))
    suite.addTest(unittest.makeSuite(TestTeacherPlanOfUploadVideo.test_teacherPlanOfUpload))
    
    #执行测试套件
    #now = time.strftime("%Y-%m-%d-%H_%M_%S",time.localtime(time.time()))
    #filePath =os.getcwd() + "/"+ now + "-TestResult.html"
    filePath = os.getcwd() + "/TestResult.html"
    fp = open(filePath,'wb')
    runner = HTMLTestRunner.HTMLTestRunner(stream=fp,title="PC客户端接口测试",description="PC客户端接口测试报告")
    runner.run(suite)
    fp.close()
    
if __name__ == '__main__':
    suite()


