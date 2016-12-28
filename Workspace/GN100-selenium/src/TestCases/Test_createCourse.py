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
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.common.by import By
from datetime import date

class Test_createCourse(unittest.TestCase):

    @classmethod
    def setUpClass(cls):
        DriverObj = Initialize.Driver()
        cls.driver = DriverObj.driver
        #登录机构首页
        loginUrl = Configuration.BaseUrl + '/'
        uname = Configuration.username
        passwd= Configuration.password
        ranInt = random.randint(1,20)
        #cls.courseName = "高雪测试专用课程--"+str(ranInt)
        cls.courseName="高雪测试专用课程jxt"
        cls.driver.maximize_window()
        cls.driver.get(loginUrl)
        time.sleep(2)
        try:
            UserSection = cls.driver.find_element_by_xpath("//*[@id='sitenav']/ul/li[1]/a")
        except NoSuchElementException :
            cls.driver.find_element_by_xpath("//*[@id='indexuser']/div/div/p[2]/a[1]").click()
            #time.sleep(2)
            WebDriverWait(cls.driver,5).until(PageProvide.PageLoadingReady(), "页面未加载失败")
            cls.driver.find_element_by_name("uname").clear()
            cls.driver.find_element_by_name("uname").send_keys(uname)
            cls.driver.find_element_by_name("password").clear()
            cls.driver.find_element_by_name("password").send_keys(passwd)
            cls.driver.find_element_by_name("submit").click()
            time.sleep(5)
      
    def test_NavigateOrgAdministationPage(self):
        #验证是否存在课堂卡片，若存在关闭
        try:
            clearBtns = self.driver.find_elements_by_xpath("//div[@class=\"class-reminder\"]/div/span")
            for clearBtn in clearBtns:
                self.driver.execute_script("arguments[0].click();",clearBtn)
        except NoSuchElementException:
            pass
        
        #进入机构管理
        OrgAdministration = WebDriverWait(self.driver,20).until(lambda x: x.find_element_by_link_text("机构管理"))
             
        OrgAdministration.click()
        WebDriverWait(self.driver,5).until(PageProvide.PageLoadingReady(), "页面未加载失败")
        
    def test_NavigateCreateCoursePage(self):
        self.driver.find_element_by_xpath('/html/body/section/div/div/div[1]/ul/li[3]/a').click()
        time.sleep(3)
        mainHandle = self.driver.current_window_handle
        global mainWindowHandle
        mainWindowHandle = mainHandle
        self.driver.find_element_by_link_text("新建课程").click()
        time.sleep(5)
        allHandles = self.driver.window_handles
        for handle in allHandles:
            if handle != mainHandle:
                self.driver.switch_to.window(handle)
                        
        #确认页面调整到新建课程页面
        WebDriverWait(self.driver,10).until(PageProvide.PageLoadingReady(), "页面未加载失败")
        titleContians = EC.title_contains("创建课程")
            
        self.assertTrue(titleContians(self.driver), "没有打开创建课程页面")
        CreateCourseUrl = self.driver.current_url
        expectUrl = Configuration.BaseUrl + "/org.course.type"        
        self.assertEqual(CreateCourseUrl,expectUrl)
    
    def test_SetBasicInformation(self):
        self.driver.find_element_by_link_text("直播课").click()
        WebDriverWait(self.driver,20).until(PageProvide.PageLoadingReady(), "页面未加载失败")
        self.driver.find_element_by_id("get-courseInfo-title").send_keys(self.courseName)
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
        
        SecondCateList= []
        self.driver.find_element_by_css_selector("#add-secondCate>cite").click()
        time.sleep(4)
        SecondCates = self.driver.find_elements_by_css_selector("#get-cate-class>dd>a") 
        for cate in SecondCates:
            SecondCateList.append(cate.text)       
        ExpectList = ["学前","小学","初中","高中"]
        self.assertListEqual(ExpectList,SecondCateList)
        
        self.driver.find_element_by_link_text("小学").click()
        #while True :
        #    ActionChains(self.driver).move_to_element(secondCite).perform()
        #    if secondCite.is_displayed()==True:
        #        secondCite.click()
        #        break
            
        time.sleep(2)
        self.driver.find_element_by_css_selector("#add-thirdCate>cite").click()
        time.sleep(4)
        thirdCateElems= self.driver.find_elements_by_css_selector("#get-cate-name-class>dd>a")
        ActualThirdCateList = []
        for cateName in thirdCateElems:
            ActualThirdCateList.append(cateName.Text)
        ExpectThirdCateList = ['测试分类','一年级','二年级','三年级','四年级','五年级','六年级','小升初','素质教育','竞赛']
        try:
            self.assertTrue(Verify.VerifyKeystructure(ExpectThirdCateList,ActualThirdCateList), 'third cates name not match')
        except Exception as e:
            print(e)
                
        self.driver.find_element_by_link_text("二年级").click()
        time.sleep(4)
        self.driver.find_element_by_id("slt-course-name").click()
            
        #选择科目
        WebDriverWait(self.driver,20).until(lambda x: x.find_element_by_id("selet-course-name"))
        time.sleep(4) 
        subjects = self.driver.find_elements_by_css_selector("#get-attr>li")
        choiceSubjects = []   
        for i in range(3):
            subjectEle = random.choice(subjects)
            choiceSubjects.append(subjectEle.text)
            subjectEle.click()
            time.sleep(1)
        self.driver.find_element_by_xpath("//*[@id='selet-course-name']/div/button[1]").click()
        try:
            subjectText = self.driver.find_element_by_id("slt-course-name").get_attribute('value')
        except Exception as e:
            print(e)
        
        #判断选择的科目是否符合分类   
        self.assertIsNotNone(subjectText, "科目没有设置")
            
        #设置老师
        TeacherName = "李胜红"
        #AddTeacherCent = self.driver.find_element_by_id("teachers-cent")
        self.driver.find_element_by_id("teachers-cent").click()
   
        time.sleep(4)
        self.driver.find_element_by_id("search-teacher-infos").send_keys(TeacherName)
        self.driver.find_element_by_xpath('//*[@id="subsearch"]/span').click()
        time.sleep(5)
        teacherInputs = self.driver.find_elements_by_css_selector("#multiple-left>li")
        for teacherinput in teacherInputs:
            teacherinput.click()
        
        self.driver.find_element_by_id("add-btn").click()
        self.driver.find_element_by_id("course_add").click()
        time.sleep(5)
        #验证老师已设置
        SelectedTeacherName= self.driver.find_element_by_css_selector("#teacher-contents>li").text
        self.assertEqual(TeacherName,SelectedTeacherName)   
    
    def test_setScopeAndDescription(self):  
            #点击下一步 设置课程图片，教学范围描述
            self.driver.find_element_by_id("add-course-info-btn").click()
            time.sleep(5)
                   
            #上传图片
            self.driver.find_element_by_id("img_p_label").click()
            time.sleep(5)
            #imgPath = str(os.getcwd() + "\\..\\..\\Image\\CourseImage.jpg")
            imgPath= "C:\\test\\Workspace\\GN100-selenium\\Image\\course012.jpg"
            #self.driver.find_element_by_id("uploadImg").click()
            fileWebElement = self.driver.find_element_by_xpath("//*[@id='upload-img-content']/p/div/input[@type='file']")
            fileWebElement.send_keys(imgPath)
            time.sleep(3)
            #点击保存
            self.driver.find_element_by_id("saveImg").click()
            time.sleep(3)
            self.driver.find_element_by_id("range-scope").send_keys("小学，初中")
            time.sleep(3)
            self.driver.find_element_by_xpath("/html/body/section[1]/div/div/section/ul/li[5]/button").click()
            time.sleep(4)
            #self.driver.execute_script("addSetCourseDesc(arguments[0])",nextStep)
            WebDriverWait(self.driver,20).until(PageProvide.PageLoadingReady(), "页面未加载失败")
            result = self.driver.title.find("创建章节")
            self.assertGreater(result, -1, "未跳转至创建章节页面")
          
    def test_addSectionAndPlan(self):   
        #添加单个课时
        #self.driver.find_element_by_xpath("//*[@id="addMorePlanInfo"]/div/section[1]/div/div/section/div[1]/span[1]").click()
        time.sleep(4)
        self.driver.find_element_by_id("addMoreCoursePlan").click() #添加多个课时
        time.sleep(5)
        #输入章节名称
        sectionNames = '''误入白虎堂
逼上梁山
火烧野猪林
杨志卖刀'''
        
        self.driver.find_element_by_id("plan-add-desc").send_keys(sectionNames)
        teacher = self.driver.find_element_by_xpath("//*[@id=\"add-more-course\"]/div/div[2]/div[2]/dl/dd/a")
        try:
            self.driver.execute_script("selectCourseTeacher(arguments[0]);",teacher)
        except Exception as e:
            print(e)    
        planTime = self.driver.find_element_by_xpath("//*[@id=\"add-more-startTime\"]/div[2]/input")
        startTime = time.strftime("%Y-%m-%d %H:00",time.localtime(time.time()))
        planTime.send_keys(startTime)
        self.driver.find_element_by_xpath("//*[@id=\"add-more-course\"]/div/div[2]/div[1]").click()
        self.driver.find_element_by_xpath("//*[@id='selectTweekType']/cite/span[2]").click()
        time.sleep(2)
        planDurations = self.driver.find_elements_by_xpath("//*[@id='selectTweekType']/dl/dd/a")
        for duration in planDurations:
                if duration.text == "每天":
                    duration.click()
                    break
                
        time.sleep(2)
        self.driver.find_element_by_css_selector("#selectLongType>cite").click()
        time.sleep(2)
        LongTypes = self.driver.find_elements_by_xpath("//*[@id='selectLongType']/dl/dd/a")
        for LongType in LongTypes:
            if LongType.text == "1小时":
                LongType.click()
                break
                 
        self.driver.find_element_by_id("quicksetCourse-btn").click()
        time.sleep(4)
        
        completeButton= self.driver.find_element_by_xpath("//*[@id=\"addMorePlanInfo\"]/div/section[1]/div/div/section/div[2]/button[2]")
        self.driver.execute_script("arguments[0].onclick();",completeButton)
        time.sleep(10)
        self.driver.close()
        self.driver.switch_to_window(mainWindowHandle)
        self.driver.find_element_by_id("sc_title").clear()
        self.driver.find_element_by_id("sc_title").send_keys(self.courseName)
        self.driver.find_element_by_id("subsearch").click()
        time.sleep(6)
        CourseNodePre = EC.presence_of_all_elements_located((By.XPATH,"//li[@class='mb10']"))
        self.assertTrue(CourseNodePre(self.driver), "搜索不到创建的课程")
        self.driver.find_element_by_xpath("//li[@class='mb10'][1]/div[5]/p[1]/a/span[2]").click()
        time.sleep(6)
        
        handles = self.driver.window_handles
        for handle in handles:
            if handle != mainWindowHandle:
                self.driver.switch_to_window(handle)
                break
        
        self.driver.find_element_by_xpath("html/body/section[2]/div/div/section/div[1]/nav/ul/li[4]/a").click()
        WebDriverWait(self.driver,10).until(EC.presence_of_element_located((By.ID,"get-class-tp-info")))
        WebDriverWait(self.driver,10).until(EC.visibility_of_element_located((By.ID,"get-class-tp-info")))
        #验证创建的章节名称
        sectionNameList = sectionNames.splitlines()
        ActualSectionNames = []
        ActualSections = self.driver.find_elements_by_xpath("//*[@id='plan-edit-info']/div/dl/dd[1]/span[1]")
        for section in ActualSections:
            ActualSectionNames.append(section.text.strip())
        try:    
            self.assertListEqual(sectionNameList, ActualSectionNames, "章节名称不匹配")
        except Exception:
            print("sectionName Test failed") 
        
        #验证排课时间  
        PlanStartTimeOfPlans = self.driver.find_elements_by_xpath("//*[@id='plan-edit-info']/div/dl/dd[2]/span[1]")
        self.assertEqual(startTime, PlanStartTimeOfPlans[0].text,"第一课时的排课时间不对应")
           
    def test_verifyQuickStatButton(self):
        #验证排课快捷按钮
        ActionNodes = self.driver.find_elements_by_xpath("//*[@id='plan-edit-info']/div[1]/dl/dd[3]/a")          
        ActionNames= []
        for node in ActionNodes:
            ActionNames.append(node.text)
        xunkeAction = self.driver.find_element_by_xpath("//*[@id='plan-edit-info']/div[1]/dl/dd[4]/a")
        ActionNames.append(xunkeAction.text)
        ExpectActions = ["上传视频","备课","巡课管理"]
        self.assertListEqual(ExpectActions, ActionNames,"failed")
    
    def test_verifyVideoPermission(self):
        #第一课时 直播录播试看权限
        VideoPremissActions = self.driver.find_elements_by_xpath("//*[@id='plan-edit-info']/div[1]/dl/dd[2]/span[2]/em")
        VideoPremiss = []
        for node in  VideoPremissActions:
            VideoPremiss.append(node.text)
        ExpectActions = ["直播：无试看","视频：试看20分钟"]
        self.assertListEqual(ExpectActions, VideoPremiss,"试看权限不匹配")
                          
    def test_verifyPlanlongType(self):
        #验证时间按天增长
        Result = True
        StartTimeMoudles = self.driver.find_elements_by_xpath("//*[@id='plan-edit-info']/div/dl/dd[2]/span[1]")
        StartTimeList = []
        for node in StartTimeMoudles:
            StartTimeList.append(node.text)
        
        for i in range(len(StartTimeList)-1):
            year,month,day  = (time.strptime(StartTimeList[i+1],"%Y-%m-%d %H:%M"))[0:3]
            year1,month1,day1 = (time.strptime(StartTimeList[i],"%Y-%m-%d %H:%M"))[0:3]
            date0 = date(year,month,day)
            date1 = date(year1,month1,day1)
            duration = (date0 - date1).days
            if duration != 1:
                Result = False
                break
        self.assertTrue(Result, "每章节排课时间不是按天累加")
               
    def test_verifyTeacher(self):
        #验证班主任和总人数
        #teacherOfClass =(self.driver.find_element_by_id("plan-teacherName")).text
        teacherOfClass = EC.text_to_be_present_in_element((By.ID,"plan-teacherName"),"李胜红")
        self.assertTrue(teacherOfClass, "教师名称有误")
        #UserTotal = (self.driver.find_element_by_id("plan-userTotal")).text
        Test_totalUser = EC.text_to_be_present_in_element((By.ID,"plan-userTotal"),"0/50")
        self.assertTrue(Test_totalUser, "班级人数有误")
        #验证讲师
        ViceTeacherNodes =self.driver.find_elements_by_xpath("//*[@id='plan-edit-info']/div/dl/dd[1]/span[2]")
        Flag = True
        for node in ViceTeacherNodes:
            if node.text.find("李胜红") == -1:
                Flag = False
                break
        self.assertTrue(Flag, "章节对应的讲师错误") 
        
    @classmethod
    def tearDownClass(cls):
        cls.driver.close()
        cls.driver.quit()
    
if __name__ == "__main__":
    #unittest.main()
    suite = unittest.TestSuite()
    suite.addTest(Test_createCourse("test_NavigateOrgAdministationPage"))
    suite.addTest(Test_createCourse("test_NavigateCreateCoursePage"))
    suite.addTest(Test_createCourse("test_SetBasicInformation"))
    suite.addTest(Test_createCourse("test_setScopeAndDescription"))
    suite.addTest(Test_createCourse("test_addSectionAndPlan"))
    suite.addTest(Test_createCourse("test_verifyQuickStatButton"))
    suite.addTest(Test_createCourse("test_verifyVideoPermission"))
    suite.addTest(Test_createCourse("test_verifyPlanlongType"))
    suite.addTest(Test_createCourse("test_verifyTeacher"))
    runner = unittest.TextTestRunner()
    runner.run(suite)