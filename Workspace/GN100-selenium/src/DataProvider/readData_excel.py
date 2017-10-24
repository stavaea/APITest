#-*- coding:utf-8 -*-
'''
Created on 2017年3月26日

@author: lsh
'''

import xdrlib,sys
import xlrd

#打开excel表
def open_excel(file="file.xls"):
    try:
        data = xlrd.open_workbook(file)
        #print("aaa")
        return data
        
    except Exception as e:
        print("bbb")
        print(str(e))
 
 
#根据索引读取表格中的数据
def read_excel_byIndex(file="file.xls",colname_index=0,by_index=0):
    data = open_excel(file)
    table = data.sheet_by_index(by_index)
    nrows = table.nrows
    ncols = table.ncols
    colnames = table.row_values(colname_index)
    list = []
    for i in range(1,nrows):
        row = table.row_values(i)
        if row:
            app={}
            for j in range(ncols):
                app[colnames[j]]= row[j]
            list.append(app)
            
    return list

def read_excel_byName(file="Test-data.xls",colname_index=0,by_name=0):
    data = open_excel(file)
    table = data.sheet_by_name(by_name)
    nrows = table.nrows
    ncols = table.ncols
    colnames = table.row_values(colname_index)
    list = []
    for i in range(1,nrows):
        row = table.row_values(i)
        if row:
            app={}
            for j in range(ncols):
                app[colnames[j]]= row[j]
            list.append(app)
            
    return list


if __name__ == '__main__':
    pass