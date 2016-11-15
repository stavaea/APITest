#-*- coding:utf-8 -*-
'''
Created on 2016年11月10日

@author: lsh
'''

from PCClientInterface import AddAnswerLog,ClassAnnouncement,GetAnnounce,CourseLivingPlan,TeacherStudents,TeacherMyClasses,GetQuestion, \
StartOrRestartClass,CoursePlanOfTeacher

import unittest
import HTMLTestRunner
import os,time

def suite():
    suite = unittest.TestSuite()
    #将所有测试用例加入到测试套件中(容器)
    suite.addTest(unittest.makeSuite(TeacherStudents.Test_TeacherOfStudents))
    suite.addTest(unittest.makeSuite(ClassAnnouncement.Test_Announcement))
    suite.addTest(unittest.makeSuite(GetAnnounce.Test_getAnnounce))
    suite.addTest(unittest.makeSuite(CourseLivingPlan.Test_courseLivingPlan))
    suite.addTest(unittest.makeSuite(TeacherMyClasses.TeacherMyClasses))
    suite.addTest(unittest.makeSuite(CoursePlanOfTeacher.Test_CoursePlanOfTeacher))
    suite.addTest(unittest.makeSuite(StartOrRestartClass.Test_startClass))
    #suite.addTest(GetQuestion.Test_GetQuestion)
    #suite.addTest(AddAnswerLog.AddAnswerLog)
    #执行测试套件
    now = time.strftime("%Y-%m-%d-%H_%M_%S",time.localtime(time.time()))
    filePath =os.path.dirname(__file__) + "\\"+ now + "-TestResult.html"
    fp = open(filePath,'wb')
    runner = HTMLTestRunner.HTMLTestRunner(stream=fp,title="PC客户端接口测试",description="PC客户端接口测试报告")
    runner.run(suite)
    fp.close()

if __name__ == '__main__':
    suite()
    
    