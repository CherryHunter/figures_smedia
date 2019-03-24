from selenium import webdriver
from selenium.webdriver.chrome.options import Options
import bs4, requests, os, time, mysql.connector, datetime

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

url1 = "https://www.nippon-yasan.com/new-products.php"
url2 = "https://www.nippon-yasan.com/new-products.php?p=2"
url3 = "https://www.nippon-yasan.com/new-products.php?p=3"

browser = webdriver.Chrome("chromedriver.exe", options=options)
browser.minimize_window()

def load_figure(link):
    browser.get(link)
    soup = bs4.BeautifulSoup(browser.page_source,"lxml")

    try:
        details = soup.find(id="idTab2").find_all("li")
        if details[0].text.find("Adult")!= -1: return

        price = soup.find(id="our_price_display").text[:-1]
        price = price.replace(',','')
        date = soup.find(id="inside2infoRealse").text
    except:
        return

    image = soup.find(id="image-block").find("img")['src']
    image_name = str(time.time())+os.path.basename(image)

    title = soup.find(id="pb-left-column").find("h1").text

    character = ""
    maker = ""
    series = ""

    for detail in details:
        if detail.text.find("Character Name")!= -1: character = detail.text[15:]
        elif detail.text.find("Maker")!= -1: maker = detail.text[6:]
        elif detail.text.find("Series Title")!= -1: series = detail.text[14:]

    if not character or not maker or not series: return

    #sprawdzanie czy dany rekord jest już w tabeli characters
    sql = "SELECT id FROM characters WHERE `name` = %s and `series` = %s"
    chr = (character, series)
    mycursor.execute(sql,chr)
    character_id = mycursor.fetchone()
    if character_id != None:

        #sprawdzanie czy dany rekord jest już w tabeli figures
        sql = "SELECT id FROM figures WHERE maker = %s and character_id = %s and `date` = %s"
        chr = (maker, character_id[0], date)
        mycursor.execute(sql,chr)
        figure_id = mycursor.fetchone()
        if figure_id != None: return

    else:

        #dodawanie do tabeli characters
        sql = "INSERT INTO characters (`name`, series) VALUES (%s, %s)"
        val = (character, series)
        print(mycursor.execute(sql, val))
        mydb.commit()
        print(mycursor.rowcount, "record inserted.")
        character_id = mycursor.lastrowid


    #zapisywanie obrazków
    with open(image_name,"wb") as file:
        file.write(requests.get(image).content)

    #dodawanie do bazy
    sql = "INSERT INTO figures ( title, character_id, maker, `date`, image) VALUES (%s, %s, %s, %s, %s)"
    val = (title, character_id, maker, date, image_name)
    print(mycursor.execute(sql, val))
    mydb.commit()
    print(mycursor.rowcount, "record inserted.")
    figure_id = mycursor.lastrowid

    sql = "SELECT id FROM shops where name = 'nipponyasan' "
    mycursor.execute(sql)
    shop_id = mycursor.fetchone()

    sql = "INSERT INTO sales (`price`, created_at, figure_id, shop_id) VALUES (%s, %s, %s, %s)"
    val = (price, datetime.datetime.today().strftime('%Y-%m-%d'), figure_id, shop_id[0])
    mycursor.execute(sql, val)
    mydb.commit()


def load_shop(url):
    browser.get(url)
    soup = bs4.BeautifulSoup(browser.page_source,"lxml")
    products = soup.find_all("div",class_='center_block')
    links = []
    for product in products:
        link = product.find("a")['href']
        links.append(link)
        load_figure(link)

load_shop(url1)
load_shop(url2)
load_shop(url3)
browser.close()
