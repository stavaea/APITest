#coding=utf-8
from selenium import webdriver
chromedriver = "chromedriver.exe" 
driver = webdriver.Chrome(chromedriver)
driver.get("http://test.gn100.com/site.main.login")
driver.find_element_by_id("x_uname").send_keys("17600117243")
driver.find_element_by_id("x_pass").send_keys("117243")
driver.find_element_by_name("submit").click()
driver.quit()