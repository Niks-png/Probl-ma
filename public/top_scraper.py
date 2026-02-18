url = "https://etop.lv/lv/visi-akcijas-produkti"
path_to_file = r"C:\laragon\www\Problēma\Probl-ma\public\\"
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC
from bs4 import BeautifulSoup
import time
import csv

driver = webdriver.Chrome()
driver.maximize_window()

driver.get(url)
time.sleep(3)

load_more_count = 0
max_attempts = 50

while load_more_count < max_attempts:
    try:
        driver.execute_script('window.scrollBy(0, 2000)')
        time.sleep(2)
        
        print(f"\n=== Attempt {load_more_count + 1} ===")
        
        try:
            load_more_button = driver.find_element(By.CLASS_NAME, "load-more-button")
            print(f"Found load more button: {load_more_button.text}")
            
            driver.execute_script("arguments[0].scrollIntoView();", load_more_button)
            time.sleep(1)
            driver.execute_script("arguments[0].click();", load_more_button)
            print(f"Clicked 'Vairāk produktu' button")
            time.sleep(3)
            load_more_count += 1
        except Exception as e:
            print(f"Button not found or error clicking: {e}")
            break
            
    except Exception as e:
        print(f"Error: {e}")
        import traceback
        traceback.print_exc()
        break

print(f"\nTotal load more attempts: {load_more_count}")

page_source = driver.page_source
driver.quit()

f = open(path_to_file+"top.txt", "w", encoding="utf-8")
f.write(page_source)
f.close()
print(f"Page source saved to top.txt after {load_more_count} load more clicks")

html = page_source
soup = BeautifulSoup(page_source, 'html.parser')

print(f"HTML length: {len(html)}")
products = soup.find_all("div", class_="product-card-wrap")
print(f"\nFound {len(products)} product items\n")

if products:
    print("=== FIRST PRODUCT HTML ===")
    print(products[0])
    print("=== END FIRST PRODUCT ===\n")

all_items = []

for i, product in enumerate(products):

    name_elem = product.find("p", class_="product-name")
    title = name_elem.get_text(strip=True) if name_elem else "N/A"
    
    current_price = "N/A"
    discounted_price_elem = product.find("div", class_="discounted-price")
    if discounted_price_elem:
        euros_elem = discounted_price_elem.find("div", class_="euros")
        cents_elem = discounted_price_elem.find("div", class_="cents")
        if euros_elem and cents_elem:
            euros = euros_elem.get_text(strip=True)
            sup_elem = cents_elem.find("sup")
            cents_val = sup_elem.get_text(strip=True) if sup_elem else "00"
            current_price = f"{euros}.{cents_val}"
    
    original_price = "N/A"
    old_price_elem = product.find("div", class_="product-old-price")
    if old_price_elem:
        price_span = old_price_elem.find("span")
        if price_span:
            original_price = price_span.get_text(strip=True)
    
    unit_price = "N/A"
    unit_price_elem = product.find("div", class_="product-unit-price")
    if unit_price_elem:
        unit_price = unit_price_elem.get_text(strip=True)
    
    discount = "N/A"
    discount_elem = product.find(class_=lambda x: x and "discount" in x.lower())
    if discount_elem:
        discount = discount_elem.get_text(strip=True)
    
    product_data = {
        "title": title,
        "original_price": original_price,
        "current_price": current_price,
        "unit_price": unit_price,
        "discount": discount
    }
    all_items.append(product_data)
    
    print(f"Product {i}:")
    print(f"  Title: {title}")
    print(f"  Original Price: {original_price}")
    print(f"  Current Price: €{current_price}")
    print(f"  Unit Price: {unit_price}")
    print(f"  Discount: {discount}\n")


if all_items:
    with open(path_to_file + "top_products.csv", "w", newline="", encoding="utf-8") as csvfile:
        fieldnames = ["title", "original_price", "current_price", "unit_price", "discount"]
        writer = csv.DictWriter(csvfile, fieldnames=fieldnames)
        writer.writeheader()
        writer.writerows(all_items)
    print(f"Saved {len(all_items)} products to top_products.csv")