#-*- coding:utf-8 -*-
'''
Created on 2016年11月16日

@author: lsh
'''

def PageLoadingReady(driver):
    script = "result = document.readyState;return result;"
    state = driver.execute_script(script)
    if state == "complete":
        result = True
    else:
        result = False
    return result  
