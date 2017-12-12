#-*- coding:utf-8 -*-
#!/usr/bin/env python
import os
import time
from socket import *
import json
import urllib2
import HTMLTestRunner

import unittest

class TestAPI(unittest.TestCase):
    def setUp(self):
        print "\n" + "*"*20 + "Test start" + "*"*20 + "\n"

    def tearDown(self):
        print "\n" + "*"*20 + "Test end" + "*"*20

    def test_chnl_add_courseDetail(self):
        values = {
          "appid":10001,
          "apphash":"7baac873edcb07a3bab8defeb60a435a",
          "params":
              {"classId":"1005084",
              "pl":"40",
              "pn":"1",
              "userId":"45"}
        }

        url = "http://testpx.gn100.com/openapi/openapi/course/detail";

        req = urllib2.Request(url, json.dumps(values))
        res = urllib2.urlopen(req)

        ret_code = res.code
        self.assertEqual(200,ret_code)
        html_body   = res.read()

        #print ("post content=%s" % values)
        #print ("retcode=%s, body=%s" % (ret_code, html_body))
    def test_chnl_add_userCourseList(self):
        values = {
           "appid":10001,
           "apphash":"17c525777660d476c192f31f0e0bdc01",
           "params":
                { "classStatus":"1",
                "classType":"1",
                "pl":"40",
                "pn":"1",
                "subjectId":" ",
                "userId":"45"}
           }

        url = "http://testpx.gn100.com/openapi/openapi/user/course/list";
        req = urllib2.Request(url, json.dumps(values))
        res = urllib2.urlopen(req)

        ret_code = res.code
        self.assertEqual(200,ret_code)
        html_body   = res.read()
        
    def test_chnl_add_courseSeat(self):
        values = {
           "appid":10001,
           "apphash":"17c525777660d476c192f31f0e0bdc01",
           "params":
                {"classId":"1005084",
                "userId":"45"}
           }

        url = "http://testpx.gn100.com/openapi/openapi/course/seat";
        req = urllib2.Request(url, json.dumps(values))
        res = urllib2.urlopen(req)

        ret_code = res.code
        self.assertEqual(200,ret_code)
        html_body   = res.read()
        
    def test_chnl_add_userOrderList(self):
        values = {
           "appid":10001,
           "apphash":"17c525777660d476c192f31f0e0bdc01",
           "params":
                {"pl":"20",
                 "pn":"1",
                 "status":" ",
                 "userId":"45"}
           }

        url = "http://testpx.gn100.com/openapi/openapi/user/order/list";
        req = urllib2.Request(url, json.dumps(values))
        res = urllib2.urlopen(req)

        ret_code = res.code
        self.assertEqual(200,ret_code)
        html_body   = res.read()
        
    def test_chnl_add_courseList(self):
        values = {
           "appid":10001,
           "apphash":"17c525777660d476c192f31f0e0bdc01",
           "params":
                {"uid":"45"}
           }

        url = "http://testpx.gn100.com/openapi/openapi/course/list";
        req = urllib2.Request(url, json.dumps(values))
        res = urllib2.urlopen(req)

        ret_code = res.code
        self.assertEqual(200,ret_code)
        html_body   = res.read()
        
    def test_chnl_add_userMycourse(self):
        values = {
           "appid":10001,
           "apphash":"17c525777660d476c192f31f0e0bdc01",
           "params":
                {"operMonth":"2017-11",
                 "userId":"45"}
           }

        url = "http://testpx.gn100.com/openapi/openapi/user/mycourse/list";
        req = urllib2.Request(url, json.dumps(values))
        res = urllib2.urlopen(req)

        ret_code = res.code
        self.assertEqual(200,ret_code)
        html_body   = res.read()


if __name__ == "__main__":
    suite = unittest.TestSuite()
    suite.addTest(TestAPI('test_chnl_add_courseDetail'))
    suite.addTest(TestAPI('test_chnl_add_userCourseList'))
    suite.addTest(TestAPI('test_chnl_add_courseSeat'))
    suite.addTest(TestAPI('test_chnl_add_userOrderList'))
    suite.addTest(TestAPI('test_chnl_add_courseList'))
    suite.addTest(TestAPI('test_chnl_add_userMycourse'))
    #unittest.TextTestRunner(verbosity=2).run(suite)
    filePath = os.getcwd() + "/TestResult.html"
    fp = open(filePath,'wb')
    runner = HTMLTestRunner.HTMLTestRunner(stream=fp,title="拓维学堂接口测试",description="拓维学堂接口测试报告")
    runner.run(suite)
    fp.close()