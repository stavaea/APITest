#-*- coding:utf-8 -*-
'''
Created on 2016年11月16日

@author: lsh
'''

from selenium import webdriver
from selenium.webdriver import FirefoxProfile
from selenium.webdriver.common.desired_capabilities import DesiredCapabilities
import os
import Configuration

currentPath = os.path.dirname(__file__)
IEdriverPath = currentPath + "\..\..\Driver\IEdriverServer-32.exe"
#ChromedriverPath = currentPath + "\..\..\Driver\chromedriver.exe"
ChromedriverPath = 'chromedriver.exe'

class Driver(object):
    def __init__(self):
        self.driverName = Configuration.DriverName.lower()
        self.base_url = Configuration.BaseUrl
        if self.driverName == "ie":
            DesiredCapabilities.INTERNETEXPLORER['ignoreProtectedModeSettings'] = True
            self.driver = webdriver.Ie(executable_path=IEdriverPath) 
        elif self.driverName =="chrome":
            #os.environ["webdriver.chrome.driver"] = driverPath
            options = webdriver.ChromeOptions()
            
            #chrome浏览器配置
            profilePath = str(os.path.join(os.environ['LocalAppdata'],"/Google/Chrome/User Data/Default")).replace('\\','/')
            options.add_argument("--user-data-dir={}".format(profilePath))
            options.add_argument("--test-type")
            options.add_argument("--start-maximized")
            options.add_argument("no-default-browser-check")
            options.add_argument("--disable-extensions")
            options.add_experimental_option("excludeSwitches",["ignore-certificate-errors"])
            self.driver = webdriver.Chrome(executable_path=ChromedriverPath,chrome_options=options)  
        elif self.driverName == "firefox" :
            #firefox浏览器配置
            firefoxProfilePath = os.path.join(os.environ['AppData'],'Mozilla/Firefox/Profiles/txqqmihl.default-1444977492043')
            firefoxdriver = r"C:\Program Files (x86)\Mozilla Firefox46\firefox.exe"  #安装在非默认路径下
            os.environ["webdriver.firefox.driver"] = firefoxdriver
            firefoxProfile= webdriver.FirefoxProfile(firefoxProfilePath)
            self.driver = webdriver.Firefox(firefox_profile=firefoxProfile)
        else :
            pass

if __name__ == '__main__':
    driver = Driver()