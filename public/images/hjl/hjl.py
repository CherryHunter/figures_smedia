from selenium import webdriver
from selenium.webdriver.chrome.options import Options
import bs4, requests, os, time, mysql.connector, datetime
from dateutil import parser
from fuzzywuzzy import fuzz

mydb = mysql.connector.connect(
    host="localhost",
    user="root",
    passwd="",
    database="figures_webapp"
)

mycursor = mydb.cursor()

url1 = "https://hlj.com/anime/figures?p=1"
url2 = "https://hlj.com/anime/figures?p=2"

browser = webdriver.Chrome("chromedriver.exe")
browser.minimize_window()


def load_figure(link):
    browser.get(link)
    try:
        WebDriverWait(browser, 15).until(EC.presence_of_element_located((By.CLASS_NAME, 'item-detail__section-title')))
    except:
        return
    time.sleep(2)
    soup = bs4.BeautifulSoup(browser.page_source,"lxml")
    title = soup.find("h2",class_='item-detail__section-title').text
    if title.find("Released")!= -1 or title.find("Exclusive Bonus")!= -1 : return
    price = soup.find("span",class_='item-detail__price_selling-price').text[:-3]
    price = price.replace(',','')
    print(price)
    maker = soup.find("span",class_='item-detail__price_selling-price').text[:-3]
    print(maker)

    #date =

def load_shop(url):
    browser.get(url)
    try:
        WebDriverWait(browser, 15).until(EC.presence_of_element_located((By.CLASS_NAME, 'newly-added-items__item')))
    except:
        return
    soup = bs4.BeautifulSoup(browser.page_source,"lxml")
    products = soup.find_all("li",class_='newly-added-items__item')
    links = []
    for product in products:
        link = 'https://www.amiami.com'+product.find("a")['href']
        links.append(link)
        #load_figure(link)

load_shop(url1)
#load_shop(url2)
#browser.close()
