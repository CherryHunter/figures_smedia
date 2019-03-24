from selenium import webdriver
from selenium.webdriver.chrome.options import Options
import bs4, requests, os, time, mysql.connector, datetime
from dateutil import parser
from fuzzywuzzy import fuzz
from selenium.webdriver.common.by import By
from selenium.webdriver.support.ui import WebDriverWait
from selenium.webdriver.support import expected_conditions as EC

options = Options()
options.add_argument("--log-level=3")
options.add_argument("--headless")

mydb = mysql.connector.connect(
    host="localhost",
    user="root",
    passwd="",
    database="figures_webapp"
)

mycursor = mydb.cursor()

url1 = "https://www.amiami.com/eng/search/list/?s_cate2=459&pagecnt=1&s_st_list_preorder_available=1"
count1 = 29
url2 = "https://www.amiami.com/eng/c/characterfigure/"
count2 = 14

browser = webdriver.Chrome("chromedriver.exe", options=options)
browser.minimize_window()


def load_figure(link):
    browser.get(link)
    try:
        WebDriverWait(browser, 10).until(EC.presence_of_element_located((By.XPATH, '//*[@class="item-detail__section-title" and text() != ""]')))
    except:
        return
    soup = bs4.BeautifulSoup(browser.page_source,"lxml")
    title = soup.find("h2",class_='item-detail__section-title').text
    if title.find("Released")!= -1 or title.find("Exclusive Bonus")!= -1 : return
    price = soup.find("span",class_='item-detail__price_selling-price').text[:-3]
    price = price.replace(',','')
    details = soup.find_all("span",class_='item-about__data-gray')
    maker = details[0].text
    details = soup.find_all("dd",class_='item-about__data-text')
    date = details[0].text
    try:
        date = parser.parse(date)
        date = date.strftime('%Y-%m-%d')
    except:
        return

    #porównywanie wartości z tymi w bazie

    sql = "SELECT `title`, maker, `date`, id FROM figures"
    mycursor.execute(sql)
    figure_data = mycursor.fetchall()
    ratio = 0
    ratio_m = 0
    corr_date = False
    figure_id = 0

    for figure in figure_data:
        fuzzy = fuzz.ratio(figure[0], title)
        if fuzzy > ratio:
            ratio = fuzzy
            figure_id = figure[3]

        fuzzy_m = fuzz.ratio(figure[1], maker)
        if fuzzy_m > ratio_m: ratio_m = fuzzy_m

        if date[:-3] == str(figure[2])[:-3]: corr_date = True

    if ratio > 50 and ratio_m > 60 and corr_date:

        sql = "SELECT id FROM shops where name = 'amiami' "
        mycursor.execute(sql)
        shop_id = mycursor.fetchone()

        #porównanie danych z tabelą sales
        sql = "SELECT id from `sales` WHERE `price` = %s and `figure_id` = %s and `shop_id` = %s "
        chr = (price, figure_id, shop_id[0])
        mycursor.execute(sql, chr)
        is_it = mycursor.fetchone()
        if is_it != None: return

        sql = "INSERT INTO sales (`price`, created_at, figure_id, shop_id) VALUES (%s, %s, %s, %s)"
        val = (price, datetime.datetime.today().strftime('%Y-%m-%d'), figure_id, shop_id[0])
        mycursor.execute(sql, val)
        mydb.commit()
        print(mycursor.rowcount, "record inserted.")

def load_shop(url,count):
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
        load_figure(link)
        count -= 1
        if count < 0:
            return

load_shop(url1,count1)
load_shop(url2,count2)
browser.close()
