#-*- coding:utf-8 -*-

def VerifyKeystructure(ExpectList,ActualList):
    for key in ActualList:
        for obj in ExpectList:
            if key not in ExpectList:
                return False
    return True