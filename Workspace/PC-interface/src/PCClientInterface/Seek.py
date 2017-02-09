#!/usr/bin/env python3
#-*- coding:utf-8 -*-
'''
Created on 2017年1月11日

@author: lsh
'''
import requests
import json

def seekPlan(format,query,ob='',page=1,pageLength=20):
    url = "http://api.gn100.com/seek/plan/list/"
    param = {}
    param['f']  = format
    param['q']  = query
    param['ob'] = ob
    param['p']  = page
    param['pl'] = pageLength
    sess = requests.session()
    response = sess.post(url, data=json.dumps(param,separators=(',',':'),ensure_ascii=False))
    response.encoding = "utf-8"
    return json.loads(response.text)
    
def seekCourse(format,query,ob='',page=1,pageLength=20):
    url = "http://api.gn100.com/seek/course/list/"
    param = {}
    param['f']  = format
    param['q']  = query
    param['ob'] = ob
    param['p']  = page
    param['pl'] = pageLength
    sess = requests.session()
    response = sess.post(url, data=json.dumps(param,separators=(',',':'),ensure_ascii=False))
    response.encoding = "utf-8"
    return json.loads(response.text)

def seekTeacher(format,query,ob='',page=1,pageLength=20):
    url = "http://api.gn100.com/seek/teacher/list/"
    param = {}
    param['f']  = format
    param['q']  = query
    param['ob'] = ob
    param['p']  = page
    param['pl'] = pageLength
    sess = requests.session()
    response = sess.post(url, data=json.dumps(param,separators=(',',':'),ensure_ascii=False))
    response.encoding = "utf-8"
    return json.loads(response.text)    

    
if __name__ == '__main__':
    pass