import requests
from bs4 import BeautifulSoup
url = "https://www.rimi.lv/e-veikals/lv/akcijas-piedavajumi"
response = requests.get(url)
html = response.text
soup = BeautifulSoup(html, "html.parser")