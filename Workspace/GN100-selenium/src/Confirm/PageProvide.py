#-*- coding:utf-8 -*-
'''
Created on 2016年11月16日

@author: lsh
'''

def PageLoadingReady():
    def AddPage(driver):
        script = "return document.readyState;"
        return driver.execute_script(script) == "complete"
    return AddPage
