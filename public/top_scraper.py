url = "https://etop.lv/lv/visi-akcijas-produkti"
path_to_file = r"C:\laragon\www\Problēma\public\\"
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
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
    f = open(path_to_file+"top.txt", "w", encoding="utf-8")
    f.write(page_source)
    f.close()

html = response.text
soup = BeautifulSoup(response.content, 'html.parser')

print(f"Response status: {response.status_code}")
print(f"HTML length: {len(html)}")
products = soup.find_all("div", class_="item")
print(f"\nFound {len(products)} product items\n")

all_items = []

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
    
    product_data = {
        "title": title,
        "price": price,
        "discount": discount
    }
    all_items.append(product_data)
    
    print(f"Product {i}:")
    print(f"  Title: {title}")
    print(f"  Price: €{price}")
    print(f"  Discount: {discount}\n")


if all_items:
    with open(path_to_file + "top_products.csv", "w", newline="", encoding="utf-8") as csvfile:
        fieldnames = ["title", "price", "discount"]
        writer = csv.DictWriter(csvfile, fieldnames=fieldnames)
        writer.writeheader()
        writer.writerows(all_items)
    print(f"Saved {len(all_items)} products to top_products.csv")