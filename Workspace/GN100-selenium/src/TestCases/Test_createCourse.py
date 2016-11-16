#-*- coding:utf-8 -*-

'''
Created on 2016年11月16日

@author: lsh
'''
import unittest ,time,random,os
from Prerequirement import Initialize
import Configuration
from selenium.common.exceptions import NoSuchElementException
from selenium.webdriver.common.action_chains import ActionChains
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.common.keys import Keys
from Confirm import PageProvide,Verify

class Test_createCourse(unittest.TestCase):

    @classmethod
    def setUpClass(cls):
        cls.driver = Initialize.Driver()
        #登录机构首页
        loginUrl = Configuration.BaseUrl + '/'
        uname = Configuration.uname
        password= Configuration.password
        cls.driver.maximize_window()
        cls.driver.get(loginUrl)
        try:
            userNameSection = cls.driver.find_element_by_xpath("//*[@id='sitenav']/ul/li[1]/a/span[2]")
        except NoSuchElementException :
            cls.driver.find_element_by_name("uname").clear()
            cls.driver.find_element_by_name("uname").send_keys(uname)
            cls.driver.find_element_by_name("pass").clear()
            cls.driver.find_element_by_name("pass").send_keys(password)
            cls.driver.find_element_by_xpath("//*[@id=\"login-form\"]/button").click()
            time.sleep(5)
        
    def test_NavigateOrgAdministationPage(self):
        #进入机构管理
        OrgAdministration = WebDriverWait(self.driver,20).until(lambda x: x.find_element_by_link_text("机构管理"))
        #验证是否存在课堂卡片，若存在关闭
        try:
            clearBtns = self.driver.find_elements_by_xpath("//div[@class=\"class-reminder\"]/div/span")
            for clearBtn in clearBtns:
                self.driver.execute_script("arguments[0].click();",clearBtn)
        except NoSuchElementException:
            pass
             
        OrgAdministration.click()
        WebDriverWait(self.driver,20).until(PageProvide.PageLoadingReady(self.driver), "页面未加载失败")
        
    def Test_NavigateCreateCoursePage(self):
        courseManage = self.driver.find_element_by_xpath('/html/body/section/div/div/div[1]/ul/li[3]/a')
        courseManage.click()
        time.sleep(3)
        maintHandle = self.driver.current_window_handle
        self.driver.find_element_by_link_text("新建课程").click()
        time.sleep(5)
        #self.driver.get(self.base_url + "/user.org.checkcourse")
        allHandles = self.driver.window_handles
        print(allHandles)
        for handle in allHandles:
            if handle != maintHandle:
                self.driver.switch_to.window(handle)
                        
        #确认页面调整到新建课程页面
        WebDriverWait(self.driver,20).until(PageProvide.PageLoadingReady(self.driver), "页面未加载失败")
        Result = False
        if self.driver.title。find("创建课程")>-1:
            Result= True
            
        self.assertTrue(Result, "没有打开创建课程页面")
        CreateCourseUrl = self.driver.current_url
        expectUrl = Configuration.BaseUrl + "/org.course.type"        
        self.assertEqual(CreateCourseUrl,expectUrl)
    
    def test_SetBasicInformation(self):
        self.driver.find_element_by_link_text("直播课").click()
        WebDriverWait(self.driver,20).until(PageProvide.PageLoadingReady(self.driver), "页面未加载失败")
        ranInt = random.randint(10,20)
        self.driver.find_element_by_id("get-courseInfo-title").send_keys("测试演示课程"+str(ranInt))
        tag = self.driver.find_element_by_xpath("//*[@id='divSelectFirstVal']/div/div/section/div/div/section/div[6]/div[2]/label/div/input")
        tag.send_keys("test")
        tag.send_keys(Keys.SPACE)
        tag.send_keys("test1")
        tag.send_keys(Keys.SPACE)
        
        #选择分类和科目
        self.driver.find_element_by_css_selector("#get-firstCate-btn>cite").click()
        #self.driver.execute_script("getCate();")
        time.sleep(2)
        xueqian= self.driver.find_element_by_xpath("//*[@id='get-firstCate-btn']/dl/dd[1]/a")
        xueqian.click()
        self.driver.execute_script("getCateClass(arguments[0],1)",xueqian)
        time.sleep(2)
        
        self.driver.find_element_by_css_selector("#add-secondCate>cite").click()
        SecondCates = self.driver.find_elements_by_css_selector("#get-cate-class>dd>a")
        SecondCateList= [] 
        for cate in SecondCates:
            SecondCateList.append(cate.Text)
        self.assertListEqual()       
        ExpectList = ["学前","小学","初中","高中"]
        self.assertList(ExpectList,SecondCateList)
        
        secondCite = self.driver.find_element_by_link_text("小学")
        while True :
            ActionChains(self.driver).move_to_element(secondCite).perform()
            if secondCite.is_displayed()==True:
                secondCite.click()
                break
            
        time.sleep(4)
        self.driver.find_element_by_css_selector("#add-thirdCate>cite").click()
        thirdCateElems= self.driver.find_elements_by_css_selector("#get-cate-name-class>dd>a")
        ActualThirdCateList = []
        for cateName in thirdCateElems:
            ActualThirdCateList.append(cateName.Text)
        ExpectThirdCateList = ['测试分类','一年级','二年级','三年级','四年级','五年级','六年级','小升初','素质教育','竞赛']
        self.assertTrue(Verify.VerifyKeystructure(ExpectThirdCateList,ActualThirdCateList), 'third cates name not match')
        self.driver.find_element_by_link_text("二年级").click()
        time.sleep(4)
        self.driver.find_element_by_id("slt-course-name").click()
            
        #选择科目 
        subjectDialog = self.driver.find_element_by_id("layui-layer1")
        #print(subjectDialog.text)
        subjects = self.driver.find_elements_by_css_selector("#get-attr>li")
        #print(len(subjects))
        choiceSubjects = []   
        for i in range(3):
            subjectEle = random.choice(subjects)
            choiceSubjects.append(subjectEle.text)
            subjectEle.click()
        self.driver.find_element_by_css_selector("button.set-req-btn.green-button").click()
        try:
            subjectText = self.driver.find_element_by_id("slt-course-name").get_attribute("value")
        except Exception:
            pass
        
        #判断选择的科目是否符合分类   ******
        attr = ['语文','数学','英语','思想品德','科学','信息技术','综合实践','作文','阅读','全科辅导','其他','体育','美术','音乐']
        self.assertTrue(self.subjectIsBelongAttr(choiceSubjects,attr))
            
        #设置老师
        self.driver.find_element_by_id("teachers-cent").click()
        self.driver.find_element_by_id("search-teacher-infos").send_keys("李胜红")
        self.driver.find_element_by_xpath('//*[@id="subsearch"]/span').click()
        #self.driver.execute_script("orgTeacher()")
        teacherInputs = self.driver.find_elements_by_css_selector("#multiple-left>li")
        
        for teacherinput in teacherInputs:
            #print(teacherinput.text)
            teacherinput.click()
        
        self.driver.find_element_by_id("add-btn").click()
        self.driver.find_element_by_id("course_add").click()
        time.sleep(5)
        #验证老师已设置
        SelectedTeacherName = self.driver.find_element_by_css_selector("#teacher-contents>li>div").text
        self.assertEqual("李胜红",SelectedTeacherName)   
    
    def test_setScopeAndDescription(self):  
            #点击下一步 设置课程图片，教学范围描述
            self.driver.find_element_by_id("add-course-info-btn").click()
            time.sleep(5)
                   
            #上传图片
            self.driver.find_element_by_id("img_p_label").click()
            time.sleep(5)
            imgPath = str(os.getcwd() + "\\..\\..\\Image\\CoursePicture.jpg").replace("\\","/")
            #self.driver.find_element_by_id("uploadImg").click()
            fileWebElement = self.driver.find_element_by_xpath("//*[@id='upload-img-content']/p/div/input[@type='file']")
            fileWebElement.send_keys(imgPath)
            time.sleep(3)
            #点击保存
            self.driver.find_element_by_id("saveImg").click()
            time.sleep(3)
            self.driver.find_element_by_id("range-scope").send_keys("小学，初中")
            nextStep = self.driver.find_element_by_xpath("/html/body/section[1]/div/div/section/ul/li[5]/button")
            self.driver.execute_script("addSetCourseDesc(arguments[0])",nextStep)
            WebDriverWait(self.driver,20).until(PageProvide.PageLoadingReady(self.driver), "页面未加载失败")
            result = self.driver.title.find("创建章节")
            self.assertGreater(result, -1, "未跳转至创建章节页面")
            
    def test_addSectionAndPlan(self):
        #添加单个课时
        #self.driver.find_element_by_xpath("//*[@id="addMorePlanInfo"]/div/section[1]/div/div/section/div[1]/span[1]").click()
        
        self.driver.find_element_by_id("addMoreCoursePlan").click() #添加多个课时
        time.sleep(5)
        
        #输入章节名称
        sectionNames = '''红楼梦 
白蛇传
新白娘子传奇 '''
        
        self.driver.find_element_by_id("plan-add-desc").send_keys(sectionNames)
        teacher = self.driver.find_element_by_xpath("//*[@id=\"add-more-course\"]/div/div[2]/div[2]/dl/dd/a")
        try:
            self.driver.execute_script("selectCourseTeacher(arguments[0]);",teacher)
        except Exception as e:
            print(e)    
        planTime = self.driver.find_element_by_xpath("//*[@id=\"add-more-startTime\"]/div[2]/input")
        self.driver.execute_script("arguments[0].removeAttribute('readonly');",planTime)
        startTime = time.strftime("%Y-%m-%d %H:00",time.localtime(time.time()))
        planTime.send_keys(startTime)
        self.driver.find_element_by_xpath("//*[@id=\"add-more-course\"]/div/div[2]/div[1]").click()
        #self.driver.execute_script("arguments[0].blur();",planTime)
        self.driver.find_element_by_xpath("//*[@id='selectTweekType']/cite/span[2]").click()
        time.sleep(4)
        planDurations = self.driver.find_elements_by_xpath("//*[@id='selectTweekType']/dl/dd/a")
        for duration in planDurations:
                if duration.text == "每天":
                    duration.click()
                    break
                
        time.sleep(4)
        self.driver.find_element_by_css_selector("#selectLongType>cite").click()
        time.sleep(4)
        LongTypes = self.driver.find_elements_by_xpath("//*[@id='selectLongType']/dl/dd/a")
        for LongType in LongTypes:
            if LongType.text == "1小时":
                LongType.click()
                break
            
        time.sleep(4)     
        self.driver.find_element_by_id("quicksetCourse-btn").click()
        time.sleep(4)
        completeButton= self.driver.find_element_by_xpath("//*[@id=\"addMorePlanInfo\"]/div/section[1]/div/div/section/div[2]/button[2]")
        self.driver.execute_script("arguments[0].onclick();",completeButton)
        time.sleep(5)
        
        #验证创建的章节名称
        sectionNameList = sectionNames.splitlines()
        ActualSections = self.driver.find_elements_by_xpath("//*[@id='plan-edit-info']/div/dl/dd/span[1]")
        ActualSectionNames = []
        for section in ActualSections:
            ActualSectionNames.append(section.Text)
        self.assertListEqual(sectionNameList, ActualSectionNames, "章节名称不匹配")
        
        #验证排课快捷按钮
        ActionNodes = self.driver.find_elements_by_xpath("//*[@id='plan-edit-info']/div[1]/dl/dd[3]/a")          
        ActionNames= []
        for node in ActionNodes:
            ActionNames.append(node.text)
        xuekeAction = self.driver.find_element_by_xpath("//*[@id='plan-edit-info']/div[1]/dl/dd[4]/a")
        ActionNames.append(xuekeAction.text)
        ExpectActions = ["上传视频","备课","巡课管理"]
        self.assertListEqual(ExpectActions, ActionNames,"failed")
        
        #验证排课时间    
        PlanStartTimeOfPlans = self.driver.find_elements_by_xpath("//*[@id='plan-edit-info']/div/dl/dd[2]/span[1]")
        self.assertEqual(startTime, PlanStartTimeOfPlans[0].text,"第一课时的排课时间不对应")
        #第一课时 直播录播试看权限
        VideoPremissActions = self.driver.find_elements_by_xpath("//*[@id='plan-edit-info']/div[1]/dl/dd[2]/span[2]/em")
        VideoPremiss = []
        for node in  VideoPremissActions:
            VideoPremiss.append(node.text)
        ExpectActions = ["直播：无试看","视频：试看20分钟"]
        self.assertListEqual(ExpectActions, VideoPremiss,"试看权限不匹配")
        #验证时间按天增长
        
        
        #验证班主任
        
        #验证讲师
        
        
    @classmethod
    def tearDownClass(cls):
        cls.driver。quite()
    
if __name__ == "__main__":
    #import sys;sys.argv = ['', 'Test.testName']
    unittest.main()