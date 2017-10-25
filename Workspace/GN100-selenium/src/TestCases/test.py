from selenium import webdriver  
  
chromedriver = "chromedriver.exe"  
driver = webdriver.Chrome(chromedriver)  
driver.get("https://www.baidu.com")  
driver.find_element_by_id("kw").send_keys("Selenium2")
driver.find_element_by_id("su").click()
driver.quit()