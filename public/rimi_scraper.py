url = "https://www.rimi.lv/e-veikals/lv/akcijas-piedavajumi"
response = requests.get(url)

soup = BeautifulSoup(html, "html.parser")
from selenium import webdriver
from selenium.webdriver.common.by import By
from bs4 import BeautifulSoup
import time
import csv
import requests
response = requests.get(url)
mode = "" #mode=extract/scrape/""
if(mode != "scrape"):
    driver = webdriver.Chrome()
    driver.maximize_window()

    driver.get(url)

    last_height = 0

    while True:
        driver.execute_script('window.scrollBy(0, 1400)')
        time.sleep(4)

        new_height = driver.execute_script('return document.body.scrollHeight')
        print(str(new_height)+"-"+str(last_height))

        if(new_height == last_height):
            break

        else:
            last_height = new_height

    page_source = driver.page_source
    f = open(path_to_file+"source.txt","w",encoding="utf-8")
    f.write(page_source)
    f.close()
    if(mode != "scrape"):
        pass

html = response.text
soup = BeautifulSoup(response.content, 'html.parser')
