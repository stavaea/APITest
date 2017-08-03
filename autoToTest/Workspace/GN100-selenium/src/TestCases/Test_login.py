#-*- coding:utf-8 -*-
'''
Created on 2017年3月26日

@author: lsh
'''
import unittest
from Prerequirement import Initialize
import Configuration
from selenium.common.exceptions import NoSuchElementException

class Test(unittest.TestCase):
    @classmethod
    def setUpClass(cls):
        DriverObj = Initialize.Driver()
        cls.driver = DriverObj.driver
        #打开机构首页
        loginUrl = Configuration.BaseUrl + '/'
        cls.driver.get(loginUrl)
        
    def setUp(self):
        try:
            self.driver.find_element_by_xpath(".//*[@id='indexuser']/div/div/p[2]/a[1]")
        except NoSuchElementException as e:
            self.driver.delete_all_cookies()
    
    def testName(self):
        pass

    @classmethod
    def tearDownClass(cls):
        cls.driver.quit()
    
if __name__ == "__main__":
    #import sys;sys.argv = ['', 'Test.testName']
    unittest.main()