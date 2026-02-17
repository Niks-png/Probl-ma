url = "https://www.maxima.lv/piedavajumi"

path_to_file = r"C:\laragon\www\Problēma\public\\"
from selenium import webdriver
from selenium.webdriver.common.by import By
from bs4 import BeautifulSoup
import time
import csv
import requests

response = requests.get(url)

mode = ""  # mode=extract/scrape/""
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
    f = open(path_to_file+"max.txt","w",encoding="utf-8")
    f.write(page_source)
    f.close()
    if(mode != "scrape"):
        pass

html = response.text
soup = BeautifulSoup(response.content, 'html.parser')



print(f"Response status: {response.status_code}")
print(f"HTML length: {len(html)}")

price_divs = soup.find_all("div", class_=lambda x: x and "price" in x)
print(f"Found {len(price_divs)} divs with 'price' in class")
if price_divs:
    for i, div in enumerate(price_divs[:3]):
        print(f"\nDiv {i}: {div.get('class')}")
        print(div)

print("\n\n=== Looking for span elements with 'value' or 'cents' ===")
values = soup.find_all("span", class_=lambda x: x and ("value" in x or "cents" in x))
print(f"Found {len(values)} span elements")
if values:
    for i, span in enumerate(values[:5]):
        print(f"Span {i}: class='{span.get('class')}' text='{span.get_text(strip=True)}'")

print("\n\n=== Looking for discount-related elements ===")
discounts = soup.find_all(class_=lambda x: x and "discount" in x.lower())
print(f"Found {len(discounts)} discount elements")
if discounts:
    for i, elem in enumerate(discounts[:2]): 
        print(f"\nDiscount {i}: tag={elem.name} class='{elem.get('class')}'")
        print(str(elem)[:500])

print("\n\n=== Looking for product titles (food names) ===")
products = soup.find_all("div", class_="item")
print(f"Found {len(products)} product items")

if products:
    for i, product in enumerate(products):

        title_elem = product.find("div", class_="title")
        title = title_elem.get_text(strip=True) if title_elem else "N/A"
        
    
        price_elem = product.find("div", class_="t1")
        if price_elem:
            value = price_elem.find("span", class_="value")
            cents = price_elem.find("span", class_="cents")
            price = f"{value.get_text(strip=True)}.{cents.get_text(strip=True)}" if value and cents else "N/A"
        else:
            price = "N/A"
        

        discount_elem = product.find("span", class_="bottom-icon-item")
        if discount_elem:
            discount_value = discount_elem.find("span", class_="value")
            discount = f"-{discount_value.get_text(strip=True)}%" if discount_value else "N/A"
        else:
            discount = "N/A"
        
        print(f"\nProduct {i}:")
        print(f"  Title: {title}")
        print(f"  Price: €{price}")
        print(f"  Discount: {discount}")