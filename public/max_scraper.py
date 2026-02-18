url = "https://www.maxima.lv/piedavajumi"

path_to_file = r"C:\laragon\www\Problēma\Probl-ma\public\\"
from selenium import webdriver
from selenium.webdriver.common.by import By
from bs4 import BeautifulSoup
import time
import csv

driver = webdriver.Chrome()
driver.maximize_window()

driver.get(url)
time.sleep(3)

last_height = 0
scroll_count = 0
max_scrolls = 100
while scroll_count < max_scrolls:
    driver.execute_script('window.scrollBy(0, 2000)')
    time.sleep(3)
    scroll_count += 1

    new_height = driver.execute_script('return document.body.scrollHeight')
    print(f"Scroll {scroll_count}: Height = {new_height}")

    if new_height == last_height:
        print("Reached bottom of page")
        break

    last_height = new_height

print(f"Total scrolls: {scroll_count}")

page_source = driver.page_source
driver.quit()

html = page_source
soup = BeautifulSoup(page_source, 'html.parser')

print(f"HTML length: {len(html)}")

print("\n=== Looking for product titles (food names) ===")
products = soup.find_all("div", class_="item")
print(f"Found {len(products)} product items")

csv_file = open(path_to_file+"max_products.csv", "w", newline="", encoding="utf-8")
csv_writer = csv.writer(csv_file)
csv_writer.writerow(["Title", "Original Price", "Current Price", "Discount"])

if products:
    for i, product in enumerate(products):

        title_elem = product.find("div", class_="title")
        title = title_elem.get_text(strip=True) if title_elem else "N/A"
        
        price_elem = product.find("div", class_="t1")
        if price_elem:
            value = price_elem.find("span", class_="value")
            cents = price_elem.find("span", class_="cents")
            current_price = f"{value.get_text(strip=True)}.{cents.get_text(strip=True)}" if value and cents else "N/A"
        else:
            current_price = "N/A"
        
        original_price = "N/A"
        price_elem_original = product.find("div", class_="t0")
        if price_elem_original:
            value_orig = price_elem_original.find("span", class_="value")
            cents_orig = price_elem_original.find("span", class_="cents")
            original_price = f"{value_orig.get_text(strip=True)}.{cents_orig.get_text(strip=True)}" if value_orig and cents_orig else "N/A"

        discount_elem = product.find("span", class_="bottom-icon-item")
        if discount_elem:
            discount_value = discount_elem.find("span", class_="value")
            discount = f"-{discount_value.get_text(strip=True)}%" if discount_value else "N/A"
        else:
            discount = "N/A"
        
        csv_writer.writerow([title, original_price, current_price, discount])
        
        print(f"\nProduct {i}:")
        print(f"  Title: {title}")
        print(f"  Original Price: €{original_price}")
        print(f"  Current Price: €{current_price}")
        print(f"  Discount: {discount}")

csv_file.close()
print(f"\n\nTotal products scraped: {len(products)}")
print(f"Data saved to max_products.csv")