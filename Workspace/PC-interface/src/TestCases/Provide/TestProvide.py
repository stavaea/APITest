#-*- coding:utf-8 -*-
#/usr/bin/env python3
import Configuration
import json
import hashlib
import time
import requests


def generateKey(TimeStamp,params):
    encryptStr = json.dumps(params,separators=(',',':'),ensure_ascii=False) + str(TimeStamp) + Configuration.salt
    md5 = hashlib.md5()
    encryptStr = encryptStr.encode('utf8')
    md5.update(encryptStr)
    encryptStr = md5.hexdigest()
    md5 = hashlib.md5()
    md5.update(encryptStr.encode('utf8'))
    key = md5.hexdigest()    
    return key

def login(s,mobile,password):
    params = {}
    currenttime = int(time.time()) 
    params['u']= 'p'
    params['v']= '1.9.0'
    params['time']= currenttime
    params['params']= {
                    "name":mobile,
                    "password":password
                }
    params['key']= generateKey(currenttime,params['params'])
    loginUrl = Configuration.HostUrl + "/interface/login"
    response = s.post(loginUrl,data=json.dumps(params,separators=(',',':')))
    response.encoding = "utf-8"
    return s
